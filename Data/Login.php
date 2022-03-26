<?php 
	require("Database.php");

	if (isset($_GET['USERNAME']) && isset($_GET['PASSWORD']) && $_GET['USERNAME'] != null && $_GET['PASSWORD'] != null)
	{
			$User = $_GET['USERNAME'];
			$Pass = $_GET['PASSWORD'];
			$retval = mysqli_query( connection("au_avery"),"SELECT * FROM avery_user WHERE Username = '$User' AND Password = '$Pass' AND ACTIVE = 1");
			$row = mysqli_fetch_assoc($retval);
			if(count($row) != 0 && $row["Username"] != "")
			{
				setcookie("VNRISIntranet", $row["Username"], time() + (86400 * 30), "/");
				setcookie("Name_Department", $row["Name_Department"], time() + (86400 * 30), "/");
				echo "OK";
			} else
			{
				$db = "A:\VNDB\user list.mdb";
				if (!file_exists($db))
				{
					die("No database file.");
				}
				$Turn = 0;
				$dbNew = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=$db; Uid=; Pwd=19781121ok;");
				$sql = "SELECT username FROM [user_list] WHERE user_list.username = '$User' AND password = '$Pass'";
				$rs = $dbNew->query($sql);
				while($result = $rs->fetch())
				{
					setcookie("VNRISIntranet", $result["username"], time() + (86400 * 30), "/");
					$Turn = 1;
				} 
				if($Turn == 1)
				{
					echo "OK";
				} else
				{
					echo "NG";
				}
			}
	} 
?>