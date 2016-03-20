
var createProfile = function(){
    /*.............HEADER........................*/

    var usernameBak = "";
    var schoolBak = "";
    var emailBak = "";
    var descriptionBak = "";
    // warning!! If you change here , u need to change in lib_standard too

    /*.................................*/
    return {

        init : function () {
            usernameBak = $("#view-username").val();
            schoolBak = $("#view-school").val();
            emailBak = $("#view-email").val();
            descriptionBak = $("#view-description").val();
        },
        
        editIn : function () {
            $("#view-username").attr("disabled",true);
            $("#view-school").removeAttr("disabled");
            $("#view-email").removeAttr("disabled");
            $("#view-description").removeAttr("disabled");
            $("#viewprofile .edit-button").html('\
                        <button type="button" class="btn btn-default" onclick="getProfile().editOut()">Cancel</button>  \
                        <button type="button" class="btn btn-primary save" onclick="getProfile().save()" data-loading-text="Loading..." autocomplete="off" >Save</button>  \
                        <div class="modal-error save-info"  style="display:none"></div>');
        },
        
        editOut : function() {
            $("#view-username").val(usernameBak);
            $("#view-school").val(schoolBak);
            $("#view-email").val(emailBak);
            $("#view-description").val(descriptionBak);
            $("#view-username").attr("disabled",true);
            $("#view-school").attr("disabled",true);
            $("#view-email").attr("disabled",true);
            $("#view-description").attr("disabled",true);
            
            $("#viewprofile .edit-button").html('<button type="button" class="btn btn-primary" onclick="getProfile().editIn()">Edit</button>');
        },
        

        save : function() {
            
            var username = $("#view-username").val();
            var school = $("#view-school").val();
            var email = $("#view-email").val();
            var description = $("#view-description").val();
            $("#viewprofile .save").button('loading');


            if(username != usernameBak) {
                alert("OK");
                $("#viewprofile .save-info").text('非法操作');
                $("#viewprofile .save-info").show();
                $("#viewprofile .save").button('reset');
                return;
            }
            if(!checkSchool(school)) {
                $("#viewprofile .save-info").text('学校输入包含非法字符');
                $("#viewprofile .save-info").show();
                $("#viewprofile .save").button('reset');
                return;
            }
            if(!checkEmail(email)) {
                alert("OK");
                $("#viewprofile .save-info").text('邮箱格式错误');
                $("#viewprofile .save-info").show();
                $("#viewprofile .save").button('reset');
                return;
            }
            if(!checkText(description)) {
                $("#viewprofile .save-info").text('描述输入包含非法字符');
                $("#viewprofile .save-info").show();
                $("#viewprofile .save").button('reset');
                return;
            }
            
            $("#viewprofile .save-info").hide();
            
            
            var data = "username=" + encodeURIComponent(username) + "&school=" + encodeURIComponent(school) + 
                    "&email=" + encodeURIComponent(email) + "&description=" + encodeURIComponent(description);
            
           // alert(encodeURIComponent(description));
            $.post("http://" + window.location.host + "/index.php?controller=server&action=editProfile", data, function(json) {
               var flag = json.flag;
               // alert(flag);
               if(flag === 'false') {
                    $("#viewprofile .save-info").text(json.info);
                    $("#viewprofile .save-info").show();
                }
                else {
                    $("#viewprofile .save-info").hide();
                    location.reload();
                }
                $("#viewprofile .save").button('reset');

            },"json"); 

        },

    };

};


var decorateProfile = function () {
    var instance = null;
    return function() {
        if(instance === null) {
            
            instance = createProfile();
        }
       return instance;
    };
};

var getProfile = decorateProfile();

$(document).ready(function(){
    getProfile().init(); 
});