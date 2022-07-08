<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Mpdf\Mpdf;

/**
 * Pdf Class Library
 * 
 * @author  José Cabezas Lucero <josecabezaslucero@gmail.com>
 */
class Pdf extends mPDF
{
    public $filename = '';
    public $output = 'I';

    public function __construct($config = []) {
        parent::__construct(self::setconfig($config));
    }

    static function setConfig($config) {
        // $mode = array_key_exists('mode', $setting) ? $setting['mode']
        //$this->output = isset($config['output']) ? $config['output'] : $this->output;
        return [
            'mode' => isset($config['mode']) ? $config['mode'] : 'UTF-8',
            'format' => isset($config['mode']) ? $config['mode'] : 'Letter',
            'default_font_size' => isset($config['default_font_size']) ? $config['default_font_size'] : '',
            'default_font' => isset($config['default_font']) ? $config['default_font'] : '',
            'margin_left' => isset($config['margin_left']) ? $config['margin_left'] : 10,
            'margin_right' => isset($config['margin_right']) ? $config['margin_right'] : 10,
            'margin_top' => isset($config['margin_top']) ? $config['margin_top'] : 10,
            'margin_bottom' => isset($config['margin_bottom']) ? $config['margin_bottom'] : 30,
            'margin_header' => isset($config['margin_header']) ? $config['margin_header'] : 0,
            'margin_footer' => isset($config['margin_footer']) ? $config['margin_footer'] : 10,
            'orientation' => isset($config['orientation']) ? $config['orientation'] : 'P',
            'tempDir' => '/tmp',
        ];
    }

    private function setTemplate($templates = []) {
        setlocale(LC_ALL, 'es_ES');

        $this->ignore_invalid_utf8= TRUE;

        if(isset($templates['stylesheet'])) {
            $this->WriteHTML($templates['stylesheet'], 1);
        }

        if(isset($templates['template'])) {
            $this->WriteHTML($templates['template'], 2);
        }

        if(isset($templates['footer'])) {
            $this->setHTMLFooter($templates['footer']);
        }

        if(isset($templates['pagination']) && $templates['pagination'] === TRUE) {
            $this->setFooter('{PAGENO}');
        }
    }

    private function setFilename($filename) {
        $this->filename = isset($filename) ? mb_strimwidth($filename, 0, 100, '') : 'pdf_report.pdf';
    }

    public function generate($template, $filename) {
        if(isset($template['template'])) {
            $this->setTemplate($template);
            $this->setFilename($filename);
            $this->Output($this->filename, $this->output);
        }
        else {
            trigger_error('Parameters Array(template) is required.', E_USER_ERROR);
        }
    }
}