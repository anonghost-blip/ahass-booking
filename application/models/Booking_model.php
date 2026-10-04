<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_model extends CI_Model {

    private $table = 'bookings';

    // Slot jam servis yang tersedia (fixed)
    private $available_slots = array(
        '08:00:00', '09:00:00', '10:00:00', '11:00:00',
        '13:00:00', '14:00:00', '15:00:00', '16:00:00'
    );

    // Maksimal kendaraan per slot per tanggal
    private $max_per_slot = 3;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get semua booking dengan join paket_servis
     * Support filter: tanggal, nama, plat_nomor, status
     */
    public function get_all($filters = array())
    {
        $this->db->select('bookings.*, paket_servis.nama_paket');
        $this->db->from($this->table);
        $this->db->join('paket_servis', 'paket_servis.id = bookings.paket_id', 'left');

        // Apply filters
        if (!empty($filters['tanggal'])) {
            $this->db->where('bookings.tanggal_servis', $filters['tanggal']);
        }
        if (!empty($filters['nama'])) {
            $this->db->like('bookings.nama_pelanggan', $filters['nama']);
        }
        if (!empty($filters['plat_nomor'])) {
            $this->db->like('bookings.plat_nomor', $filters['plat_nomor']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('bookings.status', $filters['status']);
        }

        $this->db->order_by('bookings.tanggal_servis', 'DESC');
        $this->db->order_by('bookings.jam_servis', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Get booking by ID
     */
    public function get_by_id($id)
    {
        $this->db->select('bookings.*, paket_servis.nama_paket');
        $this->db->from($this->table);
        $this->db->join('paket_servis', 'paket_servis.id = bookings.paket_id', 'left');
        $this->db->where('bookings.id', $id);

        return $this->db->get()->row();
    }

    /**
     * Hitung jumlah booking pada slot tertentu di tanggal tertentu
     * Hanya hitung yang statusnya bukan 'cancelled'
     */
    public function count_slot($tanggal, $jam)
    {
        $this->db->where('tanggal_servis', $tanggal);
        $this->db->where('jam_servis', $jam);
        $this->db->where('status !=', 'cancelled');

        return $this->db->count_all_results($this->table);
    }

    /**
     * Cek apakah slot masih tersedia (belum penuh)
     */
    public function is_slot_available($tanggal, $jam)
    {
        $count = $this->count_slot($tanggal, $jam);
        return $count < $this->max_per_slot;
    }

    /**
     * Cek apakah jam servis merupakan slot yang valid
     */
    public function is_valid_slot($jam)
    {
        return in_array($jam, $this->available_slots, true);
    }

    /**
     * Get semua slot dengan info ketersediaan untuk tanggal tertentu
     */
    public function get_slots_availability($tanggal)
    {
        $slots = array();
        $is_today = ($tanggal === date('Y-m-d'));
        $current_time = date('H:i:s');

        foreach ($this->available_slots as $slot) {
            $count = $this->count_slot($tanggal, $slot);
            $is_past = ($is_today && $slot <= $current_time);
            $is_available = (!$is_past && $count < $this->max_per_slot);

            $slots[] = array(
                'jam'         => $slot,
                'jam_display' => date('H:i', strtotime($slot)),
                'terisi'      => $count,
                'sisa'        => max(0, $this->max_per_slot - $count),
                'is_past'     => $is_past,
                'available'   => $is_available
            );
        }

        return $slots;
    }

    /**
     * Simpan booking baru
     */
    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update status booking
     */
    public function update_status($id, $status)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Get daftar slot jam (untuk dropdown)
     */
    public function get_available_slots()
    {
        return $this->available_slots;
    }
}
