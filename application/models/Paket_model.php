<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paket_model extends CI_Model {

    private $table = 'paket_servis';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get semua paket servis
     */
    public function get_all()
    {
        $this->db->order_by('nama_paket', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Get paket by ID
     */
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, array('id' => $id))->row();
    }

    /**
     * Simpan paket baru
     */
    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update paket
     */
    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Hapus paket
     */
    public function delete($id)
    {
        // Cek apakah paket sedang dipakai di booking
        $this->db->where('paket_id', $id);
        $count = $this->db->count_all_results('bookings');

        if ($count > 0) {
            return false; // Tidak bisa hapus karena sedang dipakai
        }

        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Cek apakah paket sedang dipakai di booking
     */
    public function is_used($id)
    {
        $this->db->where('paket_id', $id);
        return $this->db->count_all_results('bookings') > 0;
    }
}
