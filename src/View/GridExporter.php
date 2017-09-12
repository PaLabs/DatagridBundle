<?php

namespace PaLabs\DatagridBundle\View;


use PaLabs\DatagridBundle\Field\FieldRenderResult;
use PHPExcel;
use PHPExcel_IOFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GridExporter
{
    public static function toCsv($report, $fileName)
    {
        // To prevent killing script while exporting
        set_time_limit(0);

//        $writer = new CsvWriter('php://output', ';', '"', "");
//        $callback = function () use ($writer, $report) {
//            $writer->open();
//            foreach ($report as $row) {
//                $writer->write($row);
//            }
//            $writer->close();
//        };
//
//        return new StreamedResponse($callback, 200, [
//            'Content-Type' => 'text/csv',
//            'Content-Disposition' => sprintf('attachment; filename=%s.csv', $fileName)]);
    }

    public static function toXlsx($report, $fileName)
    {
        $phpExcel = new PHPExcel();
        $phpExcel->setActiveSheetIndex(0);

        $rowNumber = 1;


        foreach ($report as $row) {
            $columnNumber = 0;
            /** @var FieldRenderResult[] $row */
            foreach ($row as $value) {
                $phpExcel->getActiveSheet()->setCellValueByColumnAndRow($columnNumber, $rowNumber, $value->getRenderedContent());
                $columnNumber++;
            }

            $rowNumber++;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
        $callback = function () use ($objWriter) {
            $objWriter->save('php://output');
        };
        return new StreamedResponse($callback, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => "attachment; filename=$fileName.xlsx"]);
    }
}