var createProfile = function() {
    
    return {
        
        save : function(){
			var username = $("#username").text();
            var school = $("#school").val();
            var email = $("#email").val();
			var old_password = $("#old_password").val();
            var new_password = $("#new_password").val();
            var re_password = $("#re_password").val();


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

			if(old_password == '')
			{
                $(".profile-info#old_password").text('密码不能为空');
                $(".profile-info#old_password").show();
                $("#profile-save").button('reset');
				return;
			}

            if(new_password != '' && !checkPassword(new_password)) {
                $(".profile-info#new_password").text('密码格式错误');
                $(".profile-info#new_password").show();
                $("#profile-save").button('reset');
                return;       
            }

            if(new_password != '' && new_password !== re_password) {
                $(".profile-info#re_password").text('2次密码输入不一致');
                $(".profile-info#re_password").show();
                $("#profile-save").button('reset');
                return;       
            }

			if(new_password == '') new_password = old_password;

            $(".profile-info").hide();

            var data = "username=" + username + "&password=" + old_password;
            
			$.post("/index.php?controller=server&action=logIn", data, function(json) {
				var flag = json.flag;
				if(flag === 'false') {
					$(".profile-info#old_password").text("密码错误");
					$(".profile-info#old_password").show();
				}
				else {
					$(".profile-info").hide();
					data = "username=" + username + "&password=" + new_password + "&school=" + school + "&email=" + email;
					
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
					},"json");
				}
				$("#profile-save").button('reset');
			},"json");
        },

        reset : function(){
            $("#school").val("");
            $("#email").val("");
            $("#old_password").val("");
            $("#new_password").val("");
            $("#re_password").val("");
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

