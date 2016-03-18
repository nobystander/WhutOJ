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
    return /^[A-z][\w]{7,15}$/.test(str);
}

var checkPassword = function (str) { //检测密码
    return /[\w]{8,}$/.test(str);
}
var checkEmail = function (str) { //检查邮箱
	return /(?!_)(?!.*?_$)[\w]+@[\w-]+\.[\w]+/.test(str);
}

var checkSchool = function (str) {//
	return /[\w\u4e00-\u9fa5]{1,15}/.test(str);
}	

var checkDesc = function (str) {
	return /[\w\s\u4e00-\u9fa5]+{0,100}/.test(str);
}

var checkText = function (str) { //检测文本
    return true;
}
