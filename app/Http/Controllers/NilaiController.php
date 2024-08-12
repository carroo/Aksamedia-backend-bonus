<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Schema;

class NilaiController extends Controller
{
    public function rt()
    {
        $results = Nilai::where('materi_uji_id', 7)->whereNot('nama_pelajaran', 'Pelajaran Khusus')->get();

        $data = [];

        foreach ($results as $row) {
            $nama = $row->nama;
            $nisn = $row->nisn;
            $nama_pelajaran = $row->nama_pelajaran;
            $skor = $row->skor;

            if (!isset($data[$nama])) {
                $data[$nama] = [
                    'nama' => $nama,
                    'nilaiRT' => [],
                    'nisn' => $nisn,
                ];
            }

            $data[$nama]['nilaiRT'][$nama_pelajaran] = $skor;
        }

        $output = array_values($data);

        return response()->json($output);
    }
    public function st()
    {
        $results = Nilai::where('materi_uji_id', 4)->get();

        $data = [];

        foreach ($results as $row) {
            $nama = $row->nama;
            $nisn = $row->nisn;
            $nama_pelajaran = $row->nama_pelajaran;
            $skor = $row->skor;

            if (!isset($data[$nama])) {
                $data[$nama] = [
                    'listNilai' => [],
                    'nama' => $nama,
                    'nisn' => $nisn,
                    'total' => 0,
                ];
            }
            $kalikan = 1;
            if ($row->pelajaran_id == 44) {
                $kalikan = 41.67;
            } else if ($row->pelajaran_id == 45) {
                $kalikan = 29.67;
            } else if ($row->pelajaran_id == 46) {
                $kalikan = 100;
            } else if ($row->pelajaran_id == 47) {
                $kalikan = 23.81;
            }
            $nilai = round($skor * $kalikan, 2);

            $data[$nama]['listNilai'][$nama_pelajaran] = $nilai;
            $data[$nama]['total'] += $nilai;
        }

        $output = array_values($data);

        usort($output, function ($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        return response()->json($output);
    }
}
