<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model('Product_model');
        $this->load->library('pagination');
    }


    public function index($page = null)
    {
        $data['title'] = "Produk";

        // Jumlah data per halaman
        $limit = 10;

        // Hitung total jumlah data produk
        $total_rows = $this->Product_model->countProducts();

        // Konfigurasi pagination
        $config['base_url'] = base_url('product/index');  // URL dasar untuk pagination
        $config['total_rows'] = $total_rows;  // Jumlah total data
        $config['per_page'] = $limit;  // Jumlah data per halaman
        $config['uri_segment'] = 3;  // Segment URL yang digunakan untuk pagination (index ke-3)

        // Styling pagination (opsional, bisa disesuaikan dengan tema Anda)
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['num_links'] = 5;  // Jumlah nomor halaman yang ditampilkan

        // Inisialisasi pagination
        $this->pagination->initialize($config);

        // Ambil data produk dengan pagination
        $data['productAll'] = $this->Product_model->getDataProduct($limit, $page);

        // Link pagination
        $data['pagination'] = $this->pagination->create_links();

        // Tentukan halaman
        $data['page'] = 'pages/users/product';
        $this->view($data);
    }
}

/* End of file Home.php */
