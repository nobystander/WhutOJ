<!--
$page_title
$lang
$code

-->
<?php
    require_once('./view/template/header.php');
?>

<div class="wrapper" id="showcode">
	<div class="container">
	<div class="codebox">
	<pre>
	<code class="language-cpp">
<?php echo $code; ?>
	</code>
	</pre>
	</div>
	</div>
</div>

<?php
    require_once('./view/template/footer.php');
?>
