<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel; // <-- WAJIB ADA: Untuk manggil tabel kategori
use CodeIgniter\Validation\Validation;

class Artikel extends BaseController
{

    public function index()
    {
        $model = new ArtikelModel();

        $data = [
            'title' => 'Daftar Artikel',
            // Modul 6: Menggunakan relasi agar nama kategori tampil di halaman user
            'artikel' => $model->getArtikelDenganKategori() 
        ];

        return view('artikel/index', $data);
    }

    public function detail($slug)
    {
        $model = new ArtikelModel();

        // Modul 6: JOIN untuk nampilin kategori di halaman detail
        $artikel = $model->select('artikel.*, kategori.nama_kategori')
                         ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                         ->where(['slug' => $slug])
                         ->first();

        if (!$artikel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Artikel tidak ditemukan');
        }

        $data['artikel'] = $artikel;

        return view('artikel/detail', $data);
    }

    public function view($slug)
    {
        $model = new ArtikelModel();

        $artikel = $model->select('artikel.*, kategori.nama_kategori')
                         ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                         ->where(['slug' => $slug])
                         ->first();

        $title = $artikel['judul'];

        return view('artikel/detail', compact('artikel', 'title'));
    }

    public function tambah()
    {
        return view('artikel/tambah');
    }

    public function simpan()
    {
        $model = new ArtikelModel();

        $slug = url_title($this->request->getPost('judul'), '-', true);

        $model->insert([
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'slug' => $slug,
            'status' => 1
        ]);

        return redirect()->to('/artikel');
    }

    public function update($id)
    {
        $model = new ArtikelModel();

        $slug = url_title($this->request->getPost('judul'), '-', true);

        $model->update($id, [
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'slug' => $slug,
            'status' => 1
        ]);

        return redirect()->to('/artikel');
    }

    public function delete($id)
    {
        $model = new ArtikelModel();

        $model->delete($id);

        return redirect()->to('/admin/artikel');
    }

   public function add()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'id_kategori' => 'required'
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();

        if ($isDataValid) {
            // --- KODE BARU: Menangkap file gambar (Modul 7) ---
            $file = $this->request->getFile('gambar');
            $nama_file = '';

            // Cek apakah ada file yang diupload dan valid
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Pindahkan file ke folder public/gambar
                $file->move(ROOTPATH . 'public/gambar');
                // Ambil nama filenya untuk disimpan ke database
                $nama_file = $file->getName();
            }
            // ---------------------------------------------------

            $artikel = new ArtikelModel();
            $artikel->insert([
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'slug'        => url_title($this->request->getPost('judul')),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'gambar'      => $nama_file // Simpan nama gambar ke database
            ]);
            return redirect()->to('/admin/artikel');
        }
        
        $kategoriModel = new KategoriModel(); 
        $title = "Tambah Artikel";
        $kategori = $kategoriModel->findAll();
        
        // Sesuaikan nama view dengan yang kamu pakai (add.php atau form_add.php)
        return view('artikel/add', compact('title', 'kategori')); 
    }

    public function edit($id)
    {
        $artikel = new ArtikelModel();
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required',
            'id_kategori' => 'required' // <-- Modul 6: Kategori wajib diisi
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();
        
        if ($isDataValid) {
            $artikel->update($id, [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori') // <-- Modul 6: Simpan perubahan kategori
            ]);
            return redirect()->to('/admin/artikel');
        }
        
        // ambil data lama
        $data = $artikel->where('id', $id)->first();
        
        $kategoriModel = new KategoriModel(); // <-- Modul 6: Ambil data untuk dropdown kategori
        $kategori = $kategoriModel->findAll();
        
        $title = "Edit Artikel";
        return view('artikel/edit', compact('title', 'data', 'kategori'));
    }

    public function admin_index()
    {
        $title = 'Daftar Artikel';
        $q = $this->request->getVar('q') ?? ''; 
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        
        // TAMBAHAN MODUL 9: Tangkap parameter 'page' untuk pagination AJAX
        $page = $this->request->getVar('page') ?? 1; 

        $model = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        $builder = $model->select('artikel.*, kategori.nama_kategori')
                         ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }
        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $data = [
            'title'       => $title,
            'q'           => $q,
            'kategori_id' => $kategori_id,
            // TAMBAHAN MODUL 9: Masukkan $page ke dalam fungsi paginate
            'artikel'     => $builder->orderBy('artikel.id', 'ASC')->paginate(10, 'default', $page), 
            'pager'       => $model->pager,
            'kategori'    => $kategoriModel->findAll() 
        ];
        
        // TAMBAHAN MODUL 9: Cek apakah request dari AJAX. Jika ya, kirim JSON!
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        } else {
            return view('artikel/admin_index', $data);
        }
    }
}