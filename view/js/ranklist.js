
var createRankList = function() {
    /*..................................*/
    var ranklist_now_page = 1;
    var ranklist_item_per_page = 30;
    var ranklist_total_page;

    /*................RANKLIST...................*/

    return {
        startRankListPage : function () //JS刷新RankList页面，包括table和分页
        {
            var data = '';
            var tmp = '';
            var that = this;
            $.post("/index.php?controller=server&action=getTotalUserNum",data, function(json)
            {
                item = json;
               // alert(json);
               var num = Math.ceil(item/ranklist_item_per_page);
                ranklist_total_page = num;
                ranklist_now_page = 1;
                
                that.updateRankListPage();
                if(tmp)
                    that.reloadRankListTable(tmp);
                else
                    that.reloadRankListTable();  
            });

        },


        updateRankListPage : function () //刷新分页
        {
            
            var num = ranklist_total_page;
            
            $("#ranklist-list .separate-page").html('');
           var first = $("#ranklist-list .template .page-nav .first").clone(true);
            if(ranklist_now_page === 1)
                first.addClass("disabled");
            var last = $("#ranklist-list .template .page-nav .last").clone(true);
            if(ranklist_now_page === num)
                last.addClass("disabled");
            
            if(num) 
                $("#ranklist-list .separate-page").append(first);

            for(var i = 1;i <= num;++i)
            {
                var tmp = $("#ranklist-list .template .page-nav .common").clone(true);
                tmp.children("a").text(i);
                tmp.children("a").attr("onclick","getRankList().changeRankListPage(" + i + ")");
                if(i === ranklist_now_page)
                {
                    tmp.addClass("active");
                }
                $("#ranklist-list .separate-page").append(tmp);
            }
            if(num) 
                $("#ranklist-list .separate-page").append(last); 


        },


        updateRankListPageRankList : function (idx) //刷新分页状态
        {
            
            $("#ranklist-list .separate-page").children().eq(ranklist_now_page).removeClass("active");
            ranklist_now_page = idx;
            $("#ranklist-list .separate-page").children().eq(ranklist_now_page).addClass("active");
            if(ranklist_now_page === 1)
                $("#ranklist-list .separate-page").children().eq(0).addClass("disabled");
            else
                $("#ranklist-list .separate-page").children().eq(0).removeClass("disabled");

            if(ranklist_now_page === ranklist_total_page)
                $("#ranklist-list .separate-page").children().eq(ranklist_total_page+1).addClass("disabled");
            else
                $("#ranklist-list .separate-page").children().eq(ranklist_total_page+1).removeClass("disabled");

        },


        reloadRankListTable : function () //刷新table
        {

            data = "skip=" + (ranklist_now_page-1)*ranklist_item_per_page + "&num=" + ranklist_item_per_page;

            $.post("/index.php?controller=server&action=getUser",data, function(json)
            {


                $("#ranklist-list .ranklist-table tbody").html('');
                var num = json.length;

                for(var i = 0;i < num;++i)
                {
                    var hosts = "/index.php?";
                    var tmp = $("#ranklist-list .template .table-item .table-row").clone(true);
                    tmp.children("td.rank").text(json[i].rank);

                    tmp.children("td.username").children("a").text(json[i].username);
                    tmp.children("td.username").children("a").attr("href","#" ); //这里连接到查看用户界面

                    tmp.children("td.school").text(json[i].result);
                    tmp.children("td.solved").text(json[i].language);
                    tmp.children("td.submit").text(json[i].language);
                    tmp.children("td.ratio").text(json[i].language);

                    $("#ranklist-list .ranklist-table tbody").append(tmp);  
                }  
            },"json"); 
        },

        changeRankListPage : function (idx) //分页跳转
        {

            if(idx === ranklist_now_page) return;
            this.updateRankListPageRankList(idx);
            this.reloadRankListTable();
        },
        nextRankListPage : function () //下一页
        { 
            var idx;
            if(ranklist_now_page === ranklist_total_page)
                return;
            else    
                idx = ranklist_now_page+1;
            this.updateRankListPageRankList(idx);
            this.reloadRankListTable();
        },
        prevRankListPage : function () //上一页
        {
            var idx;
            if(ranklist_now_page === 1)
                return;
            else   
                idx = ranklist_now_page-1;
            this.updateRankListPageRankList(idx);
            this.reloadRankListTable();
        },

    };
    
};


var decorateRankList = function() {
    var instance = null;
    return function() {
        if(instance === null) {
            instance = createRankList();
        }
        return instance;
    };
};

var getRankList = decorateRankList();

$(document).ready(function(){
    getRankList().startRankListPage(); 
});

