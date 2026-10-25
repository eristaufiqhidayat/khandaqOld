<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Menyisipkan skrip kecil sebelum </body> di setiap halaman HTML:
 * - semua <form method="post"> (termasuk yang dibuat lewat JavaScript) diberi
 *   input tersembunyi berisi token CSRF;
 * - setiap AJAX/fetch non-GET ke server ini diberi header token CSRF;
 * - flashdata 'peringatan' (misalnya upload ditolak, token kedaluwarsa)
 *   ditampilkan sebagai pesan.
 */
class CsrfSisip implements FilterInterface
{
    private const JSON = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;

    public function before(RequestInterface $request, $arguments = null)
    {
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if ($response->getStatusCode() >= 300 && $response->getStatusCode() < 400) {
            return;
        }
        $tipe = $response->getHeaderLine('Content-Type');
        if ($tipe !== '' && stripos($tipe, 'text/html') === false) {
            return;
        }
        $body = (string) $response->getBody();
        $posisi = strripos($body, '</body>');
        if ($posisi === false) {
            return;
        }

        $peringatan = session()->getFlashdata('peringatan');
        $skrip = '<script>(function(){'
            . 'var nama=' . json_encode(csrf_token(), self::JSON) . ',nilai=' . json_encode(csrf_hash(), self::JSON) . ',header=' . json_encode(csrf_header(), self::JSON) . ';'
            . <<<'JS'
function perlu(method,url){if(/^(GET|HEAD|OPTIONS)$/i.test(method||'GET'))return false;try{return new URL(url,location.href).origin===location.origin}catch(e){return true}}
function isiForm(f){if(!f||(f.getAttribute('method')||'').toLowerCase()!=='post')return;var el=f.querySelector('input[name="'+nama+'"]');if(!el){el=document.createElement('input');el.type='hidden';el.name=nama;f.appendChild(el)}el.value=nilai}
function isiSemua(a){if(!a||a.nodeType!==1)return;if(a.tagName==='FORM')isiForm(a);if(a.querySelectorAll)Array.prototype.forEach.call(a.querySelectorAll('form'),isiForm)}
document.addEventListener('submit',function(e){isiForm(e.target)},true);
isiSemua(document.documentElement);
if(window.MutationObserver)new MutationObserver(function(ms){ms.forEach(function(m){Array.prototype.forEach.call(m.addedNodes,isiSemua)})}).observe(document.documentElement,{childList:true,subtree:true});
var xp=Object.getPrototypeOf(new XMLHttpRequest()),buka=xp.open,kirim=xp.send;
xp.open=function(method,url){this._csrf=perlu(method,url);return buka.apply(this,arguments)};
xp.send=function(){if(this._csrf){try{this.setRequestHeader(header,nilai)}catch(e){}}return kirim.apply(this,arguments)};
if(window.fetch){var asli=window.fetch;window.fetch=function(input,init){init=init||{};var req=(typeof Request!=='undefined'&&input instanceof Request)?input:null;var method=init.method||(req?req.method:'GET');var url=req?req.url:String(input);if(perlu(method,url)){var h=new Headers(init.headers||(req?req.headers:undefined));h.set(header,nilai);init.headers=h}return asli.call(this,input,init)}}
JS
            . ($peringatan ? 'window.addEventListener("load",function(){alert(' . json_encode((string) $peringatan, self::JSON) . ')});' : '')
            . '})();</script>';

        $response->setBody(substr($body, 0, $posisi) . $skrip . "\n" . substr($body, $posisi));

        return $response;
    }
}
