<?php @session_start(); ?>
<?php include 'connection/connect.php'; ?>
<?php if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
        <LINK REL="SHORTCUT ICON" HREF="images/logo.png">
        <!-- Bootstrap core CSS -->
        <link href="option/css/bootstrap.css" rel="stylesheet">
        <!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
        <!-- Add custom CSS here -->
        <link href="option/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
        <link rel="stylesheet" href="option/css/stylelist.css">
        <script src="option/js/excellentexport.js"></script>
        </head>
    <body>
 
<?php 
	if($_POST['method']=='add_event'){
                   $event_title=$_POST['massege'];	 	  	 
                   $event_start=$_POST['event_start_date'].' '.$_POST['event_start_time']; 
                   $date_end=date('Y-m-d', strtotime($_POST['event_end_date']."+1 days "));
                   $event_end=$date_end.' '.$_POST['event_end_time'];
                   $event_allDay=$_POST['range'];
                   $empno=$_SESSION[user];
                   $process=$_POST['type_event'];
                   
		$insert_event=mysql_query("insert into tbl_event set event_title='$event_title',event_start='$event_start',event_end='$event_end',event_url='',event_allDay='$event_allDay',
                        empno='$empno',workid='0',process='$process'"); 	
	
 							if($insert_event==false){
											 echo "<p>";
											 echo "Update not complete".mysql_error();
											 echo "<br />";
											 echo "<br />";

											 echo "	<span class='glyphicon glyphicon-remove'></span>";
											 echo "<a href='add_privatet_calendra.php' >กลับ</a>";
		
								}else{
								    echo	 "<p>&nbsp;</p>	";
								    echo	 "<p>&nbsp;</p>	";
									echo " <div class='bs-example'>
									              <div class='progress progress-striped active'>
									                <div class='progress-bar' style='width: 100%'></div>
									              </div>";
										echo "<div class='alert alert-info alert-dismissable'>
								              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
								               <a class='alert-link' target='_blank' href='#'><center>แก้ไขข้อมูลเรียบร้อย</center></a> 
								            </div>";								
							 		 	 echo" <META HTTP-EQUIV='Refresh' CONTENT='2;URL=fullcalendar/fullcalendar4.php'>";
								}
   
   }
 include 'footer.php'; ?>
	
	
 
