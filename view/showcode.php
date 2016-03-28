<!--
$page_title
$language
$code

$compile_error;

-->
<?php
    require_once('./view/template/header.php');
?>

<div class="wrapper" id="showcode">
	<div class="container">
    <?php
        require_once('./view/template/announcement.php');
    ?>
        <?php
        if($compile_error)
        {
            echo '<div class="panel panel-danger compile-info">';
            echo '  <div class="panel-heading">';
            echo '      <h3 class="panel-title">Compile Info</h3>';
            echo '</div>';
            echo '  <div class="panel-body">';
            echo       $compile_error;
            echo '  </div>';
            echo '</div>';
        }
        ?>
        <div class="codebox">
            <pre>
            <?php 
                echo '<code class="language-'.$language.'">'.$code;
            ?></code>
            </pre>
        </div>
        
	</div>
</div>

<?php
    require_once('./view/template/footer.php');
?>