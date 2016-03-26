var createStatus = function() {
    /*..................................*/
    var status_now_page = 1;
    var status_item_per_page = 10;
    var status_total_page;
    /*................STATUSLIST...................*/

    return {
        startStatusPage : function () //JS刷新Status页面，包括table和分页
        {
            var data = '';
            var tmp = '';
            var that = this;
            if(arguments[0])
            {
                tmp = arguments[0];
                var pattern = /^(.*)@(.*)$/;
                var buf = pattern.exec(arguments[0]);
                if(buf[1] && buf[2])
                    data = "username=" + encodeURIComponent(buf[1]) + "&problem_id=" + encodeURIComponent(buf[2]);
                else if(buf[1])
                    data = "username=" + encodeURIComponent(buf[1]);
                else if(buf[2])
                    data = "problem_id=" + encodeURIComponent(buf[2]);

            }
            
            $("#show-result-log").on('show.bs.modal',function(event){
              //  alert(event.relatedTarget.getAttribute("value")); 
                var run_id = event.relatedTarget.getAttribute("value");
                that.loadResultLogModal(run_id);    
            });
            
            $.post("http://" + window.location.host + "/index.php?controller=server&action=getTotalSubmitNum",data, function(json)
            {
                item = json;
               // alert(json);
               var num = Math.ceil(item/status_item_per_page);
                status_total_page = num;
                status_now_page = 1;
                
                that.updateStatusPage();
                if(tmp)
                    that.reloadStatusTable(tmp);
                else
                    that.reloadStatusTable();  
            });
            

        },

        loadResultLogModal : function(run_id)
        {
            $("#show-result-log .modal-header .run-id").text("RUN ID: " + run_id);
            
            var data = "run_id=" + run_id;
            $.post("http://" + window.location.host + "/index.php?app=admin&controller=backend&action=getRunLog",data, function(json)
            {
               
                $("#show-result-log .modal-body .compile-log .panel-body").html(json.compile_log);
                $("#show-result-log .modal-body .compile-error .panel-body").html(json.compile_error);
                $("#show-result-log .modal-body .run-log .panel-body").html(json.run_log);
                $("#show-result-log .modal-body .run-error .panel-body").html(json.run_error);
            },"json"); 
            
        },

        updateStatusPage : function () //刷新分页
        {
            
            var num = status_total_page;
            
            $("#backend #view-status .separate-page").html('');
           var first = $("#backend #view-status .template .page-nav .first").clone(true);
            if(status_now_page === 1)
                first.addClass("disabled");
            var last = $("#backend #view-status .template .page-nav .last").clone(true);
            if(status_now_page === num)
                last.addClass("disabled");
            
            if(num) 
                $("#backend #view-status .separate-page").append(first);

            for(var i = 1;i <= num;++i)
            {
                var tmp = $("#backend #view-status .template .page-nav .common").clone(true);
                tmp.children("a").text(i);
                tmp.children("a").attr("onclick","getStatus().changeStatusPage(" + i + ")");
                if(i === status_now_page)
                {
                    tmp.addClass("active");
                }
                $("#backend #view-status .separate-page").append(tmp);
            }
            if(num) 
                $("#backend #view-status .separate-page").append(last); 


        },


        updateStatusPageStatus : function (idx) //刷新分页状态
        {
            
            $("#backend #view-status .separate-page").children().eq(status_now_page).removeClass("active");
            status_now_page = idx;
            $("#backend #view-status .separate-page").children().eq(status_now_page).addClass("active");
            if(status_now_page === 1)
                $("#backend #view-status .separate-page").children().eq(0).addClass("disabled");
            else
                $("#backend #view-status .separate-page").children().eq(0).removeClass("disabled");

            if(status_now_page === status_total_page)
                $("#backend #view-status .separate-page").children().eq(status_total_page+1).addClass("disabled");
            else
                $("#backend #view-status .separate-page").children().eq(status_total_page+1).removeClass("disabled");

        },


        reloadStatusTable : function () //刷新table
        {


            data = "skip=" + (status_now_page-1)*status_item_per_page + "&num=" + status_item_per_page;

            if(arguments[0])
            {
                var pattern = /^(.*)@(.*)$/;
                var buf = pattern.exec(arguments[0]);   
                if(buf[1])
                    data += "&username=" + encodeURIComponent(buf[1]);

                if(buf[2])
                    data += "&problem_id=" + encodeURIComponent(buf[2]);

            }

            $.post("http://" + window.location.host + "/index.php?controller=server&action=getSubmit",data, function(json)
            {


                $("#backend #view-status .status-table tbody").html('');
                var num = json.length;

                for(var i = 0;i < num;++i)
                {
                    var hosts = "http://"+ window.location.host+"/index.php?";
                    var tmp = $("#backend #view-status .template .table-item .table-row").clone(true);
                    tmp.children("td.run-id").children("a").text(json[i].run_id);
                    tmp.children("td.run-id").children("a").attr("href",hosts+"controller=showcode&run_id="+json[i].run_id ); 

                    tmp.children("td.problem-id").children("a").text(json[i].problem_id);
                    tmp.children("td.problem-id").children("a").attr("href",hosts+"controller=problem&problem_id="+json[i].problem_id ); 

                    tmp.children("td.username").children("a").text(json[i].username);
                    tmp.children("td.username").children("a").attr("href",hosts+"controller=viewprofile&username="+json[i].username );

//                    if(json[i].result == 'Compile Error')
//                    {
//                        tmp.children("td.result").html('<a href="' + hosts+"controller=showcode&run_id="+json[i].run_id +'">'+json[i].result +'</a>')
//                    }
//                    else
//                        tmp.children("td.result").text(json[i].result);
                    
                    tmp.children("td.result").children("a").text(json[i].result);
                    tmp.children("td.result").children("a").attr("value",json[i].run_id);
                    
                    tmp.children("td.language").text(json[i].language);

                    if(json[i].result === 'Accepted')
                    {
                        tmp.children("td.time").text(json[i].time + ' ms');
                        tmp.children("td.memory").text(json[i].memory + ' KB');
                    }
                    else
                    {
                        tmp.children("td.time").text('--');
                        tmp.children("td.memory").text('--');
                    }

                    tmp.children("td.length").text(json[i].length + ' B');
                    tmp.children("td.submit-time").text(convertDate(json[i].submit_time));

                     $("#backend #view-status .status-table tbody").append(tmp);  
                } 
                
                
                
            },"json"); 
        },

        searchStatusSubmit : function () //搜缩框事件
        {

            var a = $("#backend #view-status #username-search").val();
            var b = $("#backend #view-status #problem-search").val();
            a = trim(a);
            b = trim(b);
            if(a != '' || b != '')
            {
                this.startStatusPage(a+'@'+b);

            }
            else
                this.startStatusPage();
        },
        
        updateStatusSubmit : function () //搜缩框分页更新
        {

            var a = $("#backend #view-status #username-search").val();
            var b = $("#backend #view-status #problem-search").val();
            a = trim(a);
            b = trim(b);
            if(a != '' || b != '')
            {
                this.reloadStatusTable(a+'@'+b);

            }
            else
                this.reloadStatusTable();
        },


        changeStatusPage : function (idx) //分页跳转
        {

            if(idx === status_now_page) return;
            this.updateStatusPageStatus(idx);
            this.updateStatusSubmit();
        },
        nextStatusPage : function () //下一页
        { 
            var idx;
            if(status_now_page === status_total_page)
                return;
            else    
                idx = status_now_page+1;
            this.updateStatusPageStatus(idx);
            this.updateStatusSubmit();
        },
        prevStatusPage : function () //上一页
        {
            var idx;
            if(status_now_page === 1)
                return;
            else   
                idx = status_now_page-1;
            this.updateStatusPageStatus(idx);
            this.updateStatusSubmit();
        },

    };
    
};


