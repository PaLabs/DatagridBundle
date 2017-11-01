<?php


namespace PaLabs\DatagridBundle\Grid\Export;


use PaLabs\DatagridBundle\Field\Renderer\FieldRenderResult;
use PaLabs\DatagridBundle\Grid\View\GridView;
use PaLabs\DatagridBundle\Util\StringUtils;
use PhpOffice\PhpSpreadsheet\Cell;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Symfony\Component\HttpFoundation\StreamedResponse;

class XlsxExporter implements GridExporter
{
    const FORMAT = 'xlsx';

    public function supportedFormat(): string
    {
        return self::FORMAT;
    }

    public function export(GridView $view, string $fileName)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $rowNumber = 1;

        foreach ($view->getHeader() as $row) {
            $this->exportRow($row, $rowNumber, $sheet);
            $rowNumber++;
        }
        $sheet->freezePaneByColumnAndRow(1, $rowNumber);

        foreach ($view->getRows() as $row) {
            $this->exportRow($row, $rowNumber, $sheet);
            $rowNumber++;
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $callback = function () use ($writer) {
            $writer->save('php://output');
        };
        return new StreamedResponse($callback, 200, [
            'Content-Type' => ' application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=$fileName.xlsx"
        ]);
    }

    private function exportRow($row, $rowNumber, Worksheet $sheet)
    {
        $columnNumber = 0;
        /** @var FieldRenderResult[] $row */
        foreach ($row as $value) {
            $content = $value->getRenderedContent();
            if ($content instanceof MemoryDrawing) {
                $columnLetter = Cell::stringFromColumnIndex($columnNumber);
                $coordinate = $columnLetter . $rowNumber;
                $content->setCoordinates($coordinate);
                $content->setWorksheet($sheet);
            } else {
                if(is_string($content)) {
                    $content = StringUtils::fixEncoding($content);
                }
                $sheet->setCellValueByColumnAndRow($columnNumber, $rowNumber, $content);
            }
            $columnNumber++;
        }
    }
}