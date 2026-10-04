<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookingController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Booking_model');
        $this->load->model('Paket_model');
    }

    /**
     * Get daftar booking (dengan filter)
     * AJAX GET
     */
    public function list()
    {
        $filters = array(
            'tanggal'    => $this->input->get('tanggal'),
            'nama'       => $this->input->get('nama'),
            'plat_nomor' => $this->input->get('plat_nomor'),
            'status'     => $this->input->get('status')
        );

        $bookings = $this->Booking_model->get_all($filters);

        echo json_encode(array(
            'status'  => true,
            'message' => 'Data booking berhasil dimuat',
            'data'    => $bookings
        ));
    }

    /**
     * Get ketersediaan slot jam pada tanggal tertentu
     * AJAX GET
     */
    public function get_slots()
    {
        $tanggal = $this->input->get('tanggal');

        if (empty($tanggal)) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Tanggal harus diisi',
                'data'    => null
            ));
            return;
        }

        $slots = $this->Booking_model->get_slots_availability($tanggal);

        echo json_encode(array(
            'status'  => true,
            'message' => 'Data slot berhasil dimuat',
            'data'    => $slots
        ));
    }

    /**
     * Simpan booking baru
     * AJAX POST
     */
    public function store()
    {
        // Ambil input
        $plat_nomor     = trim($this->input->post('plat_nomor'));
        $nama_pelanggan = trim($this->input->post('nama_pelanggan'));
        $tipe_motor     = trim($this->input->post('tipe_motor'));
        $tanggal_servis = $this->input->post('tanggal_servis');
        $jam_servis     = $this->input->post('jam_servis');
        $paket_id       = $this->input->post('paket_id');

        // Validasi input - semua field wajib diisi
        $errors = array();

        if (empty($plat_nomor)) {
            $errors[] = 'Plat Nomor wajib diisi';
        }
        if (empty($nama_pelanggan)) {
            $errors[] = 'Nama Pelanggan wajib diisi';
        }
        if (empty($tipe_motor)) {
            $errors[] = 'Tipe Motor wajib diisi';
        }
        if (empty($tanggal_servis)) {
            $errors[] = 'Tanggal Servis wajib diisi';
        }
        if (empty($jam_servis)) {
            $errors[] = 'Jam Servis wajib dipilih';
        }
        if (empty($paket_id)) {
            $errors[] = 'Paket Servis wajib dipilih';
        }

        // Validasi panjang karakter sesuai batas skema database
        if (strlen($plat_nomor) > 15) {
            $errors[] = 'Plat Nomor maksimal 15 karakter';
        }
        if (strlen($nama_pelanggan) > 100) {
            $errors[] = 'Nama Pelanggan maksimal 100 karakter';
        }
        if (strlen($tipe_motor) > 50) {
            $errors[] = 'Tipe Motor maksimal 50 karakter';
        }

        if (!empty($errors)) {
            echo json_encode(array(
                'status'  => false,
                'message' => implode(', ', $errors),
                'data'    => null
            ));
            return;
        }

        // Validasi format tanggal (YYYY-MM-DD)
        $d = DateTime::createFromFormat('Y-m-d', $tanggal_servis);
        if (!$d || $d->format('Y-m-d') !== $tanggal_servis) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Format tanggal servis tidak valid',
                'data'    => null
            ));
            return;
        }

        // Validasi tanggal tidak boleh di masa lalu
        if ($tanggal_servis < date('Y-m-d')) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Tanggal servis tidak boleh di masa lalu',
                'data'    => null
            ));
            return;
        }

        // Validasi jam servis harus merupakan slot resmi AHASS
        if (!$this->Booking_model->is_valid_slot($jam_servis)) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Jam servis tidak valid. Silakan pilih dari slot resmi yang tersedia.',
                'data'    => null
            ));
            return;
        }

        // Validasi jam di masa lalu jika booking untuk hari ini
        if ($tanggal_servis === date('Y-m-d') && $jam_servis <= date('H:i:s')) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Jam servis untuk hari ini sudah lewat. Silakan pilih jam berikutnya atau tanggal lain.',
                'data'    => null
            ));
            return;
        }

        // Validasi paket_id ada di database
        $paket = $this->Paket_model->get_by_id($paket_id);
        if (!$paket) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Paket servis tidak ditemukan',
                'data'    => null
            ));
            return;
        }

        // VALIDASI SLOT BACKEND: Cek apakah slot masih tersedia (max 3 per slot per tanggal)
        if (!$this->Booking_model->is_slot_available($tanggal_servis, $jam_servis)) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Maaf, slot jam ' . date('H:i', strtotime($jam_servis)) . ' pada tanggal ' . date('d/m/Y', strtotime($tanggal_servis)) . ' sudah penuh (maksimal 3 kendaraan per slot). Silakan pilih slot jam lain.',
                'data'    => null
            ));
            return;
        }

        // Simpan booking
        $data = array(
            'plat_nomor'     => strtoupper($plat_nomor),
            'nama_pelanggan' => $nama_pelanggan,
            'tipe_motor'     => $tipe_motor,
            'tanggal_servis' => $tanggal_servis,
            'jam_servis'     => $jam_servis,
            'paket_id'       => $paket_id,
            'status'         => 'pending'
        );

        $id = $this->Booking_model->create($data);

        if ($id) {
            $booking = $this->Booking_model->get_by_id($id);
            echo json_encode(array(
                'status'  => true,
                'message' => 'Booking berhasil dibuat! No. Booking: #' . str_pad($id, 4, '0', STR_PAD_LEFT),
                'data'    => $booking
            ));
        } else {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Gagal membuat booking. Silakan coba lagi.',
                'data'    => null
            ));
        }
    }

    /**
     * Update status booking
     * AJAX POST
     */
    public function update_status()
    {
        $id     = $this->input->post('id');
        $status = $this->input->post('status');

        $valid_statuses = array('pending', 'confirmed', 'completed', 'cancelled');

        if (empty($id) || empty($status)) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'ID dan status wajib diisi',
                'data'    => null
            ));
            return;
        }

        if (!in_array($status, $valid_statuses)) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Status tidak valid',
                'data'    => null
            ));
            return;
        }

        // Cek booking ada
        $booking = $this->Booking_model->get_by_id($id);
        if (!$booking) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Booking tidak ditemukan',
                'data'    => null
            ));
            return;
        }

        $result = $this->Booking_model->update_status($id, $status);

        if ($result) {
            echo json_encode(array(
                'status'  => true,
                'message' => 'Status booking berhasil diupdate menjadi ' . ucfirst($status),
                'data'    => null
            ));
        } else {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Gagal mengupdate status',
                'data'    => null
            ));
        }
    }
}
