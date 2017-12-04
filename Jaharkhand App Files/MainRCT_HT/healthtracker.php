<?php 
if(!defined('HTTAG')) die('Access Denied');

include 'getuser.php';
$html= getTabData('0');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Smart Health</title>    
	<link rel="stylesheet" href="styles/style.css" type="text/css" />
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
		


	<script src="amcharts/amcharts.js" type="text/javascript"></script>
	<script src="amcharts/serial.js" type="text/javascript"></script>

	<link rel="stylesheet" href="scripts/datepicker.css">
	<link rel="stylesheet" href="scripts/bootstrap.min.css">
	<script src="scripts/jquery-1.9.1.min.js"></script>
	<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
	<script src="scripts/bootstrap-datepicker.js"></script>
	<style type="text/css">
		.btn{

			margin-left: 10px;
		}
		.form-control {
			width: auto!important;
			display: inline-block;
		}
		select.form-control{
			width: 120px!important;
		}
	</style>
	<script type="text/javascript">
		// When the document is ready
		$(document).ready(function () {
		$('#todate').attr( "disabled",'disabled' );
			$('#datepicker').datepicker({
				format: "yyyy-mm-dd",
				autoclose: true,
				startDate: "2014-12-21",
				endDate: "taday"
			}).on('changeDate', function(e){
				var date=$('#datepicker').val(); //alert(date)
				$('#todate').removeAttr( "disabled" );
				$('#todate').datepicker({
					format: "yyyy-mm-dd",
					autoclose: true,
					startDate: date,
					endDate: "taday"
				});
			});



		});

	</script>
	<script type="text/javascript">

			$(function () {
				$('#submitfilter').click(function(){
					$('#tablet').val('');
					$('#villagedropdown').val('');
					var from=$('#datepicker').val();
					var to=$('#t0odate').val();
					if(to!=''&&from!='') {


						$.ajax({
							type: "GET",
							url: "getuserondate.php",
							data: "f=" + from + "&t=" + to,
							beforeSend: function () {
								$body.addClass("loading");
							},
							success: function (prm) {
								//alert(prm);
								document.getElementById("chartdiv").innerHTML = "";
								if (prm != 'false') {
									loadChart(prm);
								}
								else {
									$('#totalcount').html('0');
									document.getElementById("chartdiv").innerHTML = "NO data to display";
									document.getElementById("chartdiv").style.textAlign = "center";
									$('#radiodiv').hide();
								}
							},
							complete: function () {
								$body.removeClass("loading");
							}
						});
					}else{
						alert('Please Select Encounter Start Date and End Date')
					}
				});
		})
	</script>
	<script type="text/javascript">
		function changeTablet()	
		{
			$('#datepicker').val('');
			$('#todate').val('');
			$('#villagedropdown').val('');
			var str=document.getElementById("tablet").value;
			/*if (str=="")
			{
				document.getElementById("txtChart").innerHTML="";				
				return;
			}	*/		
			
			$body = $("body");
			
			$.ajax({
				type: "GET",
				url: "getuser.php",
				data: "q="+str,
				beforeSend: function(){
					$body.addClass("loading");					
				},
				success: function(prm){					
					document.getElementById("chartdiv").innerHTML="";					
					if(prm!='false')
					{
						loadChart(prm);						
					}
					else
					{ $('#totalcount').html('0');
						document.getElementById("chartdiv").innerHTML="NO data to display";
						document.getElementById("chartdiv").style.textAlign="center";
						$('#radiodiv').hide();
					}
				},
				complete: function(){
					$body.removeClass("loading");					
				}    


			});
		}
		
		function changeVillage()	
		{
			$('#datepicker').val('');
			$('#todate').val('');
			$('#tablet').val('');
			var terminal = document.getElementById("villagedropdown");
			var str = terminal.options[terminal.selectedIndex].text;			
			
			/*if (str=="")
			{							
				location.reload();
			}	*/		
			
			$body = $("body");
			
			$.ajax({
				type: "GET",
				url: "getvillagestats.php",
				data: "village="+str,
				beforeSend: function(){
					$body.addClass("loading");					
				},
				success: function(prm){	
                           // alert(prm)
					document.getElementById("chartdiv").innerHTML="";					
					if(prm!='false')
					{
						loadChart(prm);						
					}
					else
					{        $('#totalcount').html('0');
						document.getElementById("chartdiv").innerHTML="NO data to display";
						document.getElementById("chartdiv").style.textAlign="center";
						$('#radiodiv').hide();
					}
				},
				complete: function(){
					$body.removeClass("loading");					
				}           
			});
		}
		
		function selectVillage()
		{
			var vid = document.getElementById("villagedd").value;			
			var uid = document.getElementById("ashadd").value;
			
			if(vid != '')
				$('#btnFilter').prop("disabled", false);
			else
			{
				if(uid == '')
					$('#btnFilter').prop("disabled", true);
			}
			
			var x=document.getElementById("localitydd");			
			x.options.length = 0;
			
			var opt=document.createElement("option");						
			opt.text='Select';
			opt.id='0';
			
			try
			{
			  // for IE earlier than version 8
			  x.add(opt,x.options[null]);
			}
			catch (e)
			{
			  x.add(opt,null);
			}
			
			if(vid != '')
			{				
				$body = $("body");
			
				$.ajax({
					type: "GET",
					url: "getlocalities.php",
					data: "id="+vid,
					beforeSend: function(){
						$body.addClass("loading");					
					},
					success: function(prm){					
						var res = prm.split("#");					
						for (var i=0;i<res.length;i++)
						{ 	
							var option=document.createElement("option");						
							option.text=res[i].split(',')[1];
							option.id=res[i].split(',')[0];
							try
							{
							  // for IE earlier than version 8
							  x.add(option,x.options[null]);
							}
							catch (e)
							{
							  x.add(option,null);
							}
						}
					},
					complete: function(){
						$body.removeClass("loading");					
					}           
				});
			}
		}
		
		function enableBtnFilter()
		{
			var vid = $('#villagedd').val();
			var lid = $('#localitydd').val();
			var aid = $('#ashadd').val();
			var eid = $('#encounterdd').val();
			var date = $('#ptodate').val();
			if(vid != '' || lid != '' || aid != '' ||  eid != '' || date!='')
				$('#btnFilter').prop("disabled", false);
			else				
				$('#btnFilter').prop("disabled", true);			
		}
                
                function refreshdata(){
                     $body = $("body");
			$.ajax({
				type: "GET",
				url: "refresh.php",
				beforeSend: function(){
					$body.addClass("loading");					
				},
				success: function(prm){
                                      //alert(prm);
				},
                                error: function(prm){
                                     
                                },
				complete: function(){
                                    $body.removeClass("loading");					
				}           
			});
                }
                function setLocalities(){
                    var vill_name = $('#villagedd option:selected').text();
                    var selectedLocality = $('#localitydd option:selected').text();
                    var selectedASHA = $('#ashadd option:selected').text();
                    $body = $("body");
			$.ajax({
				type: "GET",
				url: "loadLocalities.php?villname="+vill_name+"&selectedloc="+selectedLocality+"&selectedasha="+selectedASHA,
				beforeSend: function(){
					$body.addClass("loading");					
				},
				success: function(prm){
                                       var localityasharesult = prm.split("#");
                                       document.getElementById("localitydd").innerHTML=localityasharesult[0];	
                                       document.getElementById("ashadd").innerHTML=localityasharesult[1];	
				},
                                error: function(prm){
                                     alert(prm);
                                },
				complete: function(){
                                    $body.removeClass("loading");					
				}           
			});
                  
                }
		
		function searchListing(str,sort,order,p,locality_name,village_name,hh_head_fname)
		{	
			document.getElementById("errorMessage").style.display="none";
			
			if(str=='List')
			{
				locality_name=$('#localitydd option:selected').text();
				village_name=$('#villagedd option:selected').text();
				
				changeTab('List',sort,order,p,locality_name,village_name,hh_head_fname);
				return false;
			}
			if(str=='Clear')
			{
				changeTab(str,sort,'ASC',1,locality_name,village_name,hh_head_fname);
				return false;
			}
		}

		function changeTab(str,sort,order,p,locality_name,village_name,hh_head_fname)
		{
			document.getElementById("errorMessage").style.display="none";
			if (str=="")
			{
				document.getElementById("divListingContent").innerHTML="";				
				return;
			}			
			
			if(str=='Tab')
			{
				//xmlhttp.open("GET","gettab.php",true);
			}
			else if(str=='List')
			{				
				if($('#localitydd option:selected').text() !='Select')
				{
					var locality_name_val = $('#localitydd option:selected').text();					
				}
				else
				{
					var locality_name_val = '';					
				}
				
				if($('#villagedd option:selected').text() !='Select')
				{
					var village_name_val = $('#villagedd option:selected').text();
				}
				else
				{
					var village_name_val = '';
				}
				
				if($('#ashadd option:selected').text() !='Select')
				{
					var asha_name_val = $('#ashadd option:selected').text();
				}
				else
				{
					var asha_name_val = '';
				}

				if($('#encounterdd option:selected').text() !='Select')
				{
					var encounter_name_val = $('#encounterdd option:selected').text();
					var encounter_date_val = $('#encounterdd option:selected').val();
				}
				else
				{
					var encounter_name_val = '';
					var encounter_date_val ='';
				}
				if($('#pfromdate').val() !=''&& $('#ptodate').val() !='')
				{
					var pfdate = $('#pfromdate').val();
					var ptdate = $('#ptodate').val();
				}
				else
				{
					var pfdate = '';
					var ptdate = '';
				}
												
				var querystring = "sort="+sort+"&order="+order+"&p="+p+"&village_name="+village_name_val+"&locality_name="+locality_name_val+"&encounter_name="+encounter_name_val+"&asha_name="+asha_name_val+"&asha_fdate="+pfdate+"&asha_tdate="+ptdate+"&en_date="+encounter_date_val;
			}
			else if(str=='Clear')
			{	
				var locality_name_val = '';					
				var village_name_val = '';								
				var encounter_name_val = '';
				var asha_name_val = '';
				
				var querystring = "sort="+sort+"&order="+order+"&p="+p+"&village_name="+village_name_val+"&locality_name="+locality_name_val+"&encounter_name="+encounter_name_val+"&asha_name="+asha_name_val;				
			}
                        //alert(querystring);
			$body = $("body");
			$.ajax({
				type: "GET",
				url: "getlist.php",
				data: querystring,
				beforeSend: function(){
					$body.addClass("loading");					
				},
				success: function(prm){
                                        if(str != 'Clear'){
                                             setLocalities();
                                        }
                                       document.getElementById("divListingContent").innerHTML=prm;					
					if(str=='List' || str=='Clear')
					{
						document.getElementById("idlist").style.zindex="100";
						document.getElementById("idlist").style.background="#F7F7F7";
						document.getElementById("idlist").style.borderBottom="1px solid #F7F7F7";				
						document.getElementById("idlist").style.color="#000";
						
						document.getElementById("idtab").style.zindex="0";
						document.getElementById("idtab").style.background="#4C4D4F";				
						document.getElementById("idtab").style.borderBottom="1px solid #D6D6D6";
						document.getElementById("idtab").style.color="#FFF";
					}
					if(str=='Tab')
					{
						document.getElementById("idtab").style.zindex="100";
						document.getElementById("idtab").style.borderBottom="1px solid #FFF";
						document.getElementById("idlist").style.zindex="0";
						document.getElementById("idlist").style.borderBottom="1px solid #D6D6D6";
					}
                                        
				},
				complete: function(){
					$body.removeClass("loading");

						$('#ptodate').attr("disabled", 'disabled');

					$('#pfromdate').datepicker({
						format: "yyyy-mm-dd",
						autoclose: true,
						startDate: "2014-12-21",
						endDate: "taday"
					}).on('changeDate', function(e){
						var date=$('#pfromdate').val(); //alert(date)
						$('#ptodate').removeAttr( "disabled" );

						$('#ptodate').datepicker({
							format: "yyyy-mm-dd",
							autoclose: true,
							startDate: date,
							endDate: "taday"
						}).on('changeDate',function(e){
							enableBtnFilter()
						});
					});
				}           
			});
		}
		
		function loadListingData()
		{			
			$body = $("body");
			
			$.ajax({
				type: "GET",
				url: "getlist.php",
				data: "sort=''&order=''&p=''",
				beforeSend: function(){
					$body.addClass("loading");					
				},
				success: function(prm){					
					document.getElementById("divListingContent").innerHTML=prm;
				},
				complete: function(){
					$body.removeClass("loading");
					$('#ptodate').attr("disabled", 'disabled');
					$('#pfromdate').datepicker({
						format: "yyyy-mm-dd",
						autoclose: true,
						startDate: "2014-12-21",
						endDate: "taday"
					}).on('changeDate', function(e){
						var date=$('#pfromdate').val(); //alert(date)
						$('#ptodate').val('');
						$('#ptodate').removeAttr( "disabled" );
						$('#ptodate').datepicker({
							format: "yyyy-mm-dd",
							autoclose: true,
							startDate: date,
							endDate: "taday"
						}).on('changeDate',function(e){
							enableBtnFilter()
						});
					});
				}           
			});
		}
		
		//Draw Graphs using JQuery Plugins
		$(document).ready(function(){
				<?php 
					if($html!='false')
					{
				?>
				loadChart('<?php echo $html; ?>');
				<?php
					}
					else
					{
				?>
                                         $('#totalcount').html('0');
				document.getElementById("chartdiv").innerHTML="NO data to display";
                                $('#totalcount').html('0');
				<?php
				}
				?>
				loadListingData();
				getASHASData();
				getDoctordata();

				$(".closebtn").click(function () {
					var varParentId=$(this).attr("data-parent-id");
					$('#'+varParentId).hide("slow");			
				} );			
			});
							
		function togglePopup(isvisible,exporttype) {
				document.getElementById("hdnexporttype").value = exporttype;
				
				if(isvisible) {
					$('#exportmodal').show("slow");
					$('#pwderrormsg').hide();
					$('#exportpwd').val('');
				}
				else
					$('#exportmodal').hide("slow");
				return false;
		}						
		
		var chart;
		var chartData = [];
		var chartCursor;				
		
		function loadChart(str)
		{	

			

			$('#radiodiv').show();
			chartData = [];
			// CURSOR
			chartCursor = new AmCharts.ChartCursor();
			chartCursor.cursorPosition = "mouse";
			chartCursor.pan = true; // set it to false if you want the cursor to work in "select" mode			
			
			var res = str.split("#");


			var totlacounts=0;

			
			var test;

			for (var i=0;i<res.length;i++)
			{

				

				chartData.push({
					date: new Date(res[i].split(',')[0]),
					visits: parseInt(res[i].split(',')[1]),
                                        
				});
                                totlacounts=totlacounts+parseInt(res[i].split(',')[1]);
			}
                        $('#totalcount').html(totlacounts);



                       


			chart = AmCharts.makeChart("chartdiv", {
				"type": "serial",
				"theme": "none",
				"pathToImages": "amcharts/images/",
				"dataProvider": chartData,
				"valueAxes": [{
					"axisAlpha": 0.2,
					"dashLength": 1,
					"position": "left"
				}],
				"graphs": [{
					"id":"g1",					
					"bullet": "round",
					"bulletBorderAlpha": 1,
					"bulletColor":"#FFFFFF",
					"bulletSize": 5,
					"hideBulletsCount": 50,
					"lineThickness": 2,
					"title": "red line",
					"valueField": "visits",
					"useLineColorForBulletBorder":true
				}],
				"chartScrollbar": {
					"autoGridCount": false,
					"graph": "g1",
					"scrollbarHeight": 30
				},
				"chartCursor": {
					"cursorPosition": "mouse",
					"pan": true
				},
				"categoryField": "date",
				"categoryAxis": {
					"parseDates": true,
					"axisColor": "#DADADA",
					"dashLength": 1,
					"minorGridEnabled": true,
					"position": "top"
				},				
			});		

			chart.addListener("rendered", zoomChart);
			$( "#rb1" ).prop( "checked", false );
			$( "#rb2" ).prop( "checked", true );
		}			
		
		function toggleTab(str)
		{
			if(str=='Tab')
			{
				document.getElementById("divTabletContent").style.display='block';
				document.getElementById("divListingContent").style.display='none';				
				document.getElementById("divAshaContent").style.display='none';
				document.getElementById("divdoctContent").style.display='none';
				
				document.getElementById("idtab").style.zindex="100";
				document.getElementById("idtab").style.background="#F7F7F7";
				document.getElementById("idtab").style.borderBottom="1px solid #F7F7F7";
				document.getElementById("idtab").style.color="#000";
				
				document.getElementById("idlist").style.zindex="0";
				document.getElementById("idlist").style.background="#4C4D4F";
				document.getElementById("idlist").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("idlist").style.color="#FFF";
				
				document.getElementById("idasha").style.zindex="0";
				document.getElementById("idasha").style.background="#4C4D4F";
				document.getElementById("idasha").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("idasha").style.color="#FFF";

				document.getElementById("iddoctors").style.zindex="0";
				document.getElementById("iddoctors").style.background="#4C4D4F";
				document.getElementById("iddoctors").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("iddoctors").style.color="#FFF";
			}
			
			if(str=='List')
			{
				document.getElementById("divTabletContent").style.display='none';
				document.getElementById("divListingContent").style.display='block';				
				document.getElementById("divAshaContent").style.display='none';
				document.getElementById("divdoctContent").style.display='none';
				
				document.getElementById("idtab").style.zindex="0";
				document.getElementById("idtab").style.background="#4C4D4F";				
				document.getElementById("idtab").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("idtab").style.color="#FFF";
				
				document.getElementById("idlist").style.zindex="100";
				document.getElementById("idlist").style.background="#F7F7F7";
				document.getElementById("idlist").style.borderBottom="1px solid #F7F7F7";				
				document.getElementById("idlist").style.color="#000";							
				
				document.getElementById("idasha").style.zindex="0";
				document.getElementById("idasha").style.background="#4C4D4F";
				document.getElementById("idasha").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("idasha").style.color="#FFF";

				document.getElementById("iddoctors").style.zindex="0";
				document.getElementById("iddoctors").style.background="#4C4D4F";
				document.getElementById("iddoctors").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("iddoctors").style.color="#FFF";
			}			
			
			if(str=='Asha')
			{
				document.getElementById("divListingContent").style.display='none';
				document.getElementById("divTabletContent").style.display='none';
				document.getElementById("divAshaContent").style.display='block';
				document.getElementById("divdoctContent").style.display='none';
				
				document.getElementById("idtab").style.zindex="0";
				document.getElementById("idtab").style.background="#4C4D4F";
				document.getElementById("idtab").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("idtab").style.color="#FFF";
				
				document.getElementById("idlist").style.zindex="0";
				document.getElementById("idlist").style.background="#4C4D4F";
				document.getElementById("idlist").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("idlist").style.color="#FFF";

				document.getElementById("iddoctors").style.zindex="0";
				document.getElementById("iddoctors").style.background="#4C4D4F";
				document.getElementById("iddoctors").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("iddoctors").style.color="#FFF";
				
				document.getElementById("idasha").style.zindex="100";
				document.getElementById("idasha").style.background="#F7F7F7";
				document.getElementById("idasha").style.borderBottom="1px solid #F7F7F7";
				document.getElementById("idasha").style.color="#000";
			}
			if(str=='Doctors')
			{
				document.getElementById("divListingContent").style.display='none';
				document.getElementById("divTabletContent").style.display='none';
				document.getElementById("divAshaContent").style.display='none';
				document.getElementById("divdoctContent").style.display='block';

				document.getElementById("idtab").style.zindex="0";
				document.getElementById("idtab").style.background="#4C4D4F";
				document.getElementById("idtab").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("idtab").style.color="#FFF";

				document.getElementById("idlist").style.zindex="0";
				document.getElementById("idlist").style.background="#4C4D4F";
				document.getElementById("idlist").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("idlist").style.color="#FFF";

				document.getElementById("idasha").style.zindex="100";
				document.getElementById("idasha").style.background="#4C4D4F";
				document.getElementById("idasha").style.borderBottom="1px solid #D6D6D6";
				document.getElementById("idasha").style.color="#FFF";

				document.getElementById("iddoctors").style.zindex="100";
				document.getElementById("iddoctors").style.background="#F7F7F7";
				document.getElementById("iddoctors").style.borderBottom="1px solid #F7F7F7";
				document.getElementById("iddoctors").style.color="#000";
			}
		}
		
		function getASHASData()
		{					
			$body = $("body");
			
			$.ajax({
				type: "GET",
				url: "getashasdata.php",
				data: "id=",
				beforeSend: function(){
					//$body.addClass("loading");					
				},
				success: function(prm){																			
					document.getElementById("Ashadiv").innerHTML=prm;					
				},
				complete: function(){
					//$body.removeClass("loading");					
				}           
			});						
		}

		function getDoctordata()
		{
			$body = $("body");

			$.ajax({
				type: "GET",
				url: "getdoctordetails.php",
				data: "id=",
				beforeSend: function(){
					$body.addClass("loading");
				},
				success: function(prm){
					document.getElementById("divdoctContent").innerHTML=prm;
				},
				complete: function(){
					$body.removeClass("loading");
					$('#doctto').hide();
					$('#doctfrom').hide();
					$('#exportDoctor').hide();
					$('#dccfilter').hide();
					$('#doctfrom').attr("disabled", 'disabled');
					$('#doctto').attr("disabled", 'disabled');
					$('#doctfrom').datepicker({
						format: "yyyy-mm-dd",
						autoclose: true,
						startDate: "2014-12-21",
						endDate: "taday"
					}).on('changeDate', function(e){
						var date=$('#doctfrom').val(); //alert(date)
						$('#doctto').val('');
						$('#doctto').removeAttr( "disabled" );
						$('#doctto').datepicker({
							format: "yyyy-mm-dd",
							autoclose: true,
							startDate: date,
							endDate: "taday"
						})
					});
				}
			});
		}
		
		function onRowSelection(hhid)
		{	
			document.getElementById("divattributes").innerHTML="";
			var prevSelectedId = document.getElementById("hdnrowid").value;
			var prevSelectedClass= $("#hdnrowclass").val();
						
			if(prevSelectedId != hhid)
			{							
				document.getElementById("hdnrowid").value = hhid;
				document.getElementById("hdnrowclass").value = $('#'+hhid).attr("class");
			}
			
			$('#'+hhid).removeClass($('#'+hhid).attr("class")).addClass("selectedRow");
			
			if(prevSelectedId!='' && prevSelectedId != hhid)
			{
				$('#'+prevSelectedId).addClass("tr_class_0");
				$('#'+prevSelectedId).removeClass("selectedRow").addClass(prevSelectedClass);
			}
									
			$body = $("body");
			
			$.ajax({
				type: "GET",
				url: "getpatientinfo.php",
				data: "id="+hhid,
				beforeSend: function(){
					$body.addClass("loading");					
				},
				success: function(prm){					
					document.getElementById("divattributes").innerHTML=prm;
					var dialog;
					dialog = $( "#dialog-form" ).dialog({
						autoOpen: false,
						height: 600,
						width: 600,
						modal: true
					});
					dialog.dialog( "open" );

				},
				complete: function(){
					$body.removeClass("loading");					
				}           
			});
		}		
		
		function validatePassword() {
		
			var pwd=$('#exportpwd').val();
			var exporttype = $("#hdnexporttype").val();
			
			if($('#localitydd option:selected').text() !='Select')
			{
				var locality_name_val = $('#localitydd option:selected').text();					
			}
			else
			{
				var locality_name_val = '';					
			}
			
			if($('#villagedd option:selected').text() !='Select')
			{
				var village_name_val = $('#villagedd option:selected').text();
			}
			else
			{
				var village_name_val = '';
			}
			
			if($('#ashadd option:selected').text() !='Select')
			{
				var asha_name_val = $('#ashadd option:selected').text();
			}
			else
			{
				var asha_name_val = '';
			}
			
			if($('#encounterdd option:selected').text() !='Select')
			{
				var encounter_name_val = $('#encounterdd option:selected').text();
			}
			else
			{
				var encounter_name_val = '';
			}
			if($('#pfromdate').val() !=''&& $('#ptodate').val() !=''){
					var pfdate = $('#pfromdate').val();
					var ptdate = $('#ptodate').val();
			}else{
                                var pfdate = '';
				var ptdate = '';
			}
                        var querystring = "pfdate="+pfdate+"&ptdate="+ptdate+"&village_name="+village_name_val+"&locality_name="+locality_name_val+"&asha_name="+asha_name_val+"&encounter_name="+encounter_name_val+"&exporttype="+exporttype;
			//alert(querystring);
                        $body = $("body");
			if(pwd !='') {
			
				$.ajax({
						type: "GET",
						url: "validateuser.php",
						data: "pwd="+pwd,
						beforeSend: function(){
							//$body.addClass("loading");					
						},
						success: function(prm){							
							if(prm == "true"){								
								window.location.href = "exporttocsv.php?"+querystring;								
								$('#exportmodal').hide("slow");								
								$body.addClass("loading");
							}
							else {
								$('#pwderrormsg').text("Invalid password");
								$('#pwderrormsg').show();							
							}
						},
						complete: function(){
							//$body.removeClass("loading");
						}           
					});
				
			}
			else {
				$('#pwderrormsg').text("Password required");
				$('#pwderrormsg').show();
			}
			setTimeout( "jQuery('body').removeClass('loading');",5000 );
			return false;
		}		
		
		// this method is called when chart is first inited as we listen for "dataUpdated" event
		function zoomChart() {
			// different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
			chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
		}

		// changes cursor mode from pan to select
		function setPanSelect() {
			if (document.getElementById("rb1").checked) {
				chartCursor.pan = false;
				chartCursor.zoomable = true;
			} else {
				chartCursor.pan = true;
			}
			chart.addChartCursor(chartCursor);
			chart.validateNow();			
		}
		function dcchange(id){
			//alert(id)
			if(id!='filter'){
				$('#doctfrom').val('');
				$('#doctto').val('');
			}
			$body = $("body");
			$('#doctfrom').removeAttr( "disabled" );
			var from=$('#doctfrom').val();
			var to=$('#doctto').val();
			var id=$('#phcname').val();
			$('#doctto').show();
			$('#doctfrom').show();

			$.ajax({
				type: "GET",
				url: "getdoctordetails.php?from="+from+"&todate="+to,
				data: "id="+id,
				beforeSend: function(){
					$body.addClass("loading");
				},
				success: function(prm){
					document.getElementById("divdoctContent").innerHTML=prm;
				},
				complete: function(){
					if(id==''){
						$('#doctto').hide();
						$('#doctfrom').hide();
						$('#exportDoctor').hide();
						$('#dccfilter').hide();
					}
					$body.removeClass("loading");
					$('#doctto').attr("disabled", 'disabled');
					$('#doctfrom').datepicker({
						format: "yyyy-mm-dd",
						autoclose: true,
						startDate: "2014-12-21",
						endDate: "today"
					}).on('changeDate', function(e){
						var date=$('#doctfrom').val(); //alert(date)
						$('#doctto').val('');
						$('#doctto').removeAttr( "disabled" );
						$('#doctto').datepicker({
							format: "yyyy-mm-dd",
							autoclose: true,
							startDate: date,
							endDate: "today"
						})
					});
				}
			});
		}
		function exportDoctors(){
			var phc=$('#phcname').val();
			var from=$('#doctfrom').val();
			var to=$('#doctto').val();
			window.location.href = "exportphcdetails.php?id="+phc+"&from="+from+"&todate="+to;if(from)
			{
				window.location.href = "exportphcdetails.php?id="+phc+"&from="+from+"&todate="+to;
				//	window.location.href = "exportphcdetails.php?id="+phc;
			}else{
				window.location.href = "exportphcdetails.php?id="+phc;
			//alert("exportphcdetails.php?id='"+phc+"'&from='"+from+"'&todate='"+to+"'");return false;
			//window.location.href = "exportphcdetails.php?id="+phc+"&from="+from+"&todate="+to;
			}
			/*$.ajax({
				type: "GET",
				url: "exportphcdetails.php",
				data: "id="+phc
				*//*beforeSend: function(){
					//$body.addClass("loading");
				},
				success: function(prm){
					document.getElementById("divdoctContent").innerHTML=prm;
				},
				complete: function(){
					//$body.removeClass("loading");
				}*//*
			});*/
		}
	</script>

