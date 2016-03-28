<?php
    require_once('./view/template/header.php');
?>

<div class="wrapper" id="backend">
    <div class="container">
      <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#add-problem" aria-controls="add-problem" role="tab" data-toggle="tab" id="add-problem-tab">Add problem</a></li>
            <li role="presentation"><a href="#edit-problem" aria-controls="edit-problem" role="tab" data-toggle="tab" id="edit-problem-tab">Edit problem</a></li>
            <li role="presentation"><a href="#view-problem" aria-controls="view-problem" role="tab" data-toggle="tab" id="view-problem-tab">View problem</a></li>
            <li role="presentation"><a href="#view-status" aria-controls="view-status" role="tab" data-toggle="tab" id="view-status-tab" >View status</a></li>
            <li role="presentation"><a href="#announcement" aria-controls="announcement" role="tab" data-toggle="tab" id="announcement-tab" >Announcement</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="add-problem">
                
                <form id="add-problem-form" enctype="multipart/form-data" >
                    <br />
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="title">Title</label>
                            <input type="text" class="form-control title" name="title" placeholder="Title" required="required">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="time-limit">Time Limit(s)</label>
                            <input type="number" class="form-control time-limit" name="time_limit" 
                             min="1" value="1" required="required">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="memory-limit">Memory Limit(MB)</label>
                            <input type="number" class="form-control memory-limit" name="memory_limit" 
                             value="64" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control description" name="description" rows="4"required ></textarea>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="input">Input</label>
                            <textarea class="form-control input" name="input" rows="3"required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="output">Output</label>
                            <textarea class="form-control output" name="output" rows="3"required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="sample-input">Sample Input</label>
                            <textarea class="form-control sample-input" name="sample_input" rows="3"required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sample-output">Sample Output</label>
                            <textarea class="form-control sample-output" name="sample_output" rows="3"required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint">Hint</label>
                        <textarea class="form-control hint" name="hint" rows="2"></textarea>
                    </div>
                     <div class="form-group">
                        <label for="source">Source</label>
                        <input type="text" class="form-control source" name="source" placeholder="Source" required="required">
                    </div>
                    <div class="form-group">
                        <label for="data">Data</label>
                        <input type="file" class="data" name="data">
                        <p class="help-block">题目数据,注意: 必须上传.tar文件,并且里面只有2个文件夹：input和output. input文件夹中的数据命名为input000,input001... ,对应output中的文件为output000,output001....</p>
                    </div>


                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="visible" value="1"> Visible?
                        </label>
                    </div>

                    <button  type="button" class="btn btn-default submit" onclick="getBackend().addProblemSubmit()" data-loading-text="Loading...">Submit</button>
                </form>   
                
            
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="edit-problem">
                <br />
                <div class="row choose-problem">
                    <div class="col-lg-4">
                        <div class="input-group">
                            <input type="number" min="1000" value="1000" class="form-control" placeholder="Problem ID">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick="getBackend().loadProblem()">Edit</button>
                            </span>
                        </div><!-- /input-group -->
                    </div>
                </div>
                
                
                <form id="edit-problem-form" enctype="multipart/form-data" style="display:none">
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="title">Title</label>
                            <input type="text" class="form-control title" name="title" placeholder="Title" required="required">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="time-limit">Time Limit(s)</label>
                            <input type="number" class="form-control time-limit" name="time_limit" 
                             min="1" value="1" required="required">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="memory-limit">Memory Limit(MB)</label>
                            <input type="number" class="form-control memory-limit" name="memory_limit" 
                             value="64" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control description" name="description" rows="4"required ></textarea>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="input">Input</label>
                            <textarea class="form-control input" name="input" rows="3"required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="output">Output</label>
                            <textarea class="form-control output" name="output" rows="3"required></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="sample-input">Sample Input</label>
                            <textarea class="form-control sample-input" name="sample_input" rows="3"required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sample-output">Sample Output</label>
                            <textarea class="form-control sample-output" name="sample_output" rows="3"required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="hint">Hint</label>
                        <textarea class="form-control hint" name="hint" rows="2"></textarea>
                    </div>
                     <div class="form-group">
                        <label for="source">Source</label>
                        <input type="text" class="form-control source" name="source" placeholder="Source" required="required">
                    </div>
                    <div class="form-group">
                        <label for="data">Data</label>
                        <input type="file" class="data" name="data">
                        <p class="text-danger">如果无需改动数据，请勿上传文件，否则上传全部完整数据</p>
                        <p class="help-block">题目数据,注意: 必须上传.tar文件,并且里面只有2个文件夹：input和output. input文件夹中的数据命名为input000,input001... ,对应output中的文件为output000,output001....</p>
                    </div>


                    <div class="checkbox">
                        <label>
                            <input type="checkbox" class="visible" name="visible" value="1"> Visible?
                        </label>
                    </div>

                    <button  type="button" class="btn btn-default cancel" onclick="getBackend().editOut()">Cancel</button>
                    
                    <button  type="button" class="btn btn-primary submit" onclick="getBackend().editProblemSubmit()" data-loading-text="Loading...">Submit</button>
                </form> 
                
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="view-problem">
                
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
                                <th width="15%">Visible</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
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
                                <td class="id"><a href="" target="_blank"></a></td>
                                <td class="title"><a href="" target="_blank"></a></td>
                                <td class="source"><a href="javascript:void(0)"></a></td>
                                <td class="visible">
                                    <div class="btn-group" data-toggle="buttons">
                                      <label class="btn btn-primary">
                                        <input type="radio" name="options" value="1" autocomplete="off"> Show
                                      </label>
                                      <label class="btn btn-primary">
                                        <input type="radio" name="options" value="0" autocomplete="off"> Hide
                                      </label>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                
            </div>
            
            <div role="tabpanel" class="tab-pane fade" id="view-status">
                <br />
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
                                <th width="15%">Result Log</th>
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
                                <td class="run-id"><a href="#" target="_blank"></a></td>
                                <td class="problem-id"><a href="#" target="_blank"></a></td>
                                <td class="username"><a href="#" target="_blank"></a></td>
                                <td class="result">
                                    <a href="#" data-toggle="modal" data-target="#show-result-log">
                                    </a>
                                </td>
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
            
            
            <div role="tabpanel" class="tab-pane fade" id="announcement">
                <br />
                <form>
                    <div class="form-group">
                        <label for="content">Here</label>
                        <textarea class="form-control content" name="content" rows="5">
                        </textarea>
                        <br />
                        <button  type="button" class="btn btn-primary submit" onclick="getBackend().changeAnnouncement()" data-loading-text="Loading..." style="float:right">Save</button>
                    </div>
                
                </form>
                
            </div>
        </div>

    </div>
    <div class="wait-info">
    <h1>Waiting.....</h1>
    </div>
    
</div>



<div class="modal fade" id="show-result-log" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title run-id" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">

                <div class="panel panel-danger compile-log">
                    <div class="panel-heading">
                        <h3 class="panel-title">Compile Log</h3>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>
                <div class="panel panel-danger compile-error">
                    <div class="panel-heading">
                        <h3 class="panel-title">Compile Error</h3>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>
                <div class="panel panel-danger run-log">
                    <div class="panel-heading">
                        <h3 class="panel-title">Run Log</h3>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>
                <div class="panel panel-danger run-error">
                    <div class="panel-heading">
                        <h3 class="panel-title">Run Error</h3>
                    </div>
                    <div class="panel-body">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php
    require_once('./view/template/footer.php');
?>