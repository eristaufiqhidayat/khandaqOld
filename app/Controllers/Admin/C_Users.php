<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\M_Menu;
use App\Models\Admin\M_Users;
use Myth\Auth\Commands\SetPassword;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;
use PHPUnit\TextUI\XmlConfiguration\Groups;

class C_Users extends BaseController
{
    protected $auth;

    /**
     * @var AuthConfig
     */
    protected $config;

    /**
     * @var Session
     */
    protected $session;
    public function __construct()
    {
        // Most services in this controller require
        // the session to be started - so fire it up!
        $this->session = service('session');
        $this->config = config('Auth');
        $this->auth   = service('authentication');
    }
    public function readjson($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $config = null;
        $model = new M_Users();
        $dataModel = $model->listing();
        $data = array(
            "data" => $dataModel
        );
        return $this->response->setJSON($data);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function groupjson($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Users();
        $groups = $model->listGroup();
        return $this->response->setJSON($groups);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function usergroupjson($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        helper('cookie');
        $model = new M_Users();
        $groups = $model->cekGroupUsersAll($this->request->getVar('user_id'));
        return $this->response->setJSON($groups);
        //return redirect()->to(base_url('index.php/TataUsaha/Spp/index/' . $menuAktip . '/' . $moduleAktip))->with('id_siswa', $this->request->getVar('id_siswa'));
    }
    public function index($menuAktip = '', $moduleAktip = '')
    {
        helper('text');
        $auth = service('authentication');
        $authorize = service('authorization');
        $groups = $authorize->groups();
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $model = new M_Users();
        $datamenu2 = $model->listing();
        $data = array(
            'title'        => 'Data Menu',
            'DataMenu'    => $datamenu2,
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip,
            'groupUser' => $groups,
        );
        if (!$auth->check()) {
            return redirect()->route('login');
        } else {
            return view('Admin/V_Users2', $data);
        }
    }

    public function tambah()
    {
        // if (!$this->config->allowRegistration) {
        //     return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        // }

        $users = model(UserModel::class);

        // Validate basics first since some password rules rely on these fields
        $rules = config('Validation')->registrationRules ?? [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validate passwords since they can only be validated properly here
        $rules = [
            //'password'     => 'required|strong_password',
            'password'     => 'required',
            'pass_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user              = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation === null ? $user->activate() : $user->generateActivateHash();

        // Ensure default group gets assigned if set
        if (!empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (!$users->save($user)) {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== null) {
            $activator = service('activator');
            $sent      = $activator->send($user);

            if (!$sent) {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
        }

        // Success!
        return redirect()->back()->with('message', lang('Auth.registerSuccess'));
    }
    public function edit($menuAktip = '', $moduleAktip = '')
    {
        $rules = [
            //'password'     => 'required|strong_password',
            'password'     => 'required',
            'pass_confirm' => 'required|matches[password]',
        ];

        // if (!$this->validate($rules)) {
        //     return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        // }
        $users = new M_Users();
        $userChange = $users->find($this->request->getVar('user_id'));

        $data = array(
            "id" => $userChange->id,
            "email" => $this->request->getVar('email'),
            "username" => $userChange->username,
            "password_hash" => password_hash(base64_encode(hash('sha384', $this->request->getVar('password'), true)), PASSWORD_DEFAULT),
            "active" => 1
        );
        if ($userChange->id) {
            //remove user from any group
            $users->deleteGroupUser($userChange->id);
            //add user from group
            $authorize = service('authorization');
            $authorize->addUserToGroup($userChange->id, $this->request->getPost('group'));
            $users->save($data);
            echo json_encode('sukses');
            //return redirect()->back()->with('message', lang('Auth.userupdate'));
        }
    }

    public function hapus()
    {
        $users = model(UserModel::class);
        // $users->Delete($this->request->getPost('id'), true);
        // return redirect()->back()->with('message', lang('Auth.userdelete'));
        //$users = new M_Users();
        if ($users->Delete($this->request->getPost('id'), true)) {
            echo json_encode('sukses');
        }
        //return redirect()->back()->with('message', lang('Auth.registerSuccess'));
    }
    public function CPass($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $session = \Config\Services::session();

        $data = array(
            'username'    => $this->request->getVar('username'),
            'password_hash'    => password_hash(base64_encode(hash('sha384', $this->request->getVar('password_hash'), true)), PASSWORD_DEFAULT),
            'email'    => $this->request->getVar('email'),
            'menu'   =>  $datamenu,
            'menuAktip' => $menuAktip,
            'moduleAktip' => $moduleAktip
        );
        //$session->setFlashdata('sukses', 'Password Sudah dirubah');
        return view('Admin/V_CPass', $data);
        // End masuk database
    }
    public function CPassDo($menuAktip = '', $moduleAktip = '')
    {
        helper('form');
        $menu = new M_Menu();
        $datamenu = $menu->listing();
        $session = \Config\Services::session();

        $validated =  $this->validate([
            'username'     => 'required',
            'password_hash'     => 'required',

        ]);
        //var_dump($this->validate);
        if ($validated) {
            $data = array(
                'username'    => $this->request->getVar('username'),
                'password_hash'    => password_hash(base64_encode(hash('sha384', $this->request->getVar('password_hash'), true)), PASSWORD_DEFAULT),
                'email'    => $this->request->getVar('email'),
                'active' => '1',
                'force_pass_reset' => '1',
            );
            $model = new M_Users();
            $model->CPass($data);
            $session->setFlashdata('sukses', 'Password Sudah dirubah');
            return redirect()->to(base_url('index.php/dashboard/' . $menuAktip . '/' . $moduleAktip));
            // End masuk database
        } else {
            echo "gagal";
        }
    }
}
