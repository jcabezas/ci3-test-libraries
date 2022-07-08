<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {

    public function index() {
        $this->load->helper('url');
        $links = '<a href="'.base_url("index.php/test/pdf").'">Test Mpdf Library</a><br>';
        $links .= '<a href="'.base_url("index.php/test/excel").'">Test Office/Spreadsheet Library</a><br>';
        echo $links;
    }

    public function pdf()
    {
        $template = [
            "template" => "Hola Mundo",
        ];
        $filename= 'hola_mundo_pdf';

        $this->load->library("pdf");
        $this->pdf->generate($template, $filename);
    }

    public function excel() {
        $header = [
            "ID Product",
            "Name Product"
        ];
        $items = [
            [1, "Product 1"],
            [2, "Product 2"],
            [3, "Product 3"],
        ];

        $data = [
            "header" => $header,
            "items" => $items
        ];

        $this->load->library("excel");
        $this->excel->generate($data);
    }
    public function excel2() {
        $this->load->library("excel");
        $this->excel->test();
    }
    
}
