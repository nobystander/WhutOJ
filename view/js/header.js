
var createHeader = function(){
    /*.............HEADER........................*/

    var setMinUserName = 8;
    var setMaxUserName = 16;
    var setMinPassword = 8;
    var setMaxPassword = 12;
    // warning!! If you change here , u need to change in lib_standard too

    /*.................................*/
    return {

        logOut : function () {
            $.post(" /index.php?controller=server&action=logOut",'', function(json) 
            {
                location.reload();
            });
        },


        login : function() {
            
             var username = $("#login-username").val();
            var password = $("#login-password").val();
            var flag = true;

            $("#loginModal .submit").button('loading');
            if(!checkUsername(username)) {
                $("#loginModal .login-info").text('用户名格式错误');
                $("#loginModal .login-info").show();
                $("#loginModal .submit").button('reset');
                return;
            }
            if(!checkPassword(password)) {
                $("#loginModal .login-info").text('密码格式错误');
                $("#loginModal .login-info").show();
                $("#loginModal .submit").button('reset');
                return;       
            }

            $("#loginModal .login-info").hide();


            var data = "username=" + username + "&password=" + password;
            $.post(" /index.php?controller=server&action=logIn", data, function(json)         {
               var flag = json.flag;
               if(flag === 'false') {
                    $("#loginModal .login-info").text(json.info);
                    $("#loginModal .login-info").show();
                }
                else {
                    $("#loginModal .login-info").hide();
                    location.reload();
                }
                $("#loginModal .submit").button('reset');

            },"json");

        },

        signup : function() {
            var username =  $("#signup-username").val();
            var password =  $("#signup-password").val();
            var repassword =  $("#signup-re-password").val();
            var email =  $("#signup-email").val();
            var school =  $("#signup-school").val();
            $("#signupModal .submit").button('loading');


            if(!checkUsername(username)) {
                $("#signupModal .signup-info").text('用户名格式错误');
                $("#signupModal .signup-info").show();
                $("#signupModal .submit").button('reset');
                return;
            }
            if(!checkPassword(password)) {
                $("#signupModal .signup-info").text('密码格式错误');
                $("#signupModal .signup-info").show();
                $("#signupModal .submit").button('reset');
                return;       
            }
            if(password !== repassword) {
                $("#signupModal .signup-info").text('2次密码输入不一致');
                $("#signupModal .signup-info").show();
                $("#signupModal .submit").button('reset');
                return;       
            }
            if(!checkEmail(email)) {
                $("#signupModal .signup-info").text('邮箱格式错误');
                $("#signupModal .signup-info").show();
                $("#signupModal .submit").button('reset');
                return;
            }
            if(!checkText(school)) {
                $("#signupModal .signup-info").text('学校输入包含非法字符');
                $("#signupModal .signup-info").show();
                $("#signupModal .submit").button('reset');
                return;
            }
            $("#signupModal .signup-info").hide();

            var data = "username=" + username + "&password=" + password + 
                    "&email=" + email + "&school=" + school;
			alert('233');
            
            $.post(" /index.php?controller=server&action=signUp", data, function(json) {
               var flag = json.flag;
               if(flag === 'false') {
                    $("#signupModal .signup-info").text(json.info);
                    $("#signupModal .signup-info").show();
                }
                else {
                    $("#loginModal .login-info").hide();
                    location.reload();
                }
                $("#signupModal .submit").button('reset');

            },"json");
        },
    };

};


var decorateHeader = function () {
    var instance = null;
    return function() {
        if(instance === null) {
            
            instance = createHeader();
        }
       return instance;
    };
};

var getHeader = decorateHeader();
