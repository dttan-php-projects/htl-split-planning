<?php

@session_start();
$idd = session_id();

include_once ("Database.php");
$conn = connection();

// this part is for loading image into item
if (@$_REQUEST["action"] == "loadImage") {
	
	// default image
	$i = "./Images/photo.png";
	
	if($_GET["IMG"] != "") 
	{
		$result = $conn->query("SELECT ImagesURL FROM htl_mainlayout WHERE ID = '". $_GET["IMG"]."'");		
		$results = mysqli_fetch_all($result,MYSQLI_ASSOC);
		if(count($results) == 1)
		{
			foreach($results[0] as $K => $V){
				$i = $V;
			}
		}

	} 
	if($i == "") $i = "Images/photo.png";
	header("Content-Type: image/jpg");
	print_r(file_get_contents($i));
	die();
}

// this part is for uploading the new one
if (@$_REQUEST["action"] == "uploadImage") {
	
	$filename = time() . basename($_FILES["file"]["name"]);
	move_uploaded_file($_FILES["file"]["tmp_name"], "Images/".$filename);
	copy("Images/".$filename, "Images/".$idd);

	header("Content-Type: text/html; charset=utf-8");
	print_r("{state: true, itemId: '".@$_REQUEST["itemId"]."', itemValue: '"."Images/".$filename."'}");
}

?>