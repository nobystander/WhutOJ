

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
                    data = "username=" + buf[1] + "&problem_id=" + buf[2];
                else if(buf[1])
                    data = "username=" + buf[1];
                else if(buf[2])
                    data = "problem_id=" + buf[2];

            }
            $.post("http://localhost/index.php?controller=server&action=getTotalSubmitNum",data, function(json)
            {
                item = json;
                alert(json);
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


        updateStatusPage : function () //刷新分页
        {
            
            var num = status_total_page;
            
            $("#status-list .separate-page").html('');
           var first = $("#status-list .template .page-nav .first").clone(true);
            if(status_now_page === 1)
                first.addClass("disabled");
            var last = $("#status-list .template .page-nav .last").clone(true);
            if(status_now_page === num)
                last.addClass("disabled");
            
            if(num) 
                $("#status-list .separate-page").append(first);

            for(var i = 1;i <= num;++i)
            {
                var tmp = $("#status-list .template .page-nav .common").clone(true);
                tmp.children("a").text(i);
                tmp.children("a").attr("onclick","getStatus().changeStatusPage(" + i + ")");
                if(i === status_now_page)
                {
                    tmp.addClass("active");
                }
                $("#status-list .separate-page").append(tmp);
            }
            if(num) 
                $("#status-list .separate-page").append(last); 


        },


        updateStatusPageStatus : function (idx) //刷新分页状态
        {
            
            $("#status-list .separate-page").children().eq(status_now_page).removeClass("active");
            status_now_page = idx;
            $("#status-list .separate-page").children().eq(status_now_page).addClass("active");
            if(status_now_page === 1)
                $("#status-list .separate-page").children().eq(0).addClass("disabled");
            else
                $("#status-list .separate-page").children().eq(0).removeClass("disabled");

            if(status_now_page === status_total_page)
                $("#status-list .separate-page").children().eq(status_total_page+1).addClass("disabled");
            else
                $("#status-list .separate-page").children().eq(status_total_page+1).removeClass("disabled");

        },


        reloadStatusTable : function () //刷新table
        {


            data = "skip=" + (status_now_page-1)*status_item_per_page + "&num=" + status_item_per_page;

            if(arguments[0])
            {
                var pattern = /^(.*)@(.*)$/;
                var buf = pattern.exec(arguments[0]);   
                if(buf[1])
                    data += "&username=" + buf[1];

                if(buf[2])
                    data += "&problem_id=" + buf[2];

            }

            $.post("http://localhost/index.php?controller=server&action=getSubmit",data, function(json)
            {


                $("#status-list .status-table tbody").html('');
                var num = json.length;

                for(var i = 0;i < num;++i)
                {
                    var hosts = "http://"+ location.host+"/index.php?";
                    var tmp = $("#status-list .template .table-item .table-row").clone(true);
                    tmp.children("td.run-id").children("a").text(json[i].run_id);
                    tmp.children("td.run-id").children("a").attr("href","#" ); //这里连接到查看代码界面

                    tmp.children("td.problem-id").children("a").text(json[i].problem_id);
                    tmp.children("td.problem-id").children("a").attr("href",hosts+"controller=problem&problem_id="+json[i].problem_id ); //这里连接到查看代码界面

                    tmp.children("td.username").children("a").text(json[i].username);
                    tmp.children("td.username").children("a").attr("href","#" ); //这里连接到查看用户界面

                    tmp.children("td.result").text(json[i].result);
                    tmp.children("td.language").text(json[i].language);

                    if(json.result === 'Accepted')
                    {
                        tmp.children("td.time").text(json[i].time + ' ms');
                        tmp.children("td.memory").text(json[i].memory + ' KB');
                    }

                  //  tmp.children("td.length").text(json[i].length + ' B');
                //    tmp.children("td.submit-time").text(convertDate(json[i].submit_time));

                     $("#status-list .status-table tbody").append(tmp);  
                }  
            },"json"); 
        },

        searchStatusSubmit : function () //搜缩框事件
        {

            var a = $("#status-list #username-search").val();
            var b = $("#status-list #problem-search").val();
            a = trim(a);
            b = trim(b);
            if(a != '' || b != '')
            {
                this.startStatusPage(a+'@'+b);

            }
            else
                this.startStatusPage();
        },


        changeStatusPage : function (idx) //分页跳转
        {

            if(idx === status_now_page) return;
            this.updateStatusPageStatus(idx);
            this.reloadStatusTable();
        },
        nextStatusPage : function () //下一页
        { 
            var idx;
            if(status_now_page === status_total_page)
                return;
            else    
                idx = status_now_page+1;
            this.updateStatusPageStatus(idx);
            this.reloadStatusTable();
        },
        prevStatusPage : function () //上一页
        {
            var idx;
            if(status_now_page === 1)
                return;
            else   
                idx = status_now_page-1;
            this.updateStatusPageStatus(idx);
            this.reloadStatusTable();
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

$(document).ready(function(){
    getStatus().startStatusPage(); 
});