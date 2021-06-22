<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function text(string $type, string $table, array $field = [], array $relation = [], array $firstValue = [], array $secondValue = []): string
{
    if ($type == 'Insert') {
        // if ($table != 'product_kendaraan' && $table != 'kartu_stok_non_aset' && $table != 'kartu_stok_aset') {
        if ($relation == null) {
            $isi = [];
            foreach ($firstValue as $key => $val) {
                if (in_array($key, $field)) {
                    array_push($isi, ucfirst(str_replace('_', ' ', $key)) . ' = ' . $val);
                }
            }
            $nil = implode(', ', $isi);
            $text = 'Menambahkan data ' . ucfirst(str_replace('_', ' ', $table)) . ' dengan nilai ' . $nil;
        } else {
            $isi = [];
            foreach ($firstValue as $key => $val) {
                if (in_array($key, $field)) {
                    array_push($isi, ucfirst(str_replace('_', ' ', $key)) . ' = ' . $val);
                }
            }
            $end = ' dan termasuk ke dalam ';
            $yy = [];
            foreach ($relation as $key => $val) {
                $temp = [];
                foreach ($val['field'] as $k => $v) {
                    array_push($temp, ucfirst(str_replace('_', ' ', $v)) . ' = ' . view($val['table'], [$val['pk'] => $val['valuePk']], $v));
                }
                $im = implode(', ', $temp);
                $textTemp = $val['table'] . ' dengan ' . $im;
                array_push($yy, $textTemp);
            }
            $nil = implode(', ', $isi);
            $rel = implode(', ', $yy);
            $text = 'Menambahkan data ' . ucfirst(str_replace('_', ' ', $table)) . ' dengan nilai ' . $nil . $end . $rel;
        }
        // } elseif ($table != 'kartu_stok_aset' && $table != 'product_kendaraan') {
        //     $isi = [];
        //     foreach ($firstValue as $key => $val) {
        //         if (in_array($key, $field)) {
        //             array_push($isi, ucfirst(str_replace('_', ' ', $key)) . ' = ' . $val);
        //         }
        //     }

        //     $end = ' dan termasuk ke dalam ';
        //     $yy = [];
        //     foreach ($relation as $key => $val) {
        //         $temp = [];
        //         foreach ($val['field'] as $k => $v) {
        //             array_push($temp, ucfirst(str_replace('_', ' ', $v)) . ' = ' . view($val['table'], [$val['pk'] => $val['valuePk']], $v));
        //         }
        //         $im = implode(', ', $temp);
        //         $textTemp = $val['table'] . ' dengan ' . $im;
        //         array_push($yy, $textTemp);
        //     }
        //     $nil = implode(', ', $isi);
        //     $rel = implode(', ', $yy);
        //     $text = 'Menambahkan data ' . ucfirst(str_replace('_', ' ', $table)) . ' dengan nilai ' . $nil . $end . $rel;
        //     // var_dump($text);
        //     // die;
        // }
    }
    if ($type == 'Update') {
        // if ($table != 'product_kendaraan' && $table != 'kartu_stok_non_aset' && $table != 'kartu_stok_aset' && $table != 'product') {
        if ($relation == null) {
            $merge = array_merge($firstValue, $secondValue);
            $unique = array_unique($merge);
            $isi = [];
            foreach ($unique as $key => $val) {
                if (in_array($key, $field) && $val != $firstValue[$key]) {
                    array_push($isi, ucfirst(str_replace('_', ' ', $key)) . ' = ' . $firstValue[$key] . ' ke ' . $secondValue[$key]);
                }
            }
            $nil = implode(', ', $isi);
            if ($isi == null) {
                $text = '';
            } else {
                $text = 'Mengubah data ' . ucfirst(str_replace('_', ' ', $table)) . ' dengan nilai ' . $nil;
            }
        } else {
            $merge = array_merge($firstValue, $secondValue);
            $unique = array_unique($merge);
            $isi = [];
            foreach ($unique as $key => $val) {
                if (in_array($key, $field) && $val != $firstValue[$key]) {
                    array_push($isi, ucfirst(str_replace('_', ' ', $key)) . ' = ' . $firstValue[$key] . ' ke ' . $secondValue[$key]);
                }
            }
            $end = ' dan termasuk ke dalam ';
            $yy = [];
            foreach ($relation as $key => $val) {
                $temp = [];
                foreach ($val['field'] as $k => $v) {
                    array_push($temp, ucfirst(str_replace('_', ' ', $v)) . ' = ' . view($val['table'], [$val['pk'] => $val['valuePk']], $v));
                }
                $im = implode(', ', $temp);
                $textTemp = $val['table'] . ' dengan ' . $im;
                array_push($yy, $textTemp);
            }
            $nil = implode(', ', $isi);
            $rel = implode(', ', $yy);
            if ($isi == null) {
                $text = '';
            } else {
                $text = 'Mengubah data ' . ucfirst(str_replace('_', ' ', $table)) . ' dengan nilai ' . $nil . $end . $rel;
            }
        }
        // } elseif ($table != 'kartu_stok_aset' && $table != 'product_kendaraan') {
        //     $merge = array_merge($firstValue, $secondValue);
        //     $unique = array_unique($merge);
        //     $isi = [];
        //     foreach ($unique as $key => $val) {
        //         if (in_array($key, $field) && $val != $firstValue[$key]) {
        //             array_push($isi, ucfirst(str_replace('_', ' ', $key)) . ' = ' . $firstValue[$key] . ' ke ' . $secondValue[$key]);
        //         }
        //     }
        //     $end = ' dan termasuk ke dalam ';
        //     $yy = [];
        //     foreach ($relation as $key => $val) {
        //         $temp = [];
        //         foreach ($val['field'] as $k => $v) {
        //             array_push($temp, ucfirst(str_replace('_', ' ', $v)) . ' = ' . view($val['table'], [$val['pk'] => $val['valuePk']], $v));
        //         }
        //         $im = implode(', ', $temp);
        //         $textTemp = $val['table'] . ' dengan ' . $im;
        //         array_push($yy, $textTemp);
        //     }
        //     $nil = implode(', ', $isi);
        //     $rel = implode(', ', $yy);
        //     if ($isi == null) {
        //         $text = '';
        //     } else {
        //         $text = 'Mengubah data ' . ucfirst(str_replace('_', ' ', $table)) . ' dengan nilai ' . $nil . $end . $rel;
        //     }
        // }
    }
    if ($type == 'Delete') {
        $isi = [];
        foreach ($firstValue as $key => $val) {
            if (in_array($key, $field)) {
                array_push($isi, ucfirst(str_replace('_', ' ', $key)) . ' = ' . $val);
            }
        }
        $nil = implode(', ', $isi);
        $text = 'Mengahapus data ' . ucfirst(str_replace('_', ' ', $table)) . ' dengan nilai ' . $nil;
    }
    return $text;
}

