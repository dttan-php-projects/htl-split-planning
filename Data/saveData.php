<?php 

	header("Content-Type: application/json");

	function checkMainLayoutExist($IDCode, $Index )
	{
		$check = false;

		include_once ("Database.php");
		$conn = connection();
		$table = "htl_mainlayout";

		$result = mysqli_query($conn, "SELECT `ID` FROM $table WHERE `IDCode`='$IDCode' AND `Index`='$Index' ; ");

		if ($result ) {
			if (mysqli_num_rows($result) > 0 ) $check = true;
		}

		if ($conn ) mysqli_close($conn);

		return $check;
	}

	$dataPost = trim($_POST['data']);
	// $dataPost = '[{"IDCode":"147.121.59.66_20201124111126","Index":"1","Layouts":"200875","Runs_Length":"2062","SheetsSplit":"2","SheetsCount":"800","Remain":"462","ImagesURL":"","JobJacket":"200875","PromiseDate":"","Print_Structure":""},{"IDCode":"147.121.59.66_20201124111126","Index":"2","Layouts":"200876","Runs_Length":"5382","SheetsSplit":"6","SheetsCount":"800","Remain":"582","ImagesURL":"","JobJacket":"200876","PromiseDate":"","Print_Structure":""},{"IDCode":"147.121.59.66_20201124111126","Index":"3","Layouts":"200877","Runs_Length":"190","SheetsSplit":"1","SheetsCount":"190","Remain":"0","ImagesURL":"","JobJacket":"200877","PromiseDate":"","Print_Structure":""},{"IDCode":"147.121.59.66_20201124111126","Index":"4","Layouts":"200878","Runs_Length":"3272","SheetsSplit":"4","SheetsCount":"800","Remain":"72","ImagesURL":"","JobJacket":"200878","PromiseDate":"","Print_Structure":""},{"IDCode":"147.121.59.66_20201124111126","Index":"5","Layouts":"200879","Runs_Length":"1518","SheetsSplit":"1","SheetsCount":"800","Remain":"718","ImagesURL":"","JobJacket":"200879","PromiseDate":"","Print_Structure":""}]';
	
	$status = false;
	$message = "Save data Error";

	if(isset($dataPost) && !empty($dataPost) ){
		$data = json_decode($dataPost,true);

		if (!empty($data) ) {
			include_once ("Database.php");
			$conn = connection();
			$table = "htl_mainlayout";

			$multiSql = '';

			// get data 
			foreach ($data as $value ) {
				$Index = trim($value['Index']);
				$IDCode = trim($value['IDCode']);
				$Layouts = trim($value['Layouts']);
				$Runs_Length = trim($value['Runs_Length']);
				$SheetsSplit = trim($value['SheetsSplit']);
				$SheetsCount = trim($value['SheetsCount']);
				$Remain = trim($value['Remain']);
				$ImagesURL = trim($value['ImagesURL']);
				$JobJacket = trim($value['JobJacket']);
				$PromiseDate = trim($value['PromiseDate']);
				$Print_Structure = trim($value['Print_Structure']);

				if (checkMainLayoutExist($IDCode, $Index) ) {
					$multiSql .= " UPDATE $table 
								SET 
									`Layouts`='$Layouts', 
									`Runs_Length`='$Runs_Length', 
									`SheetsSplit`='$SheetsSplit', 
									`SheetsCount`='$SheetsCount', 
									`Remain`='$Remain', 
									`ImagesURL`='$ImagesURL', 
									`PromiseDate`='$PromiseDate',  
									`JobJacket`='$JobJacket', 
									`Print_Structure`='$Print_Structure'
								WHERE `IDCode`='$IDCode' AND `Index`='$Index'
					;";
				} else { // insert
					$multiSql .= " INSERT INTO $table (`IDCode`, `Layouts`, `Runs_Length`, `Index`, `SheetsSplit`, `SheetsCount`, `Remain`, `ImagesURL`, `PromiseDate`, `JobJacket`, `Print_Structure` )
									VALUES ('$IDCode', '$Layouts', '$Runs_Length', '$Index', '$SheetsSplit', '$SheetsCount', '$Remain', '$ImagesURL', '$PromiseDate', '$JobJacket', '$Print_Structure')
					;";
				}
			}

			// execute
			$result = mysqli_multi_query($conn, $multiSql);
			if ($result) {
				$status = true;
				$message = "Save data success";	
			} 

		}

	}

	if ($conn) mysqli_close($conn);

	echo json_encode(array("status" => $status, "message" => $message) ); exit();