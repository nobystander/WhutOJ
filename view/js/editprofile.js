var createProfile = function() {

	return {

		save : function(){
			var username = $("#username").text();
			var school = $("#school").val();
			var email = $("#email").val();
			var description = $("#description").val();


			$("#profile-save").button('loading');


			if(!checkText(school)) {
				$(".profile-info#school").text('学校输入包含非法字符');
				$(".profile-info#school").show();
				$("#profile-save").button('reset');
				return;
			}

			if(!checkEmail(email)) {
				$(".profile-info#mail").text('邮箱格式错误');
				$(".profile-info#mail").show();
				$("#profile-save").button('reset');
				return;
			}

			$(".profile-info").hide();
			var data = "username=" + username + "&school=" + school + "&email=" + email + "&description=" + description;
			$.post("/index.php?controller=server&action=changeProfile", data, function(json) {
				var flag = json.flag;
				if(flag === 'true'){
					alert('修改成功');
					location.reload();
				}	
				else
				{
					alert(json.info);
				}
				$("#profile-save").button('reset');
			},"json");
		},

        reset : function(){
            $("#school").val("");
            $("#email").val("");
            $("#description").val("");
        }
    }
};

var decorateProfile = function(){
    var instance = null;
    return function(){
       if(instance === null) {
              instance = createProfile(); 
       }
       return instance;
    };
};

var getProfile = decorateProfile();

