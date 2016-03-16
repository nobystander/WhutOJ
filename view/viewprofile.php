<!--
$username
$school
$email
$rank

-->

<?php
    require_once('./view/template/header.php');
?>


<div class="wrapper" id="viewprofile">
	<div class="container">
		<div class="row">
			<div class="col-md-6 div-profile">
			<div class="center-block div-ul">
				<ul class="fa-ul">
					<li><i class="fa-li fa fa-user"></i><b>Username</b>&nbsp;&nbsp; <?php echo $username;?></li>
					<li><i class="fa-li fa fa-university"></i><b>School</b>&nbsp;&nbsp; <?php echo $school;?></li>
					<li><i class="fa-li fa fa-envelope"></i><b>Email</b>&nbsp;&nbsp; <?php echo $email;?></li>
					<li><i class="fa-li fa fa-trophy"></i><b>Rank</b>&nbsp;&nbsp; <?php echo $rank;?></li>
				</ul>
			</div>
        	</div>
			<div class="col-md-6 div-profile">
			<div class="center-block div-canvas">
				<canvas id="canvas"></canvas>
			</div>
        	</div>
       	</div>
		<div class="row">
			<div class="col-md-6 panel">
				<div class="panel-heading"><h3>Solved</h3></div>
				<div class="panel-body well well-lg problem-block">
					<a class="btn btn-success">1000</a>
					<a class="btn btn-success">1000</a>
					<a class="btn btn-success">1000</a>
					<a class="btn btn-success">1000</a>
					<a class="btn btn-success">1000</a>
					<a class="btn btn-success">1000</a>
					<a class="btn btn-success">1000</a>
					<a class="btn btn-success">1000</a>
					<a class="btn btn-success">1000</a>
					<a class="btn btn-success">1000</a>
				</div>
			</div>
			<div class="col-md-6 panel">
				<div class="panel-heading"><h3>Try</h3></div>
				<div class="panel-body well well-lg problem-block">
					<a class="btn btn-danger">1000</a>
					<a class="btn btn-danger">1000</a>
					<a class="btn btn-danger">1000</a>
					<a class="btn btn-danger">1000</a>
					<a class="btn btn-danger">1000</a>
					<a class="btn btn-danger">1000</a>
					<a class="btn btn-danger">1000</a>
					<a class="btn btn-danger">1000</a>
					<a class="btn btn-danger">1000</a>
					<a class="btn btn-danger">1000</a>
				</div>
			</div>
		<div>
	</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script>
 var Data = [
	 {
		 value: 30,
		 color:"#F7464A"
	 },
	 {
		 value : 50,
		 color : "#46BFBD"
	 },
	 {
		 value : 100,
		 color : "#FDB45C"
	 },
	 {
		 value : 40,
		 color : "#949FB1"
	 },
	 {
		 value : 120,
		 color : "#4D5360"
	 }
];

var myDoughnut = new Chart(document.getElementById("canvas").getContext("2d")).Doughnut(Data);
</script>
<?php
    require_once('./view/template/footer.php');
?>
