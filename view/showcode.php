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
	<code class="<?php echo $lang; ?>">
<?php echo $code; ?>
	</code>
	</pre>
	</div>
	</div>
</div>


		<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/highlight.min.js"></script>
		<script>hljs.initHighlightingOnLoad();</script> <!--代码高亮-->
</script>

<?php
    require_once('./view/template/footer.php');
?>
