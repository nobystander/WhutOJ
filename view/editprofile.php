<!--
$username
$school
$email
$description

-->
<?php
    require_once('./view/template/header.php');
?>

<div class="wrapper" id="editprofile">
	<div class="container">
    <form  method="POST" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="control-label col-md-4" for="user_name">Username</label>
			<label class="control-label col-md-3" for="user_name" id="username"><?php echo $username ?></label>
        </div>
		<div class="form-group">
            <label class="control-label col-md-4" for="school">School</label>
            <div class="col-md-4">
			<input class="form-control" id="school" name="school" type="text" value=<?php echo '"',$school,'"'; ?> >
            </div>
            <div class="col-md-4">
            	<span class="modal-error profile-info" id="school" style="display:none"></span>
            </div>
        </div>
		<div class="form-group">
            <label class="control-label col-md-4" for="email">Email</label>
            <div class="col-md-4">
			<input class="form-control" id="email" name="email" type="text" value=<?php echo '"',$email,'"'; ?>>
            </div>
            <div class="col-md-4">
            	<span class="modal-error profile-info" id="email" style="display:none"></span>
            </div>
		</div>
		<div class="form-group">
            <label class="control-label col-md-4" for="description">Description</label>
            <div class="col-md-6">
			<input class="form-control" id="description" name="description" type="text" value=<?php echo '"'.$description.'"'; ?>>
            </div>
		</div>
		<div class="form-group" id="btn-div">
			<button type="button" onclick="getProfile().save()" class="btn btn-primary" id="profile-save">Save</button>
		    <button type="button" onclick="getProfile().reset()" class="btn btn-default">Reset</button>
		</div>
  	</form>
    </div>
</div>

<?php
    require_once('./view/template/footer.php');
?>
