<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends MX_Controller {

    public function __construct() {
        parent::__construct();
        
        // --- START CORS FIX ---
        // Mengizinkan domain apapun untuk mengakses API ini
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, Authorization, X-Requested-With, Origin, Accept");
        
        // Menangani permintaan "Preflight" (OPTIONS) yang dikirim browser
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header("HTTP/1.1 200 OK");
            exit;
        }
        // --- END CORS FIX ---
        
        $this->load->library('jwt');
    }

    protected function get_json_input() {
        $raw_input = file_get_contents('php://input');
        return json_decode($raw_input, true) ?: [];
    }

    protected function response_json($data, $status_code = 200) {
        // Pastikan header CORS juga dikirim saat memberikan respon JSON
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json; charset=utf-8');
        $this->output->set_status_header($status_code);
        echo json_encode($data);
        exit;
    }
}