var decorateStatus = function() {
    var instance = null;
    return function() {
        if(instance === null) {
            instance = createStatus();
        }
        return instance;
    };
};

var getStatus = decorateStatus();



var createProblemList = function () {

    /*..................................*/
    var problemlist_now_page = 1;
    var problemlist_item_per_page = 10;
    var problemlist_total_page;
    /*................PROBLEMLIST...................*/

    return {
        
        startProblemListPage : function () {//JS刷新problemlist页面，包括table和分页
            
            var data = '';
            var tmp = '';
            var that = this;
            if(arguments[0]) {
                data = "addition=" + encodeURIComponent(arguments[0]);
                tmp = arguments[0];
            }
            
            $.post("http://" + window.location.host + "/index.php?app=admin&controller=backend&action=getTotalProblemNum",data, function(json) {
                var item = json;
                var num = Math.ceil(item/problemlist_item_per_page);
                problemlist_total_page = num;
                problemlist_now_page = 1;
                that.updateProblemListPage();

                if(tmp)
                    that.reloadProblemListTable(tmp);
                else
                    that.reloadProblemListTable();
                
                
            });

        },
        


        updateProblemListPage : function () { //刷新分页

            var num = problemlist_total_page;
            
            $("#backend #view-problem .separate-page").html('');
           var first = $("#backend #view-problem  .template .page-nav .first").clone(true);
            if(problemlist_now_page === 1)
                first.addClass("disabled");
            var last = $("#backend #view-problem  .template .page-nav .last").clone(true);
            if(problemlist_now_page === num)
                last.addClass("disabled");

            if(num)
                $("#backend #view-problem  .separate-page").append(first);

            for(var i = 1;i <= num;++i) {
                var tmp = $("#backend #view-problem  .template .page-nav .common").clone(true);
                tmp.children("a").text(i);
                tmp.children("a").attr("onclick","getProblemList().changeProblemListPage(" + i + ")");
                if(i === problemlist_now_page)
                {
                    tmp.addClass("active");
                }
                $("#backend #view-problem  .separate-page").append(tmp);
            }
            if(num)
                $("#backend #view-problem  .separate-page").append(last); 


        },

        updateProblemListPageStatus : function (idx) { //刷新分页状态
            $("#backend #view-problem .separate-page").children().eq(problemlist_now_page).removeClass("active");
            problemlist_now_page = idx;
            
            $("#backend #view-problem  .separate-page").children().eq(problemlist_now_page).addClass("active");
            if(problemlist_now_page === 1)
                $("#backend #view-problem .separate-page").children().eq(0).addClass("disabled");
            else
                $("#backend #view-problem  .separate-page").children().eq(0).removeClass("disabled");

            if(problemlist_now_page === problemlist_total_page)
                $("#backend #view-problem  .separate-page").children().eq(problemlist_total_page+1).addClass("disabled");
            else
                $("#backend #view-problem  .separate-page").children().eq(problemlist_total_page+1).removeClass("disabled");

        },
        
        changeProblemVisible : function(target)
        {
            var that = this;
          //  $(".wait-info").show();
            var problem_id = target.getAttribute('name');
            var visible = target.getAttribute('value');
       
            var data = "problem_id=" + problem_id + "&visible=" + visible;
            $.post("http://" + window.location.host + "/index.php?app=admin&controller=backend&action=changeProblemVisible",data, function(json) {
                var flag = json.flag;
                if(!flag)
                {
                    alert("Change Failed");
                    that.updateProblemListSubmit();
                }
                $(".wait-info").hide();
            },'json');
        },

        /*
        还需完成:
        flag --- 过题 没过 没做
        AC --- 数量
        Total --- 数量
        */
        reloadProblemListTable : function () { //刷新table
            
            var that = this;
        //    $(".wait-info").show();
            $("#backend #view-problem  .problem-table tbody").html('');
            data = "skip=" + (problemlist_now_page-1)*problemlist_item_per_page + "&num=" + problemlist_item_per_page;

            if(arguments[0]) {

                var input = trim(arguments[0]);
                data += "&addition=" + encodeURIComponent(input);
            }

            $.post("http://" + window.location.host + "/index.php?app=admin&controller=backend&action=getProblem",data, function(json) {
                var num = json.length;

                for(var i = 0;i < num;++i) {
                    var hosts = "http://"+ location.host+"/index.php?controller=problem&problem_id=" + json[i]["problem_id"];
                    var tmp = $("#backend #view-problem .template .table-item .table-row").clone(true);
                    if(json[i].flag)
                        tmp.children("td.flag").css("color","green");
                    tmp.children("td.id").children("a").text(json[i]["problem_id"]);
                    tmp.children("td.id").children("a").attr("href",hosts);
                    tmp.children("td.title").children("a").text(json[i]["title"]);
                    tmp.children("td.title").children("a").attr("href",hosts);
                    tmp.children("td.source").children("a").text(json[i]["source"]);
                    tmp.children("td.visible").find("input[type=radio]").attr('name',json[i]["problem_id"]);
                    tmp.children("td.visible").find("input[value=" +json[i]["visible"] +"]").prop('checked',true);;
                    tmp.children("td.visible").find("input[value=" +json[i]["visible"] +"]").parent().addClass("active");
                    tmp.children("td.visible").find("input[type=radio]").change(function(event){
                        that.changeProblemVisible(event.target);
                    });
                    
                    
                     $("#backend #view-problem  .problem-table tbody").append(tmp); 
                } 
            //    $(".wait-info").hide();
            },"json");
        },

        searchProblemListProblem : function () { //搜缩框事件
            var input = $("#backend #view-problem  .navbar-form input").val();
            this.startProblemListPage(input);
        },
        
        updateProblemListSubmit : function () //搜缩框分页更新
        {

            var input = $("#backend #view-problem  .navbar-form input").val();
            if(input != '')
                this.reloadProblemListTable(input);
            else
                this.reloadProblemListTable();
        },

        

        changeProblemListPage : function (idx) {  //分页跳转
            if(idx === problemlist_now_page) return;
            this.updateProblemListPageStatus(idx);
            this.updateProblemListSubmit();
        },
        nextProblemListPage : function () { //下一页
            
            var idx;
            if(problemlist_now_page === problemlist_total_page)
                return;
            else    
                idx = problemlist_now_page+1;
            this.updateProblemListPageStatus(idx);
            this.updateProblemListSubmit();
            
            
        },
        prevProblemListPage : function () {  //上一页
            
            var idx;
            if(problemlist_now_page === 1)
                return;
            else   
                idx = problemlist_now_page-1;
            
            this.updateProblemListPageStatus(idx);
            this.updateProblemListSubmit();
        },
        

    };   

};

