

var createRank = function() {
    /*..................................*/
    var rank_now_page = 1;
    var rank_item_per_page = 20;
    var rank_total_page;
    /*................STATUSLIST...................*/

    return {
        startRankPage : function () //JS刷新Rank页面，包括table和分页
        {
            var data = '';
            var tmp = '';
            var that = this;
            if(arguments[0])
            {
                tmp = arguments[0];
                data = "username=" + arguments[0];
            }

            $.post("http://" + window.location.host + "/index.php?controller=server&action=getTotalUserNum",data, function(json)
            {
                item = json;
                //alert(json);
               var num = Math.ceil(item/rank_item_per_page);
                rank_total_page = num;
                rank_now_page = 1;
                
                that.updateRankPage();
                if(tmp)
                    that.reloadRankTable(tmp);
                else
                    that.reloadRankTable();  
            });

        },


        updateRankPage : function () //刷新分页
        {
            
            var num = rank_total_page;
            
            $("#rank-list .separate-page").html('');
           var first = $("#rank-list .template .page-nav .first").clone(true);
            if(rank_now_page === 1)
                first.addClass("disabled");
            var last = $("#rank-list .template .page-nav .last").clone(true);
            if(rank_now_page === num)
                last.addClass("disabled");
            
            if(num) 
                $("#rank-list .separate-page").append(first);

            for(var i = 1;i <= num;++i)
            {
                var tmp = $("#rank-list .template .page-nav .common").clone(true);
                tmp.children("a").text(i);
                tmp.children("a").attr("onclick","getRank().changeRankPage(" + i + ")");
                if(i === rank_now_page)
                {
                    tmp.addClass("active");
                }
                $("#rank-list .separate-page").append(tmp);
            }
            if(num) 
                $("#rank-list .separate-page").append(last); 


        },


        updateRankPageRank : function (idx) //刷新分页状态
        {
            
            $("#rank-list .separate-page").children().eq(rank_now_page).removeClass("active");
            rank_now_page = idx;
            $("#rank-list .separate-page").children().eq(rank_now_page).addClass("active");
            if(rank_now_page === 1)
                $("#rank-list .separate-page").children().eq(0).addClass("disabled");
            else
                $("#rank-list .separate-page").children().eq(0).removeClass("disabled");

            if(rank_now_page === rank_total_page)
                $("#rank-list .separate-page").children().eq(rank_total_page+1).addClass("disabled");
            else
                $("#rank-list .separate-page").children().eq(rank_total_page+1).removeClass("disabled");

        },


        reloadRankTable : function () //刷新table
        {


            data = "skip=" + (rank_now_page-1)*rank_item_per_page + "&num=" + rank_item_per_page;

            if(arguments[0])
            {
                data += "&username=" + arguments[0];
            }

            $.post("http://" + window.location.host + "/index.php?controller=server&action=getRank",data, function(json)
            {

                
                $("#rank-list .rank-table tbody").html('');
                var num = json.length;
               // alert(num);
                for(var i = 0;i < num;++i)
                {
                    var hosts = "http://"+ window.location.host+"/index.php?";
                    var tmp = $("#rank-list .template .table-item .table-row").clone(true);
                    
                    tmp.children("td.rank").text(json[i].rank);

                    tmp.children("td.username").children("a").text(json[i].username);
                    tmp.children("td.username").children("a").attr("href",hosts+"controller=viewprofile&username="+json[i].username); 
                    
                    tmp.children("td.description").text(json[i].description);
                    tmp.children("td.solved").text(json[i].cnt);
                    tmp.children("td.submitted").text(json[i].submitted);

     
                     $("#rank-list .rank-table tbody").append(tmp);  
                }  
            },"json");  
        },

        searchRankSubmit : function () //搜缩框事件
        {

            var a = $("#rank-list #username-search").val();
            //var b = $("#rank-list #problem-search").val();
            a = trim(a);
            //b = trim(b);
            if(a != '')
            {
                this.startRankPage(a);

            }
            else
                this.startRankPage();
        },


        changeRankPage : function (idx) //分页跳转
        {

            if(idx === rank_now_page) return;
            this.updateRankPageRank(idx);
            this.reloadRankTable();
        },
        nextRankPage : function () //下一页
        { 
            var idx;
            if(rank_now_page === rank_total_page)
                return;
            else    
                idx = rank_now_page+1;
            this.updateRankPageRank(idx);
            this.reloadRankTable();
        },
        prevRankPage : function () //上一页
        {
            var idx;
            if(rank_now_page === 1)
                return;
            else   
                idx = rank_now_page-1;
            this.updateRankPageRank(idx);
            this.reloadRankTable();
        },

    };
    
};


var decorateRank = function() {
    var instance = null;
    return function() {
        if(instance === null) {
            instance = createRank();
        }
        return instance;
    };
};

var getRank = decorateRank();

$(document).ready(function(){
    getRank().startRankPage(); 
});