
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
                data = "addition=" + arguments[0];
                tmp = arguments[0];
            }
            $.post("http://localhost/index.php?controller=server&action=getTotalProblemNum",data, function(json) {
                var item = json;
               // alert(item);
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
            
            $("#problem-list .separate-page").html('');
           var first = $("#problem-list .template .page-nav .first").clone(true);
            if(problemlist_now_page === 1)
                first.addClass("disabled");
            var last = $("#problem-list .template .page-nav .last").clone(true);
            if(problemlist_now_page === num)
                last.addClass("disabled");

            if(num)
                $("#problem-list .separate-page").append(first);

            for(var i = 1;i <= num;++i) {
                var tmp = $("#problem-list .template .page-nav .common").clone(true);
                tmp.children("a").text(i);
                tmp.children("a").attr("onclick","getProblemList().changeProblemListPage(" + i + ")");
                if(i === problemlist_now_page)
                {
                    tmp.addClass("active");
                }
                $("#problem-list .separate-page").append(tmp);
            }
            if(num)
                $("#problem-list .separate-page").append(last); 


        },

        updateProblemListPageStatus : function (idx) { //刷新分页状态
            $("#problem-list .separate-page").children().eq(problemlist_now_page).removeClass("active");
            problemlist_now_page = idx;
            
            $("#problem-list .separate-page").children().eq(problemlist_now_page).addClass("active");
            if(problemlist_now_page === 1)
                $("#problem-list .separate-page").children().eq(0).addClass("disabled");
            else
                $("#problem-list .separate-page").children().eq(0).removeClass("disabled");

            if(problemlist_now_page === problemlist_total_page)
                $("#problem-list .separate-page").children().eq(problemlist_total_page+1).addClass("disabled");
            else
                $("#problem-list .separate-page").children().eq(problemlist_total_page+1).removeClass("disabled");

        },

        /*
        还需完成:
        flag --- 过题 没过 没做
        AC --- 数量
        Total --- 数量
        */
        reloadProblemListTable : function () { //刷新table
            
            
            $(".wait-info").show();
            $("#problem-list .problem-table tbody").html('');
            data = "skip=" + (problemlist_now_page-1)*problemlist_item_per_page + "&num=" + problemlist_item_per_page;

            if(arguments[0]) {

                var input = trim(arguments[0]);
                data += "&addition=" + input;
            }

            $.post("http://localhost/index.php?controller=server&action=getProblem",data, function(json) {
                var num = json.length;

                for(var i = 0;i < num;++i) {
                    var hosts = "http://"+ location.host+"/index.php?controller=problem&problem_id=" + json[i]["problem_id"];
                    var tmp = $("#problem-list .template .table-item .table-row").clone(true);
                   // tmp.children("td.flag").css("background-color","green");
                    tmp.children("td.id").children("a").text(json[i]["problem_id"]);
                    tmp.children("td.id").children("a").attr("href",hosts);
                    tmp.children("td.title").children("a").text(json[i]["title"]);
                    tmp.children("td.title").children("a").attr("href",hosts);
                    tmp.children("td.source").children("a").text(json[i]["source"]);
                   // tmp.children("td.ac_num").children("a").text(json[i]["ac_num"]);
                   // tmp.children("td.total_num").children("a").text(json[i]["total_num"]);

                     $("#problem-list .problem-table tbody").append(tmp); 
                } 
                $(".wait-info").hide();
            },"json");
        },

        searchProblemListProblem : function () { //搜缩框事件
            var input = $("#problem-list .navbar-form input").val();
            this.startProblemListPage(input);
        },

        changeProblemListPage : function (idx) {  //分页跳转
            if(idx === problemlist_now_page) return;
            this.updateProblemListPageStatus(idx);
            this.reloadProblemListTable();
        },
        nextProblemListPage : function () { //下一页
            
            var idx;
            if(problemlist_now_page === problemlist_total_page)
                return;
            else    
                idx = problemlist_now_page+1;
            this.updateProblemListPageStatus(idx);
            this.reloadProblemListTable();
            
            
        },
        prevProblemListPage : function () {  //上一页
            
            var idx;
            if(problemlist_now_page === 1)
                return;
            else   
                idx = problemlist_now_page-1;
            
            this.updateProblemListPageStatus(idx);
            this.reloadProblemListTable();
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

$(document).ready(function(){
    getProblemList().startProblemListPage();
});