</head>
<body>
	<form>
		<div id="container">
			<div id="header">				
				<div class="logo">
					<img src="images/login_logo.png"/>
				</div>				
				<div class="clear">
				</div>
			</div>
			<div style="width:90%;margin:auto;">
				<div style="float:left;width:auto; padding:5px 0 5px 0; font-size:13px; font-weight:bold;">
					Hello <?php echo $_SESSION['_staff']['FName']?>
				</div>
                               
                               <div style="float:right;width:auto; padding:5px 10px; background:#F7F7F7;text-align:center" a>
                                   <input type="hidden" class="signout" value="Refresh" onclick="refreshdata();" style="margin-right:10px;" ></input> <a class="signout" href="logout.php">Sign Out</a>
                                </div>
			</div>
			<div style="width:90.2%;margin:auto;">			
				<ul id="nav">				
					<li><a id="idtab" class="tablet" style="z-index:100; background: #F7F7F7; color:#000; border-bottom:1px solid #F7F7F7;" onclick="toggleTab('Tab');">Analytics</a></li>
					<li><a id="idlist" class="listing" onclick="toggleTab('List');">Patients</a></li>
					<li><a id="idasha" class="asha" onclick="toggleTab('Asha');">ASHAS</a></li>
					<li><a id="iddoctors" class="doctors" onclick="toggleTab('Doctors');">Reports</a></li>
				</ul>		
			</div>
			<div id="content">
				<div id="divTabletContent" style="width:100%;">
					<div style="width:auto; padding:10px;">
						<p></p>
						<b>Choose ASHA&nbsp;:&nbsp;</b> 
						<?php
						$result = db_query("Select Distinct(asha_assigned) from cvd_basetable where asha_assigned<>'null' order by asha_assigned ASC;");
            					?>
						<select id="tablet" class="dropdown form-control" onchange="changeTablet();">
							<option value='' selected>Select</option>
							<?php
							if($result && db_num_rows($result))	{
								while (list($user) = db_fetch_row($result)) {									
							?>
									<option value="<?php echo $user;?>"><?php echo $user;?></option>
							<?php
								}
							}
							?>
						</select>
						<b>&nbsp;&nbsp;&nbsp;&nbsp;Choose Village&nbsp;:&nbsp;</b>
						<?php
						$villages_result = db_query('Select Distinct(value) from person_attribute PA
						Join person_attribute_type PAT ON PA.person_attribute_type_id = PAT.person_attribute_type_id
						where PAT.name = \'Village\'  order by value');
						?>
						<select id="villagedropdown" class="dropdown form-control" onchange="changeVillage();">
							<option value='' selected>Select</option>
							<?php
							if($villages_result && db_num_rows($villages_result))	{
								$id = 1;
								while (list($vil) = db_fetch_row($villages_result)) {
									?>
									<option value="<?php echo $id;?>"><?php echo $vil;?></option>
							<?php
								$id = $id + 1;
								}
							} 
							?>
						</select>
                       <input type='text' class="form-control" data-provide="datepicker" id="datepicker" placeholder="Encounter start date" class='datepicker' name='from' >
                      <input type='text' class="form-control" id="todate" class="todate" placeholder="Encounter end date" name='to' disabled="" >
						<input type="button" value="Filter" class="btn btn-default" id="submitfilter">
                                                
                                                
                                                <b>&nbsp;&nbsp;&nbsp;&nbsp;Total Visits: &nbsp;&nbsp;</b><span id="totalcount" ></span>
                                                
                                                
					</div>					
					<div id="chartdiv" style="width: 100%; height: 400px;text-align:center;"></div>
					<div id="radiodiv" style="margin-left:35px; display:none;">
						<input type="radio" name="group" id="rb1" onclick="setPanSelect()">Select
						<input type="radio" checked="true" name="group" id="rb2" onclick="setPanSelect()">Pan
					</div>
				</div>
				<div id="divListingContent" style="width:100%; padding:20px 0px 20px 0px; display:none;">
					
				</div>
				<div id="divAshaContent" style="width:100%; padding:20px 0px 20px 0px; display:none;">
					<div id="Ashadiv" style="width:94%; margin:auto;min-height: 400px;"></div>
				</div>
				<div id="divdoctContent" style="width:100%; padding:20px 0px 20px 0px; display:none;">

				</div>
				<input type="hidden" id="hdnrowid" name="rowid">
				<input type="hidden" id="hdnrowclass" name="rowclass">
				<input type="hidden" id="hdnexporttype" name="csvexporttype">
			 </div>
			<div class="clear">
			</div> 			
		</div>	
		<div id="footer">
			Copyright &copy; <?php echo date('Y');?> The George Institute
		</div>
	</form>	
	<div class="modal1"></div>
	<div id="exportmodal" class="modalPage">
		<div class="modalBackground">
		</div>
		<div class="modalContainer">
			<div class="exportmodal">            
				<div class="modalBody">
					<span>Please enter password to download</span>
					<input type="password" name="pwd" id="exportpwd" class="pwdtextarea"/>
					<div style="height:45px;">
						<span id="pwderrormsg" class="password_errormsg">Invalid password</span>
					</div>
					<div class="buttonarea">					
						<input id="btnsubmit" type="Button" value="Submit" onClick="return validatePassword();$('body').removeClass('loading')"/>   
						<input data-parent-id="exportmodal" class="closebtn" type="Button" value="Close"/>   
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="dialog-form" title="Attributes">
		<div id="divattributes"></div>
	</div>
</body>
</html>