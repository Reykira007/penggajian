<?php
defined('BASEPATH') or exit('No direct script access allowed');

class dataPegawai extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = $this->db->query("SELECT * FROM data_pegawai")->result();
        var_dump($data);
    }
}

/* End of file DataPegawai.php and path \application\controllers\admin\DataPegawai.php */