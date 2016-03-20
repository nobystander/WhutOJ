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
           
            var data = "problem_id=" + encodeURIComponent(pid) + "&language=" + encodeURIComponent(language) + "&sourcecode=" + encodeURIComponent(sourcecode);
            
            $.post("http://" + window.location.host + "/index.php?controller=server&action=submit",data,function(json){
                
                var flag = json.flag;
                //console.log(flag);
                if(flag === 'false'){
                    alert('Submit Failed!');
                }
                else {
                  //  alert('OK');
                   window.location.href = "http://" + window.location.host + "/index.php?controller=status"; 
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