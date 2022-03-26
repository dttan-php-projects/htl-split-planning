<?php 
	
	function CheckHeader($dbMi2,$urlRedirect='')
	{
		$SQL_CREATE_DATE = "SELECT CREATEDDATE FROM autoload_log where FUNC = 'AUTOMAIL' order by ID desc limit 0,1;";
		$CREATE_DATE = MiQuery($SQL_CREATE_DATE,$dbMi2 );

		if(!empty($CREATE_DATE)){
			$CREATE_DATE_TEXT = 'AUTOMAIL UPDATED: '.date('d-M-y H:i',strtotime($CREATE_DATE));
		}else{
			$CREATE_DATE_TEXT = '';
		}

		if(!isset($_COOKIE["VNRISIntranet"])) {
			echo 'var HeaderTile = "'.$CREATE_DATE_TEXT.'<a style=\'color:blue;font-style:italic;padding-left:10px\'>Hi Guest | <a href=\"/Intranet/Login/index.php?URL=HTL/GENERATEJOB\">Login</a></a>";var UserVNRIS = "";';
		} else {
			echo 'var HeaderTile = "'.$CREATE_DATE_TEXT.'<a style=\'color:blue;font-style:italic;padding-left:10px\'>Hi '.$_COOKIE["VNRISIntranet"].' | <a href=\"./Data/Logout.php\">Logout</a></a>";var UserVNRIS = "'.$_COOKIE["VNRISIntranet"].'";';
		}

		// if(!isset($_COOKIE["VNRISIntranet"])){
		// 	return 'var HeaderTile = "'.$CREATE_DATE_TEXT.'<a style=\'color:blue;font-style:italic;padding-left:10px\'>Hi Guest | <a href=\"/Intranet/Login/index.php?URL=HTL/GENERATEJOB\">Login</a></a>";var UserVNRIS = "";';
		// } else {
		// 	return 'var HeaderTile = "'.$CREATE_DATE_TEXT.'<a style=\'color:blue;font-style:italic;padding-left:10px\'>Hi '.$_COOKIE["VNRISIntranet"].' | <a href=\"/Data/Logout.php\">Logout</a></a>";var UserVNRIS = "'.$_COOKIE["VNRISIntranet"].'";';
		// }
	}
?>