<?php @session_start(); ?>
<?php include 'connection/connect.php'; ?>
<?php if($_REQUEST['method']!='back'){
if (empty($_SESSION[user])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}}
?>
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
if ($_REQUEST['del_id'] != "") { //ถ้า ค่า del_id ไม่เท่ากับค่าว่างเปล่า
    $del_id = $_REQUEST['del_id'];
    $project_id=$_REQUEST[id];
    $sql_del = "delete from plan_out where empno = '$del_id' and idpo='$project_id'";
    $event_del = "delete from tbl_event where empno='$del_id' and workid='$project_id' and process='1'"; 
    mysql_query($sql_del) or die(mysql_error());
    mysql_query($event_del) or die(mysql_error());
//echo "ลบข้อมูล ID $del_id เรียบร้อยแล้ว";
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดโครงการ </font></h1> 
        <?php if($_SESSION[Status]=='ADMIN' and $_REQUEST['method']!='back'){?>
        <ol class="breadcrumb alert-success">
            <li><a href="index.php"><i class="fa fa-home"></i> หน้าหลัก</a></li>
            <li><a href="pre_trainout.php"><i class="fa fa-home"></i> บันทึกการฝึกอบรมภายนอกหน่วยงาน</a></li>
            <li class="active"><i class="fa fa-edit"></i> รายละเอียดโครงการ</li>
        </ol>
        <?php }?>
    </div>
</div>
<?php
include_once ('option/funcDateThai.php');
$project_id = $_REQUEST[id];
$sql_pro = mysql_query("SELECT t.*, CONCAT(e.firstname,' ',e.lastname) as fullname,p.PROVINCE_NAME 
FROM training_out t
INNER JOIN emppersonal e ON t.nameAdmin=e.empno
inner join province p on t.provenID=p.PROVINCE_ID
 WHERE tuid='$project_id'");
$Project_detial = mysql_fetch_assoc($sql_pro);
?>
<div class="row">
    <div class="col-lg-12" align="center">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางบันทึกการฝึกอบรมภายในหน่วยงาน</h3>
            </div>
            <div class="panel-body">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><b>เลขที่โครงการ : &nbsp; </b><?= $Project_detial[memberbook] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ชื่อโครงการ : &nbsp; </b><?= $Project_detial[projectName] ?></td>
                                </tr>
                                <tr>
                                    <td><b>หน่วยงานที่จัดโครงการ : &nbsp; </b><?= $Project_detial[anProject] ?></td>
                                </tr>
                                <tr>
                                    <td><b>เข้าร่วมตั้งแตวันที่ : &nbsp; </b><?= DateThai1($Project_detial[Beginedate]) ?>&nbsp; <b> ถึง &nbsp;</b><?= DateThai1($Project_detial[endDate]) ?>
                                        <b> &nbsp; จำนวน : &nbsp; </b><?= $Project_detial[amount] ?><b>&nbsp; วัน</b><br>
                                        <b>เดินทางวันที่ : &nbsp; </b><?= DateThai1($Project_detial[stdate]) ?>&nbsp; <b> ถึง &nbsp;</b><?= DateThai1($Project_detial[etdate]) ?>
                                        <b> &nbsp; ณ. &nbsp; </b><?= $Project_detial[stantee] ?><b> &nbsp; จ. </b> &nbsp; <?= $Project_detial[PROVINCE_NAME] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ค่าที่พัก : &nbsp; </b><?= $Project_detial[m1] ?><b>&nbsp;บาท&nbsp; </b><b>ค่าลงทะเบียน : &nbsp; </b><?= $Project_detial[m2] ?><b>&nbsp;บาท&nbsp; </b>
                                    <b>ค่าเบี้ยเลี้ยง : &nbsp; </b><?= $Project_detial[m3] ?><b>&nbsp;บาท&nbsp; </b><b>ค่าพาหนะเดินทาง : &nbsp; </b><?= $Project_detial[m4] ?><b>&nbsp;บาท&nbsp; </b>
                                    <b>ค่าใช้จ่ายอื่นๆ : &nbsp; </b><?= $Project_detial[m5] ?><b>&nbsp;บาท&nbsp; </b></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <?php
                            if(empty($_GET['empno'])){
                                $sql_pro_name = mysql_query("SELECT *, CONCAT(e.firstname,' ',e.lastname) as fullname 
                                    FROM plan_out p
INNER JOIN emppersonal e ON p.empno=e.empno
 WHERE p.idpo='$project_id'");
                            ?>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                 
                                <tr>
                                    <td colspan="4" align="center"><b>ผู้เข้าร่วมโครงการ</b></td>
                                </tr>
                                 <tr><th>ลำดับ</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>วันที่เข้าร่วม</th>
                                    <th>จำนวนวัน</th>
                                    <th>สถานะ</th>
                                    <?php if($_SESSION[Status]=='ADMIN' and $_REQUEST['method']!='back'){?>
                                    <th>แก้ไข</th>
                                    <th>ลบ</th>
                                    <?php }?>
                                </tr>
                                <?php
                    $i = 1;
                    while ($Project_Name = mysql_fetch_assoc($sql_pro_name)) {
                        ?>
                                <tr><td align="center"><?=$i?></td>
                                    <td><!--<a href="detial_trainout.php?id=<?=$Project_Name[empno];?>&&pro_id=<?=$Project_detial[tuid];?>">--><?=$Project_Name[fullname]?></a></td>
                                    <td align="center"><?=DateThai1($Project_Name[begin_date])?> ถึง <?=DateThai1($Project_Name[end_date])?></td>
                                    <td align="center"><?=$Project_Name[amount]?></td>
                                    <td align="center">
                                    <?php if($Project_Name['status_out']=='N'){ ?>
                                        <a href="" title="ยังไม่ได้สรุป"><i class="fa fa-spinner fa-spin"></i></a>
                                    <?php } elseif ($Project_Name['status_out']=='Y') {?>
                                    <img src="images/Symbol_-_Check.ico" width="20"  title="สรุปแล้ว">
                                    <?php }?></td>
                                    <?php if($_SESSION[Status]=='ADMIN' and $_REQUEST['method']!='back'){?>
                                    <td align="center"><a href="pre_project_out.php?method=edit&&empno=<?=$Project_Name[empno];?>&&id=<?=$Project_detial[tuid];?>"><img src='images/tool.png' width='25'></a></td>
                                    <td align="center"><a href='pre_project_out.php?del_id=<?=$Project_Name[empno];?>&&id=<?=$Project_detial[tuid];?>' onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/bin1.png' width='25'></a></td>
                                    <?php }?>
                                </tr>
                                <?php $i++;
                }
                ?>
                            </table>
                            <?php if($Project_detial['hboss']=='W' and $_SESSION[Status]=='ADMIN'){?>
                            <form class="navbar-form navbar-center" role="form" action='prctraining.php' enctype="multipart/form-data" method='post' onSubmit="return Check_txt()">
                                <center>
                                    <div class="alert alert-info">
                                        <input type="radio" name="hboss" value="Y" required=""> : อนุมัติ&nbsp;&nbsp;&nbsp; <br>
                                        <input type="radio" name="hboss" value="N" required=""> : ไม่อนุมัติ <br>
                                    </div>
                                  <input type="hidden" name="method" value="approve_trainout">
                                  <input type="hidden" name="pro_id" value="<?= $Project_detial['tuid']?>">
                                <input class="btn btn-success" name="submit" type="submit" value="อนุมัติ">  
                                </center>
                            </form>
                            
                            <?php } }else{
                                $empno=$_GET['empno'];
                                $add_emp=  mysql_query("SELECT id_plan,begin_date,end_date,amount FROM plan_out WHERE empno=$empno AND idpo=$project_id");
                                $planout=  mysql_fetch_assoc($add_emp);
                                echo "<form action='prctraining.php' method='post' name='form' enctype='multipart/form-data' id='form'>";
                                echo "<lable for='begin_date'>วันที่เข้าร่วม</lable>";
                                echo "&nbsp; <input type='date' name='begin_date' id='begin_date' value='".$planout['begin_date']."'> &nbsp;";
                                echo "<lable for='end_date'>ถึง</lable>";
                                echo "&nbsp; <input type='date' name='end_date' id='end_date' value='".$planout['end_date']."'> &nbsp;";
                                echo "<lable for='amount'>จำนวน</lable>";
                                echo "&nbsp; <input type='text' name='amount' id='amount' size='1' value='".$planout['amount']."'> &nbsp; วัน";
                                echo "<input type='hidden' name='method' value='edit_date_out'>";
                                echo "<input type='hidden' name='id_plan' value='".$planout['id_plan']."'>";
                                echo "<input type='hidden' name='empno' value='".$empno."'>";
                                echo "<input type='hidden' name='idpo' value='".$project_id."'>";
                                echo "&nbsp; <input type='submit' name='submit' class='btn-warning' value='แก้ไข'>";
                                echo "</form>";
                            }?>
                        </td>
                    </tr>
                </table>
            </div>
        </div><?php 
        $select_url=  mysql_query("select url from hospital");
        $url=  mysql_fetch_assoc($select_url);
        if($_REQUEST['method']=='back'){?>
        <a href="fullcalendar/fullcalendar3.php"><img src="images/undo.ico" width="20"  title="ย้อนกลับ"> กลับไปปฏิทินไปราชการ</a>
                <br>หรือ<br>
                <a href="fullcalendar/fullcalendar4.php"><img src="images/undo.ico" width="20"  title="ย้อนกลับ"> กลับไปปฏิทินกิจกรรมส่วนตัว</a>
        <?php }?>
    </div>
</div>
<?php include 'footer.php'; ?>
