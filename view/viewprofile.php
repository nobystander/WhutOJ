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
			<div class="col-md-6">
				<ul class="fa-ul">
					<li><i class="fa-li fa fa-user"></i><b>Username</b>&nbsp;&nbsp; <?php echo $username;?></li>
					<li><i class="fa-li fa fa-university"></i><b>School</b>&nbsp;&nbsp; <?php echo $school;?></li>
					<li><i class="fa-li fa fa-envelope"></i><b>Email</b>&nbsp;&nbsp; <?php echo $email;?></li>
					<li><i class="fa-li fa fa-trophy"></i><b>Rank</b>&nbsp;&nbsp; <?php echo $rank;?></li>
				</ul>
        	</div>
			<div class="col-md-6">
				TODO
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

<?php
    require_once('./view/template/footer.php');
?>
