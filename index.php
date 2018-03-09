<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>毕业去向分布</title>
<script src="js/lib/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/lib/raphael-min.js"></script>
<script type="text/javascript" src="js/res/chinaMapConfig.js"></script>
<script type="text/javascript" src="js/map-min.js"></script>
<style>
	*{margin:0;padding:0;border: none;}
	body { color: #333; text-align: center; font: 12px "微软雅黑";background-color: #dcf5ed; }
	.mapTipText{width: 280px;height: 110px;background-color: #ffffff;}
	.mapTipText .mapTipImg{height: 66px; width: 66px; float: left;border: 2px solid #ffffff; border-radius: 50%;overflow: hidden;margin: -12px 5px 0 -12px;}
	.mapTipText .mapTipImg img{width: 100%;height: 100%;}
	.mapTipText .mapTipList{float: left;margin-left: 4px;}
	.mapTipText .mapTipList h2{text-align: left;}
	.mapTipText .mapTipList h2 a{font-size: 24px; color: #262626;text-decoration:none;}
	.mapTipText .mapTipList h2 a:hover{ color: #0085d2;}
	.mapTipText .mapTipList h2 a span{font-size: 16px;margin-left: 3px;}
	.mapTipText .mapTipList ul{ width: 203px;padding-right: 10px;}
	.mapTipText .mapTipList ul li{list-style: none;float: left;padding: 7px 3px 0 3px;}
	.mapTipText .mapTipList ul li a{color: #262626;text-decoration:none;}
	.mapTipText .mapTipList ul li a:hover{background-color:#2ebcfe;color:#ffffff;}
</style>
<script type="text/javascript">
	$(function(){
		$('#ChinaMap').SVGMap({
			mapWidth: 1206,
			mapHeight: 596
		});
	});
</script>
</head>
<body>
<div class="wrap" style="margin-top: 50px;">
<div style="text-align:center;clear:both;">
<script src="/gg_bd_ad_720x90.js" type="text/javascript"></script>
<script src="/follow.js" type="text/javascript"></script>
</div>

<div class="itemCon" style="float: left">
	<div id="ChinaMap" style="margin: 50px;"></div>
	<div id="stateTip" style="position: absolute;left: 100%;text-align: left;display: inline;"></div>
</div>

<div id="mapTipContent" style="width: 900px;margin: 0 auto;display: none">
		<?php
		$con = mysqli_connect("localhost","root","zbw879034");
		if(!$con){
			die('Could not connect: ' . mysqli_error());
		//	echo "mysqld connect error!";
		}
		
		
		function generateProvinceInfo($id, $con){
			echo '<div class="mapTipText mapTipText' . $id . '">';
			echo "\n";
			echo '<div class="mapTipImg"><img src="images/heilongjiang.jpg" alt=""/></div>';
			echo "\n";
			echo '<div class="mapTipList">';
			echo "\n";
			mysqli_select_db($con, "student_47");
			$queryResult = mysqli_query($con, "SELECT * FROM province WHERE id=" . $id);
			$row = mysqli_fetch_array($queryResult);
			$provinceName = $row['province'];
			echo '<h2><a href="">' . $provinceName . '<span>Heilongjiang</span>' . '</a></h2>';
			echo "\n";
			echo '<ul>';
			echo "\n";
			generateIndividualInfo($id, $con);
			echo '</ul>';
			echo "\n";
			echo '</div>';
			echo "\n";
			echo '</div>';
			echo "\n";
		}
		
		function generateIndividualInfo($id, $con){
			mysqli_select_db($con, "student_47");
			$queryResult = mysqli_query($con, "SELECT name FROM student, school WHERE student.schoolid=school.id AND school.province=" . $id);
			// echo "fff";
			// echo "SELECT * FROM student WHERE provinceid=" . $id;
			while($row = mysqli_fetch_array($queryResult)){
				echo '<li><a href="">' . $row['name'] . '</a></li>';
				echo "\n";
			}
		
		}
		
		for($i=0;$i<31;$i++){
			generateProvinceInfo($i, $con);
		}
		echo 'fff'
		?>
</div>
</div>

<div id=link_add>
<h2> <a href=addinfo.php> 添加个人信息 </a></h2>
</div>
<div style="text-align:center;clear:both;">
<script src="/gg_bd_ad_720x90-2.js" type="text/javascript"></script>
</div>
</body>
</html>
