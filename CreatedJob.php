

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

<script>

	<?php 
		require("./Data/Database.php");
		require("./Data/CheckRole.php");
		echo CheckHeader( connection("au_avery") );
		if(isset($_GET["IDCODE"]))
		{
			echo 'var KeyWord = "' .$_GET["IDCODE"]. '";';	
		}
	?>
	var FormDetailImages;
	var MainMenu;
	var GridMain;
	$(document).ready(function(){	
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

		
		var Toolbar = new dhtmlXToolbarObject({
			parent: "ToolbarBottom",
			icons_path: "./Module/dhtmlx/common/imgs/",
			align: "left",
		});

		Toolbar.addText("Title", null, "<a style='font-size:20pt;font-weight:bold'>HTL Generate Job</a>");
		Toolbar.addButton("Generate", null, "Generate Job", "save.gif");
		Toolbar.addSpacer("Title");

		Toolbar.attachEvent("onClick", function(id){
			if (id == "Generate")
			{	
				// save data before 
				saveData(KeyWord);

				window.open("PrintPage.php?IDCODE=" + KeyWord, '_blank'); 
			}
		});

		
		var LayoutMain = new dhtmlXLayoutObject({
			parent: document.body,
			pattern: "3J",
			offsets: {
				top: 65,
				bottom: 0,
			},
			cells: [
				{id: "a", header: true, text: "Layout Detail"},
				{id: "b", header: false, width: 400},
				{id: "c", header: false}
			]
		});


			GridMain = LayoutMain.cells("a").attachGrid();
			GridMain.setImagePath("./Module/dhtmlx/imgs/");
			GridMain.setHeader("Index,Layouts,Runs Length, Sheets Split, Sheets Count, Remain, Images, JobJacket, Promise Date, Print Structure");
			GridMain.setInitWidths("50,100,100,100,100,100,*,100,100,120")
			GridMain.setColAlign("center,center,center,center,center,center,center,center,center,center");
			GridMain.setColTypes("ro,ro,ro,ro,ed,ro,ed,ed,dhxCalendar,txt");
			GridMain.setColSorting("str,str,str,str,str,str,str,str,str,str")
			GridMain.setRowTextStyle("1", "background-color: red; font-family: arial;");
			GridMain.entBox.id = "GridMain";
			GridMain.setDateFormat("%d/%m/%Y")

			GridMain.init();
				

			GridMain.loadXML("Data/Data.php?EVENT=LOADLAYOUT&IDCODE=" + KeyWord,function(){
				
			});

			GridItem = LayoutMain.cells("b").attachGrid();
			GridItem.setImagePath("./Module/dhtmlx/imgs/");
			GridItem.setHeader("Index,Layouts,Item Code, Placed");
			GridItem.setInitWidths("90,*,100,100")
			GridItem.setColAlign("center,center,center,center");
			GridItem.setColTypes("ro,ro,ro,ro");
			GridItem.setColSorting("str,str,str,str")
			GridItem.setRowTextStyle("1", "background-color: red; font-family: arial;");
			GridItem.entBox.id = "GridMain";
			GridItem.setDateFormat("%d/%m/%Y")

			GridItem.init();

			var	dp = new dataProcessor("Data/Data.php?EVENT=LOADLAYOUT&IDCODE=" + KeyWord);
				dp.init(GridMain);
				dp.attachEvent("onBeforeUpdate", function(id, state, data){
					GridMain.cells(id,3).setValue(Math.floor(data.c2/data.c4));
					GridMain.cells(id,5).setValue(data.c2 - Math.floor(data.c2/data.c4)*data.c4);
					return true;
				});

			GridMain.attachEvent("onRowSelect", function(id,ind){
				console.log("hihi");
				FormDetailImages.removeItem("photo");
				FormDetailImages.loadStruct([
					{type: "image", name: "photo", label: "", imageWidth: 500, imageHeight: 500, inputWidth: LayoutMain.cells("c").getWidth() - 10, inputHeight: LayoutMain.cells("c").getHeight() - 10, url: "dhxform_image.php?IMG=" + id}
				], "json");
				GridItem.clearAll();
				GridItem.loadXML("Data/Data.php?EVENT=LOADITEM&IDCODE=" + KeyWord + "&INDEX=" + GridMain.cells(id,0).getValue() + "&LAYOUT=" + GridMain.cells(id,1).getValue());

				console.log("Data/Data.php?EVENT=LOADITEM&IDCODE=" + KeyWord + "&INDEX=" + GridMain.cells(id,0).getValue() + "&LAYOUT=" + GridMain.cells(id,1).getValue());
			});


			
			var FormData = [
				{type: "image", name: "photo", label: "", imageWidth: 500, imageHeight: 500, inputWidth: LayoutMain.cells("c").getWidth() - 10, inputHeight: LayoutMain.cells("c").getHeight() - 10, url: "dhxform_image.php?IMG=NA"}
			];

			FormDetailImages = LayoutMain.cells("c").attachForm();
			FormDetailImages.loadStruct(FormData, "json");

			FormDetailImages.attachEvent("onImageUploadSuccess", function(name, value, extra){
				GridMain.cells(GridMain.getSelectedRowId(),6).setValue(value);
				dp.setUpdated(GridMain.getSelectedRowId(),true);
				alert("Đã Updated");
				return true;
			});
	});

	function saveData(KeyWord) 
	{
		var Data = [];
		GridMain.forEachRow(function(id){
			var Index = GridMain.cells(id,0).getValue();
			var Layouts = GridMain.cells(id,1).getValue();
			var Runs_Length = GridMain.cells(id,2).getValue();
			var SheetsSplit = GridMain.cells(id,3).getValue();
			var SheetsCount = GridMain.cells(id,4).getValue();
			var Remain = GridMain.cells(id,5).getValue();
			var ImagesURL = GridMain.cells(id,6).getValue();
			var JobJacket = GridMain.cells(id,7).getValue();
			var PromiseDate = GridMain.cells(id,8).getValue();
			var Print_Structure = GridMain.cells(id,9).getValue();

			Data.push({
				IDCode : KeyWord,
				Index : Index,
				Layouts : Layouts,
				Runs_Length : Runs_Length,
				SheetsSplit : SheetsSplit,
				SheetsCount : SheetsCount,
				Remain : Remain,
				ImagesURL : ImagesURL,
				JobJacket : JobJacket,
				PromiseDate : PromiseDate,
				Print_Structure : Print_Structure
			});

		});

		console.log(JSON.stringify(Data));

		$.ajax({
			url: "./Data/saveData.php",
			type: "POST",
			data: {data: JSON.stringify(Data)},
			dataType: "json",
			beforeSend: function(x) { if (x && x.overrideMimeType) { x.overrideMimeType("application/j-son;charset=UTF-8"); } },
			success: function(result) {
				if(!result.status){
					alert(result.mess);
					return false;
				}
			}
		});

			
	}


	
	


</script>
</head>
	<body>
		<div style="height: 30px;background:#205670;font-weight:bold">
			<div id="menuObj"></div>
		</div>
		
		<div style="position:absolute;width:100%;top:35;background:white">
			<div id="ToolbarBottom" ></div> 
		</div>

	</body>
</html>