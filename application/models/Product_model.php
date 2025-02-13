<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends MY_Model
{
    protected $perPage = 5;

    public function getDefaultValues()
    {
        return [
            'id_category'   => '',
            'slug'          => '',
            'title'         => '',
            'description'   => '',
            'size'          => '',
            'color'         => '',
            'type'          => '',
            'price'         => '',
            'is_available'  => 1,
            'image'         => ''
        ];
    }
    public function getDataProduct($limit, $start)
    {
        $this->db->select('*');   // Pilih semua kolom dari tabel 'product'
        $this->db->from('product'); // Tentukan tabel 'product'
        $this->db->limit($limit, $start); // Tentukan limit dan offset berdasarkan parameter
        $query = $this->db->get(); // Eksekusi query
        return $query->result();  // Kembalikan hasil query sebagai array objek
    }
    public function countProducts()
    {
        return $this->db->count_all('product');  // Menghitung jumlah total baris dalam tabel 'product'
    }
    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'id_category',
                'label' => 'Kategori',
                'rules' => 'required'
            ],
            [
                'field' => 'slug',
                'label' => 'Slug',
                'rules' => 'trim|required|callback_unique_slug'
            ],
            [
                'field' => 'title',
                'label' => 'Nama Produk',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'description',
                'label' => 'Deskripsi',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'size',
                'label' => 'Ukuran',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'color',
                'label' => 'Warna',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'type',
                'label' => 'Tipe',
                'rules' => 'required'
            ],
            [
                'field' => 'price',
                'label' => 'Harga',
                'rules' => 'trim|required|numeric'
            ],
            [
                'field' => 'is_available',
                'label' => 'Ketersediaan',
                'rules' => 'required'
            ]
        ];

        return $validationRules;
    }

    public function uploadImage($fieldName, $fileName)
    {
        $config = [
            'upload_path'       => './images/product',
            'file_name'         => $fileName,
            'allowed_types'     => 'jpg|gif|png|jpeg|JPG|PNG',
            'max_size'          => 20480,
            'max_width'         => 0,
            'max_height'        => 0,
            'overwrite'         => true,
            'file_ext_tolower'  => true
        ];

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($fieldName)) {
            return $this->upload->data();
        } else {
            $this->session->set_flashdata('image_error', $this->upload->display_errors('', ''));
            return false;
        }
    }

    public function deleteImage($fileName)
    {
        if (file_exists("./images/product/$fileName")) {
            unlink("./images/product/$fileName");
        }
    }
}

/* End of file Product_model.php */
