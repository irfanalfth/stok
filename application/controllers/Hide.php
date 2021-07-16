<?php

use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

defined('BASEPATH') or exit('No direct script access allowed');

class Hide extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data['header'] = 'Seluruh Data Selesai';
        $data['_view'] = 'hide/index';
        $this->load->view('administrator/layouts/main', $data);
    }
    
    public function hidebarang()
    {
        if ($this->input->post('nilai') == "txtarea") {
            $this->form_validation->set_rules('kode', 'No INV', 'required|trim');
            
            if ($this->form_validation->run()) {
                $txt = $this->input->post('kode');
            
                $arr = explode(PHP_EOL, $txt);
                foreach (array_keys($arr, '') as $key) {
                    unset($arr[$key]);
                }

                for ($i=0; $i <= count($arr); $i++) {
                    $this->db->set('hideData', 'Yes');
                    $this->db->where('noInventaris', $arr[$i]);
                    $this->db->update('kartu_stok_aset');
                }

                alert('success', 'Berhasil...', 'Berhasil hide data');
                redirect('hide');
            } else {
                redirect('hide');
            }
        } elseif ($this->input->post('nilai') == "range") {
            $this->form_validation->set_rules('no_inv', 'No INV', 'required|trim');
            
            if ($this->form_validation->run()) {
                $f = $this->input->post('no_inv');
                $l = $this->input->post('no_inv1');
                $dp = $this->input->post('dept');
                $m = $this->input->post('bulan');
       
                $x = range($f, $l);
                $no = array_map(function ($x) {
                    return sprintf("%04s", $x);
                }, $x);

                for ($i=0; $i <= count($no) ; $i++) {
                    $noInv = $no[$i] . '-' . $dp . '-' . $m . '-2021-SA';
                    $this->db->set('hideData', 'Yes');
                    $this->db->where('noInventaris', $noInv);
                    $this->db->update('kartu_stok_aset');
                }

                // 1023-BAAK-VI-2021-SA1024-BAAK-VI-2021-SA1025-BAAK-VI-2021-SA1026-BAAK-VI-2021-SA1027-BAAK-VI-2021-SA1028-BAAK-VI-2021-SA1029-BAAK-VI-2021-SA1030-BAAK-VI-2021-SA-BAAK-VI-2021-SA
                alert('success', 'Berhasil...', 'Berhasil hide data');
                redirect('hide');
            } else {
                redirect('hide');
            }
        }
        
        

        // var_dump($arr);
        // die;
    }
}
