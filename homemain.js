$(document).ready(function(){

});

function prikaziObjekat(){
   
    var id=$("#objecttype").val();
   
    $.post("ajax_homemain.php?funkcija=popuniSelectSubObject",{id: id},function(response){
        var arr = JSON.parse(response);
        $("#subobjecttype").empty();

        console.log(arr);
        for(var i=0;i<arr.length;i++)
        {
            var value = arr[i].SubObjectTypeId;
            var text=arr[i].SubObjectTypeName;
            $("#subobjecttype").append("<option value='"+value+"'>"+text+"</option>");
        }

        if(arr == 0)
        {
            $("#subobjecttype").append("<option value='null'>-- Choose SubObject--</option>");
        }
    })
}
