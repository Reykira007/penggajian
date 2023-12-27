<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenggajianModel extends CI_Model
{
    public function get_data($table)
    {
        return $this->db->get($table);
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
}

/* End of file PenggajianModel_model.php and path \application\models\models\PenggajianModel_model.php */