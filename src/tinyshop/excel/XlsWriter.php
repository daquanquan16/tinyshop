<?php


namespace tinyshop\excel;


class XlsWriter
{
//$filePath='D:\\data\\web\\besr_agent/app/common/lib/excel/lib/test.xlsx';
    private $excel = null;

    public function __construct($filePath)
    {
        $config = ['path' => $filePath];
        $excel = new \Vtiful\Kernel\Excel($config);
    }

    public function writeExcel()
    {
        //$config = ['path' => './tests'];
        // $excel = new \Vtiful\Kernel\Excel($config);
        $fileName = "test.xlsx";
        // 导出测试文件
        $filePath = $this->excel->fileName($fileName)
            ->header(['Item', 'Cost'])
            ->output();
    }

    public function readExcel($fileName)
    {
        $fileName = "test.xlsx";
        // 读取测试文件
        $data = $this->excel->openFile($fileName)
            ->openSheet()
            ->getSheetData();
        return $data;
        var_dump($data);
    }
    public function nextRow($fileName){

// 读取测试文件
        $this->excel->openFile($fileName)
            ->openSheet();

        var_dump($this->excel->nextRow()); // ['Item', 'Cost']
        var_dump($this->excel->nextRow()); // NULL
        // 此处判断请使用【!==】运算符进行判断；
// 如果使用【!=】进行判断，出现空行时，返回空数组，将导致读取中断；
      /*  while (($row = $excel->nextRow()) !== NULL) {
            var_dump($row);
        }*/
    }




}