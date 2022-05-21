$(document).ready(function(){

});

function prikaziDrzavu(){
   
    var id=$("#country").val();
   
    $.post("ajax_registration.php?funkcija=popuniSelectCity",{id: id},function(response){
        var arr = JSON.parse(response);
        console.log(arr);
        $("#city").empty();

        for(var i=0;i<arr.length;i++)
        {
            var value = arr[i].CityId;
            var text=arr[i].CityName;
            $("#city").append("<option value='"+value+"'>"+text+"</option>");
        }

        if(arr == 0)
        {
            $("#city").append("<option value='null'>--Choose City--</option>");
        }
    })
}
