

var createDiscuss = function() {
    /*..................................*/
    var problem_id;
    var father;
    /*................DISCUSS...................*/

    return {
        
        init : function()
        {
            problem_id = parseInt($("#discuss .discuss-header .problem-id").text());  
            father = 0;
        },
        
        setFather : function(t)
        {
            father = t;
        },
        
        discussSubmit : function()
        {
         
            if(!$("#new-discuss #discuss-input").valid()) return;
            var content = $("#new-discuss #discuss-input .discuss-content").val();
            
            var data = "problem_id=" + encodeURIComponent(problem_id) + "&father=" +
                encodeURIComponent(father) + "&content=" + encodeURIComponent(content);
            
            $("#new-discuss .modal-footer .submit").button('loading');
            
            $.post("http://" + window.location.host + "/index.php?controller=server&action=discussSubmit",data, function(json)
            {
                var flag = json.flag;
                $("#new-discuss .modal-footer .submit").button('reset');
                if(!flag)
                    alert(json.info);
                else
                    location.reload();
            },"json"); 
        },

    };
    
};


var decorateDiscuss = function() {
    var instance = null;
    return function() {
        if(instance === null) {
            instance = createDiscuss();
        }
        return instance;
    };
};

var getDiscuss = decorateDiscuss();

$(document).ready(function(){
    getDiscuss().init(); 
    $("#new-discuss").on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var father = button.data('father');
         getDiscuss().setFather(father);
    });
});