<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Excel Class Library
 * 
 * @author  José Cabezas Lucero <josecabezaslucero@gmail.com>
 */
class Excel
{
    public function generate($data = []) {
        if(isset($data['header']) && isset($data['items'])) {

            $header = $data['header'];
            $items = $data['items'];

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->fromArray([$header], NULL, 'A1');
            $highestColumn = $sheet->getHighestColumn();
            $sheet->fromArray($items, NULL, 'A2');
            $styleArrayFirstRow = ['font' => ['bold' => TRUE]];

            foreach(range('A', $highestColumn) as $columnId) {
                $sheet->getStyle($columnId.'1')->applyFromArray($styleArrayFirstRow);
                $spreadsheet->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(TRUE);
            }

            if(isset($data['filename'])) {
                $filename = $data['filename'];
            }
            else {
                $filename = 'excel_report';
            }

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'.$filename.'.xlsx"');
            header('Cache-Control: max-age=0');

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save('php://output');
        }
        else {
            //trigger_error('Parameters Array(header, items) is required.', E_USER_ERROR);
            die('Error (Excel Library): Parameters Array(header, items) are requireds.');
        }
    }
} 