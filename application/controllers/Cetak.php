<?php
class Cetak extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $daaa = $this->db->get_where('kartu_stok_aset', ['kodeRuang' => $_POST['ruangan'], 'status' => 'import'])->result_array();
        if (isset($_POST['view'])) {
            redirect('kartu_stok_aset/index/' . $_POST['ruangan']);
            die;
        }
        $this->load->library('Pdf');
        error_reporting(0); // AGAR ERROR MASALAH VERSI PHP TIDAK MUNCUL

        // select * from kartu_stok_aset where "noInventaris" like '%-GDA-VI-2021-SA' and "noInventaris" > '0007-GDA-VI-2021-SA'
        $str = substr($daaa[0]['noInventaris'], strpos($daaa[0]['noInventaris'], "_") + 4);
        // var_dump($daaa);
        // die;
        
        $Ilim = $this->db->like('noInventaris', $str, 'before')->where('status', 'ilim')->get('kartu_stok_aset')->result_array();
        // var_dump($ilim);
        // die;
        foreach ($Ilim as $i => $v) {
            $this->db->where('noInventaris', $v['noInventaris'])->where('status', 'ilim')
                ->update('kartu_stok_aset', ['noInventaris' => 'XX' . $v['noInventaris'] . 'XX', 'status' => 'reinvilim']);
        }
        
        $notIlim = $this->db->like('noInventaris', $str, 'before')->where('status', 'import')->order_by('noInventaris')->get('kartu_stok_aset')->result_array();
        foreach ($notIlim as $p => $c) {
            $invID = str_pad($p + 1, 4, '0', STR_PAD_LEFT);
            // var_dump($c['noInventaris']);
            $this->db->where('noInventaris', $c['noInventaris'])
                ->update('kartu_stok_aset', ['noInventaris' => $invID . $str]);
        }
        
        $jadi = $this->db->order_by('noInventaris')->get_where('kartu_stok_aset', ['kodeRuang' => $_POST['ruangan'], 'status' => 'import'])->result_array();
        $pdf = new FPDF('L', 'mm', array(190, 148));
        $k = 0;
         for ($a = 0; $a < ceil(count($jadi) / 9); $a++) {
            $pdf->AddPage();
            $pdf->SetFont('Arial', '', 11);
            $vv = [22, 65, 106];
            $ln = [10, 43, 41];
            $hh = [18, 85, 151];
            foreach ($vv as $ii => $v) {
                $pdf->Ln($ln[$ii]);
                foreach ($hh as $i => $h) {
                    $ada =  file_exists('assets/img/' . $jadi[$k]['noInventaris'] . '.png');
                    if (!$ada) {
                        $this->createQrCode($jadi[$k]['noInventaris']);
                    }
                    if ($i == 2) {
                        if (isset($jadi[$k])) {
                            $pdf->Image(base_url('assets/img/' . $jadi[$k]['noInventaris'] . '.png'), $h, $v, 25, 25);
                        }
                    } elseif ($i == 1) {
                        if (isset($jadi[$k])) {
                            $pdf->Image(base_url('assets/img/' . $jadi[$k]['noInventaris'] . '.png'), $h, $v, 25, 25);
                        }
                    } else {
                        if (isset($jadi[$k])) {
                            $pdf->Image(base_url('assets/img/' . $jadi[$k]['noInventaris'] . '.png'), $h, $v, 25, 25);
                        }
                    }
                    if ($i == 2) {
                        if (isset($jadi[$k])) {
                            $pdf->Cell(48);
                            $pdf->Cell(20, 1, $jadi[$k]['noInventaris'], 0, 0, 'C');
                        }
                    } elseif ($i == 1) {
                        if (isset($jadi[$k])) {
                            $pdf->Cell(46);
                            $pdf->Cell(20, 1,  $jadi[$k]['noInventaris'], 0, 0, 'C');
                        }
                    } else {
                        if (isset($jadi[$k])) {
                            $pdf->Cell(10);
                            $pdf->Cell(20, 1,  $jadi[$k]['noInventaris'], 0, 0, 'C');
                        }
                    }
                    $k++;
                }
            }
        }

        $no = 0;

        $pdf->Output();
    }
    function createQrCode($namaINV)
    {
        $this->load->library('ciqrcode');
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/img/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '512'; //interger, the default is 1024
        $config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
        $config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);
        $image_name = $namaINV . '.png';
        $params['data'] = $namaINV;
        $params['level'] = 'H';
        $params['size'] = 6;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name;
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

    }
}
