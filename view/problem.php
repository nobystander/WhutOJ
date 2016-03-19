<!--
$page_title
$title
$time_limit
$memory_limit
$description
$input
$output
$sample_input
$sample_output
$hint
$source
-->

<?php
    require_once('./view/template/header.php');
?>
<div class="wrapper">
    <div class="container" id="problem-container">
        <h2 class="center-text"><?php echo $title; ?></h2>
        <div class="limit">
            <span>Time Limit: <span class="badge"><?php echo $time_limit; ?></span>&thinsp;s</span>
            <span>　　　</span>
            <span>Memory Limit: <span class="badge"><?php echo $memory_limit; ?></span>&thinsp;KB</span>
        </div>
        <div class="btn-group problem-bar">
            <button type="button" class="btn btn-default">Status</button>
            <button type="button" class="btn btn-default">Statistics</button>
            <button type="button" class="btn btn-default">Discuss</button>
        <?php
            if(isset($_SESSION['user_id']))
                echo '<a href="/index.php?controller=submit&problem_id='. $problem_id .'"><button type="button" class="btn btn-primary">Submit</button></a>';
            ?>
        </div>
        <div class="problem-tag">
            <h4>Description</h4>
        </div>
        <div class="problem-content">
            <?php
                echo $description;
            ?>
        </div>
        <div class="problem-tag">
            <h4>Input</h4>
        </div>
        <div class="problem-content">
            <?php
                echo $input;
            ?>
        </div>
        <div class="problem-tag">
            <h4>Output</h4>
        </div>
        <div class="problem-content">
            <?php
                echo $output;
            ?>
        </div>
        
        <div class="problem-tag">
            <h4>Sample Input</h4>
        </div>
        <div class="problem-content">
            <?php
                echo $sample_input;
            ?>
        </div>
        <div class="problem-tag">
            <h4>Sample Output</h4>
        </div>
        <div class="problem-content">
            <?php
                echo $sample_output;
            ?>
        </div>
        <div class="problem-tag">
            <h4>Hint</h4>
        </div>
        <div class="problem-content">
            <?php
                echo $hint;
            ?>
        </div>
        <div class="problem-tag">
            <h4>Source</h4>
        </div>
        <div class="problem-content">
            <?php
                echo $source;
            ?>
        </div>
        <div class="btn-group problem-bar">
            <button type="button" class="btn btn-default">Status</button>
            <button type="button" class="btn btn-default">Statistics</button>
            <button type="button" class="btn btn-default">Discuss</button>
            <?php
            if(isset($_SESSION['user_id']))
                echo '<a href="/index.php?controller=submit&problem_id='. $problem_id .'"><button type="button" class="btn btn-primary">Submit</button></a>';
            ?>
        </div>
    </div>
</div>


<?php
    require_once('./view/template/footer.php');
?>
