<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran_awal extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array(
            'menu' => 'backend/menu',
            'content' =>'backend/awalKonten',
            'title' => 'Admin'
        );

        $this->load->view('template', $data);
    }

}