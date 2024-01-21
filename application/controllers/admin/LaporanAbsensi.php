<?php

class LaporanAbsensi extends CI_Controller
{
    public function index()
    {
        $data['title'] = "Laporan Gaji Pegawai";
        $this->load->view('templates_admin/header', $data);
        $this->load->view('templates_admin/sidebar');
        $this->load->view('admin/absensi/laporanAbsensi');
        $this->load->view('templates_admin/footer');
    }

    public function cetakLaporanAbsensi()
    {
        $data['title'] = "Cetak Laporan Absensi Pegawai";

        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');

        if (empty($bulan) || empty($tahun)) {
            $this->session->set_flashdata('error', 'Bulan dan Tahun harus dipilih.');
            redirect('admin/laporanAbsensi', 'refresh');
        }

        $bulantahun = $bulan . $tahun;

        $checkDataQuery = $this->db->query("
            SELECT COUNT(*) as total_rows
            FROM data_kehadiran
            WHERE bulan = '$bulantahun'
        ");

        $result = $checkDataQuery->row();

        if ($result->total_rows == 0) {
            $this->session->set_flashdata('error', 'Data masih kosong. Silahkan input terlebih dahulu.');
            redirect('admin/laporanAbsensi', 'refresh');
        }

        $data['lap_kehadiran'] = $this->db->query("SELECT * FROM data_kehadiran WHERE bulan='$bulantahun' ORDER BY nama_pegawai ASC")->result();

        $this->load->view('templates_admin/header', $data);
        $this->load->view('admin/absensi/cetakLaporanAbsensi', $data);
    }
}
