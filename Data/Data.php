<?php 
    require("Database.php");
    $conn = connection();

    if(isset($_GET["EVENT"]) && isset($_GET["IDCODE"]) && $_GET["EVENT"] == "LOADLAYOUT")
    {
        $ArrayMain = array();
        $IDCODE = $_GET["IDCODE"];
        $sql = "SELECT `ID`,`Index`,`Layouts`,`Runs_Length`,`SheetsSplit`,`SheetsCount`,`Remain`,`ImagesURL`,`JobJacket`,`PromiseDate`,`Print_Structure`
                FROM `htl_mainlayout` 
                WHERE `IDCode` = '$IDCODE';
        ";
        
        $ArrayMain = MiQuery($sql, $conn);
        header('Content-type: text/xml');
        echo "<rows>";
            foreach ($ArrayMain as $R ) {
                echo '<row id="'. $R["ID"] .'">';
                    echo '<cell>' .$R["Index"]. '</cell>';
                    echo '<cell>' .$R["Layouts"]. '</cell>';
                    echo '<cell>' .$R["Runs_Length"]. '</cell>';
                    echo '<cell>' .$R["SheetsSplit"]. '</cell>';
                    echo '<cell>' .$R["SheetsCount"]. '</cell>';

                    echo '<cell>' .$R["Remain"]. '</cell>';
                    echo '<cell>' .$R["ImagesURL"]. '</cell>';
                    echo '<cell>' .$R["JobJacket"]. '</cell>';
                    echo '<cell>' .$R["PromiseDate"]. '</cell>';
                    echo '<cell>' .$R["Print_Structure"]. '</cell>';
                echo '</row>';
            }

        echo "</rows>";
    } else if(isset($_GET["EVENT"]) && isset($_GET["IDCODE"]) && $_GET["EVENT"] == "LOADITEM")
    {
        $ArrayMain = array();
        $IDCode = $_GET["IDCODE"];
        $INDEX = $_GET["INDEX"];
        $LAYOUT = $_GET["LAYOUT"];

        $sql = "SELECT `ID`,`Index`,`Item`,`Placed`
                FROM `htl_detaillayout`
                WHERE `IDCODE` = '$IDCode' AND `Index` = '$INDEX';
        ";
        
        $ArrayMain = MiQuery($sql, $conn);
        
        header('Content-type: text/xml');
        echo "<rows>";
            foreach ($ArrayMain as $R ) {
                echo '<row id="'. $R["ID"] .'">';
                    echo '<cell>' .$R["Index"]. '</cell>';
                    echo '<cell>' .$LAYOUT. '</cell>';
                    echo '<cell>' .$R["Item"]. '</cell>';
                    echo '<cell>' .$R["Placed"]. '</cell>';
                echo '</row>';
            }
        echo "</rows>";
   
    }
?>