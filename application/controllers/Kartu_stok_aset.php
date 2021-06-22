<?php
class Kartu_stok_aset extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('isLogIn') != true) {
            redirect('auth/logout');
        }
        $this->load->model('Kartu_stok_aset_model');
        $this->load->model('Produk_model');
        $this->load->model('Department_model');
        $this->load->model('Gedung_model');
        $this->load->model('Global_model');
        $this->load->model('Ruangan_model');
        $this->load->helper(array('download'));
    }
    function index()
    {
        $jsondata = file_get_contents('error/err_input_peralatan2.json');
        $dat = json_decode($jsondata, true);
        $data['berhasil'] = '12393'; 
        $data['error'] =  0;
        $data['jumlah'] = $this->db->from('kartu_stok_aset')->count_all_results() + $this->db->from('kartu_stok_non_aset')->count_all_results();
        $data['ruangan'] = $this->Ruangan_model->get_all_ruangan();
        if ($this->uri->segment(3) != null) {
            $data['kartu_stok_aset_']  = $this->db->order_by('createdAt','desc')->get_where('kartu_stok_aset', ['kodeRuang' => $this->uri->segment(3)])->result_array();
            $data['kebanyakan'] = false;

        } else {
            $data['kebanyakan'] = true;
        }
        // $data['base64'] = chunk_split(base64_encode(file_get_contents(base_url('assets/pdf/') . '0004-BAAK-IV-2021.pdf')));
        $data['_view'] = 'guest/kartu_stok_aset/index';
        $this->load->view('guest/layouts/main', $data);
    }
    function detailerror()
    {
        $jsondata = file_get_contents('error/err_input_peralatan2.json');
        $dat = json_decode($jsondata, true);
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("final3.xlsx");
        $sheet = $spreadsheet->getSheet(5);
        $cellvalue=[];
        foreach ($dat as $dd) {
            $ex = explode(' | ', $dd);
            $num = preg_replace('/\s+/', '',$ex[2]);
            $cellvalue[] = [ 
            'C' => strtoupper($sheet->getCell("C" . $num)->getValue()),
            'D' => strtoupper($sheet->getCell("D" . $num)->getValue()),
            'E' => strtoupper($sheet->getCell("E" . $num)->getValue()),
            'F' => strtoupper($sheet->getCell("F" . $num)->getValue()),
            'G' => strtoupper($sheet->getCell("G" . $num)->getValue()),
            'H' => strtoupper($sheet->getCell("H" . $num)->getValue()),
            'I' => strtoupper($sheet->getCell("I" . $num)->getValue()),
            'J' => strtoupper($sheet->getCell("J" . $num)->getValue()),
            'K' => strtoupper($sheet->getCell("K" . $num)->getValue()),
            'L' => strtoupper($sheet->getCell("L" . $num)->getValue()),
            'M' => strtoupper($sheet->getCell("M" . $num)->getValue()),
            'N' => strtoupper($sheet->getCell("N" . $num)->getValue()),
            'O' => strtoupper($sheet->getCell("O" . $num)->getValue()),
            'P' => strtoupper($sheet->getCell("P" . $num)->getValue()),
            'Q' => strtoupper($sheet->getCell("Q" . $num)->getValue()),
            'R' => strtoupper($sheet->getCell("R" . $num)->getValue()),
            'S' => strtoupper($sheet->getCell("S" . $num)->getValue()),
            'T' => strtoupper($sheet->getCell("T" . $num)->getValue()),
            'U' => strtoupper($sheet->getCell("U" . $num)->getValue()),
            'V' => strtoupper($sheet->getCell("V" . $num)->getValue()),
            'W' => strtoupper($sheet->getCell("w" . $num)->getValue()),
            'X' => strtoupper($sheet->getCell("X" . $num)->getValue()),
            ];
            
        }
        $data['data'] = $cellvalue;
        $data['_view'] = 'guest/kartu_stok_aset/detailerror';
        $this->load->view('guest/layouts/main', $data);
    }
    function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('productId', 'Produk', 'required|max_length[100]');
        $this->form_validation->set_rules('departement', 'Departement', 'required|max_length[100]');
        $this->form_validation->set_rules('ruang', 'Ruang', 'required|max_length[100]');
        // $this->form_validation->set_rules('hargaPerolehan', 'Harga perlolehan', 'max_length[100]');
        $this->form_validation->set_rules('masaManfaat', 'Masa manfaat', 'required|max_length[100]');
        $this->form_validation->set_rules('supplier', 'Supplier', 'required|max_length[100]');
        $this->form_validation->set_rules('pengguna', 'Pengunaa', 'required|max_length[100]');
        $this->form_validation->set_rules('noPo', 'No PO', 'max_length[100]');
        $this->form_validation->set_rules('statusPerolehan', 'Status perolehan', 'required|max_length[100]');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required|max_length[100]');
        $this->form_validation->set_rules('kondisi', 'Kondisi', 'required|max_length[100]');

        if ($this->input->post('isWaranty') == "true") {
            $this->form_validation->set_rules('noKartuGaransi', 'No kartu Garansi', 'required|max_length[100]|is_unique[kartu_garansi.noKartuGaransi]');
            $this->form_validation->set_rules('jenisGaransi', 'Jenis Garansi', 'required|max_length[100]');
            $this->form_validation->set_rules('masaGaransi', 'Masa Garansi', 'required|max_length[100]');
        }
        if ($this->input->post('isKendaraan') == "true") {
            $this->form_validation->set_rules('namaStnk', 'Nama Stnk', 'required|max_length[100]');
            $this->form_validation->set_rules('alamatStnk', 'Alamat Stnk', 'required|max_length[100]');
            $this->form_validation->set_rules('peruntukan', 'Peruntukan', 'required|max_length[100]');
        }

        if ($this->form_validation->run()) {
            // var_dump($_POST);
            // die;
            $newInv = getInventaris($this->input->post('departement'));
            $asset = array(
                'productId' => $this->input->post('productId'),
                'noInventaris' => $newInv,
                'kodeRuang' => $this->input->post('ruang'),
                // 'hargaPerolehan' => str_replace(',', '', $this->input->post('hargaPerolehan')),
                'hargaPerolehan' => 0,
                'masaManfaat' => $this->input->post('masaManfaat'),
                'supplier' => $this->input->post('supplier'),
                'pengguna' => $this->input->post('pengguna'),
                'noPo' => $this->input->post('noPo'),
                'statusPerolehan' => $this->input->post('statusPerolehan'),
                'lokasi' => $this->input->post('lokasi'),
                'kondisi' => $this->input->post('kondisi'),
                'isWaranty' => $this->input->post('isWaranty'),
                'createdAt' => date('Y-m-d H:i:s'),
            );
            $relation = [
                [
                    'table' => 'barang',
                    'field' => ['namaBarang'],
                    'pk' => 'id',
                    'valuePk' => view('product', ['id' => $this->input->post('productId')], 'kodeBarang'),
                ]
            ];
            // $this->load->library('ciqrcode');
            // $config['cacheable']    = true; //boolean, the default is true
            // $config['cachedir']     = './assets/'; //string, the default is application/cache/
            // $config['errorlog']     = './assets/'; //string, the default is application/logs/
            // $config['imagedir']     = './assets/img/'; //direktori penyimpanan qr code
            // $config['quality']      = true; //boolean, the default is true
            // $config['size']         = '512'; //interger, the default is 1024
            // $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
            // $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
            // $this->ciqrcode->initialize($config);

            // $image_name = $newInv . '.png';

            // $params['data'] = $newInv;
            // $params['level'] = 'H';
            // $params['size'] = 6;
            // $params['savename'] = FCPATH . $config['imagedir'] . $image_name;
            // //buat pdf
            // $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            // $this->load->library('pdf');
            // $pdf = new FPDF('L', 'mm', [30, 58]);
            // $pdf->SetMargins(2, 1, 0);
            // $pdf->AddPage();
            // $pdf->SetFont('Arial', 'B', 9);
            // $pdf->Image($params['savename'], 20, 6.0, 20, 20);
            // $pdf->Cell(0, 5, $newInv, 0, 0, 'C');
            // $pdf->Output("F", "C:/xampp/htdocs/stok/assets/pdf/" . $newInv . ".pdf"); //simpan
            //
            $text = text('Insert', 'kartu_stok_aset', ['namaStnk', 'alamatStnk', 'peruntukan', 'noKartuGaransi', 'jenisGaransi', 'noInventaris', 'masaGaransi', 'ruang', 'hargaPerolehan', 'masaManfaat', 'supplier', 'pengguna', 'noPo', 'statusPerolehan', 'lokasi', 'kondisi', 'isWaranty'], $relation, $_POST, []);
            $noInventaris = $this->Kartu_stok_aset_model->add_kartu_stok_aset($asset, $text);
            if ($this->input->post('isWaranty') == "true" && $this->input->post('noKartuGaransi') != '') {
                $garansi = [
                    'noInventaris' => $newInv,
                    'noKartuGaransi' => $this->input->post('noKartuGaransi'),
                    'jenisGaransi' => $this->input->post('jenisGaransi'),
                    'masaGaransi' => $this->input->post('masaGaransi'),
                    'createdAt' => date('Y-m-d H:i:s'),
                ];
                $this->Kartu_stok_aset_model->add_kartu_garansi($garansi);
            }
            if ($this->input->post('isKendaraan') == "true" && $this->input->post('namaStnk') != '') {
                $kendaraan = [
                    'namaStnk' => $this->input->post('namaStnk'),
                    'alamatStnk' => $this->input->post('alamatStnk'),
                    'peruntukan' => $this->input->post('peruntukan'),
                    'createdAt' => date('Y-m-d H:i:s'),
                    'ksa' => $newInv,
                ];
                $this->Kartu_stok_aset_model->add_ksa_kendaraan($kendaraan);
            }
            if ($this->input->post('isNomor') == "true" && $this->input->post('nama') != '') {
                foreach ($this->input->post('nama') as $i => $n) {
                    $nomor = [
                        'kode' => str_replace(' ', '-', $this->input->post('nama[' . $i . ']')) . str_replace(' ', '-', $this->input->post('nomor[' . $i . ']')),
                        'nama' => $this->input->post('nama[' . $i . ']'),
                        'nomor' => $this->input->post('nomor[' . $i . ']'),
                        'createdAt' => date('Y-m-d H:i:s'),
                        'ksa' => $newInv,
                    ];
                    $this->Kartu_stok_aset_model->add_ksa_nomor($nomor);
                }
            }
            if ($noInventaris) {
                alert('success', 'Berhasil...', 'Berhasil menambahkan data');
            } else {
                alert('error', 'Gagal...', 'Gagal menambahkan data');
            }
            redirect('kartu_stok_aset/index');
        } else {
            $data['gedung'] = $this->Gedung_model->get_all_gedung();
            $data['produk'] = $this->Produk_model->get_all_produk_asset();
            $data['department'] = $this->Department_model->get_all_department();

            $data['_view'] = 'guest/kartu_stok_aset/add';
            $this->load->view('guest/layouts/main', $data);
        }
    }
    function edit($id)
    {
        $data['kartu_stok_aset'] = $this->Kartu_stok_aset_model->get_kartu_stok_aset($id);
        $data['kartu_garansi'] = $this->Kartu_stok_aset_model->get_kartu_garansi($id);
        $data['ksa_nomor'] = $this->Kartu_stok_aset_model->get_ksa_nomor($id);
        $data['ksa_kendaraan'] = $this->Kartu_stok_aset_model->get_ksa_kendaraan($id);
        if (isset($data['kartu_stok_aset']['noInventaris'])) {
            $this->load->library('form_validation');
            $da = array_merge((isset($data['kartu_stok_aset'])) ? $data['kartu_stok_aset'] : [], (isset($data['kartu_garansi'])) ? $data['kartu_garansi'] : [], (isset($data['ksa_kendaraan'])) ? $data['ksa_kendaraan'] : []);
            $this->form_validation->set_rules('productId', 'Produk', 'required|max_length[100]');
            $this->form_validation->set_rules('noInventaris', 'No Inventaris', 'required|max_length[100]');
            $this->form_validation->set_rules('ruang', 'Ruang', 'required|max_length[100]');
            $this->form_validation->set_rules('hargaPerolehan', 'Harga perlolehan', 'required|max_length[100]');
            $this->form_validation->set_rules('masaManfaat', 'Masa manfaat', 'required|max_length[100]');
            $this->form_validation->set_rules('supplier', 'Supplier', 'required|max_length[100]');
            $this->form_validation->set_rules('pengguna', 'Pengunaa', 'required|max_length[100]');
            $this->form_validation->set_rules('noPo', 'No PO', 'required|max_length[100]');
            $this->form_validation->set_rules('statusPerolehan', 'Status perolehan', 'required|max_length[100]');
            $this->form_validation->set_rules('lokasi', 'Lokasi', 'required|max_length[100]');
            $this->form_validation->set_rules('kondisi', 'Kondisi', 'required|max_length[100]');

            if ($this->input->post('isWaranty') == "true") {
                $this->form_validation->set_rules('noKartuGaransi', 'No kartu Garansi', 'required|max_length[100]');
                $this->form_validation->set_rules('jenisGaransi', 'Jenis Garansi', 'required|max_length[100]');
                $this->form_validation->set_rules('masaGaransi', 'Masa Garansi', 'required|max_length[100]');
            }
            if ($this->input->post('isKendaraan') == "true") {
                $this->form_validation->set_rules('namaStnk', 'Nama Stnk', 'required|max_length[100]');
                $this->form_validation->set_rules('alamatStnk', 'Alamat Stnk', 'required|max_length[100]');
                $this->form_validation->set_rules('peruntukan', 'Peruntukan', 'required|max_length[100]');
            }

            if ($this->form_validation->run()) {
                // var_dump($_POST);
                // die;
                $asset = array(
                    'productId' => $this->input->post('productId'),
                    'noInventaris' => $this->input->post('noInventaris'),
                    'kodeRuang' => $this->input->post('ruang'),
                    'hargaPerolehan' => str_replace(',', '', $this->input->post('hargaPerolehan')),
                    'masaManfaat' => $this->input->post('masaManfaat'),
                    'supplier' => $this->input->post('supplier'),
                    'pengguna' => $this->input->post('pengguna'),
                    'noPo' => $this->input->post('noPo'),
                    'statusPerolehan' => $this->input->post('statusPerolehan'),
                    'lokasi' => $this->input->post('lokasi'),
                    'kondisi' => $this->input->post('kondisi'),
                    'isWaranty' => $this->input->post('isWaranty'),
                    'updatedAt' => date('Y-m-d H:i:s'),
                );
                $relation = [
                    [
                        'table' => 'barang',
                        'field' => ['namaBarang'],
                        'pk' => 'id',
                        'valuePk' => view('product', ['id' => $this->input->post('productId')], 'kodeBarang'),
                    ]
                ];
                $text = text('Update', 'kartu_stok_aset', ['namaStnk', 'alamatStnk', 'peruntukan', 'noKartuGaransi', 'jenisGaransi', 'noInventaris', 'masaGaransi', 'ruang', 'hargaPerolehan', 'masaManfaat', 'supplier', 'pengguna', 'noPo', 'statusPerolehan', 'lokasi', 'kondisi', 'isWaranty'], $relation, $da, $_POST);
                $noInventaris = $this->Kartu_stok_aset_model->update_kartu_stok_aset($id, $asset, $text);
                if ($data['kartu_garansi'] != null) {
                    if ($this->input->post('isWaranty') == "true" && $this->input->post('noKartuGaransi') != '') {
                        $garansi = [
                            'noInventaris' => $this->input->post('noInventaris'),
                            'noKartuGaransi' => $this->input->post('noKartuGaransi'),
                            'jenisGaransi' => $this->input->post('jenisGaransi'),
                            'masaGaransi' => $this->input->post('masaGaransi'),
                            'updatedAt' => date('Y-m-d H:i:s'),
                        ];
                        $this->Kartu_stok_aset_model->update_kartu_garansi($id, $garansi);
                    } else {
                        $this->db->where(['noInventaris' => $this->input->post('noInventaris')]);
                        $this->db->delete('kartu_garansi');
                    }
                } else {
                    if ($this->input->post('isWaranty') == "true" && $this->input->post('noKartuGaransi') != '') {
                        $garansi = [
                            'noInventaris' => $this->input->post('noInventaris'),
                            'noKartuGaransi' => $this->input->post('noKartuGaransi'),
                            'jenisGaransi' => $this->input->post('jenisGaransi'),
                            'masaGaransi' => $this->input->post('masaGaransi'),
                            'createdAt' => date('Y-m-d H:i:s'),
                        ];
                        $this->Kartu_stok_aset_model->add_kartu_garansi($garansi);
                    }
                }
                if ($data['ksa_kendaraan'] != null) {
                    if ($this->input->post('isKendaraan') == "true" && $this->input->post('namaStnk') != '') {
                        $kendaraan = [
                            'namaStnk' => $this->input->post('namaStnk'),
                            'alamatStnk' => $this->input->post('alamatStnk'),
                            'peruntukan' => $this->input->post('peruntukan'),
                            'updatedAt' => date('Y-m-d H:i:s'),
                            'ksa' => $this->input->post('noInventaris'),
                        ];
                        $this->Kartu_stok_aset_model->update_ksa_kendaraan($id, $kendaraan);
                    } else {
                        $this->db->where(['ksa' => $this->input->post('noInventaris')]);
                        $this->db->delete('ksa_kendaraan');
                    }
                } else {
                    if ($this->input->post('isKendaraan') == "true" && $this->input->post('namaStnk') != '') {
                        $kendaraan = [
                            'namaStnk' => $this->input->post('namaStnk'),
                            'alamatStnk' => $this->input->post('alamatStnk'),
                            'peruntukan' => $this->input->post('peruntukan'),
                            'createdAt' => date('Y-m-d H:i:s'),
                            'ksa' => $this->input->post('noInventaris'),
                        ];
                        $this->Kartu_stok_aset_model->add_ksa_kendaraan($kendaraan);
                    }
                }
                if ($data['ksa_nomor'] != null) {
                    if ($this->input->post('isNomor') == "true" && $this->input->post('nama') != '') {
                        foreach ($this->input->post('nama') as $i => $n) {
                            if ($this->input->post('kode[' . $i . ']') != null) {
                                $nomor = [
                                    'kode' => $this->input->post('kode[' . $i . ']'),
                                    'nama' => $this->input->post('nama[' . $i . ']'),
                                    'nomor' => $this->input->post('nomor[' . $i . ']'),
                                    'updatedAt' => date('Y-m-d H:i:s'),
                                    'ksa' => $this->input->post('noInventaris'),
                                ];
                                $this->Kartu_stok_aset_model->update_ksa_nomor($this->input->post('kode[' . $i . ']'), $nomor);
                            } else {
                                $nomor = [
                                    'kode' => str_replace(' ', '-', $this->input->post('nama[' . $i . ']')) . str_replace(' ', '-', $this->input->post('nomor[' . $i . ']')),
                                    'nama' => $this->input->post('nama[' . $i . ']'),
                                    'nomor' => $this->input->post('nomor[' . $i . ']'),
                                    'createdAt' => date('Y-m-d H:i:s'),
                                    'ksa' => $this->input->post('noInventaris'),
                                ];
                                $this->Kartu_stok_aset_model->add_ksa_nomor($nomor);
                            }
                        }
                    } else {
                        $this->db->where(['ksa' => $this->input->post('noInventaris')]);
                        $this->db->delete('ksa_nomor');
                    }
                } else {
                    if ($this->input->post('isNomor') == "true" && $this->input->post('nama') != '') {
                        foreach ($this->input->post('nama') as $i => $n) {
                            $nomor = [
                                'kode' => str_replace(' ', '-', $this->input->post('nama[' . $i . ']')) . str_replace(' ', '-', $this->input->post('nomor[' . $i . ']')),
                                'nama' => $this->input->post('nama[' . $i . ']'),
                                'nomor' => $this->input->post('nomor[' . $i . ']'),
                                'createdAt' => date('Y-m-d H:i:s'),
                                'ksa' => $this->input->post('noInventaris'),
                            ];
                            $this->Kartu_stok_aset_model->add_ksa_nomor($nomor);
                        }
                    }
                }
                if ($noInventaris) {
                    alert('success', 'Berhasil...', 'Berhasil merubah data');
                } else {
                    alert('error', 'Gagal...', 'Gagal merubah data');
                }
                redirect('kartu_stok_aset/index');
            } else {
                $data['department'] = $this->Department_model->get_all_department();

                $data['gedung'] = $this->Gedung_model->get_all_gedung();
                $data['produk'] = $this->Produk_model->get_all_produk_();
                $data['_view'] = 'guest/kartu_stok_aset/edit';
                $this->load->view('guest/layouts/main', $data);
            }
        } else
            show_error('The kartu_stok_aset you are trying to edit does not exist.');
    }
    function remove($id)
    {
        $kartu_stok_aset = $this->Kartu_stok_aset_model->get_kartu_stok_aset($id);
        if (isset($kartu_stok_aset['noInventaris'])) {
            $cekGaransi = $this->Global_model->get_data('kartu_garansi', ['noInventaris' => $kartu_stok_aset['noInventaris']], false);
            $cekKendaraan = $this->Global_model->get_data('ksa_kendaraan', ['ksa' => $kartu_stok_aset['noInventaris']], false);
            $cekNomor = $this->Global_model->get_data('ksa_nomor', ['ksa' => $kartu_stok_aset['noInventaris']], false);
            $da = array_merge((isset($kartu_stok_aset)) ? $kartu_stok_aset : [], (isset($cekGaransi)) ? $cekGaransi : [], (isset($cekKendaraan)) ? $cekKendaraan : [], (isset($cekNomor)) ? $cekNomor : []);

            if ($cekGaransi != null) {
                $this->db->where(['noInventaris' => $id]);
                $delGaransi = $this->db->delete('kartu_garansi');
            }
            if ($cekKendaraan != null) {
                $this->db->where(['ksa' => $id]);
                $delKendaraan = $this->db->delete('ksa_kendaraan');
            }
            if ($cekNomor != null) {
                $this->db->where(['ksa' => $id]);
                $delNomor = $this->db->delete('ksa_nomor');
            }
            $text = text('Insert', 'kartu_stok_aset', ['namaStnk', 'alamatStnk', 'peruntukan', 'noKartuGaransi', 'jenisGaransi', 'noInventaris', 'masaGaransi', 'ruang', 'hargaPerolehan', 'masaManfaat', 'supplier', 'pengguna', 'noPo', 'statusPerolehan', 'lokasi', 'kondisi', 'isWaranty'], [], $da, []);

            $del = $this->Kartu_stok_aset_model->delete_kartu_stok_aset($id, $text);

            if ($del) {
                alert('success', 'Berhasil...', 'Berhasil menghapus data');
            } else {
                alert('error', 'Gagal...', 'Gagal menghapus data');
            }
            redirect('kartu_stok_aset/index');
            die;
        } else {
            alert('error', 'Gagal...', 'Data yang ingin dihapus tidak ditemukan');
            redirect('kartu_stok_aset/index');
            die;
        }
    }
    function hapusnomor($noInv, $kode)
    {
        $cek = $this->db->get_where('ksa_nomor', ['ksa' => $noInv, 'kode' => $kode])->row_array();
        if ($cek) {
            $this->db->where(['ksa' => $noInv, 'kode' => $kode]);
            $this->db->delete('ksa_nomor');
            alert('success', 'Berhasil...', 'Berhasil menghapus data');
            redirect('kartu_stok_aset/edit/' . $noInv);
        } else {
            alert('error', 'Gagal...', 'Data yang ingin dihapus tidak ditemukan');
            redirect('kartu_stok_aset/edit/' . $noInv);
        }
    }
    function getruang()
    {
        $ruangan = $this->db->get_where('ruangan', ['gedungId' => $_POST['gedung']])->result_array();
        $html = '';
        foreach ($ruangan as $r) {
            $selected = ($r['id'] == $this->input->post('ruang')) ? ' selected="selected"' : "";
            $html .= '<option value="' . $r['id'] . '" ' . $selected . '>' . $r['nama'] . '</option>';
        }
        echo $html;
    }
    function getqrcode()
    {
        $path = base_url('assets/pdf/' . $_POST['inv'] . '.pdf');
        $data = file_get_contents($path);
        $b64Doc = base64_encode($data);
        echo 'data:application/pdf;base64,' . $b64Doc;
    }
    function tes()
    {
        $path = base_url('assets/pdf/' . '0003-BAAK-IV-2021' . '.pdf');
        // echo $path;
        $data = file_get_contents($path);
        // var_dump($data);
        $b64Doc = base64_encode($data);
        echo 'data:application/pdf;base64,' . $b64Doc;
    }
    function uploadgambar($id)
    {
        if (isset($_FILES["gambar"])) {
            $config['upload_path'] = './assets/img/aset/';
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size']     = '8000';
            $this->load->library('upload');
            $this->upload->initialize($config);
            if ($this->upload->do_upload('gambar')) {
                $new = $this->upload->data('file_name');
                $cek = $this->db->get_where('product', ['id' => $id])->row_array();
                if ($cek) {
                    $this->db->where('id', $id)
                        ->update('product', ['gambar' => $new]);
                    alert('success', 'Berhasil...', 'Berhasil menghapus data');
                    redirect('kartu_stok_aset/index/'.$this->uri->segment(4));
                } else {
                    alert('error', 'Gagal...', 'Produk Tidak ada');
                    redirect('kartu_stok_aset/index/'.$this->uri->segment(4));
                }
            } else {
                alert('error', 'Gagal...', 'Format salah');
                redirect('kartu_stok_aset/index/'.$this->uri->segment(4));
                die;
            }
        } else {
            alert('error', 'Gagal...', 'Tidak ada data');
            redirect('kartu_stok_aset/index/'.$this->uri->segment(4));
            die;
        }
    }

    public function file_download($s)
    {
        force_download('assets/pdf/' . $s . '.pdf', NULL);
    }
    function keberadaan($ada,$inv){
        $aset = $this->Kartu_stok_aset_model->get_kartu_stok_aset($inv);
        if($aset){
            if($ada == 'y'){
                if($aset['status'] == 'ilim'){
                    $this->db->where('noInventaris', $inv)
                ->update('kartu_stok_aset', ['status' => 'import']);
                // die;
                alert('success', 'Berhasilll', 'Kan ternyata adaa ngeyel sih');
                redirect('kartu_stok_aset/index/'.$aset['kodeRuang']);
                die;
                }
                $tampung = str_replace('XX', '', $inv);
                 $str = substr($tampung, strpos($aset['noInventaris'], "_") + 4);
                // $ex = explode('-', $tampung);
                // var_dump($str);
                $notIlim = $this->db->like('noInventaris', $str, 'before')->where('status', 'import')->order_by('noInventaris','desc')->get('kartu_stok_aset')->row_array();
                // var_dump($notIlim);
                $last = $notIlim['noInventaris'];
        $x = explode('-', $last);
        $invID = $x[0] + 1;
        $invID = str_pad($invID, 4, '0', STR_PAD_LEFT);
        // var_dump($invID.'-'.$x[1].'-'.$x[2].'-'.$x[3]);
        // die;
                // die;
                $rrrr = "UPDATE kartu_stok_aset SET noInventaris='".$invID."-".$x[1]."-".$x[2]."-".$x[3]."-SA', status='import' WHERE noInventaris='".$aset['noInventaris']."' AND status='reinvilim'";
                $this->db->query($rrrr);
                // $this->db->where(['noInventaris'=> $aset['noInventaris'],'status'=> 'reinvilim'])->update('kartu_stok_aset', ['status' => 'import', 'noInventaris' => $invID.'-'.$x[1].'-'.$x[2].'-'.$x[3]].'-SA');
                alert('success', 'Berhasilll', 'Kan ternyata adaa ngeyel sih');
                redirect('kartu_stok_aset/index/'.$aset['kodeRuang']);
            }elseif ($ada == 'n') {
                $this->db->where('noInventaris', $inv)
                ->update('kartu_stok_aset', ['status' => 'ilim']);
                alert('success', 'Berhasilll', 'Berhasil nanti cek lagi ya siapa tau galiat');
                redirect('kartu_stok_aset/index/'.$aset['kodeRuang']);
            }else{
                alert('error', 'Gagal...', 'Gagal Iliem');
                redirect('kartu_stok_aset/index/'.$aset['kodeRuang']);
            }
        }else{
        alert('error', 'Gagal...', 'Data Tidak Ada');
        redirect('kartu_stok_aset/index/'.$aset['kodeRuang']);
        }
    }
}
