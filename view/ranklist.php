<?php
    require_once('./view/template/header.php');
?>

<div class="wrapper" id="ranklist">
    <div class="container">
        <nav>
            <ul class="pagination separate-page">
                
            </ul>
        </nav>
        <div class="table-responsive" style="clear:both">
            <table class="ranklist-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="10%">Rank</th>
                        <th width="32%">Username</th>
                        <th width="32%">School</th>
                        <th width="10%">Solved</th>
                        <th width="10%">Submit</th>
                        <th width="10%">Ratio</th>
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
                <a href="javascript:void(0)" onclick="getRankList().prevRankListPage()" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="common"><a href="javascript:void(0);" onclick="getRankList().changeRankListPage()"></a></li>
            <li class="last">
                <a href="javascript:void(0)" onclick="getRankList().nextRankListPage()" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </div>

        <div class="table-item">
            <table>
                <tr class="table-row">
                    <td class="rank"></td>
                    <td class="username"><a href="#"></a></td>
                    <td class="school"></td>
                    <td class="solved"></td>
                    <td class="submit"></td>
                    <td class="ratio"></td>
                </tr>
            </table>
        </div>
    </div>
</div>



<?php
    require_once('./view/template/footer.php');
?>
