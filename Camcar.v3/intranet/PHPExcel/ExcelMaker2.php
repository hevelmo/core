<?php

class ExcelMaker2 {
    private $nameFileExcel;
    private $nameSheetExcel;
    private $nameFilePhpCreator;
    private $folderFilesPhpCreator;
    private $locationFileCreator;
    private $numberColumns;
    private $numberRows;
    private $excelContent;

    public function __construct($nameFileExcel, $nameSheetExcel, $ths, $trs) {
        $this->nameSheetExcel = $nameSheetExcel;
        $this->nameFileExcel = '' . $nameFileExcel . '.xlsx';
        $this->numberColumns = count($ths);
        $this->numberRows = count($trs) + 1;
        $this->makeExcelContent($ths, $trs);
        $this->makeNameFilePhpCreator();
        $this->makeFolderFilesPhpCreator();
        $this->makeLocationFileCreator();
    }

    private function makeExcelContent($ths, $trs) {
        $trsClean = array();
        $trsClean[] = $ths;
        foreach($trs as $trKey => $trContent) {
            $trNew = array();
            foreach($trContent as $tdKey => $tdContent) {
                $trNew[] = $tdContent;
            }
            $trsClean[] = $trNew;
        }
        $this->excelContent = $trsClean;
    }

    private function makeNameFilePhpCreator() {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $length = intval(strlen($chars) / 3, 10);
        $randomNameFile = '';
        for($i = 0; $i < $length; $i++) {
            $randomNameFile .= substr($chars, rand(0, strlen($chars)), 1);
        }
        $randomNameFile .= str_replace(array(':', '-', ' '), '', date('o-m-d H:i:s'));
        $this->nameFilePhpCreator = '_' . $randomNameFile . '.php';
    }

    private function makeFolderFilesPhpCreator() {
        $this->folderFilesPhpCreator = __DIR__ . '/' . '_filescreator' . '/';
    }

    private function makeLocationFileCreator() {
        $explodeFolder = explode('/', __DIR__ . '/' . '_filescreator');
        $length = count($explodeFolder);
        $this->locationFileCreator = $explodeFolder[$length - 2] . '/' . $explodeFolder[$length - 1] . '/';
    }

