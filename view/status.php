<?php
    require_once('./view/template/header.php');
?>
<div class="wrapper" id="status-list">
    <div class="container">
        <form action="javascript:void(0)" class="form-inline submit-search">
            <div class="form-group">
                <label for="username-search">Username:</label>
                <input type="text" class="form-control" id="username-search" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="problem-search">PID:</label>
                <input type="text" class="form-control" id="problem-search" placeholder="Problem ID">
            </div>
            <button type="submit" onclick="getStatus().searchStatusSubmit()" class="btn btn-default">Search</button>
        </form>
        <nav>
            <ul class="pagination separate-page">
                
            </ul>
        </nav>
        
        <div class="table-responsive" style="clear:both">
            <table class="status-table table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="5%">RunID</th>
                        <th width="5%">PID</th>
                        <th width="12%" >User</th>
                        <th width="15%">Result</th>
                        <th width="5%">Language</th>
                        <th width="10%">Time</th>
                        <th width="11%">Memory</th>
                        <th width="9%">Length</th>
                        <th width="18%">Submit Time</th>
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
                <a href="javascript:void(0)" onclick="getStatus().prevStatusPage()" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="common"><a href="javascript:void(0);" onclick="getStatus().changeStatusPage()"></a></li>
            <li class="last">
                <a href="javascript:void(0)" onclick="getStatus().nextStatusPage()" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </div>
        <div class="table-item">
            <table>
                <tr class="table-row">
                    <td class="run-id"><a href="#"></a></td>
                    <td class="problem-id"><a href="#"></a></td>
                    <td class="username"><a href="#"></a></td>
                    <td class="result"></td>
                    <td class="language"></td>
                    <td class="time"></td>
                    <td class="memory"></td>
                    <td class="length"></td>
                    <td class="submit-time"></td>
                </tr>
            </table>
        </div>
    </div>
</div>




<?php
    require_once('./view/template/footer.php');
?>