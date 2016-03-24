<?php
    require_once('./view/template/header.php');
?>
<div class="wrapper" id="problem-list">
    <div class="container">
        <div class="row">
            <div class="col-md-4" >
                <form action="javascript:void(0)"  class="navbar-form" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="ID or Title or Source">
                    </div>
                    <button type="submit" onclick="getProblemList().searchProblemListProblem()" class="btn btn-default">Search</button>
                </form>
            </div>
            <nav>
                <ul class="pagination separate-page">
                    
                </ul>
            </nav>
        </div>
        <div class="table-responsive">
            <table class="problem-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="3%">Flag</th>
                        <th width="6%">ID</th>
                        <th width="38%" >Title</th>
                        <th width="38%">Source</th>
                        <th width="8%">AC</th>
                        <th width="7%">Total</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="wait-info">
    <h1>Waiting.....</h1>
    </div>

    <div class="template" style="display:none">
        <div class="page-nav">
            <li class="first">
                <a href="javascript:void(0)" onclick="getProblemList().prevProblemListPage()" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="common"><a href="javascript:void(0);" onclick="getProblemList().changeProblemListPage()"></a></li>
            <li class="last">
                <a href="javascript:void(0)" onclick="getProblemList().nextProblemListPage()" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </div>
        <div class="table-item">
            <table>
                <tr class="table-row">
                    <td class="flag" style="text-align:center">√</td>
                    <td class="id"><a href=""></a></td>
                    <td class="title"><a href=""></a></td>
                    <td class="source"><a href="javascript:void(0)"></a></td>
                    <td class="ac_num"></td>
                    <td class="total_num"></td>
                </tr>
            </table>
        </div>
    </div>
    
    
</div>


<?php
    require_once('./view/template/footer.php');
?>