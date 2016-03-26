<!--
$page_title

-->
<?php
    require_once('./view/template/header.php');
?>


<div class="wrapper">
    <div class="container" id="statistics">
        <div class="row">
            <div class="col-md-8 problem-rank">
                <h2>Top20 Submit</h2>
                 <div class="table-responsive" style="clear:both">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">Order</th>
                                <th width="10%" >User</th>
                                <th width="10%">Submit Time</th>
                                <th width="5%">Time</th>
                                <th width="5%">Memory</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            for($i = 0;$i < count($problem_rank);$i++)
                            {
                                echo    '<tr class="table-row">';
                                echo    '<td class="order">'. ($i+1) .'</td>';
                                echo    '<td class="username"><a href="/index.php?controller=viewprofile&username='. $problem_rank[$i]['username'] .'">'. $problem_rank[$i]['username'] .'</a></td>';
                                echo    '<td class="submit-time">'. $problem_rank[$i]['submit_time'] .'</td>';
                                echo    '<td class="time">'.$problem_rank[$i]['time'].'</td>';
                                echo    '<td class="memory">'.$problem_rank[$i]['memory'] .'</td>';
                                echo    '</tr>';
                                
                            }
                        ?> 

                        </tbody>
                    </table>
                </div>
                
            </div>
            <div class="col-md-4">
                <div class="center-block div-canvas">
                    <canvas id="canvas"></canvas>
                </div>
                
                <div class="data">
                    <h3>Total Count</h3>
                    <ul>
                        <li id="CE_num">CE: <span><?php echo $CE_num ?></span></li>
                        <li id="AC_num">AC: <span><?php echo $AC_num ?></span></li>
                        <li id="RE_num">RE: <span><?php echo $RE_num ?></span></li>
                        <li id="WA_num">WA: <span><?php echo $WA_num ?></span></li>
                        <li id="Other_num"sss>Other: <span><?php echo $Other_num ?></span></li>
                    </ul>
                </div>
            </div>
        
        </div>
        
    </div>
</div>


<?php
    require_once('./view/template/footer.php');
?>