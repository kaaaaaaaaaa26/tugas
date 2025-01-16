<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_biaya extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Masterdata_model', 'md');
    }

    // Menampilkan halaman utama
    public function index()
    {
        $data = array(
            'menu' => 'backend/menu',
            'content' => 'backend/biayaKonten',
            'title' => 'Admin'
        );
        $this->load->view('template', $data);
    }

    // Mengambil semua jenis biaya
    public function getAllJenisBiaya()
    {
        $data = $this->md->getAllJenisBiaya();
        echo json_encode($data);
    }

    // Menyimpan jenis biaya baru
    public function saveJenisBiaya()
    {
        $jenis_biaya = $this->input->post('jenis_biaya');
        $this->md->saveJenisBiaya($jenis_biaya);
        echo json_encode(['status' => true, 'message' => 'Jenis Biaya berhasil disimpan!']);
    }

    // Mengedit jenis biaya
    public function editJenisBiaya()
    {
        $id = $this->input->post('id'); // Mendapatkan ID dari form
        $jenis_biaya = $this->input->post('jenis_biaya'); // Mendapatkan jenis biaya dari form

        if (!$id || !$jenis_biaya) {
            echo json_encode(['status' => false, 'message' => 'Data tidak lengkap!']);
            return;
        }

        $result = $this->md->updateJenisBiaya($id, $jenis_biaya);
        echo json_encode($result);
    }

    // Menghapus jenis biaya
    public function deleteJenisBiaya()
    {
        $id = $this->input->post('id');
        $this->md->deleteJenisBiaya($id);
        echo json_encode(['status' => true, 'message' => 'Jenis Biaya berhasil dihapus!']);
    }

    // Mendapatkan jenis biaya berdasarkan ID untuk di-edit
    public function getJenisBiayaById()
    {
        $id = $this->input->get('id');
        $data = $this->md->getJenisBiayaById($id);
        echo json_encode($data);
    }
}
?>
