<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataPegawai extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('penggajianModel'); // Pastikan model telah dimuat
    }

    public function index()
    {
        $data['title'] = "Data Pegawai";
        $data['pegawai'] = $this->penggajianModel->get_data('data_pegawai')->result();
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/dataPegawai', $data);
        $this->load->view('templates_admin/footer');
    }

    public function tambahData()
    {
        $data['title'] = 'Tambah Data Pegawai';
        $data['jabatan'] = $this->penggajianModel->get_data('data_jabatan')->result();
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/formTambahPegawai', $data);
        $this->load->view('templates_admin/footer');
    }

    public function tambahDataAksi()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->tambahData();
        } else {
            $nik = $this->input->post('nik');
            $nama_pegawai = $this->input->post('nama_pegawai');
            $jenis_kelamin = $this->input->post('jenis_kelamin');
            $jabatan = $this->input->post('jabatan');
            $tanggal_masuk = $this->input->post('tanggal_masuk');
            $status = $this->input->post('status');
            $photo = $_FILES['photo']['name'];

            // Gunakan operator kesamaan di sini
            if ($photo == '') {
                $this->session->set_flashdata('pesan', '<div class="alert 
                alert-danger alert-dismissible fade show" role="alert">
                <strong>Foto wajib diisi!</strong>
                <button type="button" class="close" data-dismiss="alert" 
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
                redirect('admin/dataPegawai/tambahData');
            } else {
                $config['upload_path'] = './assets/photo';
                $config['allowed_types'] = 'jpg|jpeg|png|tiff';
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('photo')) {
                    echo "Photo Gagal diupload!";
                } else {
                    $photo = $this->upload->data('file_name');
                }
            }

            $data = array(
                'nik' => $nik,
                'nama_pegawai' => $nama_pegawai,
                'jenis_kelamin' => $jenis_kelamin,
                'jabatan' => $jabatan,
                'tanggal_masuk' => $tanggal_masuk,
                'status' => $status,
                'photo' => $photo,
            );

            $this->penggajianModel->insert_data($data, 'data_pegawai');
            $this->session->set_flashdata('pesan', '<div class="alert 
            alert-success alert-dismissible fade show" role="alert">
            <strong>Data berhasil ditambahkan!</strong>
            <button type="button" class="close" data-dismiss="alert" 
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>');
            redirect('admin/dataPegawai');
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nik', 'nik', 'required');
        $this->form_validation->set_rules('nama_pegawai', 'nama_pegawai', 'required');
        $this->form_validation->set_rules('jenis_kelamin', 'jenis_kelamin', 'required');
        $this->form_validation->set_rules('jabatan', 'jabatan', 'required');
        $this->form_validation->set_rules('tanggal_masuk', 'tanggal_masuk', 'required');
        $this->form_validation->set_rules('status', 'status', 'required');
    }
}

/* End of file DataPegawai.php and path \application\controllers\admin\DataPegawai.php */