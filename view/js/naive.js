

var convertDate = function (time) {
    var d = new Date(time * 1000);
    var dateStr = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + d.getDate()
        + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    return dateStr;
}

var getNowTime = function () {
    $.post("/index.php?controller=server&action=getNowTime",'', function(json) {
        var time = parseInt(json);
       // alert(convertDate(time));
    });
    
}


/*..............COMMON...................*/
var trim = function (str) {
    return str.replace(/^\s+|\s+$/g,'');
}
/*................Check...................*/

var checkUsername = function (str) { //检查用户名
    return true;
}

var checkPassword = function (str) { //检测密码
    return true;
}
var checkEmail = function (str) { //检查邮箱
    return true;
}
var checkText = function (str) { //检测文本
    return true;
}
