$(document).ready(function(){
    $("#form").on("submit",function(e){
        e.preventDefault();
        let content = $("#content").val();
        $.ajax({
            url : 'posttext.php',
            type : "POST",
            data : {contentData : content},
            processData : false,
            contentType : false,
            success : function (result) { 
                console.log(result);
             }
        })
    })
})