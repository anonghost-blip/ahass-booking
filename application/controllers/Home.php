<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Paket_model');
    }

    /**
     * Landing page utama (Single Page Application)
     */
    public function index()
    {
        $data['paket_list'] = $this->Paket_model->get_all();
        $this->load->view('layout/main', $data);
    }
}
