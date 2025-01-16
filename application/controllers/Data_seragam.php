<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_seragam extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Masterdata_model', 'md');
    }

    public function index()
    {
        $data = array(
            'menu' => 'backend/menu',
            'content' => 'backend/seragamKonten',
            'title' => 'Admin'
        );
        $this->load->view('template', $data);
    }

    // Mendapatkan semua data seragam
    public function getAllSeragam()
    {
        $data = $this->md->getAllSeragam();
        echo json_encode($data);
    }

    // Menyimpan data seragam
    public function saveSeragam()
    {
        $jenis_biaya = $this->input->post('jenis_biaya');
        $this->md->saveSeragam($jenis_biaya);
        echo json_encode(['status' => true, 'message' => 'Seragam berhasil disimpan!']);
    }

    // Mengedit data seragam
    public function editSeragam()
    {
        $id = $this->input->post('id');
        $jenis_biaya = $this->input->post('jenis_biaya');

        $result = $this->md->updateSeragam($id, $jenis_biaya);
        echo json_encode($result);
    }

    // Menghapus data seragam
    public function deleteSeragam()
    {
        $id = $this->input->post('id');
        $this->md->deleteSeragam($id);
        echo json_encode(['status' => true, 'message' => 'Seragam berhasil dihapus!']);
    }

    // Mendapatkan data seragam berdasarkan ID
    public function getSeragamById()
    {
        $id = $this->input->get('id');
        $data = $this->md->getSeragamById($id);
        echo json_encode($data);
    }
}
