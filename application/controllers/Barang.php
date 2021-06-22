<?php
class Barang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('isLogIn') != true){
            redirect('auth/logout');
        }
        $this->load->model('Barang_model');
        $this->load->model('Global_model');
        $this->load->model('Subkelompok_model');
    }
    function index()
    {
        $data['barang_'] = $this->Barang_model->get_all_barang_();
        $data['_view'] = 'administrator/barang/index';
        $this->load->view('administrator/layouts/main', $data);
    }
    function add()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('barang', 'barang', 'required|max_length[100]');
        $this->form_validation->set_rules('kodeSub', 'Kode Sub Kelompok', 'required');
        if ($this->form_validation->run()) {
            $params = array(
                'namaBarang' => $this->input->post('barang'),
                'createdAt' => date('Y-m-d H:i:s'),
                'updatedAt' => date('Y-m-d H:i:s'),
                'kodeSub' => $this->input->post('kodeSub'),
            );
            $relation = [
                [
                    'table' => 'sub_kelompok',
                    'field' => ['namaSub'],
                    'pk' => 'id',
                    'valuePk' => $this->input->post('kodeSub'),
                ]
            ];
            $text = text('Insert', 'barang', ['namaBarang', 'kodeSub'], $relation, $_POST, []);
            $barang_id = $this->Barang_model->add_barang($params, $text);
            if ($barang_id) {
                alert('success', 'Berhasil...', 'Berhasil menambahkan data');
            } else {
                alert('error', 'Gagal...', 'Gagal menambahkan data');
            }
            redirect('barang/index');
        } else {
            $data['subkelompok_'] = $this->Subkelompok_model->get_all_subkelompok_();
            $data['_view'] = 'administrator/barang/add';
            $this->load->view('administrator/layouts/main', $data);
        }
    }
    function edit($id)
    {
        $data['barang'] = $this->Barang_model->get_barang($id);
        if (isset($data['barang']['id'])) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('namaBarang', 'Nama Barang', 'required|max_length[100]');
            $this->form_validation->set_rules('kodeSub', 'Kode Sub Kelompok', 'required|max_length[100]');
            if ($this->form_validation->run()) {
                $params = array(
                    'namaBarang' => $this->input->post('namaBarang'),
                    'updatedAt' => date('Y-m-d H:i:s'),
                    'kodeSub' => $this->input->post('kodeSub'),
                );
                $relation = [
                    [
                        'table' => 'sub_kelompok',
                        'field' => ['namaSub'],
                        'pk' => 'id',
                        'valuePk' => $this->input->post('kodeSub'),
                    ]
                ];
       
                $text = text('Update', 'barang', ['namaBarang', 'kodeSub'], $relation, $data['barang'], $_POST);
                if ($text != '') {
                    $barang_id = $this->Barang_model->update_barang($id, $params, $text);
                    if ($barang_id) {
                        alert('success', 'Berhasil...', 'Berhasil mengubah data');
                    } else {
                        alert('error', 'Gagal...', 'Gagal mengubah data');
                    }
                } else {
                    alert('info', 'Ubah ?', 'Tidak ada data yang diubah');
                }
                redirect('barang/index');
            } else {
                $data['subkelompok_'] = $this->Subkelompok_model->get_all_subkelompok_();
                $data['_view'] = 'administrator/barang/edit';
                $this->load->view('administrator/layouts/main', $data);
            }
        } else {
            alert('error', 'Gagal...', 'Data yang ingin diubah tidak ditemukan');
            redirect('barang/index');
            die;
        }
    }
    function remove($id)
    {
        $barang = $this->Barang_model->get_barang($id);
        if (isset($barang['id'])) {
            $cek = $this->Global_model->get_data('product', ['kodeBarang' => $id], false);
            if ($cek == null) {
                $text = text('Delete', 'barang', ['id', 'namaBarang', 'kodeSub'], [], $barang, []);
                $barang_id = $this->Barang_model->delete_barang($id, $text);
                if ($barang_id) {
                    alert('success', 'Berhasil...', 'Berhasil menghapus data');
                } else {
                    alert('error', 'Gagal...', 'Gagal menghapus data');
                }
                redirect('barang/index');
                die;
            } else {
                alert('error', 'Gagal...', 'Tidak diizinkan untuk menghapus data yang sedang digunakan!');
                redirect('barang/index');
                die;
            }
        } else {
            alert('error', 'Gagal...', 'Data yang ingin dihapus tidak ditemukan');
            redirect('barang/index');
            die;
        }
    }
}
