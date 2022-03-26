

<!DOCTYPE html>
<html>
    <head>
        <title>HTL SPLIT JOB</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">     
        <script src="./Module/dhtmlx/codebase/dhtmlx.js" type="text/javascript"></script> 
        <link rel="STYLESHEET" type="text/css" href="./Module/dhtmlx/skins/skyblue/dhtmlx.css">   
        <script src="./Module/JS/jquery-1.10.1.min.js"></script> 
    </head>
<style>
	html, body {
        width: 100%;      /*provides the correct work of a full-screen layout*/ 
        height: 100%;     /*provides the correct work of a full-screen layout*/
        margin: 0px;      /*hides the body's scrolls*/
		font-family: "Source Sans Pro","Helvetica Neue",Helvetica;
		background-repeat: no-repeat;
    background-size: cover;
		overflow:hidden;
    }

</style>

<script src="./Data/trianglify.min.js"></script>
<script>
	var check_gg = 0;

	function setCookie(cname,cvalue,exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires=" + d.toGMTString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	<?php 

		require("./Data/Database.php");
		require("./Data/CheckRole.php");

		function getUser() 
    {
        $email = isset($_COOKIE["VNRISIntranet"]) ? trim($_COOKIE["VNRISIntranet"]) : "";
        return $email;
    }

    function planning_user_statistics($email, $program )
    {
        if (!empty($email) ) {
            $table = 'planning_user_statistics';
            $ip = $_SERVER['REMOTE_ADDR'];

            $url = "http://" .$_SERVER["SERVER_ADDR"] .$_SERVER["REQUEST_URI"];

            $METADATA = "HTTP_COOKIE: " . $_SERVER["HTTP_COOKIE"]. "PATH: " .$_SERVER["PATH"]. "SERVER_ADDR" .$_SERVER["SERVER_ADDR"]. "SERVER_PORT" .$_SERVER["SERVER_PORT"]. "DOCUMENT_ROOT" .$_SERVER["DOCUMENT_ROOT"]. "SCRIPT_FILENAME" .$_SERVER["SCRIPT_FILENAME"];
            $METADATA = mysqli_real_escape_string(connection("au_avery"), $METADATA);

            // update data
            $key = $email . $program;
            $updated = date('Y-m-d H:i:s');
            $check = MiQuery("SELECT `email` FROM $table WHERE CONCAT(`email`,`program`) = '$key';", connection('au_avery') );
            if (!empty($check) ) {
                $sql = "UPDATE $table SET `ip` = '$ip', `url` = '$url', `METADATA` = '$METADATA', `updated` = '$updated'  WHERE `email` = '$email' AND `program` = '$program';";
            } else {
                // Thêm mới. Tự động nên không trả về kết quả
                $sql = "INSERT INTO $table (`email`, `program`, `ip`, `url`, `METADATA`, `updated`) VALUE ('$email', '$program', '$ip',  '$url', '$METADATA', '$updated');";
            }

            return MiNonQuery2( $sql,connection("au_avery"));
            
        }
        
        
    }

	$email = getUser();

		echo CheckHeader(connection("au_avery"));
	?>

	var pattern = Trianglify({
		width: window.innerWidth,
		height: window.innerHeight,
		variance: "1",
  		// cell_size: 40
	});
	var MainMenu;
	$(document).ready(function(){	
		// var VNRISIntranet = '<?php echo isset($_COOKIE["VNRISIntranet"]) ? $_COOKIE["VNRISIntranet"] : ""; ?>';
		// if (!VNRISIntranet ) {
		// 	var username_gg = '<?php echo isset($_GET["VNRISIntranet"]) ? trim($_GET["VNRISIntranet"]) : ""; ?>';
		
		// 	if (username_gg ) {
		// 		setCookie('VNRISIntranet', username_gg, 30 );
		// 		var check_gg = 1;
		// 	}
		// }

		// if (check_gg) location.href="./";

		var VNRISIntranet = '<?php echo getUser(); ?>';
        console.log("VNRISIntranet: "+VNRISIntranet);
        if (!VNRISIntranet ) {
            var pr = prompt('Nhập tiền tố email trước @. Ví dụ: tan.doan', '');
            pr = pr.trim();
            if (!pr || pr.indexOf('@') !== -1 ) {
                alert('Bạn vui lòng nhập đúng tiền tố email là phần trước @');
            } else {
                // Save email đến bảng thống kê (au_avery.planning_user_statistics)
                setCookie('VNRISIntranet', pr, 30 );
                // setCookie('VNRISIntranet', pr, 30 );
                var VNRISIntranet = '<?php echo getUser(); ?>';
                var pr_s = '<?php echo planning_user_statistics($email, "HTL_Spit_Job"); ?>';
                console.log('save planning_user_statistics: ' + pr_s);
                
                check_gg = 1;
            }
            
           
        }
		
		if (check_gg) location.href = './';

		MainMenu = new dhtmlXMenuObject({
				parent: "menuObj",
				icons_path: "./Module/dhtmlx/common/imgs_Menu/",
				json: "/FileHome/Menu.json",
				onload: function() {
					//MainMenu.setItemDisabled("Logo");
				},
				top_text: HeaderTile
			});
		
		MainMenu.attachEvent("onClick", function(id, zoneId, cas){
			if(id != "Logo")
			{
				location.href = "Redirect.php?PAGE=" + id;
			} else
			{
				location.href = "Index.php";
			}
		});
		
		document.body.style.background = "#f3f3f3 url('" + pattern.png() + "')";
		document.body.style.backgroundSize = "cover";

		setTimeout(function(){HomeWin();},1000);
	})
	
	var dhxWins;
	function HomeWin() {
		var id = "HomeWin";
        var w = Number($(window).width() - 100);	
        var h = Number($(window).height() - 100);	
        var x = Number(50);	
        var y = Number(50);

		//
        var Popup = dhxWins.createWindow(id, x, y, w, h);
		dhxWins.window(id).setText("Notification");
		dhxWins.window(id).keepInViewport(true);
		
		Popup.attachHTMLString(`<div style="with: 100%; height:100%; text-align: CENTER;font-size: 16pt"><br/><br/><br/><br/>
                                    <form action="UploadFile.php" method="post" enctype="multipart/form-data">
                                    Vui lòng tải file Json để tách lệnh: <br/> <br/>
                                    <input type="file" name="fileToUpload" id="fileToUpload">
                                    <br/><br/>
                                    <input style="font-size: 20pt; color: red" type="submit" value="Tải Tệp Lên" name="submit">
                                </form>
								
								<button onclick="location.href = 'ExportExcel.php';">Download Summary</button>
								</div>`);
		
		
	}
	
	
	function doOnLoad() {
        dhxWins = new dhtmlXWindows();
        dhxWins.attachViewportTo(document.body);
    }
    
    function doOnUnload() {
        if (dhxWins != null && dhxWins.unload != null) {
            dhxWins.unload();
            dhxWins = null;
        }
    }


</script>
</head>
	<body onload="doOnLoad();" onunload="doOnUnload();">
		<div style="height: 30px;background:#205670;font-weight:bold">
			<div id="menuObj"></div>
		</div>
	</body>
</html>