function ruangID(string $kodeRuang)
{
    $CI = &get_instance();
    $gedung  = [
        '-',
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G',
    ];
    $gedung2 = [
        '-',
        'Masjid Baitul Ilmi',
        'Gedung UKM',
        'Gedung DSC',
        'Gedung Parkir',
        'Gedung Genset',
        'Bank BJB',
        'DJ SHOP',
        'WAKAF U-MART',
        'Gudang 1',
        'POS SATPAM',
        'WC Diluar Gedung',
        'Lapangan',
        'ATM',

    ];
    $ex = explode('.', $kodeRuang);
    if (count($ex) == 5 || count($ex) == 4) {
        (int) $gee = $ex[1];
        if ($gee == 1) {
            (int) $g = $ex[2];
            $ge = $gedung[$g];
            $CI->db->from('gedung');
            $CI->db->like('namaGedung', 'Gedung ' . $ge, 'after');
        }
        if ($gee == 2) {
            (int) $g = $ex[2];
            $ge = $gedung2[$g];
            $CI->db->from('gedung');
            $CI->db->like('namaGedung', $ge, 'after');
        }
        $query = $CI->db->get()->row_array();
        if (count($ex) == 5) {
            $CI->db->like('nama', $ex[3] . '.' . $ex[4], 'after');
            $ru = $CI->db->get_where('ruangan', ['gedungId' => $query['id']])->row_array();
            if ($ru != null) {
                $rr = $ru['id'];
            } else {
                $rr = null;
            }
        } else {
            $CI->db->like('nama', $ex[3], 'after');
            $ru = $CI->db->get_where('ruangan', ['gedungId' => $query['id']])->row_array();
            if ($ru != null) {
                $rr = $ru['id'];
            } else {
                $rr = null;
            }
        }
        return $rr;
    } else {
        return null;
    }
}

