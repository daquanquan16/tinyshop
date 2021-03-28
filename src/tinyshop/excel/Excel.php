<?php


namespace tinyshop\excel;


use PhpOffice\PhpSpreadsheet\IOFactory;

class Excel
{
    public function run($inputFileName, $sheetIndex = 0, $class = null, $method = null)
    {
        $inputFileType = IOFactory::identify($inputFileName);
        //  $excelReader = IOFactory::createReader($inputFileType);
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);//只需要添加这个方法实现表格数据格式转换
        $PHPExcel = $reader->load($inputFileName);
        $sheet = $PHPExcel->getSheet($sheetIndex);
        $rows = $sheet->getRowIterator();
        $i = 0;
        $data = [];
        foreach ($rows as $rowKey => $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            $rowData = [];
            foreach ($cellIterator as $colKey => $cell) {
                // $rowData[$colKey] = $cell->getValue();
                $rowData[] = $cell->getValue();
            }
            if (!empty($class)) {
                if (empty($method)) {
                    return "异常";
                }
                call_user_func([$class, $method], $rowData);
            }
            $data[] = $rowData;
            // echo "执行时间：{$start}出去{$i}:".memory_get_usage() / 1024 / 1024 . PHP_EOL;
            // $i++;
            //print_r($rowData);
        }
        return $data;
    }

}