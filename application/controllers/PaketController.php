<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaketController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Paket_model');
    }

    /**
     * Get semua paket servis
     * AJAX GET
     */
    public function list()
    {
        $paket = $this->Paket_model->get_all();

        echo json_encode(array(
            'status'  => true,
            'message' => 'Data paket servis berhasil dimuat',
            'data'    => $paket
        ));
    }

    /**
     * Get paket by ID
     * AJAX GET
     */
    public function get($id = null)
    {
        if (empty($id)) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'ID paket wajib diisi',
                'data'    => null
            ));
            return;
        }

        $paket = $this->Paket_model->get_by_id($id);

        if ($paket) {
            echo json_encode(array(
                'status'  => true,
                'message' => 'Data paket ditemukan',
                'data'    => $paket
            ));
        } else {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Paket tidak ditemukan',
                'data'    => null
            ));
        }
    }

    /**
     * Simpan paket baru
     * AJAX POST
     */
    public function store()
    {
        $nama_paket = trim($this->input->post('nama_paket'));
        $deskripsi  = trim($this->input->post('deskripsi'));

        // Validasi
        $errors = array();

        if (empty($nama_paket)) {
            $errors[] = 'Nama paket wajib diisi';
        } elseif (strlen($nama_paket) > 100) {
            $errors[] = 'Nama paket maksimal 100 karakter';
        }

        if (!empty($errors)) {
            echo json_encode(array(
                'status'  => false,
                'message' => implode(', ', $errors),
                'data'    => null
            ));
            return;
        }

        $data = array(
            'nama_paket' => $nama_paket,
            'deskripsi'  => $deskripsi
        );

        $id = $this->Paket_model->create($data);

        if ($id) {
            echo json_encode(array(
                'status'  => true,
                'message' => 'Paket servis berhasil ditambahkan',
                'data'    => $this->Paket_model->get_by_id($id)
            ));
        } else {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Gagal menambahkan paket servis',
                'data'    => null
            ));
        }
    }

    /**
     * Update paket
     * AJAX POST
     */
    public function update()
    {
        $id         = $this->input->post('id');
        $nama_paket = trim($this->input->post('nama_paket'));
        $deskripsi  = trim($this->input->post('deskripsi'));

        // Validasi
        $errors = array();

        if (empty($id)) {
            $errors[] = 'ID paket wajib diisi';
        }
        if (empty($nama_paket)) {
            $errors[] = 'Nama paket wajib diisi';
        } elseif (strlen($nama_paket) > 100) {
            $errors[] = 'Nama paket maksimal 100 karakter';
        }

        if (!empty($errors)) {
            echo json_encode(array(
                'status'  => false,
                'message' => implode(', ', $errors),
                'data'    => null
            ));
            return;
        }

        // Cek paket ada
        $paket = $this->Paket_model->get_by_id($id);
        if (!$paket) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Paket tidak ditemukan',
                'data'    => null
            ));
            return;
        }

        $data = array(
            'nama_paket' => $nama_paket,
            'deskripsi'  => $deskripsi
        );

        $result = $this->Paket_model->update($id, $data);

        if ($result) {
            echo json_encode(array(
                'status'  => true,
                'message' => 'Paket servis berhasil diupdate',
                'data'    => $this->Paket_model->get_by_id($id)
            ));
        } else {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Gagal mengupdate paket servis',
                'data'    => null
            ));
        }
    }

    /**
     * Hapus paket
     * AJAX POST
     */
    public function delete()
    {
        $id = $this->input->post('id');

        if (empty($id)) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'ID paket wajib diisi',
                'data'    => null
            ));
            return;
        }

        // Cek apakah paket sedang dipakai
        if ($this->Paket_model->is_used($id)) {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Paket tidak bisa dihapus karena sedang digunakan dalam booking',
                'data'    => null
            ));
            return;
        }

        $result = $this->Paket_model->delete($id);

        if ($result) {
            echo json_encode(array(
                'status'  => true,
                'message' => 'Paket servis berhasil dihapus',
                'data'    => null
            ));
        } else {
            echo json_encode(array(
                'status'  => false,
                'message' => 'Gagal menghapus paket servis',
                'data'    => null
            ));
        }
    }
}
