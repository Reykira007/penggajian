<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenggajianModel extends CI_Model
{
    public function get_data($table)
    {
        return $this->db->get($table);
    }
    public function get_data_pagination($table, $limit, $start)
    {
        $query = $this->db->get($table, $limit, $start);
        return $query;
    }
    public function insert_data($data, $table)
    {
        $this->db->insert($table, $data);
    }

    public function update_data($table, $data, $where)
    {
        // Perbarui data di tabel database
        $this->db->update($table, $data, $where);
    }

    public function delete_data($where, $table)
    {
        // Dapatkan nama file photo sebelum menghapus data
        $photo_data = $this->db->get_where($table, $where)->row();
        $photo_filename = $photo_data->photo;

        // Hapus file foto dari folder
        $photo_path = FCPATH . './assets/photo/' . $photo_filename;
        if (file_exists($photo_path)) {
            unlink($photo_path);
        }

        $this->db->where($where);
        $this->db->delete($table);
    }

    public function insert_batch($table = null, $data = array())
    {
        $jumlah = count($data);
        if ($jumlah > 0) {
            $this->db->insert_batch($table, $data);
        }
    }

    // Fungsi untuk mendapatkan semua data potongan gaji
    public function getAllPotonganGaji()
    {
        return $this->db->get('potongan_gaji')->result();
    }

    // Fungsi untuk mendapatkan data potongan gaji berdasarkan jenis
    public function getPotonganGajiByJenis($jenis)
    {
        return $this->db->get_where('potongan_gaji', array('potongan' => $jenis))->row();
    }

    public function cek_login()
    {
        $username = set_value('username');
        $password = set_value('password');

        $result = $this->db->where('username', $username)->where('password', md5($password))->limit(1)->get('data_pegawai');
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return FALSE;
        }
    }
}

/* End of file PenggajianModel_model.php and path \application\models\models\PenggajianModel_model.php */