var decorateProblemList = function () {
    var instance = null;
    return function() {
        if(instance === null) {
            instance = createProblemList();
        }
       return instance;
    };
};

var getProblemList = decorateProblemList();



//////////////////////////////////////////////////////////////

var createBackend = function () {

    /*..................................*/
    var choosed_problem_id = 0;
    /*................BACKEND...................*/

    return {
        addProblemSubmit : function () //JS刷新Status页面，包括table和分页
        {
            if(!$("#backend #add-problem-form").valid()) return;
            
            $("#backend #add-problem-form .submit").button('loading');
            
            var form_data = new FormData($("#backend #add-problem-form")[0]);
            var url = "http://" + window.location.host + "/index.php?app=admin&controller=backend&action=addProblem";
            $.ajax({
                url : url,
                type : 'POST',
                data : form_data,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(json) {
                    $("#backend #add-problem-form .submit").button('reset');
                    var flag = json.flag;
                    if(!flag)
                    {
                        alert(flag);
                    }
                    else
                    {
                        $("#backend #view-problem-tab").tab('show');
                    }
                },
                error : function(json) {
                    alert('Submit Wrong');
                }
                
            });

        },
        
        editProblemSubmit : function()
        {
            if(!$("#backend #edit-problem-form").valid()) return;
            
            $("#backend #edit-problem-form .submit").button('loading');
            
            var form_data = new FormData($("#backend #edit-problem-form")[0]);
            form_data.append('problem_id',choosed_problem_id);
            var url = "http://" + window.location.host + "/index.php?app=admin&controller=backend&action=editProblem";
            $.ajax({
                url : url,
                type : 'POST',
                data : form_data,
                dataType : 'json',
                processData : false,
                contentType : false,
                success : function(json) {
                    $("#backend #edit-problem-form .submit").button('reset');
                    var flag = json.flag;
                    if(!flag)
                    {
                        alert(json.info);
                    }
                    else
                    {
                        $("#backend #view-problem-tab").tab('show');
                    }
                },
                error : function(json) {
                    alert('Submit Wrong');
                }
                
            });
        },
        
        editIn : function()
        {
            $("#backend #edit-problem .choose-problem").hide(); 
            $("#backend #edit-problem #edit-problem-form").show(); 
        },
        
        editOut : function()
        {
            $("#backend #edit-problem .choose-problem").show(); 
            $("#backend #edit-problem #edit-problem-form").hide(); 
            
        },
        
        loadProblem : function() 
        {
            var that = this;
            var problem_id = $("#backend #edit-problem .choose-problem input").val();
            var data = "problem_id="+encodeURIComponent(problem_id);
            
            $.post("http://" + window.location.host + "/index.php?app=admin&controller=backend&action=loadProblem",data, function(json)
            {
                var flag = json.flag;
                if(flag)
                {
                    var arr = json.info;
                    choosed_problem_id = problem_id;
                    $("#backend #edit-problem-form .title").val(arr.title);
                    $("#backend #edit-problem-form .time-limit").val(arr.time_limit);
                    $("#backend #edit-problem-form .memory-limit").val(arr.memory_limit);
                    $("#backend #edit-problem-form .description").val(arr.description);
                    $("#backend #edit-problem-form .input").val(arr.input);
                    $("#backend #edit-problem-form .output").val(arr.output);
                    $("#backend #edit-problem-form .sample-input").val(arr.sample_input);
                    $("#backend #edit-problem-form .sample-output").val(arr.sample_output);
                    $("#backend #edit-problem-form .hint").val(arr.hint);
                    $("#backend #edit-problem-form .source").val(arr.source);
                    
                    if(arr.visible == 1)
                        $("#backend #edit-problem-form .visible").prop("checked",true);
                    else
                        $("#backend #edit-problem-form .visible").prop("checked",false);
                        
                    that.editIn();
                }
                else
                {
                    alert(json.info);            
                }
            },"json");
            
        },
  


    };
    
};


var decorateBackend = function() {
    var instance = null;
    return function() {
        if(instance === null) {
            instance = createBackend();
        }
        return instance;
    };
};

var getBackend = decorateBackend();
 $("#backend #view-problem-tab").tab('show');

$(document).ready(function(){
    getProblemList().startProblemListPage();
    getStatus().startStatusPage(); 
    $("#backend #view-problem-tab").on('show.bs.tab',function(e){
        getProblemList().startProblemListPage();
    });
    $("#backend #view-status-tab").on('show.bs.tab',function(e){
        getStatus().startStatusPage(); 
    });
    
});
