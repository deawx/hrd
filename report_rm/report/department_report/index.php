<?php include'../../../connect.php'; ?>
 
 

 

<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
 </head>

<body>
 
 
		  <p><h3>  &nbsp;&nbsp;ข้อมูลผู้ป่วยแยกตามจังหวัด อำเภอ ตำบล</h3></p>

<?php
			
 				$strQuery = "select count(mngrisk_id) as number_risk,d1.name as dep_name from mngrisk m1
				 LEFT OUTER JOIN takerisk t1 on t1.takerisk_id = m1.takerisk_id
				 LEFT OUTER JOIN department d1 on t1.take_dep = d1.dep_id
				 where  m1.mng_status='Y'   and t1.move_status='N' group by d1.dep_id order by number_risk DESC";
 			 
				//Iterate through each factory
				$result = mysql_query($strQuery) or die(mysql_error()); 
				if ($result) {

 					  while($rs = mysql_fetch_array($result)){
 						    $name.="'$rs[dep_name]'".',';
					 	    $countnum.= $rs[number_risk].',';
				   }
				}
 
			 
			 
			


	//ค่าที่นำไปใส่ในกราฟแกน X     $name; 
	//ค่าที่นำไปใส่ในกราฟแกน Y     $count;
 ?>


<!-- 		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
 -->		<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'bar'
            },
            title: {
                text: '------'
            },
            subtitle: {
                text: '------'
            },
            xAxis: {
                categories: [<?php echo $name ?>],
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'จำนวนผู้ป่วย (คน)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                formatter: function() {
                    return ''+
                        this.series.name +': '+ this.y +' คน';
                }
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -100,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'จำนวนผู้ป่วย',
                data: [<?echo $countnum ?>]
            
            }]
        });
    });
    
});
		</script> 
	</head>

 
<script src="../../highcharts.js"></script>
<script src="../../exporting.js"></script>

 