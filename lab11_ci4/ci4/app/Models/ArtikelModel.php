<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'judul',
        'isi',
        'status',
        'slug',
        'gambar',
        'created_at',
        'id_kategori' // Tambahan untuk Modul 6
    ];

    protected $useTimestamps = false;

    // Tambahan Fungsi untuk JOIN tabel artikel dan kategori (Modul 6)
    public function getArtikelDenganKategori()
    {
        return $this->db->table('artikel')
                        ->select('artikel.*, kategori.nama_kategori')
                        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                        ->get()
                        ->getResultArray();
    }
}