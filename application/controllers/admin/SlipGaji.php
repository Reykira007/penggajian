<?php

class SlipGaji extends CI_Controller
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
        $data['title'] = "Slip Gaji Pegawai";
        $data['pegawai'] = $this->penggajianModel->get_data('data_pegawai')->result();
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/gaji/slipGaji', $data);
        $this->load->view('templates_admin/footer');
    }

    public function cetakSlipGaji()
    {
        $data['title'] = "Cetak Slip Gaji Pegawai";
        $nama = $this->input->post('nama_pegawai');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        // Memeriksa apakah nama pegawai, bulan, dan tahun telah dipilih
        if (empty($nama) || empty($bulan) || empty($tahun)) {
            $this->session->set_flashdata('error', 'Nama Pegawai, Bulan, dan Tahun harus dipilih.');
            redirect('admin/slipGaji', 'refresh');
        }

        $bulantahun = $bulan . $tahun;

        // Mengambil data potongan gaji untuk digunakan di view
        $data['potongan'] = $this->penggajianModel->getAllPotonganGaji();

        // Memeriksa apakah data kehadiran untuk nama pegawai, bulan, dan tahun yang dipilih tersedia
        $checkDataQuery = $this->db->query("
        SELECT COUNT(*) as total_rows
        FROM data_kehadiran
        WHERE bulan = '$bulantahun' AND nama_pegawai = '$nama'
    ");

        $result = $checkDataQuery->row();

        if ($result->total_rows == 0) {
            $this->session->set_flashdata('error', 'Data kehadiran untuk ' . $nama . ' pada bulan ' . $bulan . ' tahun ' . $tahun . ' tidak ditemukan.');
            redirect('admin/slipGaji', 'refresh');
        }

        // Mendapatkan data untuk cetak slip gaji
        $data['cetak_slip_gaji'] = $this->db->query("
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
        FROM data_pegawai
        INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
        INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
        WHERE data_kehadiran.bulan = '$bulantahun' AND data_kehadiran.nama_pegawai='$nama'
    ")->result();

        $this->load->view('templates_admin/header', $data);
        $this->load->view('admin/gaji/cetakSlipGaji', $data);
    }
}
