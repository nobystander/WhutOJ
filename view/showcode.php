<!--
$page_title
$language
$code
-->
<?php
    require_once('./view/template/header.php');
?>

<div class="wrapper" id="showcode">
	<div class="container">
	<div class="codebox">
	<pre>
	<?php 
        echo '<code class="language-'.$language.'">'
    ?>
<?php echo $code; ?>
	</code>
	</pre>
	</div>
	</div>
</div>

<?php
    require_once('./view/template/footer.php');
?>