var reqUrl = "http://dentist-clinic.com:8088/php/Case.php";

// 遍历查询病例
$(function load() {
    $.ajax({
        contentType:'application/x-www-form-urlencoded;charset=utf-8',
        type: "POST",
        dataType: "json",
        url: reqUrl,
        data: {
            operate: "query",
        },
        success:function(data){
            console.log(data);
            var listdata=data.result;
            if(listdata.length>0){
                var listInfo="";
                $.each(listdata,function(){
					listInfo+="<div class='media col-sm-12 mt-sm-0 mt-3'>"+
                                    "<div class='media-left'>"+
                                        "<a href='#'>"+
                                            "<img class='media-object' src='images/default-avatar.png'>"+
                                        "</a>"+
                                    "</div>"+
                                    "<div class='media-body'>"+
                                        "<h4 class='media-heading'><a href='caseDetails.html?"+this.id+"'>"+this.name+"</a></h4>"+
                                        "<b>编号：<span>"+this.id+"</span></b>"+
                                        "<br>病例详情:<br>&emsp;&emsp;"+
                                        "<span>"+this.note+"</span>"+
                                    "</div>"+
                                    "<div class='login-icon work-icon'>"+
                                        "<a href='#' data-id='"+this.id+"' onclick='delCase("+this.id+")'> 删除</a>"+
                                    "</div>"+
                                "</div><br>";
                });
                $("#caseList")[0].innerHTML=listInfo;	
            }
        },
        error:function(data){
            console.log(data);
        }
    });
});

// 添加病例
function addCase() {
    var addCaseForm = $('#addCaseForm').serialize();
    $.ajax({
        contentType:'application/x-www-form-urlencoded;charset=utf-8',
        type: "POST",
        dataType: "json",
        url: reqUrl,
        data: $.param({operate: "add"})+'&'+addCaseForm,
        success: function (data) {
            console.log(data.result);
            if("病例添加成功"==(data.result)){
                alert(data.result);
                location.reload();
            }else{
                alert(data.result);
            }
        },
        error:function(data) {
            console.log(data.result);
            alert(data);
        }
    });
}

// 删除病例
function delCase(id) {
    if(confirm("此操作不可逆，确认删除吗")){
        $.ajax({
            contentType:'application/x-www-form-urlencoded;charset=utf-8',
            type: "POST",
            dataType: "json",
            url: reqUrl,
            data: {
                operate:"delete",
                id:id
            },
            success: function (data) {
                console.log(data);
                location.reload()
            },
            error:function(data) {
                console.log(data);
            }
        })
    }
};

