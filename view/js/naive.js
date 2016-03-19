/******
    CONFIG


******/
var setMinUserName = 6;
var setMaxUserName = 16;
var setMinPassword = 8;
    // warning!! If you change here , u need to change in lib_standard too

var add0 = function(m){
    return m < 10?'0'+m:m;
}

var convertDate = function (time) {
    var d = new Date(time * 1000);
    var dateStr = d.getFullYear() + '-' + (d.getMonth()+1) + '-' + d.getDate()
        + ' ' + add0(d.getHours()) + ':' + add0(d.getMinutes()) + ':' + add0(d.getSeconds());
    return dateStr;
}

var getNowTime = function () {
    $.post("http://" + window.location.host + "/index.php?controller=server&action=getNowTime",'', function(json) {
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
	var reg = eval("/^[A-z][\\w]{" + (setMinUserName-1) + "," + (setMaxUserName-1) +"}$/");
    return reg.test(str);
}

var checkPassword = function (str) { //检查密码
    return str.length >= setMinPassword;
}

var checkSchool = function (str) { //检查学校
	var reg = /^[A-Za-z]+[A-Za-z ]*$/;
	return reg.test(str);
}	

var checkEmail = function (str) { //检查邮箱
	return /(?!_)(?!.*?_$)[\w]+@[\w-]+\.[\w]+/.test(str);
}
var checkText = function (str) { //检测文本
    return true;
}
