<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{

    public function __construct()
    {
        $this->user = new UserModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        if(session()->get('isLogin')){
            return redirect()->to('home');
        }else{
            return view('login');
        }
    }

    public function prosses()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        if ($username && $password) {
            // cek username
            $user = $this->user->where('username', $username)->first();
?>
            <link rel="stylesheet" href="<?= base_url() ?>/asset/css/sweetalert2-dark.min.css">
            <script src="<?= base_url() ?>/asset/js/sweetalert2.min.js"></script>

            <body>
            </body>
            <style>
                body {
                    font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
                    font-size: 1.124em;
                    font-weight: normal;
                }
            </style>
            <?php
            if ($user == null) {
            ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Username tidak ditemukan'
                    }).then((result) => {
                        if (result.value) {
                            window.location = "<?= site_url('login') ?>"
                        }
                    })
                </script>
                <?php
            } else {
                // cek password
                if ($this->checkPassword($password)) {
                    $session = [
                        'isLogin' => true,
                        'id_user' => $user->id_user,
                        'username' => $username
                    ];
                    $this->session->set($session);
                ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Selamat',
                            text: 'Login berhasil'
                        }).then((result) => {
                            if (result.value) {
                                window.location = "<?= site_url() ?>"
                            }
                        })
                    </script>
                <?php
                } else {
                ?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Password Salah'
                        }).then((result) => {
                            if (result.value) {
                                window.location = "<?= site_url('login') ?>"
                            }
                        })
                    </script>
                <?php
                }
            }
        }
    }

    function checkPassword($password)
    {
        $user = $this->user->where('password', md5($password))->first();
        if ($user)
            return true;
        else
            return false;
    }

    function logout(){
        $this->session->destroy();
        return redirect()->to('login');
    }
}
