<!--
$page_title
$problem_id
$title
array $data

-->


<?php
    require_once('./view/template/header.php');
?>

<div class="wrapper" id="discuss">
	<div class="container">
        <br />
        <div class="discuss-header">
            <h2>Problem <span class="problem-id"><?php echo $problem_id;?></span> : <?php echo $title;?> </h2>
        </div>
        
        <br />
        
        <div class="discuss-body">
            
        <?php
            
            
            function show($now,$deep)
            {
                if(empty($now)) return;
                echo    '<ul>';
                for($i = 0;$i < count($now);$i++)
                {
                    echo    '<li>';
                    $t = $deep?'Re:&nbsp;':'&clubs;:&nbsp;';
                    echo        '<div>'.$t.'<span class="content">'.$now[$i]['content'].'</span>&nbsp;&nbsp;&nbsp;By&nbsp;<span class="username"> <a href="/index.php?controller=viewprofile&username='.$now[$i]['username'].'">'.$now[$i]['username'].'</a></span>&nbsp;&nbsp;<span class="time">'.$now[$i]['time'].'</span>'; 
                    
                    if(isset($_SESSION['username']))
                    {
                        echo '&nbsp;&nbsp;&nbsp;<a href="#" data-toggle="modal" data-target="#new-discuss" data-father="'.$now[$i]['discuss_id'].'">Reply</a>';
                    }
                    
                    echo        '</div>';
                    
                    show($now[$i]['children'],$deep+1);
                    
                    echo    '</li>';
                }
                echo    '</ul>';
            }
            
            
            show($data,0);
            echo    '<ul>';
            echo    '<li><a href="#" data-toggle="modal" data-target="#new-discuss" data-father="0">Add a new Comment</a></li>';
            echo    '</ul>';
            
        ?>
        </div>
        
        
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="new-discuss" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">New</h4>
            </div>
            
            <div class="modal-body">
                <div class="alert alert-info" role="alert">Support Mathjax</div>
                <form id="discuss-input">
                    <div class="form-group">
                        <label for="discuss-content">Here</label>
                        <textarea class="form-control discuss-content" name="discuss-content" rows="5"required maxlength="50"></textarea>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary submit" onclick="getDiscuss().discussSubmit()" data-loading-text="Loading...">Submit</button>
            </div>
        </div>
    </div>
</div>

<?php
    require_once('./view/template/footer.php');
?>