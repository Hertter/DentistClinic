//请求路径
var reqUrl = "http://dentist-clinic.com:8088/php/Case.php";
var docReqUrl = "http://dentist-clinic.com:8088/php/Dentist.php";

//跳转路径
var jumpModify = "http://dentist-clinic.com:8080/web/caseModify.html?";
var jumpDetail = "http://dentist-clinic.com:8080/web/caseDetails.html?";
var jumpIndex = "http://dentist-clinic.com:8080/web/index.html";

// 修改资料切换
$(document).ready(function(){
    $("#modifyData").click(function(){ 
        $("#personDetailData").toggleClass("switch",true); 
        $("#personModifyData").toggleClass("switch",false); 

    }); 
})
$(document).ready(function(){
    $("#cancel").click(function(){ 
        $("#personDetailData").toggleClass("switch",false); 
        $("#personModifyData").toggleClass("switch",true); 
    }); 
})

// 覆盖头像
var upload = function (c, d) {
    "use strict";
    var $c = document.querySelector(c),
        $d = document.querySelector(d),
        file = $c.files[0],
        reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function (e) {
        $d.setAttribute("src", e.target.result);
    };
};

// 返回首页
function backIndex() {
    if (confirm("是否要退出登录，并返回首页？")) {
        window.location.href=jumpIndex;
    }
}

//跳转修改页面
function caseModify() {
    var id = sessionStorage.getItem('id');
    window.location.href = jumpModify + id;
}

// 修改病例
function modifyCase() {
    var strHref = window.location.href;
    var s = strHref.indexOf("?");
    var id = strHref.substring(s+1);

    var modifyCaseForm = $('#modifyCaseForm').serialize();
    var note = $("#note").val().toString();
    var plan = $("#plan").val().toString();

    $.ajax({
        contentType:'application/x-www-form-urlencoded;charset=utf-8',
        type: "POST",
        dataType: "json",
        url: reqUrl,
        data: $.param({
            operate: "update",
            note: note,
            treatment_plan:plan,
            id:id
        })+'&'+modifyCaseForm,
        success: function (data) {
            console.log(data);
            alert(data.result);
            if("更新成功"==(data.result)){
                //跳转
                window.location.href= jumpDetail + id;
            }
        },
        error:function(data) {
            console.log(data);
            alert(data.result);
        }
    });
}

//修改页面回显
$(function modifyDetails() {
    var name = sessionStorage.getItem('name');
    var sex = sessionStorage.getItem('sex');
    var status = sessionStorage.getItem('status');
    var born = sessionStorage.getItem('born');

    $("#name").val(name);
    $("#sex").val(sex);
    $("#status").val(status);
    $("#born_year").val(born);
});

//跳转回病例详情页面
function returnCaseDetails() {
    var strHref = window.location.href;
    var s = strHref.indexOf("?");
    var id = strHref.substring(s+1);
    //跳转
    window.location.href= jumpDetail + id;
};

// 根据id查询病例
$(function caseFind() {
    var strHref = window.location.href;
    var s = strHref.indexOf("?");
    var id = strHref.substring(s+1);
    $.ajax({
        contentType:'application/x-www-form-urlencoded;charset=utf-8',
        type: "POST",
        dataType: "json",
        url: reqUrl,
        data: {
            operate: "find",
            id: id
        },
        success:function(data){
            console.log(data);
            var id = data.result[0].id;
            var name = data.result[0].name;
            var sex = data.result[0].sex;
            var status = data.result[0].status;
            var treatment_plan = data.result[0].treatment_plan;
            var note = data.result[0].note;
            var born_year = data.result[0].born_year;

            sessionStorage.setItem('id', id);
            sessionStorage.setItem('name', name);
            sessionStorage.setItem('status', status);
            sessionStorage.setItem('treatment_plan', treatment_plan);
            sessionStorage.setItem('sex', sex);
            sessionStorage.setItem('born', born_year);
            sessionStorage.setItem('note', note);

            $("#id").html(id);
            $("#name").html(name);
            $("#sex").html(sex);
            $("#status").html(status);
            $("#born_year").html(born_year);
            $("#plan").html(treatment_plan);
            $("#note").html(note);    
        },
        error:function(data){
            console.log(data);
        }
    });
});

// 牙医资料查询
$(function findDoctor() {

    // var username = sessionStorage.getItem('username');
    // var id = sessionStorage.getItem('id');

    var id = 1;
    var username = "hzt";

    $.ajax({
        contentType:'application/x-www-form-urlencoded;charset=utf-8',
        type: "POST",
        dataType: "json",
        url: docReqUrl,
        data: {
            operate: "find",
            username: username,
            id: id
        },
        success:function(data){
            console.log(data);

            var docName = data.result[0].name;
            var docSex = data.result[0].sex;
            var docUsername = data.result[0].username;
            var docPassword = data.result[0].password;
            var docLocation = data.result[0].location;
            var docProfile = data.result[0].profile;

            sessionStorage.setItem('docName', docName);
            sessionStorage.setItem('docSex', docSex);
            sessionStorage.setItem('docUsername', docUsername);
            sessionStorage.setItem('docPassword', docPassword);
            sessionStorage.setItem('docLocation', docLocation);
            sessionStorage.setItem('docProfile', docProfile);

            $("#docName").html(docName);
            $("#docSex").html(docSex);
            $("#docUsername").html(docUsername);
            // 密码不显示
            // $("#docPassword").html(docPassword);
            $("#docLocation").html(docLocation);
            $("#docProfile").html(docProfile);
            $("#photoName").html(docName);
            $("#photoLocation").html(docLocation);

        },
        error:function(data){
            console.log(data);
        }
    });
});

//修改页面回显
$(function modifyDetails() {
    var docName = sessionStorage.getItem('docName');
    var docSex = sessionStorage.getItem('docSex');
    var docUsername = sessionStorage.getItem('docUsername');
    var docLocation = sessionStorage.getItem('docLocation');
    var docProfile = sessionStorage.getItem('docProfile');
    var docPassword = sessionStorage.getItem('docPassword');


    $("#updateName").val(docName);
    $("#updateSex").val(docSex);
    $("#updateUsername").val(docUsername);
    $("#updateLocation").val(docLocation);
    $("#updateProfile").val(docProfile);
    $("#updatePassword").val(docPassword);

});

//
// 
function updatePersonData() {
    var updateDocForm = $('#updateDocForm').serialize();
    $.ajax({
        contentType:'application/x-www-form-urlencoded;charset=utf-8',
        type: "POST",
        dataType: "json",
        url: docReqUrl,
        data: $.param({operate: "update"})+'&'+updateDocForm,
        success: function (data) {
            console.log(data.result);
            if("更新成功"==(data.result)){
                alert(data.result);
                location.reload();
            }else{
                alert(data.result);
            }
        },
        error:function(data) {
            console.log(data.result);
            alert("更新失败！");
        }
    });
}


