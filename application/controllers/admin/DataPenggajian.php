<?php

class DataPenggajian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('hak_akses') != '1') {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<strong>Anda Belum Login!</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
				</div>');
            redirect('login');
        }
    }

    public function index()
    {
        $data['title'] = 'Data Gaji Pegawai';

        if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
            $bulan = $_GET['bulan'];
            $tahun = $_GET['tahun'];
            $bulantahun = $bulan . $tahun;
        } else {
            $bulan = date('m');
            $tahun = date('Y');
            $bulantahun = $bulan . $tahun;
        }

        $data['gaji'] = $this->db->query("
            SELECT
                data_pegawai.nik,
                data_pegawai.nama_pegawai,
                data_pegawai.jenis_kelamin,
                data_jabatan.nama_jabatan,
                data_jabatan.gaji_pokok,
                data_jabatan.tj_transport,
                data_jabatan.uang_makan,
                data_kehadiran.hadir,
                data_kehadiran.sakit,
                data_kehadiran.alpa
            FROM
                data_pegawai
            INNER JOIN
                data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
            INNER JOIN
                data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
            WHERE
                data_kehadiran.bulan = '$bulantahun'
            ORDER BY data_pegawai.nama_pegawai ASC
        ")->result();

        // Mengambil data potongan gaji untuk digunakan di view
        $data['potongan'] = $this->penggajianModel->getAllPotonganGaji();

        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/gaji/dataGaji', $data);
        $this->load->view('templates_admin/footer');
    }

    public function cetakGaji()
    {
        $data['title'] = "Cetak Data Gaji Pegawai";
        if ((isset($_GET['bulan']) && $_GET['bulan'] != '') && (isset($_GET['tahun']) && $_GET['tahun'] != '')) {
            $bulan = $_GET['bulan'];
            $tahun = $_GET['tahun'];
            $bulantahun = $bulan . $tahun;
        } else {
            $bulan = date('m');
            $tahun = date('Y');
            $bulantahun = $bulan . $tahun;
        }

        // Mengambil data potongan gaji untuk digunakan di view
        $data['potongan'] = $this->penggajianModel->getAllPotonganGaji();

        $data['cetak_gaji'] = $this->db->query("
        SELECT
            data_pegawai.nik,
            data_pegawai.nama_pegawai,
            data_pegawai.jenis_kelamin,
            data_jabatan.nama_jabatan,
            data_jabatan.gaji_pokok,
            data_jabatan.tj_transport,
            data_jabatan.uang_makan,
            data_kehadiran.sakit,
            data_kehadiran.alpa
        FROM
            data_pegawai
        INNER JOIN
            data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
        INNER JOIN
            data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
        WHERE
            data_kehadiran.bulan = '$bulantahun'
        ORDER BY data_pegawai.nama_pegawai ASC")->result();


        $this->load->view('templates_admin/header', $data);
        $this->load->view('admin/gaji/cetakGaji', $data);
    }
}