function depart()
{
    return '
   [{"kodeRuang":"2.1.1.101","department":"BIRO PEMBINAAN KEMAHASISWAAN & KARAKTER"},{"kodeRuang":"2.1.1.101.1","department":"BIRO PEMBINAAN KEMAHASISWAAN & KARAKTER"},{"kodeRuang":"2.1.1.102","department":"BIRO MAL"},{"kodeRuang":"2.1.1.103","department":"BSDM"},{"kodeRuang":"2.1.1.104","department":"BIRO MAL"},{"kodeRuang":"2.1.1.201","department":"GEDUNG A"},{"kodeRuang":"2.1.1.201.1","department":"GEDUNG A"},{"kodeRuang":"2.1.1.202","department":"REKTOR"},{"kodeRuang":"2.1.1.202.1","department":"REKTOR"},{"kodeRuang":"2.1.5.103","department":"2.1.5.103"},{"kodeRuang":"2.1.5.103.1","department":"2.1.5.103.1"},{"kodeRuang":"2.1.1.204","department":"YAYASAN"},{"kodeRuang":"2.1.1.204.1","department":"YAYASAN"},{"kodeRuang":"2.1.1.205","department":"YAYASAN"},{"kodeRuang":"2.1.1.205.1","department":"YAYASAN"},{"kodeRuang":"2.1.1.205.2","department":"YAYASAN"},{"kodeRuang":"2.1.1.206","department":"GEDUNG A"},{"kodeRuang":"2.1.1.206.1","department":"GEDUNG A"},{"kodeRuang":"2.1.1.207","department":"BIRO MAL"},{"kodeRuang":"2.1.1.208","department":"BIRO MAL"},{"kodeRuang":"2.1.1.209","department":"BIRO MAL"},{"kodeRuang":"2.1.1.209.1","department":"BIRO MAL"},{"kodeRuang":"2.1.1.209.2","department":"BIRO MAL"},{"kodeRuang":"2.1.1.209.3","department":"BIRO MAL"},{"kodeRuang":"2.1.1.301","department":"WR1"},{"kodeRuang":"2.1.1.302","department":"BSDM"},{"kodeRuang":"2.1.1.302.1","department":"BSDM"},{"kodeRuang":"2.1.1.302.2","department":"BSDM"},{"kodeRuang":"2.1.1.302.3","department":"BSDM"},{"kodeRuang":"2.1.1.303","department":"WR3"},{"kodeRuang":"2.1.1.304","department":"LPPM"},{"kodeRuang":"2.1.1.304.1","department":"LPPM"},{"kodeRuang":"2.1.1.305","department":"WR 2"},{"kodeRuang":"2.1.1.306","department":"2.1.1.306"},{"kodeRuang":"2.1.1.307","department":"2.1.1.307"},{"kodeRuang":"2.1.1.307.1","department":"LPM"},{"kodeRuang":"2.1.1.308","department":"LPM"},{"kodeRuang":"2.1.1.309","department":"BIRO KEUANGAN"},{"kodeRuang":"2.1.1.309.1","department":"BIRO KEUANGAN"},{"kodeRuang":"2.1.1.310","department":"BIRO ICT"},{"kodeRuang":"2.1.1.310.1","department":"BIRO ICT"},{"kodeRuang":"2.1.1.310.2","department":"BIRO ICT"},{"kodeRuang":"2.1.1.311","department":"BIRO ICT"},{"kodeRuang":"2.1.1.312","department":"BIRO KEUANGAN"},{"kodeRuang":"2.1.1.401","department":"BIRO MAL"},{"kodeRuang":"2.1.1.402","department":"BIRO MAL"},{"kodeRuang":"2.1.1.403","department":"BIRO MAL"},{"kodeRuang":"2.1.1.404","department":"BIRO MAL"},{"kodeRuang":"2.1.1.501","department":"BIRO MAL"},{"kodeRuang":"2.1.2.101","department":"DEKANAT"},{"kodeRuang":"2.1.2.102","department":"UPT KIO"},{"kodeRuang":"2.1.2.103","department":"DEKANAT"},{"kodeRuang":"2.1.2.104","department":"UPT PELATIHAN "},{"kodeRuang":"2.1.2.105","department":"BIRO MAL"},{"kodeRuang":"2.1.2.106","department":"UPT PELATIHAN "},{"kodeRuang":"2.1.2.107","department":"UPT PELATIHAN "},{"kodeRuang":"2.1.2.108","department":"DEKAN ILKOM"},{"kodeRuang":"2.1.2.109","department":"BIRO MAL"},{"kodeRuang":"2.1.2.110","department":"BIRO MAL"},{"kodeRuang":"2.1.2.201","department":"UPT KIO"},{"kodeRuang":"2.1.2.202","department":"BIRO MAL"},{"kodeRuang":"2.1.2.202.1","department":"BIRO MAL"},{"kodeRuang":"2.1.2.203","department":"PASCA SARJANA"},{"kodeRuang":"2.1.2.203.1","department":"PASCA SARJANA"},{"kodeRuang":"2.1.2.203.2","department":"PASCA SARJANA"},{"kodeRuang":"2.1.2.204","department":"PLPP"},{"kodeRuang":"2.1.2.205","department":"PLPP"},{"kodeRuang":"2.1.2.206","department":"PLPP"},{"kodeRuang":"2.1.2.207","department":"PLPP"},{"kodeRuang":"2.1.2.208","department":"PLPP"},{"kodeRuang":"2.1.2.209","department":"BIRO MAL"},{"kodeRuang":"2.1.2.210","department":"BIRO MAL"},{"kodeRuang":"2.1.2.211","department":"BIRO MAL"},{"kodeRuang":"2.1.2.301","department":"PLPP"},{"kodeRuang":"2.1.2.302","department":"PLPP"},{"kodeRuang":"2.1.2.303","department":"PLPP"},{"kodeRuang":"2.1.2.304","department":"PLPP"},{"kodeRuang":"2.1.2.305","department":"PLPP"},{"kodeRuang":"2.1.2.306","department":"PLPP"},{"kodeRuang":"2.1.2.307","department":"PLPP"},{"kodeRuang":"2.1.2.308","department":"BIRO MAL"},{"kodeRuang":"2.1.2.309","department":"BIRO MAL"},{"kodeRuang":"2.1.2.309.1","department":"BIRO MAL"},{"kodeRuang":"2.1.3.101","department":"UPT BAHASA & PELATIHAN "},{"kodeRuang":"2.1.3.101.1","department":"UPT BAHASA & PELATIHAN "},{"kodeRuang":"2.1.3.101.2","department":"UPT PELATIHAN "},{"kodeRuang":"2.1.3.101.3","department":"UPT BAHASA "},{"kodeRuang":"2.1.3.102","department":"UPT BAHASA "},{"kodeRuang":"2.1.3.103","department":"UPT BAHASA "},{"kodeRuang":"2.1.3.104","department":"UPT BAHASA "},{"kodeRuang":"2.1.3.104.1","department":"UPT BAHASA "},{"kodeRuang":"2.1.3.104.2","department":"UPT BAHASA "},{"kodeRuang":"2.1.3.104.3","department":"UPT BAHASA "},{"kodeRuang":"2.1.3.104.4","department":"UPT BAHASA "},{"kodeRuang":"2.1.3.201","department":"UPT PERPUS"},{"kodeRuang":"2.1.3.201.1","department":"UPT PERPUS"},{"kodeRuang":"2.1.3.301","department":"UPT PERPUS"},{"kodeRuang":"2.1.3.301.1","department":"UPT PERPUS"},{"kodeRuang":"2.1.3.301.2","department":"UPT PERPUS"},{"kodeRuang":"2.1.4.101","department":"PRODI AKT"},{"kodeRuang":"2.1.4.102","department":"BANK"},{"kodeRuang":"2.1.4.103","department":"BIRO KEMAHASISWAAN"},{"kodeRuang":"2.1.4.104","department":"PRODI DKV"},{"kodeRuang":"2.1.4.104.1","department":"2.1.4.104.1"},{"kodeRuang":"2.1.4.105","department":"PLPP"},{"kodeRuang":"2.1.4.106","department":"BIRO KEMAHASISWAAN"},{"kodeRuang":"2.1.4.107","department":"BIRO MAL"},{"kodeRuang":"2.1.4.108","department":"2.1.4.108"},{"kodeRuang":"2.1.4.109","department":"2.1.4.109"},{"kodeRuang":"2.1.4.201","department":"PLPP"},{"kodeRuang":"2.1.4.202","department":"PLPP"},{"kodeRuang":"2.1.4.203","department":"PLPP"},{"kodeRuang":"2.1.4.204","department":"PLPP"},{"kodeRuang":"2.1.4.205","department":"PLPP"},{"kodeRuang":"2.1.4.206","department":"PLPP"},{"kodeRuang":"2.1.4.301","department":"PLPP"},{"kodeRuang":"2.1.4.302","department":"PLPP"},{"kodeRuang":"2.1.4.303","department":"PLPP"},{"kodeRuang":"2.1.4.304","department":"PLPP"},{"kodeRuang":"2.1.4.305","department":"PLPP"},{"kodeRuang":"2.1.4.306","department":"PLPP"},{"kodeRuang":"2.1.5.101","department":"BIRO HUMAS PEMASARAN "},{"kodeRuang":"2.1.5.101.1","department":"BIRO HUMAS PEMASARAN "},{"kodeRuang":"2.1.5.102","department":"BIRO HUMAS PEMASARAN "},{"kodeRuang":"2.1.5.102.1","department":"BIRO HUMAS PEMASARAN "},{"kodeRuang":"2.1.5.102.2","department":"BIRO HUMAS PEMASARAN "},{"kodeRuang":"2.1.5.103","department":"BIRO HUMAS PEMASARAN "},{"kodeRuang":"2.1.5.103.1","department":"BIRO HUMAS PEMASARAN "},{"kodeRuang":"2.1.5.104","department":"PLPP"},{"kodeRuang":"2.1.5.201","department":"PLPP"},{"kodeRuang":"2.1.5.202","department":"PLPP"},{"kodeRuang":"2.1.5.203","department":"PLPP"},{"kodeRuang":"2.1.5.204","department":"PLPP"},{"kodeRuang":"2.1.5.301","department":"PLPP"},{"kodeRuang":"2.1.5.302","department":"PLPP"},{"kodeRuang":"2.1.5.303","department":"PLPP"},{"kodeRuang":"2.1.5.304","department":"PLPP"},{"kodeRuang":"2.1.6.101","department":"PRODI TI"},{"kodeRuang":"2.1.6.102","department":"PRODI SK"},{"kodeRuang":"2.1.6.103","department":"PRODI MA"},{"kodeRuang":"2.1.6.104","department":"PRODI AKT"},{"kodeRuang":"2.1.6.105","department":"BAAK"},{"kodeRuang":"2.1.6.106","department":"PLPP"},{"kodeRuang":"2.1.6.107","department":"PRODI SI"},{"kodeRuang":"2.1.6.108","department":"2.1.6.108"},{"kodeRuang":"2.1.6.109","department":"GEDUNG F"},{"kodeRuang":"2.1.6.110","department":"GEDUNG F"},{"kodeRuang":"2.1.6.201","department":"PLPP"},{"kodeRuang":"2.1.6.202","department":"PLPP"},{"kodeRuang":"2.1.6.203","department":"PLPP"},{"kodeRuang":"2.1.6.204","department":"PLPP"},{"kodeRuang":"2.1.6.205","department":"PLPP"},{"kodeRuang":"2.1.6.206","department":"PLPP"},{"kodeRuang":"2.1.6.207","department":"PLPP"},{"kodeRuang":"2.1.6.208","department":"PLPP"},{"kodeRuang":"2.1.6.209","department":"PRODI MANAJEMEN"},{"kodeRuang":"2.1.6.210","department":"GEDUNG F"},{"kodeRuang":"2.1.6.211","department":"GEDUNG F"},{"kodeRuang":"2.1.6.301","department":"PLPP"},{"kodeRuang":"2.1.6.302","department":"PLPP"},{"kodeRuang":"2.1.6.303","department":"PLPP"},{"kodeRuang":"2.1.6.304","department":"PLPP"},{"kodeRuang":"2.1.6.305","department":"PLPP"},{"kodeRuang":"2.1.6.306","department":"PLPP"},{"kodeRuang":"2.1.6.307","department":"PLPP"},{"kodeRuang":"2.1.6.308","department":"PLPP"},{"kodeRuang":"2.1.6.309","department":"GEDUNG F"},{"kodeRuang":"2.1.6.310","department":"GEDUNG F"},{"kodeRuang":"2.1.6.401","department":"PLPP"},{"kodeRuang":"2.1.6.402","department":"PLPP"},{"kodeRuang":"2.1.6.403","department":"PLPP"},{"kodeRuang":"2.1.6.404","department":"PLPP"},{"kodeRuang":"2.1.6.405","department":"PLPP"},{"kodeRuang":"2.1.6.406","department":"PLPP"},{"kodeRuang":"2.1.6.407","department":"PLPP"},{"kodeRuang":"2.1.6.408","department":"PLPP"},{"kodeRuang":"2.1.6.409","department":"GEDUNG F"},{"kodeRuang":"2.1.6.410","department":"GEDUNG F"},{"kodeRuang":"2.1.6.501","department":"BIRO KEMAHASISWAAN"},{"kodeRuang":"2.1.6.502","department":"BIRO KEMAHASISWAAN"},{"kodeRuang":"2.1.6.503","department":"BIRO KEMAHASISWAAN"},{"kodeRuang":"2.1.6.504","department":"BIRO KEMAHASISWAAN"},{"kodeRuang":"2.1.6.505","department":"BIRO KEMAHASISWAAN"},{"kodeRuang":"2.1.6.506","department":"BIRO KEMAHASISWAAN"},{"kodeRuang":"2.1.6.507","department":"BIRO KEMAHASISWAAN"},{"kodeRuang":"2.1.6.508","department":"BIRO KEMAHASISWAAN"},{"kodeRuang":"2.1.7.101","department":"PLPP"},{"kodeRuang":"2.1.7.102","department":"PLPP"},{"kodeRuang":"2.1.7.103","department":"PLPP"},{"kodeRuang":"2.1.7.104","department":"PLPP"},{"kodeRuang":"2.1.7.105","department":"PLPP"},{"kodeRuang":"2.1.7.106","department":"PLPP"},{"kodeRuang":"2.1.7.107","department":"PLPP"},{"kodeRuang":"2.1.7.108","department":"PLPP"},{"kodeRuang":"2.1.7.109","department":"KEUANGAN"},{"kodeRuang":"2.1.7.110","department":"GEDUNG G"},{"kodeRuang":"2.1.7.201","department":"2.1.7.201"},{"kodeRuang":"2.1.7.202","department":"2.1.7.202"},{"kodeRuang":"2.1.7.203","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.204","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.205","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.206","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.207","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.208","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.209","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.210","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.211","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.301","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.302","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.303","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.304","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.305","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.306","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.307","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.308","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.309","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.310","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.311","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.401","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.402","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.403","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.404","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.405","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.406","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.407","department":"LABORATURIUM"},{"kodeRuang":"2.1.7.408","department":"LABORATURIUM"},{"kodeRuang":"2.1.1.203","department":"2.1.1.203"},{"kodeRuang":"2.1.1.203.1","department":"2.1.1.203.1"},{"kodeRuang":"2.2.10.101","department":"2.2.10.101"},{"kodeRuang":"2.2.5.102","department":"2.2.5.102"},{"kodeRuang":"2.1.1.304.2","department":"2.1.1.304.2"},{"kodeRuang":"2.1.1.308.1","department":"2.1.1.308.1"},{"kodeRuang":"2.1.7.409","department":"2.1.7.409"},{"kodeRuang":"2.1.7.410","department":"2.1.7.410"},{"kodeRuang":"2.2.3.204","department":"2.2.3.204"},{"kodeRuang":"2.2.3.203","department":"2.2.3.203"},{"kodeRuang":"2.2.3.205","department":"2.2.3.205"}]
    ';
}
function dept(string $kodeRuang): string
{
    $CI = &get_instance();

    foreach (json_decode(depart(), TRUE) as $k => $v) {
        if ($kodeRuang == $v['kodeRuang']) {
            $ff = $CI->db->get_where('department', ['nameLong' => $v['department']])->row_array();
            if ($ff['nameShort'] == null) {
                echo $kodeRuang . "|" . $v['department'];
                die;
            }
            return $ff['nameShort'];
        }
    }
}
