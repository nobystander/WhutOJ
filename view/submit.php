<!--
$page_title
$problem_id
-->
<?php
    require_once('./view/template/header.php');
?>

<div class="wrapper" id="submit" >
	<div class="container">
	<form role="form" class="form-horizontal submit" action="#" method="POST">
		<fieldset>
			<div class="form-group">
			    <label class="control-label col-sm-3" for="pid">PID</label>
			    <div class="col-sm-9">
				<input class="form-control" id="pid" value=<?php echo '"',$problem_id,'"'; ?>>
			    </div>
			</div>
			<div class="form-group">
			    <label class="control-label col-sm-3" for="language">LANG</label>
			    <div class="col-sm-9">
			        <select id="language" class="form-control">
			                    <option value="c">
			                C            </option>
			                    <option value="cpp" selected="">
			                C++            </option>
			                    <option value="java">
			                Java            </option>
			                </select>
			    </div>
			</div>
		</fieldset>
		<div class="form-group">
			<textarea class="form-control" cols="50" rows="20" id="sourcecode" spellcheck="false"></textarea>
			</div>
			<div class="form-group" id="btn-div">
			    <div>
			        <button type="button" onclick="getSubmit().submit()" class="btn btn-primary">Submit</button>
			    </div>
			</div>
	</form>
	</div>
 
</div>

<?php
    require_once('./view/template/footer.php');
?>