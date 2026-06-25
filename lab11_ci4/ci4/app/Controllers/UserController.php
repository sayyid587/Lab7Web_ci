<?php

namespace App\Controllers;

// Kita tetap pakai BaseController bawaan CI4
use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends BaseController
{
    // Fungsi ini yang akan menampilkan halaman login
    public function index()
    {
        return view('user/login');
    }

    // Fungsi untuk memproses data login (POST)
    public function auth()
    {
        $session = session();
        $model = new UserModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $data = $model->where('useremail', $email)->first();

        if ($data) {
            $pass = $data['userpassword'];
            if ($password === $pass) {
                $ses_data = [
                    'user_id' => $data['id'],
                    'user_nama' => $data['username'],
                    'role' => $data['role'],
                    'logged_in' => TRUE
                ];
                $session->set($ses_data);

                // Setelah login berhasil, lempar ke Controller Artikel
                return redirect()->to('/admin/artikel');
            } else {
                $session->setFlashdata('msg', 'Password Salah');
                return redirect()->to('/user/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email tidak ditemukan');
            return redirect()->to('/user/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login');
    }
}