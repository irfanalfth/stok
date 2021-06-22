<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

class T extends CI_Controller
{
    function __construct()
    {
    }
    function index()
    {
        $jsondata = file_get_contents('error/err_input_peralatan2.json');
        $dat = json_decode($jsondata, true);
        $spreadsheet = IOFactory::load($_SERVER['DOCUMENT_ROOT'] . '/stok/final3.xlsx');
        $sheet = $spreadsheet->getSheet(5);
// var_dump($jsondata);
foreach ($dat as $dd) {
    $ex = explode(' | ', $dd);
    echo $ex[2];
    $sheet
    ->getStyle('B' . $ex[2] . ':' . 'X' . $ex[2])
    ->getFill()
    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
    ->getStartColor()
    ->setARGB('ff0000');
}
// die;
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($_SERVER['DOCUMENT_ROOT'] . '/stok/finaledit.xlsx');
    }
    
}
