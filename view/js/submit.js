var createSubmit = function() {
    
    return {
        
        submit : function(){
            
            var pid = $("#pid").val();
            var language = $("#language").val();
            var sourcecode = $("#sourcecode").val();

            if(sourcecode.length === 0){
               alert('Source Code Cound not be empty!');     
               return;
            }
           
            var data = "pid=" + pid + "&language=" + language + "&sourcecode=" + sourcecode;
            $.post("/index.php?controller=server&action=submit",data,function(json){
                var flag = json.flag;
                if(flag === 'false'){
                    alert('Submit Failed!');
                }
                else {
                   location.replace("/index.php?controller=status"); 
                }
            },"json"); 
        }
    }
};

var decorateSubmit = function(){
    var instance = null;
    return function(){
       if(instance === null) {
              instance = createSubmit(); 
       }
       return instance;
    };
};

var getSubmit = decorateSubmit();
