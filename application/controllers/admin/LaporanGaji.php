<?php

class LaporanGaji extends CI_Controller
{
    public function index()
    {
        $data['title'] = "Laporan Gaji Pegawai";
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/gaji/laporanGaji');
        $this->load->view('templates_admin/footer');
    }

    public function cetakLaporanGaji()
    {
        $data['title'] = "Cetak Laporan Gaji Pegawai";

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        if (empty($bulan) || empty($tahun)) {
            $this->session->set_flashdata('error', 'Bulan dan Tahun harus dipilih.');
            redirect('admin/laporanGaji', 'refresh');
        }

        $bulantahun = $bulan . $tahun;

        // Mengambil data potongan gaji untuk digunakan di view
        $data['potongan'] = $this->penggajianModel->getAllPotonganGaji();

        $checkDataQuery = $this->db->query("
            SELECT COUNT(*) as total_rows
            FROM data_kehadiran
            WHERE bulan = '$bulantahun'
        ");

        $result = $checkDataQuery->row();

        if ($result->total_rows == 0) {
            $this->session->set_flashdata('error', 'Data masih kosong. Silahkan input terlebih dahulu.');
            redirect('admin/laporanGaji', 'refresh');
        }

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
            FROM data_pegawai
            INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
            INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
            WHERE data_kehadiran.bulan = '$bulantahun'
            ORDER BY data_pegawai.nama_pegawai ASC
        ")->result();

        $this->load->view('templates_admin/header', $data);
        $this->load->view('admin/gaji/cetakLaporanGaji', $data);
    }
}
