<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Super_admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('isLogIn') != true) {
            redirect('auth/logout');
        }
        $this->load->model('Global_model');
        $this->load->model('Ruangan_model');
    }

    public function index()
    {
        $data['history'] = $this->db
            ->join('users', 'users.user_id=history.user_id')
            ->order_by('log_date', 'DESC')
            ->limit(5)
            ->get('history')->result_array();

        $data['jumlah'] = $this->db->from('kartu_stok_aset')->count_all_results();
        $data['selesai'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'cetak'])->result_array());
        $data['tidak_ada'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'ilim'])->result_array());
        $data['baru'] = count($this->db->get_where('kartu_stok_aset', ['newData' => 'yes'])->result_array());
        $query = $this->db->select_sum('hargaPerolehan')->from('kartu_stok_aset')->get();
        $data['harga'] = $query->result_array();

        $data['_view'] = 'super_admin/dashboard';
        $this->load->view('super_admin/layouts/main', $data);
    }

    public function cari()
    {
        if (isset($_POST['view'])) {
            if ($_POST['cont'] == 'totaldata') {
                redirect('super_admin/totaldata/' . $_POST['ruangan']);
                die;
            } elseif ($_POST['cont'] == 'totaldone') {
                redirect('super_admin/totaldone/' . $_POST['ruangan']);
                die;
            } elseif ($_POST['cont'] == 'totalgone') {
                redirect('super_admin/totalgone/' . $_POST['ruangan']);
                die;
            } elseif ($_POST['cont'] == 'totalnew') {
                redirect('super_admin/totalnew/' . $_POST['ruangan']);
                die;
            }
        }
    }

    public function totaldata()
    {
        $data['jumlah'] = $this->db->from('kartu_stok_aset')->count_all_results();
        $data['selesai'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'cetak'])->result_array());
        $data['tidak_ada'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'ilim'])->result_array());
        $data['baru'] = count($this->db->get_where('kartu_stok_aset', ['newData' => 'yes'])->result_array());
        $query = $this->db->select_sum('hargaPerolehan')->from('kartu_stok_aset')->get();
        $data['harga'] = $query->result_array();
        $data['ruangan'] = $this->Ruangan_model->get_all_ruangan();

        $id = $this->uri->segment(3);

        if (isset($id)) {
            $data['kartu_stok_aset_']  = $this->db->order_by('createdAt', 'desc')->get_where('kartu_stok_aset', ['kodeRuang' => $id])->result_array();
            $data['kebanyakan'] = false;
        } else {
            $data['kebanyakan'] = true;
        }

        $data['header'] = 'Seluruh Data';
        $data['_view'] = 'super_admin/laporan/template';
        $this->load->view('super_admin/layouts/main', $data);
    }
    
    public function totaldone()
    {
        $data['jumlah'] = $this->db->from('kartu_stok_aset')->count_all_results();
        $data['selesai'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'cetak'])->result_array());
        $data['tidak_ada'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'ilim'])->result_array());
        $data['baru'] = count($this->db->get_where('kartu_stok_aset', ['newData' => 'yes'])->result_array());
        $query = $this->db->select_sum('hargaPerolehan')->from('kartu_stok_aset')->get();
        $data['harga'] = $query->result_array();
        $data['ruangan'] = $this->Ruangan_model->get_all_ruangan();

        $id = $this->uri->segment(3);

        if (isset($id)) {
            $where = [
                'kodeRuang' => $id,
                'status'    => 'cetak'
            ];

            $data['kartu_stok_aset_']  = $this->db->order_by('createdAt', 'desc')->get_where('kartu_stok_aset', $where)->result_array();
            $data['kebanyakan'] = false;
        } else {
            $data['kartu_stok_aset_']  = $this->db->get_where('kartu_stok_aset', ['status' => 'cetak'])->result_array();
            $data['kebanyakan'] = false;
        }

        $data['header'] = 'Seluruh Data Selesai';
        $data['_view'] = 'super_admin/laporan/template';
        $this->load->view('super_admin/layouts/main', $data);
    }
    
    public function totalgone()
    {
        $data['jumlah'] = $this->db->from('kartu_stok_aset')->count_all_results();
        $data['selesai'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'cetak'])->result_array());
        $data['tidak_ada'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'ilim'])->result_array());
        $data['baru'] = count($this->db->get_where('kartu_stok_aset', ['newData' => 'yes'])->result_array());
        $query = $this->db->select_sum('hargaPerolehan')->from('kartu_stok_aset')->get();
        $data['harga'] = $query->result_array();
        $data['ruangan'] = $this->Ruangan_model->get_all_ruangan();

        $id = $this->uri->segment(3);

        if (isset($id)) {
            $where = [
                'kodeRuang' => $id,
                'status'    => 'ilim'
            ];

            $data['kartu_stok_aset_']  = $this->db->order_by('createdAt', 'desc')->get_where('kartu_stok_aset', $where)->result_array();
            $data['kebanyakan'] = false;
        } else {
            $data['kartu_stok_aset_']  = $this->db->get_where('kartu_stok_aset', ['status' => 'ilim'])->result_array();
            $data['kebanyakan'] = false;
        }

        $data['header'] = 'Seluruh Data Tidak Ada';
        $data['_view'] = 'super_admin/laporan/template';
        $this->load->view('super_admin/layouts/main', $data);
    }
    
    public function totalnew()
    {
        $data['jumlah'] = $this->db->from('kartu_stok_aset')->count_all_results();
        $data['selesai'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'cetak'])->result_array());
        $data['tidak_ada'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'ilim'])->result_array());
        $data['baru'] = count($this->db->get_where('kartu_stok_aset', ['newData' => 'yes'])->result_array());
        $query = $this->db->select_sum('hargaPerolehan')->from('kartu_stok_aset')->get();
        $data['harga'] = $query->result_array();
        $data['ruangan'] = $this->Ruangan_model->get_all_ruangan();

        $id = $this->uri->segment(3);

        if (isset($id)) {
            $where = [
                'kodeRuang' => $id,
                'newData'    => 'yes'
            ];

            $data['kartu_stok_aset_']  = $this->db->order_by('createdAt', 'desc')->get_where('kartu_stok_aset', $where)->result_array();
            $data['kebanyakan'] = false;
        } else {
            $data['kartu_stok_aset_']  = $this->db->get_where('kartu_stok_aset', ['newData' => 'yes'])->result_array();
            $data['kebanyakan'] = false;
        }

        $data['header'] = 'Seluruh Data Baru';
        $data['_view'] = 'super_admin/laporan/template';
        $this->load->view('super_admin/layouts/main', $data);

        $this->load->view('super_admin/soon');
    }
    
    public function non_aset()
    {
        // $data['history'] = $this->db
        //     ->join('users', 'users.user_id=history.user_id')
        //     ->order_by('log_date', 'DESC')
        //     ->limit(5)
        //     ->get('history')->result_array();

        // $data['jumlah'] = $this->db->from('kartu_stok_aset')->count_all_results();
        // $data['selesai'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'cetak'])->result_array());
        // $data['tidak_ada'] = count($this->db->get_where('kartu_stok_aset', ['status' => 'ilim'])->result_array());

        // $data['_view'] = 'super_admin/dashboard';
        
        $this->load->view('super_admin/soon');
    }
}
