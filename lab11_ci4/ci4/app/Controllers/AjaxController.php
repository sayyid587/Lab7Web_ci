<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use App\Models\ArtikelModel;

class AjaxController extends Controller
{
   public function index()
    {
        // Tambahkan variabel title di sini
        $data = [
            'title' => 'Data Artikel via AJAX'
        ];
        
        // Kirim $data ke view
        return view('ajax/index', $data);
    }

    public function getData()
    {
        $model = new ArtikelModel();
        // Mengambil semua data dari database
        $data = $model->findAll();
        
        // Mengirim data ke View dalam format JSON (syarat utama AJAX)
        return $this->response->setJSON($data);
    }
    
    public function simpan()
    {
        $model = new ArtikelModel();
        
        // Menangkap data inputan dari form
        $judul = $this->request->getPost('judul');
        $isi = $this->request->getPost('isi');
        
        // Menyusun data untuk dimasukkan ke database
        $data = [
            'judul'  => $judul,
            'isi'    => $isi,
            'status' => 1, // Set default status aktif
            'slug'   => url_title($judul, '-', true) // Generate slug otomatis dari judul
        ];
        
        // Eksekusi insert ke database
        $model->insert($data);
        
        // Kirim konfirmasi ke AJAX bahwa proses berhasil
        return $this->response->setJSON(['status' => 'Berhasil']);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);
        
        $response = [
            'status' => 'OK'
        ];
        
        return $this->response->setJSON($response);
    }
}