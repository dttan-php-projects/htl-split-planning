<?php 
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 300);
    ob_start();	
    require("./Data/Database.php");
	require_once "../Module/PHPExcel.php";

	// Create new PHPExcel object  
	$objPHPExcel = new PHPExcel();  
	
	// Set properties  
	$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")  
	->setLastModifiedBy("Maarten Balliauw")  
	->setTitle("Office 2007 XLSX Test Document")  
	->setSubject("Office 2007 XLSX Test Document")  
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")  
	->setKeywords("office 2007 openxml php")  
	->setCategory("Test result file");  
	$cacheSettings = array( 'memoryCacheSize' => '1024MB');

    // Add some data
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Ngay Lam Lenh');
    $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Lenh San Xuat');
    $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Item Code');
    $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'RBO');
    $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'So Luong');
    $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Ups');
    $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Ma Vat Tu');
    $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Ngay Giao');
    $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Mau');
    $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Tien Trinh');
    $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Tong Luot In');
    $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Khung');
    $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Total Sheet');
    $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'So m Can Chay');


    $sql = "SELECT A.IDCode,A.Layouts,A.Runs_Length,A.`Index` AS I,A.SheetsSplit,A.SheetsCount,A.Remain,A.ImagesURL,A.PromiseDate,A.JobJacket,A.Print_Structure,A.CreatedDate, B.Placed, B.Item 
                FROM htl_mainlayout A RIGHT JOIN htl_detaillayout B ON A.IDCode = B.IDCode AND A.`Index` = B.`Index` WHERE A.JobJacket IS NOT NULL;";
    $retval = mysqli_query( connection(), $sql );
    $i = 1;

    while($result = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
        $i++;
        $objPHPExcel->getActiveSheet()->SetCellValue("A$i", $result["CreatedDate"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("B$i", $result["JobJacket"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("C$i", $result["Item"]);
        // $objPHPExcel->getActiveSheet()->SetCellValue("D$i", $result["I"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("E$i", $result["SheetsCount"] * $result["Placed"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("F$i", $result["Placed"]);
        // $objPHPExcel->getActiveSheet()->SetCellValue("G$i", $result["Remain"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("H$i", $result["PromiseDate"]);
        // $objPHPExcel->getActiveSheet()->SetCellValue("I$i", $result["PromiseDate"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("J$i", $result["Print_Structure"]);
        // $objPHPExcel->getActiveSheet()->SetCellValue("K$i", $result["Print_Structure"]);
        // $objPHPExcel->getActiveSheet()->SetCellValue("L$i", $result["CreatedDate"]);
        $objPHPExcel->getActiveSheet()->SetCellValue("M$i", $result["SheetsCount"]);
        // $objPHPExcel->getActiveSheet()->SetCellValue("N$i", $result["CreatedDate"]);
    } 

    // Rename sheet
    $objPHPExcel->getActiveSheet()->setTitle('Simple');


    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Item Information ' . Date("YmdHis") . '.xlsx"');
    header('Cache-Control: max-age=0');
    ob_end_clean();

	$objWriter->save('php://output');
	exit;
?>