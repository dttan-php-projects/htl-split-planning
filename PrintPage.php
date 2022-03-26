<!DOCTYPE html>

<html>
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <script src="./Module/JS/jquery-1.10.1.min.js"></script>
    <title>Paginated HTML</title>
    <style type="text/css" media="print">
        div.page
        {
        page-break-after: always;
        page-break-inside: avoid;
        }

        @page {
            size: A4;
            margin: 5mm 5mm 5mm 5mm;
        }

        table.ItemInformation {
            border-collapse: collapse;
        }

        table.ItemInformation td {
            border: 1px solid black;
        }

        .TextTitle {
            font-weight: bold; 
            text-decoration: underline;
        }
    </style>
    
  </head>
  <script>
    $(document).ready(function(){	
        window.print();                                             // Print preview
        setTimeout(function(){
            // window.clos
            e();
        },1000);
    })
    </script>

<?php 
    include('code128.class.php');
    function ShowData($JobNo, $PromiseDate, $Layout, $TLayout, $Sheets, $Quantity, $PStructure, $P, $Ps, $DataItem, $Img)
    {
        $CountHeight = 0;
        echo '<div class="page">
                <table style="width: 100%;border:1px black solid;">
                <tr style="height:40px">
                    <td>AVERY</td>
                    <td colspan=10 style="font-weight:bold;font-size: 20pt; text-align: center">JOB SHEET/ LỆNH SẢN XUẤT FAPL</td>
                </tr>
                <tr style="height:25px">
                    <td colspan=2 class="TextTitle">Date/Ngày Làm Lệnh:</td>
                    <td colspan=3>' . date("Y-m-d") . '</td>
                    <td colspan=3 class="TextTitle">Promise Date/Ngày G.hàng</td>
                    <td colspan=3>' . $PromiseDate . '</td>
                </tr>
                <tr style="height:25px">
                    <td colspan=2 class="TextTitle">Job No/ Số Lệnh:</td>
                    <td colspan=3 style="font-size:20pt;font-weight:bold">' . $JobNo . '</td>
                    <td colspan=3 class="TextTitle">Layout</td>
                    <td colspan=3>' . $Layout . ' (' . $TLayout . ')</td>
                </tr>
                <tr style="height:25px">
                    <td colspan=2 class="TextTitle">Sheets/ Số Tờ:</td>
                    <td colspan=3>' . $Sheets . ' Sheets</td>
                    <td colspan=3 class="TextTitle">Quantity / Số lượng:</td>
                    <td colspan=3 style="font-size:15pt;font-weight:bold">' . $Quantity . ' pcs</td>
                </tr>
                <tr style="height:25px">
                    <td colspan=2 class="TextTitle">Printing Structure:</td>
                    <td colspan=9>' . $PStructure . '</td>
                </tr>
                <tr>
                    <td colspan=11>
                        <table class="ItemInformation" style="width: 100%; text-align: center; font-size:12pt">
                            <tr style="background: yellow">
                                <td style="width:20%">Item Code</td>
                                <td style="width:14%">Page</td>
                                <td style="width:10%">UPS</td>
                                <td style="width:20%">Total Qty(Pcs)</td>
                                <td style="width:20%">Actual Qty(Pcs)</td>
                                <td style="width:16%">Actual Bag(Pcs)</td>
                            </tr>';
                $Total = 0;
                foreach($DataItem as $R)
                {
                    $Total = $Total + $R["Placed"] * $Sheets;
                    $CountHeight += 25;
                    echo '      <tr>
                                <td>' . $R["Item"] . '</td>
                                <td>' . $R["Page"] . '</td>
                                <td>' . $R["Placed"] . '</td>
                                <td>' . $R["Placed"] * $Sheets . '</td>
                                <td></td>
                                <td></td>
                            </tr>';
                }
                $CountHeight = 620 - $CountHeight;
                if($CountHeight < 150) $CountHeight = 150;
                echo        '<tr>
                                <td colspan=3 style="background: pink; font-weight: bold">Total</td>
                                <td>' . $Total  . '</td>
                                <td></td>
                                <td></td>
                            </tr>';
            echo            '</table>
                    </td>
                </tr>
                <tr style="height:' . $CountHeight . 'px">
                    <td style="height:150px; text-align: center; font-weight: bold; font-size: 30pt; color:red;background:url(\'' .$Img. '\') no-repeat center;background-size: auto 100%;" colspan=11>
                        
                    </td>
                </tr>
                <tr style="width:100%">
                    <td colspan=11 style="width:100%">
                        <table class="ItemInformation"  style="width: 100%;border:1px black solid; font-size: 12pt">
                            <tr>
                                <td style="width: 18%; height: 20px; padding-left: 5px; font-weight: bold">Dept</td>
                                <td style="width: 10%; text-align: center">Unit</td>
                                <td style="width: 13%; text-align: center">Quantity</td>
                                <td style="width: 13%; text-align: center">Scrap</td>
                                <td style="width: 18%; text-align: center">Operator</td>
                                <td style="width: 18%; text-align: center">Date</td>
                            </tr>
                            <tr>
                                <td style="height: 20px; padding-left: 5px; font-weight: bold">Screen Room</td>
                                <td style="text-align: center">Frame</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="height: 20px; padding-left: 5px; font-weight: bold">Indigo & ABG</td>
                                <td style="text-align: center">Sheet</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="height: 20px; padding-left: 5px; font-weight: bold">Sakurai</td>
                                <td style="text-align: center">Sheet</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="height: 20px; padding-left: 5px; font-weight: bold">Inspection</td>
                                <td style="text-align: center">Sheet</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="height: 20px; padding-left: 5px; font-weight: bold">Laser & Sorting</td>
                                <td style="text-align: center">Pcs</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="height: 20px; padding-left: 5px; font-weight: bold">Packing</td>
                                <td style="text-align: center">Bag</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td colspan=11></td></tr>
                <tr>
                    <td colspan=1 style="border: 1px black solid">Remark/<br/> Chú Ý</td>
                    <td colspan=10 style="border: 1px black solid; background: yellow"></td>
                </tr>
        
                <tr style="font-size:10pt">
                    <td colspan=7 style="text-align: center">Trang ' . $P . '/' . $Ps . '</td>
                    <td colspan=4> Ngày Ban Hành: 12-12-2018</td>
                </tr>
                </table>
            </div>';
    }

