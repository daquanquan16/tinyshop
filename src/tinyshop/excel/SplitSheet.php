<?php


namespace tinyshop\excel;


use PhpOffice\PhpSpreadsheet\IOFactory;

class SplitSheet
{

    public function run($inputFileType,$inputFileName)
    {
       // Create a new Reader of the type defined in $inputFileType

        $reader = IOFactory::createReader($inputFileType);

        // Define how many rows we want to read for each "chunk"
        $chunkSize = 20;
       // Create a new Instance of our Read Filter
        $chunkFilter = new ChunkReadFilter();

         // Tell the Reader that we want to use the Read Filter that we've Instantiated
        $reader->setReadFilter($chunkFilter);
        echo "初始: ".memory_get_usage()."B\n";
        $i=1;
        // Loop to read our worksheet in "chunk size" blocks
        for ($startRow = 2; $startRow <= 240; $startRow += $chunkSize) {

           // Tell the Read Filter, the limits on which rows we want to read this iteration
            $chunkFilter->setRows($startRow, $chunkSize);
            // Load only the rows that match our filter from $inputFileName to a PhpSpreadsheet Object
            $spreadsheet = $reader->load($inputFileName);
            $reader->setReadDataOnly(true);
            // Do some processing here
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            echo "使用{$i}: ".memory_get_usage()."B\n".PHP_EOL;
            $spreadsheet->disconnectWorksheets();
            unset($sheetData);
            unset($spreadsheet);
            echo "释放{$i}: ".memory_get_usage()."B\n".PHP_EOL;
          //  echo "峰值: ".memory_get_peak_usage()."B\n".PHP_EOL;
$i++;
        }
    }
}