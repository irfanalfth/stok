<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class InputExcel extends CI_Controller
{
    public function index()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("final2.xlsx");
        $sheet = $spreadsheet->getSheet(6);

        $f = "5";
        $l = "6781";

        $all = [];
        $data = [];

        for ($i = $f; $i <= $l; $i++) {
            $k = strtoupper($sheet->getCell("D" . $i)->getValue());
            $sk = strtoupper($sheet->getCell("E" . $i)->getValue());
            $ssk = strtoupper($sheet->getCell("F" . $i)->getValue());

            $nb = strtoupper($sheet->getCell("C" . $i)->getValue());
            $m = strtoupper($sheet->getCell("I" . $i)->getValue());
            $sp = strtoupper($sheet->getCell("J" . $i)->getValue());
            $ket = strtoupper($sheet->getCell("K" . $i)->getValue());
            $dsc = $sp . ',' . $ket;

            $kategori = $this->db->get_where('kelompok', ['namaKelompok' => $k])->row_array();
            if ($kategori) {
                $subKategori = $this->db->get_where('sub_kelompok', ['kodeKelompok' => $kategori['id'], 'namaSub' => $sk])->row_array();
                if ($subKategori) {
                    $subsKategori = $this->db->get_where('barang', ['kodeSub' => $subKategori['id'], 'namaBarang' => $ssk])->row_array();
                    if ($subsKategori) {
                        $params = [
                            'nama' => $nb,
                            'merek' => $m,
                            'satuan' => "pcs",
                            'deskripsi' => $dsc,
                            'gambar' => '-',
                            'createdAt' => date('Y-m-d H:i:s'),
                            'updatedAt' => date('Y-m-d H:i:s'),
                            'kodeBarang' => $subsKategori['id'],
                        ];

                        array_push($data, $params);
                    } else {
                        array_push($all, "Sub Sub Kategori | " . $ssk . " | " . $i . "\n");
                        continue;
                    }
                } else {
                    array_push($all, "Sub Kategori | " . $sk . " | " . $i . "\n");
                    continue;
                }
            } else {
                array_push($all, "Sub Sub Kategori | " . $k . " | " . $i . "\n");
                continue;
            }
        }
        // $this->db->insert_batch('product', $data);
        // file_put_contents('err_input_persediaan2_' . date('Y-m-d') . '2.txt', $all);
        $all = json_encode($all, TRUE);
        file_put_contents('error/err_input_peralatan2.json', $all);
    }

    public function satuan()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("aa_backup.xlsx");
        $sheet = $spreadsheet->getSheet(8);

        $f = "5";
        $l = "849";

        $all = [];
        $satuan = [];

        for ($i = $f; $i <= $l; $i++) {
            $sat = strtoupper($sheet->getCell("H" . $i)->getValue());
            array_push($satuan, $sat);
        }
    }

    function peralatan()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("final2.xlsx");
        $sheet = $spreadsheet->getSheet(7);

        $f = "5";
        $l = "6781";

        $all = [];
        $data = [];
        $tempKategori = '';
        $tempSubKategori = '';
        $tempSubSubKategori = '';
        for ($i = $f; $i <= $l; $i++) {
            $k = (strtoupper($sheet->getCell("E" . $i)->getValue()) == null || strtoupper($sheet->getCell("E" . $i)->getValue()) == '') ? $tempKategori : strtoupper($sheet->getCell("E" . $i)->getValue());
            $sk = (strtoupper($sheet->getCell("F" . $i)->getValue()) == null || strtoupper($sheet->getCell("F" . $i)->getValue()) == '') ? $tempSubKategori : strtoupper($sheet->getCell("F" . $i)->getValue());
            $ssk = (strtoupper($sheet->getCell("G" . $i)->getValue()) == null || strtoupper($sheet->getCell("G" . $i)->getValue()) == '') ? $tempSubSubKategori : strtoupper($sheet->getCell("G" . $i)->getValue());

            $nb = strtoupper($sheet->getCell("D" . $i)->getValue());
            $m = (strtoupper($sheet->getCell("I" . $i)->getValue()) == null || strtoupper($sheet->getCell("I" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("I" . $i)->getValue());
            $sp = (strtoupper($sheet->getCell("J" . $i)->getValue()) == null || strtoupper($sheet->getCell("J" . $i)->getValue()) == '') ? "" : strtoupper($sheet->getCell("J" . $i)->getValue());
            $ket = (strtoupper($sheet->getCell("K" . $i)->getValue()) == null || strtoupper($sheet->getCell("K" . $i)->getValue()) == '') ? "" : strtoupper($sheet->getCell("K" . $i)->getValue());
            $dsc = $sp . ',' . $ket;

            $kategori = $this->db->get_where('kelompok', ['namaKelompok' => $k])->row_array();
            if ($kategori) {
                $subKategori = $this->db->get_where('sub_kelompok', ['kodeKelompok' => $kategori['id'], 'namaSub' => $sk])->row_array();
                if ($subKategori) {
                    $subsKategori = $this->db->get_where('barang', ['kodeSub' => $subKategori['id'], 'namaBarang' => $ssk])->row_array();
                    if ($subsKategori) {
                        $params = [
                            'nama' => $nb,
                            'merek' => $m,
                            'satuan' => view('satuan', ['name' => 'PCS'], 'id'),
                            'deskripsi' => $dsc,
                            'gambar' => '-',
                            'createdAt' => date('Y-m-d H:i:s'),
                            'updatedAt' => date('Y-m-d H:i:s'),
                            'kodeBarang' => $subsKategori['id'],
                        ];

                        array_push($data, $params);
                    } else {
                        array_push($all, "Sub Sub Kategori | " . $ssk . " | " . $i . "\n");
                        continue;
                    }
                } else {
                    array_push($all, "Sub Kategori | " . $sk . " | " . $i . "\n");
                    continue;
                }
            } else {
                array_push($all, "Sub Sub Kategori | " . $k . " | " . $i . "\n");
                continue;
            }
        }
        // $this->db->insert_batch('product', $data);

        // file_put_contents('err_input_peralatan_' . date('Y-m-d') . '2.txt', $all);
        $all = json_encode($all, TRUE);
        file_put_contents('error/err_input_peralatan.json', $all);
    }

    function persediaan()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("final2.xlsx");
        $sheet = $spreadsheet->getSheet(8);

        $f = "5";
        $l = "849";

        $all = [];
        $data = [];

        for ($i = $f; $i <= $l; $i++) {
            $k = strtoupper($sheet->getCell("D" . $i)->getValue());
            $sk = strtoupper($sheet->getCell("E" . $i)->getValue());
            $ssk = strval(strtoupper($sheet->getCell("F" . $i)->getValue()));

            $nb = strtoupper($sheet->getCell("G" . $i)->getValue());
            $sat = strtoupper($sheet->getCell("H" . $i)->getValue());
            $m = (strtoupper($sheet->getCell("I" . $i)->getValue()) == null || strtoupper($sheet->getCell("I" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("I" . $i)->getValue());

            $kategori = $this->db->get_where('kelompok', ['namaKelompok' => $k])->row_array();
            if ($kategori) {
                $subKategori = $this->db->get_where('sub_kelompok', ['kodeKelompok' => $kategori['id'], 'namaSub' => $sk])->row_array();
                if ($subKategori) {
                    $subsKategori = $this->db->get_where('barang', ['kodeSub' => $subKategori['id'], 'namaBarang' => $ssk])->row_array();
                    if ($subsKategori) {
                        $params = [
                            'nama' => $nb,
                            'merek' => $m,
                            'satuan' => view('satuan', ['name' => strtoupper($sat)], 'id'),
                            'deskripsi' => '-',
                            'gambar' => '-',
                            'createdAt' => date('Y-m-d H:i:s'),
                            'updatedAt' => date('Y-m-d H:i:s'),
                            'kodeBarang' => $subsKategori['id'],
                        ];

                        array_push($data, $params);
                    } else {
                        array_push($all, "Sub Sub Kategori | " . $ssk . " | " . $i . "\n");
                        continue;
                    }
                } else {
                    array_push($all, "Sub Kategori | " . $sk . " | " . $i . "\n");
                    continue;
                }
            } else {
                array_push($all, "Sub Sub Kategori | " . $k . " | " . $i . "\n");
                continue;
            }
        }
        // $this->db->insert_batch('product', $data);

        // file_put_contents('err_input_persedian_' . date('Y-m-d') . '2.txt', $all);
        $all = json_encode($all, TRUE);
        file_put_contents('error/err_input_persediaan.json', $all);
    }

    function kendaraan()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("final2.xlsx");
        $sheet = $spreadsheet->getSheet(5);

        $f = "5";
        $l = "18";

        $all = [];

        for ($i = $f; $i <= $l; $i++) {
            $k = strtoupper($sheet->getCell("D" . $i)->getValue());
            $sk = strtoupper($sheet->getCell("E" . $i)->getValue());
            $ssk = strval(strtoupper($sheet->getCell("F" . $i)->getValue()));

            $nb = strtoupper($sheet->getCell("C" . $i)->getValue());
            $m = (strtoupper($sheet->getCell("J" . $i)->getValue()) == null || strtoupper($sheet->getCell("J" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("J" . $i)->getValue());
            $tipe = (strtoupper($sheet->getCell("K" . $i)->getValue()) == null || strtoupper($sheet->getCell("K" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("K" . $i)->getValue());
            $bb = (strtoupper($sheet->getCell("L" . $i)->getValue()) == null || strtoupper($sheet->getCell("L" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("L" . $i)->getValue());
            $thn = (strtoupper($sheet->getCell("M" . $i)->getValue()) == null || strtoupper($sheet->getCell("M" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("M" . $i)->getValue());
            $warna = (strtoupper($sheet->getCell("O" . $i)->getValue()) == null || strtoupper($sheet->getCell("O" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("O" . $i)->getValue());
            $hp = (strtoupper($sheet->getCell("P" . $i)->getValue()) == null || strtoupper($sheet->getCell("P" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("P" . $i)->getValue());

            $kategori = $this->db->get_where('kelompok', ['namaKelompok' => $k])->row_array();
            if ($kategori) {
                $subKategori = $this->db->get_where('sub_kelompok', ['kodeKelompok' => $kategori['id'], 'namaSub' => $sk])->row_array();
                if ($subKategori) {
                    $subsKategori = $this->db->get_where('barang', ['kodeSub' => $subKategori['id'], 'namaBarang' => $ssk])->row_array();
                    if ($subsKategori) {
                        $params = [
                            'nama' => $nb,
                            'merek' => $m,
                            'satuan' => view('satuan', ['name' => 'UNIT'], 'id'),
                            'deskripsi' => '-',
                            'gambar' => '-',
                            'createdAt' => date('Y-m-d H:i:s'),
                            'updatedAt' => date('Y-m-d H:i:s'),
                            'kodeBarang' => $subsKategori['id'],
                        ];
                        $hah = $this->db->insert('product', $params);
                        $last_id = $this->lastID();
                        if ($hah) {
                            $ken = [
                                'tipe' => $tipe,
                                'bahanBakar' => $bb,
                                'thPembuatan' => $thn,
                                'warna' => $warna,
                                'hp' => $hp,
                                'createdAt' => date('Y-m-d H:i:s'),
                                'updatedAt' => date('Y-m-d H:i:s'),
                                'kodeBarang' => $last_id,
                            ];
                            $this->db->insert('product_kendaraan', $ken);
                        } else {
                            $this->db->delete('product', ['id' => $last_id]);
                        }
                    } else {
                        array_push($all, "Sub Sub Kategori | " . $ssk . " | " . $i . "\n");
                        continue;
                    }
                } else {
                    array_push($all, "Sub Kategori | " . $sk . " | " . $i . "\n");
                    continue;
                }
            } else {
                array_push($all, "Sub Sub Kategori | " . $k . " | " . $i . "\n");
                continue;
            }
        }
        file_put_contents('err_input_kendaraan_' . date('Y-m-d') . '2.txt', $all);
    }

    function lastID()
    {
        return $this->db->order_by('mili', 'desc')->get('product', 1)->row_array()['id'];
    }

    function department()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("department.xlsx");
        $sheet = $spreadsheet->getSheet(8);
        $f = "6";
        $l = "228";

        $all = [];
        $gg = [];


        for ($i = $f; $i <= $l; $i++) {
            $asd = strtoupper((preg_match("/[a-zA-Z]+/", $sheet->getCell("H" . $i)->getValue())) ? $sheet->getCell("H" . $i)->getValue() : $sheet->getCell("G" . $i)->getValue());
            if ($asd == '' || $asd == null) {
                $dd = strtoupper($sheet->getCell("G" . $i)->getValue());
                $asd = $dd;
            }
            array_push($all, $asd);
        }

        $unique = array_unique($all);
        foreach ($unique as $key => $val) {
            // if ($val != 'REKTOR') {
            if (preg_match("/[a-zA-Z]+/", $val)) {
                if (ctype_upper($val)) {
                    $sn = $val;
                } elseif (strlen($val) < 5) {
                    $sn = $val;
                } elseif (preg_match("/UPT/i", $val)) {
                    $sn = $val;
                } elseif (preg_match("/LABORATURIUM/i", $val)) {
                    $sn = "LAB";
                } elseif (preg_match("/PRODI/i", $val)) {

                    $sn = 'PR' . substr($val, 6, 10);
                } elseif (preg_match("/BIRO/i", $val)) {
                    if (strlen($val) > 15) {
                        $sn = preg_replace("/[^A-Z]+/", "", ucwords(strtolower($val)));
                    } else {
                        $sn = str_replace(' ', '', str_replace('BIRO', 'BR', $val));
                    }
                } elseif (preg_match("/GEDUNG/i", $val)) {
                    $sn = str_replace(' ', '', str_replace('GEDUNG', 'GD', $val));
                } else {
                    $sn = preg_replace("/[^A-Z]+/", "", ucwords(strtolower($val)));
                    if (preg_match("/BK/i", $sn) || preg_match("/PS/i", $sn) || preg_match("/PM/i", $sn)) {
                        $sn = $val;
                    }
                }
            } else {
                $sn = $val;
            }
            // $rr[] = $sn;
            $asdf = [
                'nameShort' => str_replace(' ', '', $sn),
                'nameLong' => $val,
                'level' => 0
            ];
            // array_push($gg, $asdf);
            $this->db->insert('department', $asdf);
            // }
        }
        // var_dump(array_count_values($rr));
        // die;
    }

    function ruangan()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $spreadsheet = $reader->load("department.xls");
        $sheet = $spreadsheet->getSheet(9);
        $f = "6";
        $l = "56";

        $all = [];
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
        for ($i = $f; $i <= $l; $i++) {
            $noGedung = trim($sheet->getCell("E" . $i)->getValue());
            $gedung = $gedung2[$noGedung];
            $this->db->from('gedung');
            $this->db->like('namaGedung', $gedung, 'after');
            $query = $this->db->get()->row_array();
            $params = [
                'nama' => trim(str_replace(".", ".", $sheet->getCell("F" . $i)->getValue())) . ' - ' . trim(strtoupper($sheet->getCell("E" . $i)->getValue())),
                'jenisRuangan' => '-',
                'posisiRuangan' => '-',
                'ukuranRuangan' => '-',
                'kapasitasRuangan' => 0,
                'gedungId' => $query['id']
            ];
            array_push($all, $params);
        }
        $this->db->insert_batch('ruangan', $all);
    }



    function run()
    {
        //cek kode ruang 
        // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        // $spreadsheet = $reader->load("final2.xlsx");
        // $sheet = $spreadsheet->getSheet(7);

        // $f = "5";
        // // $l = "6781";
        // $l = "6777";

        // $all = [];

        // for ($i = $f; $i <= $l; $i++) {
        //     $k = strtoupper($sheet->getCell("T" . $i)->getValue());
        //     if ($k == '' || $k == null) {
        //         echo $l;
        //         die;
        //     }
        //     $cek =  array_search($k, array_column(json_decode(depart(), TRUE), 'kodeRuang'));
        //     if (is_bool($cek)) {
        //         $ss = $k;
        //         array_push($all, $ss);
        //     }
        // }
        // var_dump(array_unique($all));

        //convert dari excel ke json
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("department.xlsx");
        $sheet = $spreadsheet->getSheet(8);

        $f = "6";
        $l = "228";

        $d = [];

        for ($i = $f; $i <= $l; $i++) {
            $kR = strtoupper($sheet->getCell("G" . $i)->getValue());
            $department = strtoupper($sheet->getCell("H" . $i)->getValue());
            $params = [
                'kodeRuang' => $kR,
                'department' => ($department == '' || $department == null) ? $kR : $department
            ];
            array_push($d, $params);
        }
        echo json_encode($d, TRUE);
        // echo dept('2.1.6.108');
    }

    function replace()
    {
        $this->load->model('Global_model');
        $dd = $this->Global_model->get_data('ruangan', []);
        foreach ($dd as $k) {
            $nm = strtoupper($k['nama']);
            $nm = str_replace(',', '.', $nm);
            $split = explode('-', $nm);
            $str1 = trim($split[0]);
            $str2 = trim($split[1]);
            $fix = $str1 . " - " . $str2;
            $ha = $this->Global_model->update('ruangan', ['nama' => $fix], ['id' => $k['id']]);
            if ($ha) {
            } else {
                echo "S | $fix \n";
            }
        }
    }


    function cekStatusPembelianPeralatan2()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("final2.xlsx");
        $sheet = $spreadsheet->getSheet(6);

        $f = "31";
        $l = "6781";

        $all = [];

        for ($i = $f; $i <= $l; $i++) {
            $hh = trim($sheet->getCell("T" . $i)->getValue());
            $ex = explode(".", $hh);
            $g = $ex[2];
            var_dump($g);
        }
    }

    public function tran_peralatan2()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("final17062021.xlsx");
        $sheet = $spreadsheet->getSheet(5);

        $f = "5";
        // $l = "15";
        $l = "6781";

        $all = [];

        for ($i = $f; $i <= $l; $i++) {
            $k = strtoupper($sheet->getCell("D" . $i)->getValue());
            $sk = strtoupper($sheet->getCell("E" . $i)->getValue());
            $ssk = strtoupper($sheet->getCell("F" . $i)->getValue());

            $nb = strtoupper($sheet->getCell("C" . $i)->getValue());
            $m = strtoupper($sheet->getCell("I" . $i)->getValue());
            $sp = strtoupper($sheet->getCell("J" . $i)->getValue());
            $ket = strtoupper($sheet->getCell("K" . $i)->getValue());
            $dsc = $sp . ',' . $ket;

            $kategori = $this->db->get_where('kelompok', ['namaKelompok' => $k])->row_array();
            if ($kategori) {
                $subKategori = $this->db->get_where('sub_kelompok', ['kodeKelompok' => $kategori['id'], 'namaSub' => $sk])->row_array();
                if ($subKategori) {
                    $subsKategori = $this->db->get_where('barang', ['kodeSub' => $subKategori['id'], 'namaBarang' => $ssk])->row_array();
                    if ($subsKategori) {

                        $kondisi = '-';
                        $kon = trim($sheet->getCell("U" . $i)->getValue());
                        if ($kon != "") {
                            $kondisi = 'Baik';
                        } else {
                            $kon = trim($sheet->getCell("V" . $i)->getValue());
                            if ($kon != "") {
                                $kondisi = 'Rusak';
                            } else {
                                $kon = trim($sheet->getCell("W" . $i)->getValue());
                                if ($kon != "") {
                                    $kondisi = 'Hilang';
                                }
                                // else {
                                //     $kon = trim($sheet->getCell("X" . $i)->getValue());
                                //     if ($kon != "") {
                                //         $kondisi = 'Pindah';
                                //     }
                                // }
                            }
                        }
                        $kdRuang = trim($sheet->getCell("T" . $i)->getValue());
                        // var_dump(getInventaris(dept($kdRuang)));
                        // die;
                        if (is_string(getInventaris(dept($kdRuang)))) {
                            $ruang = ruangID(trim($sheet->getCell("T" . $i)->getValue()));
                            if ($ruang == null) {
                                array_push($all, "Kode Ruang | " . trim($sheet->getCell("T" . $i)->getValue()) . " | " . $i . "\n");
                                continue;
                            } else {
                                $params = [
                                    'nama' => $nb,
                                    'merek' => $m,
                                    'satuan' => "pcs",
                                    'deskripsi' => $dsc,
                                    'gambar' => '-',
                                    'createdAt' => date('Y-m-d H:i:s'),
                                    'updatedAt' => date('Y-m-d H:i:s'),
                                    'kodeBarang' => $subsKategori['id'],
                                ];
                                $this->db->insert('product', $params);
                                $bbb = $this->db->insert_id();
                                $kdRuang = trim($sheet->getCell("T" . $i)->getValue());

                                $par2 = [
                                    'noInventaris' => getInventaris(dept($kdRuang)) . "-SA",
                                    'hargaPerolehan' => ($sheet->getCell("O" . $i)->getValue() == null || trim($sheet->getCell("O" . $i)->getValue()) == '') ? 0 : $sheet->getCell("O" . $i)->getValue(),
                                    'masaManfaat' => ($sheet->getCell("Q" . $i)->getValue() == null || trim($sheet->getCell("Q" . $i)->getValue()) == '') ? 0 : $sheet->getCell("Q" . $i)->getValue(),
                                    'supplier' => ($sheet->getCell("N" . $i)->getValue() == null || trim($sheet->getCell("N" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("N" . $i)->getValue()),
                                    'pengguna' => ($sheet->getCell("R" . $i)->getValue() == null || trim($sheet->getCell("R" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("R" . $i)->getValue()),
                                    'statusPerolehan' => 'Beli',
                                    'lokasi' => ($sheet->getCell("S" . $i)->getValue() == null || trim($sheet->getCell("S" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("S" . $i)->getValue()),
                                    'kondisi' => $kondisi,
                                    'productId' => $bbb,
                                    'kodeRuang' => $ruang,
                                    'status' => 'import'
                                ];
                                $this->db->insert('kartu_stok_aset', $par2);
                            }
                        } else {
                            array_push($all, "Kode Ruang | " . $ssk . " | " . $i . "\n");
                            continue;
                        }
                    } else {
                        array_push($all, "Sub Sub Kategori | " . $ssk . " | " . $i . "\n");
                        continue;
                    }
                } else {
                    array_push($all, "Sub Kategori | " . $sk . " | " . $i . "\n");
                    continue;
                }
            } else {
                array_push($all, "Sub Sub Kategori | " . $k . " | " . $i . "\n");
                continue;
            }
        }
        // $this->db->insert_batch('product', $data);
        // file_put_contents('err_input_persediaan2_' . date('Y-m-d') . '2.txt', $all);
        $all = json_encode($all, TRUE);
        file_put_contents('error/tran_peralatan2.json', $all);
    }


    public function tran_peralatan()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("final17062021.xlsx");
        $sheet = $spreadsheet->getSheet(6);

        $f = "5";
        // $l = "15";
        $l = "6781";

        $all = [];

        for ($i = $f; $i <= $l; $i++) {
            $k = strtoupper($sheet->getCell("E" . $i)->getValue());
            $sk = strtoupper($sheet->getCell("F" . $i)->getValue());
            $ssk = strtoupper($sheet->getCell("G" . $i)->getValue());

            $nb = strtoupper($sheet->getCell("D" . $i)->getValue());
            $m = strtoupper($sheet->getCell("I" . $i)->getValue());
            $sp = strtoupper($sheet->getCell("J" . $i)->getValue());
            // $ket = strtoupper($sheet->getCell("K" . $i)->getValue());
            $dsc = $sp;

            $kategori = $this->db->get_where('kelompok', ['namaKelompok' => $k])->row_array();
            if ($kategori) {
                $subKategori = $this->db->get_where('sub_kelompok', ['kodeKelompok' => $kategori['id'], 'namaSub' => $sk])->row_array();
                if ($subKategori) {
                    $subsKategori = $this->db->get_where('barang', ['kodeSub' => $subKategori['id'], 'namaBarang' => $ssk])->row_array();
                    if ($subsKategori) {

                        $kondisi = '-';
                        $kon = trim($sheet->getCell("V" . $i)->getValue());
                        if ($kon != "") {
                            $kondisi = 'Baik';
                        } else {
                            $kon = trim($sheet->getCell("W" . $i)->getValue());
                            if ($kon != "") {
                                $kondisi = 'Rusak';
                            } else {
                                $kon = trim($sheet->getCell("X" . $i)->getValue());
                                if ($kon != "") {
                                    $kondisi = 'Hilang';
                                }
                                // else {
                                //     $kon = trim($sheet->getCell("Y" . $i)->getValue());
                                //     if ($kon != "") {
                                //         $kondisi = 'Pindah';
                                //     }
                                // }
                            }
                        }
                        $kdRuang = trim($sheet->getCell("T" . $i)->getValue());
                        // var_dump(getInventaris(dept($kdRuang)));
                        // die;
                        if (is_string(getInventaris(dept($kdRuang)))) {
                            $ruang = ruangID(trim($sheet->getCell("T" . $i)->getValue()));
                            if ($ruang == null) {
                                array_push($all, "Kode Ruang | " . trim($sheet->getCell("T" . $i)->getValue()) . " | " . $i . "\n");
                                continue;
                            } else {
                                $params = [
                                    'nama' => $nb,
                                    'merek' => $m,
                                    'satuan' => "pcs",
                                    'deskripsi' => $dsc,
                                    'gambar' => '-',
                                    'createdAt' => date('Y-m-d H:i:s'),
                                    'updatedAt' => date('Y-m-d H:i:s'),
                                    'kodeBarang' => $subsKategori['id'],
                                ];
                                $this->db->insert('product', $params);
                                $kdRuang = trim($sheet->getCell("T" . $i)->getValue());

                                $par2 = [
                                    'noInventaris' => getInventaris(dept($kdRuang)) . "-SA",
                                    'hargaPerolehan' => ($sheet->getCell("O" . $i)->getValue() == null || trim($sheet->getCell("O" . $i)->getValue()) == '') ? 0 : $sheet->getCell("O" . $i)->getValue(),
                                    'masaManfaat' => ($sheet->getCell("Q" . $i)->getValue() == null || trim($sheet->getCell("Q" . $i)->getValue()) == '') ? 0 : $sheet->getCell("Q" . $i)->getValue(),
                                    'supplier' => ($sheet->getCell("N" . $i)->getValue() == null || trim($sheet->getCell("N" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("N" . $i)->getValue()),
                                    'pengguna' => ($sheet->getCell("R" . $i)->getValue() == null || trim($sheet->getCell("R" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("R" . $i)->getValue()),
                                    'statusPerolehan' => 'Beli',
                                    'lokasi' => ($sheet->getCell("S" . $i)->getValue() == null || trim($sheet->getCell("S" . $i)->getValue()) == '') ? "-" : strtoupper($sheet->getCell("S" . $i)->getValue()),
                                    'kondisi' => $kondisi,
                                    'productId' => $this->lastID(),
                                    'kodeRuang' => $ruang,
                                    'status' => 'import'
                                ];
                                $this->db->insert('kartu_stok_aset', $par2);
                            }
                        } else {
                            array_push($all, "Kode Ruang | " . $ssk . " | " . $i . "\n");
                            continue;
                        }
                    } else {
                        array_push($all, "Sub Sub Kategori | " . $ssk . " | " . $i . "\n");
                        continue;
                    }
                } else {
                    array_push($all, "Sub Kategori | " . $sk . " | " . $i . "\n");
                    continue;
                }
            } else {
                array_push($all, "Sub Sub Kategori | " . $k . " | " . $i . "\n");
                continue;
            }
        }
        // $this->db->insert_batch('product', $data);
        // file_put_contents('err_input_persediaan2_' . date('Y-m-d') . '2.txt', $all);
        $all = json_encode($all, TRUE);
        file_put_contents('error/tran_peralatan2.json', $all);
    }
}