?>

  <body>
    <?php 
        require("./Data/Database.php");
        $conn = connection();

        $ArrayMain = array();    
    
        $Sheets = 6000;
        $IDCode = $_GET["IDCODE"];
        $retval = mysqli_query($conn, "SELECT ID, IDCode, Layouts, Runs_Length, `Index`, SheetsSplit, SheetsCount, Remain, ImagesURL, JobJacket, PromiseDate, Print_Structure, CreatedDate FROM htl_mainlayout WHERE IDCODE = '$IDCode'" );
        while($Rows = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {                
            array_push($ArrayMain, array(  "Layouts" => $Rows["Layouts"], 
                                            "Runs_Length" => $Rows["Runs_Length"], 
                                            "Index" => $Rows["Index"], 
                                            "SheetsSplit" => $Rows["SheetsSplit"], 
                                            "SheetsCount" => $Rows["SheetsCount"], 
                                            "Remain" => $Rows["Remain"], 
                                            "ImagesURL" => $Rows["ImagesURL"], 
                                            "JobJacket" => $Rows["JobJacket"], 
                                            "PromiseDate" => $Rows["PromiseDate"], 
                                            "Print_Structure" => $Rows["Print_Structure"], 
                                            "Products" => array()));
        }
        $retval = mysqli_query($conn, "SELECT A.ID, A.IDCode, A.`Index`, A.Item, A.Placed, B.EAN13, B.Page FROM htl_detaillayout A LEFT JOIN save_master B ON A.Item = B.CUSTOMER_ITEM WHERE IDCODE = '$IDCode'" );
        while($Rows = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {                
            $LayoutNo = $Rows["Index"];
            $ItemCode = $Rows["Item"];
            $Placed = $Rows["Placed"];
            $EAN13 = $Rows["EAN13"];
            $Page = $Rows["Page"];
            foreach($ArrayMain as $K=>$Rows)
            {
                if($Rows["Index"] == $LayoutNo)
                {
                    array_push($ArrayMain[$K]["Products"], array("Item" => $ItemCode, "Placed" => $Placed, "EAN13" => $EAN13, "Page" => $Page));
                }
            }
        }

        foreach($ArrayMain as $K=>$R)
        {
            $JobNo = $R["JobJacket"];
            $PromiseDate = $R["PromiseDate"];
            $ImagesURL = $R["ImagesURL"];
            $Print_Structure = $R["Print_Structure"];
            $Remain = (int)$R["Remain"];

            for($i = 1; $i <= (int)$R["SheetsSplit"]; $i++)
            {
                $SheetsSplit = ($Remain > 0) ? (int)$R["SheetsSplit"]+1 : (int)$R["SheetsSplit"];
                echo ShowData($JobNo . "-" . $i,$PromiseDate,$R["Index"],count($ArrayMain),$R["SheetsCount"],$R["Runs_Length"],$Print_Structure,$i,$SheetsSplit,$R["Products"],$ImagesURL);
            }

            if ($Remain > 0 ) 
                echo ShowData($JobNo . "-" . $i,$PromiseDate,$R["Index"],count($ArrayMain),$R["Remain"],$R["Runs_Length"],$Print_Structure,$i,(int)$R["SheetsSplit"]+1,$R["Products"],$ImagesURL);
        }

        if ($conn) mysqli_close($conn);
    
    
    ?>
  </body>
</html>