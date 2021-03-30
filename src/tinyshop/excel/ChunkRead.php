<?php


namespace tinyshop\excel;


use  tinyshop\excel\ChunkReadFilter;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ChunkRead
{

    public function chunkRead($file, $start_Row = 1, $class = null, $method = null)
    {
        ini_set('memory_limit', '512M');
        $fileType = IOFactory::identify($file);
        $reader = IOFactory::createReader($fileType);
        $reader->setReadDataOnly(true);
        $rowsData = [];
        $startRow = $start_Row;
        $chunkSize = 1000;
        // echo memory_get_usage() / 1024 / 1024 . PHP_EOL;
        while (true) {
            //  $endRow = $startRow + $chunkSize;
            $chunkFilter = new ChunkReadFilter($startRow, $chunkSize);
            $reader->setReadFilter($chunkFilter);
            $spreadsheet = $reader->load($file);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            foreach ($sheetData as $row => $value) {
                if ($row >= $startRow && $row < ($startRow + $chunkSize)) {
                    if (!empty($class) && !empty($method)) {
                        call_user_func(array($class, $method), $value);
                        continue;
                    }
                    $rowsData[] = $value;
                }
            }
//            echo memory_get_usage() / 1024 / 1024 . PHP_EOL;
            $spreadsheet->disconnectWorksheets();
            if (count($sheetData) < $chunkSize) {
                break;
            }
            $startRow = $startRow + $chunkSize;
        }
        return $rowsData;

    }

}