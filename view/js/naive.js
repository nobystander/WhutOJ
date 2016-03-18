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

var setMinUserName = 8;
var setMaxUserName = 16;
var setMinPassword = 8;
var setMaxPassword = 12;
var setMaxSchool = 15;
var setMaxDesc = 100;

var checkUsername = function (str) { //检查用户名
	var reg = eval("/^[A-z][\\w]{" + (setMinUserName-1) + "," + (setMaxUserName-1) +"}$/");
    return reg.test(str);
}

var checkPassword = function (str) { //检查密码
	var reg = eval("/[^\\s\\w\\u4e00-\\u9fa5]{"+ MinPassword + ",}$/");
    return reg.test(str);
}

var checkEmail = function (str) { //检查邮箱
	return /(?!_)(?!.*?_$)[\w]+@[\w-]+\.[\w]+/.test(str);
}

var checkSchool = function (str) { //检查学校
	var reg = eval("/[\\w\\u4e00-\\u9fa5]{1," + setMaxSchool + "}/");
	return reg.test(str);
}	

var checkDesc = function (str) { //检查描述
	var reg = eval("/[\\w\\s\\u4e00-\\u9fa5]{0," + setMaxDesc + "}/g");
	return reg.test(str);
}

var checkText = function (str) { //检查文本
    return true;
}




