<?php
    require_once('./view/template/header.php');
?>
<div class="wrapper" id="rank-list">
    <div class="container">
    <?php
        require_once('./view/template/announcement.php');
    ?>
        <form action="javascript:void(0)" class="form-inline submit-search">
            <div class="form-group">
                <label for="username-search">Username:</label>
                <input type="text" class="form-control" id="username-search" placeholder="Username">
            </div>
            <button type="submit" onclick="getRank().searchRankSubmit()" class="btn btn-default">Search</button>
        </form>
        <nav>
            <ul class="pagination separate-page">
                
            </ul>
        </nav>
        
        <div class="table-responsive" style="clear:both">
            <table class="rank-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="5%">Rank</th>
                        <th width="10%" >User</th>
                        <th width="15%">Descitption</th>
                        <th width="5%">Solved</th>
                        <th width="5%">Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
        
    </div>
    
    
    <div class="template" style="display:none">
        <div class="page-nav">
            <li class="first">
                <a href="javascript:void(0)" onclick="getRank().prevRankPage()" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="common"><a href="javascript:void(0);" onclick="getRank().changeRankPage()"></a></li>
            <li class="last">
                <a href="javascript:void(0)" onclick="getRank().nextRankPage()" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </div>
        <div class="table-item">
            <table>
                <tr class="table-row">
                    <td class="rank"></td>
                    <td class="username"><a href="#"></a></td>
                    <td class="description"></td>
                    <td class="solved"></td>
                    <td class="submitted"></td>
                </tr>
            </table>
        </div>
    </div>
</div>




<?php
    require_once('./view/template/footer.php');
?>