    public function makeFileCreator() {
        $columns = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $xlsxObjectName = 'objPHPExcel';
        $wriObjectName = 'objWriter';

        $fontSize = 10;
        $fontName = "Arial";

        //INCLUDE LIBRARY

        $includeSection =
            'require_once "../Classes/PHPExcel.php";';


        //ARRAYS STYLES SECTION

        $styleArraysSection = 
            '$' . 'styleArrayTh = array(' . 
                '"font" => array(' . 
                    '"bold" => true,'. 
                    '"color" => array(' .
                        '"rgb" => "FFFFFF"' .
                    '),' .
                    '"size" =>' . $fontSize . ',' .
                    '"name" => "'. $fontName . '"' .
                '),' .
                '"fill" => array(' .
                    '"type" => PHPExcel_Style_Fill::FILL_SOLID,' .
                    '"color" => array("rgb" => "355B9A")' .
                '),' .
                '"alignment" => array(' . 
                    '"horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,' . 
                    '"vertical" => PHPExcel_Style_Alignment::VERTICAL_CENTER,' . 
                    '"wrap" => true' . 
                ')' . 
            ');'.

            '$' . 'styleArrayTd = array(' . 
                '"font" => array(' . 
                    '"bold" => false,' . 
                    '"color" => array(' . 
                        '"rgb" => "000000"' . 
                    '),' . 
                    '"size" =>' . $fontSize . ',' . 
                    '"name" => "'. $fontName . '"' . 
                '),' . 
                '"alignment" => array(' . 
                    '"horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,' . 
                    '"vertical" => PHPExcel_Style_Alignment::VERTICAL_CENTER,' . 
                    '"wrap" => true' . 
                ')' . 
            ');';


        //CREATE A NEW PHPExcel OBJECT

        $newObjectSection =
            "$" . $xlsxObjectName . " = new PHPExcel();";


        //SET EXCEL PROPERTIES

        $propertiesSection =
            '$' . $xlsxObjectName . '->getProperties()->setCreator("VIRBAC EXPORT");' . 
            '$' . $xlsxObjectName . '->getProperties()->setLastModifiedBy("VIRBAC EXPORT");' . 
            '$' . $xlsxObjectName . '->getProperties()->setTitle("VIRBAC EXPORT");' . 
            '$' . $xlsxObjectName . '->getProperties()->setSubject("VIRBAC EXPORT");' . 
            '$' . $xlsxObjectName . '->getProperties()->setDescription("VIRBAC EXPORT");' . 
            '$' . $xlsxObjectName . '->getProperties()->setKeywords("Excel Office 2007 openxml VIRBAC EXPORT");' . 
            '$' . $xlsxObjectName . '->getProperties()->setCategory("VIRBAC EXPORT");';

        //ADD EXCEL INFORMATION, MAKE STYLES AND RESIZE COLUMNS

        $excelSection = "";
        $styleSection = "";
        $resizeSection = "";

        for($colIdx = 0; $colIdx < $this->numberColumns; $colIdx++) {
            $column = $columns{$colIdx};
            for($rowIdx = 0; $rowIdx < $this->numberRows; $rowIdx++) {
                $cell = $column . ($rowIdx + 1);
                $value = $this->excelContent[$rowIdx][$colIdx];
                $value = str_replace('"', '\"', $value);
                $arrayName = '';
                if(!$rowIdx) {
                    $value = strtoupper($value);
                    $arrayName = 'styleArrayTh';
                } else {
                    $arrayName = 'styleArrayTd';
                }
                $excelSection .= '$' . $xlsxObjectName . '->setActiveSheetIndex(0)->setCellValue("' . $cell . '", "' . $value . '");';
                $styleSection .= '$' . $xlsxObjectName . '->getActiveSheet()->getStyle("' . $cell . '")->applyFromArray($' . $arrayName . ');';
            }
            $resizeSection .= '$' . $xlsxObjectName . '->getActiveSheet()->getColumnDimension("' . $column . '")->setAutoSize(true);';
        }

        //RENAME AND SET DEFAULT SHEET
        $sheetSection = 
            "$" . $xlsxObjectName . "->getActiveSheet()->setTitle('" . strtoupper($this->nameSheetExcel) . "');" . 
            "$" . $xlsxObjectName . "->setActiveSheetIndex(0);";


        //MAKE PHP HEADERS SECTION
        $headersSection =
            "header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');" . 
            "header('Content-Disposition: attachment;filename=". $this->nameFileExcel . "');" .
            "header('Cache-Control: max-age=0');";

        //WRITER SECTION
        $writerSection = 
            "$" . $wriObjectName . " = PHPExcel_IOFactory::createWriter(" . "$" . $xlsxObjectName . ", 'Excel2007');" . 
            "$" . $wriObjectName . "->save('php://output');";

        //MAKE PHP FOOTER SECTION
        $footerSection = 
            "unlink(__FILE__);";


        //JOIN THE SECTIONS TO MAKE FILE CONTENT
        $fileContent = 
        "<?php " . 
            trim($includeSection) . 
            trim($styleArraysSection) . 
            trim($newObjectSection) .
            trim($propertiesSection) . 
            trim($excelSection) . 
            trim($styleSection) . 
            trim($resizeSection) . 
            trim($sheetSection) . 
            trim($headersSection) . 
            trim($writerSection) . 
            trim($footerSection) . 
        "?>";


        //FILE WRITING
        $fileURL = $this->folderFilesPhpCreator . $this->nameFilePhpCreator;
        if(file_exists($fileURL)) {
            unlink($fileURL);
        }
        $fileOpen = fopen($fileURL, 'a');
        fwrite($fileOpen, $fileContent);
        fclose($fileOpen);

    }

    public function getCreatorReference() {
        $file = $this->locationFileCreator . $this->nameFilePhpCreator;
        $parts = explode('PHPExcel', $file);
        $file = "/PHPExcel" . $parts[count($parts) - 1];
        $server;
        $devserverlist = array('127.0.0.1', '::1', '192.168.0.102', 'localhost');
        if(!in_array($_SERVER['SERVER_NAME'], $devserverlist)) {
            $server = 'camcar.mx';
        } else {
            $server = 'localhost/camcar/intranet';
        }
        $url = "http://$server/$file";
        return $url;
    }

}