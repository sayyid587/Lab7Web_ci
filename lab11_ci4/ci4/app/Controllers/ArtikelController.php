<?php

namespace App\Controllers;

use App\Models\ArtikelModel; // Pastikan kamu juga membuat Modelnya nanti
use CodeIgniter\Controller;

class ArtikelController extends BaseController
{
    // Fungsi untuk menampilkan semua artikel
    public function index()
    {
        // CEK LOGIN: Jika belum login, tendang ke halaman login
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }

        $model = new ArtikelModel();
        
        // Mengambil semua data dari tabel artikel
        $data['artikel'] = $model->findAll();

        return view('artikel_view', $data);
    }

    // Fungsi Tambah, Edit, Hapus biasanya diletakkan di sini
    // Untuk improvisasi, pastikan ada cek role admin
    public function tambah()
    {
        if (session()->get('role') != 'admin') {
            return "Maaf, Anda bukan Admin!";
        }
        // return view('artikel_tambah_view'); // Jika sudah ada view-nya
        return "Halaman Tambah Artikel (Segera Datang)";
    }
}