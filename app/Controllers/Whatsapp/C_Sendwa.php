<?php

namespace App\Controllers\Whatsapp;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Whatsapp\M_Groupwa;
use App\Models\Whatsapp\M_Myapp;
use App\Models\Whatsapp\M_Message;
use App\Models\Whatsapp\M_Notelp;
use App\Models\Whatsapp\M_Log;
use App\Models\Whatsapp\M_Template;

class C_Sendwa extends BaseController
{
    public function readjsonAPIServer($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Myapp();
        $dataModel = $model->findAll();
        foreach ($dataModel as $Myapp) {
            $data[] = array(
                'id' => $Myapp->no,
                'text' => $Myapp->no . "::" . $Myapp->appkey . "::" . $Myapp->vendor
            );
        }
        $data = array(
            "results" => $data
        );
        //echo json_encode($data);
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function readjsontemplate($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Template();
        $dataModel = $model->findAll();
        foreach ($dataModel as $Template) {
            $data[] = array(
                'id' => $Template->nama,
                'text' => $Template->no . "::" . $Template->nama . "::" . $Template->keterangan . "::" . $Template->type . "::" . $Template->keterangan
            );
        }
        $data = array(
            "results" => $data
        );
        //echo json_encode($data);
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function readjsonMessage($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Message();
        $dataModel = $model->findAll();
        foreach ($dataModel as $message) {
            $data[] = array(
                'id' => $message->no,
                'text' => $message->no
            );
        }
        $data = array(
            "results" => $data
        );
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function readjsonMessagebyno()
    {
        helper('form');
        helper('cookie');
        $model = new M_Message();
        $dataModel = $model->get_Message($this->request->getVar('no'));
        return $this->response->setJSON($dataModel);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function readjsonLogstatus()
    {
        helper('form');
        helper('cookie');
        $model = new M_Log();
        $dataModel = $model->get_Log();
        $data = array(
            "data" => $dataModel
        );
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function addlog($myapp, $status, $message, $datetime, $template, $nohp)
    {
        $menumodel = new M_Log();
        $data           = new \App\Entities\EMessage();
        $data->myapp    = $myapp;
        $data->status    = $status;
        $data->message    = $message;
        $data->datetime    = $datetime;
        $data->template    = $template;
        $data->nohp    = $nohp;

        $menumodel->save($data);
        //echo json_encode('sukses');
    }
    public function groupwa()
    {
        helper('form');
        helper('cookie');
        $model = new M_Notelp();
        $dataModel = $model->get_Notelparray($this->request->getVar('no'));
        $data = array(
            "data" => $dataModel
        );
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function apiserver()
    {
        helper('form');
        helper('cookie');
        $model = new M_Myapp();
        $dataModel = $model->get_Myapp2($this->request->getVar('no'));
        $data = array(
            "data" => $dataModel
        );
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function readjsonGroupwa($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Groupwa();
        $dataModel = $model->findAll();
        foreach ($dataModel as $Groupwa) {
            $data[] = array(
                'id' => $Groupwa->no,
                'text' => $Groupwa->nama
            );
        }
        $data = array(
            "results" => $data
        );
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function  index($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        if (!$this->request->getPost('monthyear')) {
            $monthyear = date('Y-m');
        } else {
            $monthyear = $this->request->getVar('monthyear');
        }
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $data = new M_Groupwa();
        $dataMyapp = $data->findAll();
        $newdata = [
            'action' => 'Tambah',
            'monthyear'  => $monthyear,
            'dataFormulir'    => $dataMyapp,
        ];
        $config = null;
        $session = \Config\Services::session($config);
        $session->set($newdata);
        $data = array(
            'title'        => 'Data Menu',
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'dataMyapp'    => $dataMyapp,
            'monthyear'    => $monthyear,
            'menu'   =>  $datamenu,
            'session' => $session
        );
        return view('Whatsapp/V_Sendmessage', $data);
    }

    public function curl_ngirimwa_meta($appkey, $authkey, $to, $file, $message)
    {

        $file = 'https://ww2.lembaharafah.com/wp-content/uploads/2024/03/WhatsApp-Image-2024-03-06-at-07.27.47-1-2-jpeg-e1709943085355.webp';
        $number = $to; //you can use POST, I tried GET for testing
        $template = array(
            'name' => 'pendaftaranbaru', //your your own or any default template. The names and samples are listed under message templates
            'language' => array('code' => 'id') //you can use yours
        );
        $text = array(
            'preview_url' => 'true', //your your own or any default template. The names and samples are listed under message templates
            'body' => $message //you can use yours
        );
        $image = array(
            'link' => $file
        );
        $type = "template";
        $endpoint = $appkey;
        $params = array('messaging_product' => 'whatsapp', 'to' => $number,  'access_token' => $authkey,  'text' => json_encode($text));

        $headers = array('Authorization' => $authkey, 'Content-Type' => 'application/json',  'User-Agent' => '(Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36');
        $url = $endpoint . '?' . http_build_query($params);
        //echo $params.'<br>';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $params);
        $result = curl_exec($ch);
        echo $result; //you can skip this, I did it to check the results
        $myapp = "meta";
        //!isset($status->success) ? $messtat = "success" : $messtat = "error";
        //$this->addlog($myapp, $result, $result,$datetime);
        curl_close($ch);

        //echo  $appkey . $authkey . $to . $file . $message;
    }
    public function curl_ngirimwa_meta_template($appkey, $authkey, $to, $file, $message, $template, $type, $imageurl)
    {

        $file = 'https://khandaq.lembaharafah.com/public/asset/dist/img/logoArafah.jpg';
        $number = $to; //you can use POST, I tried GET for testing
        if ($type == "text") {
            $template3 = "text";
            // $text = json_encode(array(
            //     'preview_url' => 'true', //your your own or any default template. The names and samples are listed under message templates
            //     'body' => $message //you can use yours
            // ));
            //$template2 = $text;
            // Should use UTF8
            $message        =  utf8_encode($message);
            // Whatsapp patterns
            $nl         = "%0D%0A"; // newline
            $space      = "%20";    // space
            $message        =  str_replace(array(" ", "<br>", "\n", "\r\n", '"'), array($space, $nl, $nl, $nl, ' \"'), $message);
            $template2 = '{"preview_url":"true","body":"' . $message . '"}';
            $type = "text";
        } elseif ($type == "image") {
            $template3 = "template";
            $template2 = '
                {
                    "name": "' . $template . '",
                    "language": {"code": "id"},
                    "components": [
                        {
                          "type": "header",
                          "parameters": [
                            {
                              "type": "image",
                              "image": {
                                "link" : "' . $imageurl . '"
                              }
                            },
                          ]
                        },   
                    ]
                }';
            $type = "template";
        } elseif ($type == "catalog") {
            $template3 = "template";
            $template2 = '
                {
                    "name": "' . $template . '",
                    "language": {"code": "id"},
                }';
            // $template2 = '
            // {
            //     "name": "' . $template . '",
            //     "language": {"code": "id"},
            //     "components": [
            //         {
            //           "type": "button",
            //           "sub_type": "CATALOG",
            //           "index": 0,
            //           "parameters": [
            //             {
            //               "type": "action",
            //               "action": {
            //                 "thumbnail_product_retailer_id": "vs7q3b0r3n"
            //               }
            //             }
            //           ]
            //         }
            //       ]
            // }';
            $type = "template";
        } else {
            $template3 = "text";
            $template2 = '
            {
                "preview_url": "true",
                "body": "' . $message . '",
            }';
            $type = "text";
        }


        $endpoint = $appkey;
        //$params = array();
        $params = array('messaging_product' => 'whatsapp', 'to' => $number,  'access_token' => $authkey, 'type' => $type, $template3 => $template2);
        $headers = array('Authorization' => $authkey, 'Content-Type' => 'application/json',  'User-Agent' => '(Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36');
        $url = $endpoint . '?' . http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $result = curl_exec($ch);
        $status = json_decode($result);
        //echo $result; //you can skip this, I did it to check the results
        curl_close($ch);
        //echo $response;
        $myapp = "meta template";
        isset($status->error) ? $messtat = "error" : $messtat = "success";

        $datetime = date('Y/m/d H:i:s');
        $this->addlog($myapp, $messtat, $result, $datetime, $template, $to);
        if (!isset($status->error)) return "error";
    }
    public function curl_ngirimwa($appkey, $authkey, $to, $file, $message, $template)
    {
        /*
            $arrayVar = [
                "message_status" => "Success",
                "data" => [
                    "from" => "628118684222",
                    "to" => "+62811161610",
                    "status_code" => 200,
                ],
            ];
        */
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://app.ngirimwa.com/api/create-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'appkey' => $appkey,
                'authkey' => $authkey,
                'to' => $to,
                'message' => $message,
                //'file' => $file,
                'sandbox' => 'false'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $status = json_decode($response);
        //echo $response;
        $myapp = "ngirimwa";
        isset($status->message_status) == "Success" ? $messtat = "success" : $messtat = "error";
        $datetime = date('Y/m/d H:i:s');
        $this->addlog($myapp, $messtat, $response, $datetime, $template, $to);
        if ($status->message_status == "Success") return json_encode($status->message_status);
    }
    public function ngirimwa($myapp, $no, $file, $idmessage, $template, $type, $imageurl)
    {
        if (!$file) {
            $file = 'https://ww2.lembaharafah.com/wp-content/uploads/2024/02/Brosur-depanK-1.jpg';
        }
        // $message = 'Ada yang Daftar Nih, Nama =, Nama Siswa = ,';

        $modulemodel = new M_Notelp();
        $module           = $modulemodel->get_namawa($no);
        $berita = $modulemodel->get_message($idmessage);
        $myapp = $modulemodel->get_myapp($myapp);

        $message = $berita["message"];
        $appkey = $myapp["appkey"];
        $authkey = $myapp["authkey"];
        $vendor = $myapp["vendor"];
        foreach ($module as $key1 => $value1) {
            $to = $value1["nohp"];
            //$this->curl_ngirimwa_meta_session($appkey, $authkey, $value1["nohp"], $file, $message);
            if ($vendor == "meta") {
                if (!$this->curl_ngirimwa_meta_template($appkey, $authkey, $to, $file, $message, $template, $type, $imageurl)) {
                    return json_encode("Error");
                }
            } elseif ($vendor == "ngirimwa") {
                //$this->curl_ngirimwa($appkey, $authkey, $to, $file, $message);
                if (!$this->curl_ngirimwa($appkey, $authkey, $to, $file, $message, $template)) {
                    return json_encode("Error");
                }
                //echo $appkey . $authkey . $to . $file . $message . "<br>";
            } elseif ($vendor == "metatemplate") {
                echo "metatemplate";
                //$this->curl_ngirimwa_meta_session($appkey, $authkey, $value1["nohp"], $file, $message);
            }
        }
    }
    public function submitwa()
    {
        $file = 'https://ww2.lembaharafah.com/wp-content/uploads/2024/02/Brosur-depanK-1.jpg';
        $idmessage = $this->request->getVar('message');
        $groupwa = $this->request->getVar('groupwa');
        $myapp = $this->request->getVar('myapp');
        $template = $this->request->getVar('template');
        $type = $this->request->getVar('type');
        $imageurl = $this->request->getVar('imageurl');

        if (!$this->ngirimwa($myapp, $groupwa, $file, $idmessage, $template, $type, $imageurl)) {
            return json_encode("Error");
        }
    }
}
