<?php
    require("./Data/Database.php");
    $conn = connection();

    $string = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
    $ArrayJson = json_decode($string);
    $ArrayMain = array();    

    $Sheets = 100;
    $IDCode = $_SERVER['REMOTE_ADDR']."_".date("YmdHms");

    foreach($ArrayJson->layouts as $R)
    {
        $S = FLOOR($R->{'run-length'}/$Sheets);
        $Rs = $R->{'run-length'} - ($Sheets*$S);
        array_push($ArrayMain, array("Layouts" => $R->name, "Runs_Length" => $R->{'run-length'}, "Index" => $R->index, "SheetsSplit" => $S, "SheetsCount" => $Sheets, "Remain" => $Rs, "Products" => array()));
        $RunsLength = $R->{'run-length'};
        $retval = mysqli_query($conn, "INSERT INTO `htl_mainlayout`
                                                        (
                                                        `IDCode`,
                                                        `Layouts`,
                                                        `Runs_Length`,
                                                        `Index`,
                                                        `SheetsSplit`,
                                                        `SheetsCount`,
                                                        `JobJacket`,
                                                        `Remain`)
                                                        VALUES
                                                        (
                                                        '$IDCode',
                                                        '$R->name',
                                                        '$RunsLength',
                                                        '$R->index',
                                                        '$S',
                                                        '$Sheets',
                                                        '$R->name',
                                                        '$Rs');" );

    }

    foreach($ArrayJson->products as $R)
    {
        $LayoutNo = $R->layouts[0]->index;
        $ItemCode = $R->name;
        $Placed = $R->layouts[0]->placed;
        foreach($ArrayMain as $K=>$Rows)
        {
            if($Rows["Index"] == $LayoutNo)
            {
                array_push($ArrayMain[$K]["Products"], array("Item" => $ItemCode, "Placed" => $Placed));
                $retval = mysqli_query($conn, "INSERT INTO `htl_detaillayout`
                                                                (
                                                                `IDCode`,
                                                                `Index`,
                                                                `Item`,
                                                                `Placed`)
                                                                VALUES
                                                                (
                                                                '$IDCode',
                                                                '$LayoutNo',
                                                                '$ItemCode',
                                                                '$Placed');
                                                                " );
            }
        }
    }
    if ($conn) mysqli_close($conn);
    header("Location: CreatedJob.php?IDCODE=" . $IDCode);
    die();
?>
    
    
    