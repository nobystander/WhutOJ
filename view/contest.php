<?php
    require_once('./view/template/header.php');
    $contest_title = 'asdasd';
    $begin_time = '2015-04-30 09:43:00';
    $end_time = '2015-04-30 12:43:00';
?>
<div class="wrapper" id="contest">
    <div class="container">
    <?php
        require_once('./view/template/announcement.php');
    ?>
        <div class="contest-title">
            <h1><?php echo $contest_title; ?></h1>
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
            </div>
        </div>
        <div class="progress-info">
            <span>Remain:</span>
            <span class="remain-time">222</span>
        </div>
        
       <div>
          <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#contest-problem" aria-controls="contest-problem" role="tab" data-toggle="tab">Problem</a></li>
                <li role="presentation"><a href="#contest-status" aria-controls="contest-status" role="tab" data-toggle="tab">Status</a></li>
                <li role="presentation"><a href="#contest-standing" aria-controls="contest-standing" role="tab" data-toggle="tab">Standing</a></li>
                <li role="presentation"><a href="#contest-notification" aria-controls="contest-notification" role="tab" data-toggle="tab">Notification</a></li>
                <li role="presentation"><a href="#contest-clarify" aria-controls="contest-clarify" role="tab" data-toggle="tab">Clarify</a></li>

            </ul>

          <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="contest-problem">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="problem-table table table-striped table-hover" id="contest-problem-table">
                                    <thead>
                                        <tr>
                                            <th width="10%">Flag</th>
                                            <th width="10%">ID</th>
                                            <th width="60%" >Title</th>
                                            <th width="10%">AC</th>
                                            <th width="10%">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-row">
                                            <td class="flag"></td>
                                            <td class="id"><a href="">A</a></td>
                                            <td class="title"><a href="">asdasd</a></td>
                                            <td class="ac_num">11</td>
                                            <td class="total_num">23</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="contest-info col-md-3">
                            <p>Begin: <?php echo $begin_time; ?></p>
                            <p>Begin: <?php echo $end_time; ?></p>
                            <p>else</p>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="contest-status">2</div>
                <div role="tabpanel" class="tab-pane" id="contest-standing">3</div>
                <div role="tabpanel" class="tab-pane" id="contest-notification">4</div>
                <div role="tabpanel" class="tab-pane" id="contest-clarify">5</div>
            </div>

        </div>
    </div>
</div>

<?php
    require_once('./view/template/footer.php');
?>