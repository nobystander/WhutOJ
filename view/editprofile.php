<!--
$username
$school
$email

-->
<?php
    require_once('./view/template/header.php');
?>

<div class="wrapper" id="editprofile">
	<div class="container">
    <form  method="POST" class="form-horizontal" role="form">
        <div class="form-group">
            <label class="control-label col-sm-4" for="user_name">Username</label>
			<label class="control-label col-sm-3" for="user_name" id="username"><?php echo $username ?></label>
        </div>
		<div class="form-group">
            <label class="control-label col-sm-4" for="school">School</label>
            <div class="col-sm-4">
			<input class="form-control" id="school" name="school" type="text" value="<?php echo '"',$school,'"'; ?>>
            </div>
            <div class="col-sm-4">
            	<span class="modal-error profile-info" id="school" style="display:none"></span>
            </div>
        </div>
		<div class="form-group">
            <label class="control-label col-sm-4" for="email">Email</label>
            <div class="col-sm-4">
			<input class="form-control" id="email" name="email" type="text" value="<?php echo '"',$email,'"'; ?>>
            </div>
            <div class="col-sm-4">
            	<span class="modal-error profile-info" id="mail" style="display:none"></span>
            </div>
        </div>
		<div class="form-group">
            <label class="control-label col-sm-4" for="old_password">Old Password</label>
            <div class="col-sm-4">
			<input class="form-control" id="old_password" name="old_password" type="password" value="">
            </div>
            <div class="col-sm-4">
            	<span class="modal-error profile-info" id="old_password" style="display:none"></span>
            </div>
        </div>
		<div class="form-group">
            <label class="control-label col-sm-4" for="new_password">New Password</label>
            <div class="col-sm-4">
			<input class="form-control" id="new_password" name="new_password" type="password" value="">
            </div>
            <div class="col-sm-4">
            	<span class="modal-error profile-info" id="new_password" style="display:none"></span>
            </div>
        </div>
		<div class="form-group">
            <label class="control-label col-sm-4" for="re_password">Re Password</label>
            <div class="col-sm-4">
			<input class="form-control" id="re_password" name="re_password" type="password" value="">
            </div>
            <div class="col-sm-4">
            	<span class="modal-error profile-info" id="re_password" style="display:none"></span>
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
