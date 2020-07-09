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



