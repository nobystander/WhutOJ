<!--
$page_title
$username
$school
$email
$description

array $solved
array $try

$CE_num
$AC_num
$RE_num
$WA_num
$Other_num

$is_self
-->

<?php
    require_once('./view/template/header.php');
?>


<div class="wrapper" id="viewprofile">
	<div class="container">
        <?php
            require_once('./view/template/announcement.php');
        ?>
        
		<div class="row">
			<div class="col-md-6 div-profile">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="view-username" class="col-sm-4 control-label">
                            Username:
                        </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="view-username" value="<?php echo $username; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view-school" class="col-sm-4 control-label">
                            School:
                        </label>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" maxlength="64" id="view-school" value="<?php echo $school; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view-email" class="col-sm-4 control-label">
                            Email:
                        </label>
                        <div class="col-sm-5">
                            <input type="email" class="form-control" maxlength="64" id="view-email" value="<?php echo $email; ?>" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="view-description" class="col-sm-4 control-label">
                            Description:
                        </label>
                        <div class="col-sm-5">
                            <textarea id="view-description" class="form-control" maxlength="100" cols=40 rows= 5 disabled><?php echo $description; ?></textarea>
                        </div>
                    </div>
                    <?php
                    if($is_self)
                    {
                        echo '<div class="edit-button" style="text-align:center">';
                        echo '<button type="button" class="btn btn-primary"'; 
                        echo 'onclick="getProfile().editIn()">Edit</button>';
                        echo '</div>';
                    }
                    ?>
                </form>
            </div>
            <div class="col-md-6  div-profile">
                <div class="center-block div-canvas">
                    <canvas id="canvas"></canvas>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 panel">
                <div class="panel-heading"><h3>Solved</h3></div>
                <div class="panel-body well well-lg problem-block">
                <?php

                    for($i = 0;$i < count($solved);$i++)
                        echo '<a class="btn btn-success" href="/index.php?controller=problem&problem_id='. $solved[$i]. '">'.$solved[$i].'</a>';

                ?>
                </div>
            </div>
            <div class="col-md-6 panel">
                <div class="panel-heading"><h3>Try</h3></div>
                <div class="panel-body well well-lg problem-block">
                    <?php

                    for($i = 0;$i < count($try);$i++)
                        echo '<a class="btn btn-danger" href="/index.php?controller=problem&problem_id='. $try[$i]. '">'.$try[$i].'</a>';
                    ?>
                </div>
            </div>
       </div>
    </div>
    
    <div class="data" style="visibility: hidden">
        <div id="CE_num"><?php echo $CE_num ?></div>
        <div id="AC_num"><?php echo $AC_num ?></div>
        <div id="RE_num"><?php echo $RE_num ?></div>
        <div id="WA_num"><?php echo $WA_num ?></div>
        <div id="Other_num"><?php echo $Other_num ?></div>
    </div>
</div>

<?php
    require_once('./view/template/footer.php');
?>