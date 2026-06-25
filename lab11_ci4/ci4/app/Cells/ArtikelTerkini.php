<?php

namespace App\Cells;

use CodeIgniter\View\Cell;
use App\Models\ArtikelModel;

class ArtikelTerkini
{
    public function render(): string
    {
        $model = new ArtikelModel();
        
        // Mengambil 5 artikel terbaru berdasarkan ID
        $artikel = $model->orderBy('id', 'DESC')->limit(5)->findAll();

        return view('components/artikel_terkini', ['artikel' => $artikel]);
    }
}