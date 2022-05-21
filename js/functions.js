function leaveComment(id_sub_object_param)
{
    var id_sub_object = id_sub_object_param;
    var comment = document.getElementById("comment").value;
    var form_data = new FormData();
    form_data.append("comment", comment);
    form_data.append("id-sub-object", id_sub_object);
    ajax = new XMLHttpRequest();

    ajax.onload = function()
    {
        var result = this.responseText;
        var split = result.split("~");
        if(split[1] == 0)
        {
            document.getElementById("leave-comment-error").innerHTML = split[0];
        }
        else
        {
            document.getElementById("comments").innerHTML = split[0];
            document.getElementById("comment").value = "";
            document.getElementById("leave-comment-error").innerText = "";
        }
    }
    ajax.open("POST", "../../../leaveComment.php", true);
    ajax.send(form_data);
}

function deleteComment(id_comment_param, id_sub_object_param)
{
    var id_sub_object = id_sub_object_param;
    var id_comment = id_comment_param;
    var form_data = new FormData();
    form_data.append("id-sub-object", id_sub_object);
    form_data.append("id-comment", id_comment);
    ajax = new XMLHttpRequest();

    ajax.onload = function()
    {
        document.getElementById("body-comments").innerHTML = this.responseText;
    }
    ajax.open("POST", "deleteComment.php", true);
    ajax.send(form_data);
}

function filterInformation()
{
    var date_from = document.getElementById("date-from").value;
    var date_to = document.getElementById("date-to").value;
    var type_object = document.getElementById("type-objects").value;
    var form_date = new FormData();
    form_date.append("date-from", date_from);
    form_date.append("date-to", date_to);
    form_date.append("type-object", type_object);
    var ajax = new XMLHttpRequest();

    ajax.onload = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById("wrapper-table-filter").innerHTML = this.responseText;
        }
    }
    ajax.open("POST", "getFilterInformation.php", true);
    ajax.send(form_date);
}

function filterProfit()
{
    var date_from = document.getElementById("date-from").value;
    var date_to = document.getElementById("date-to").value;
    var form_date = new FormData();
    form_date.append("date-from", date_from);
    form_date.append("date-to", date_to);
    var ajax = new XMLHttpRequest();

    ajax.onload = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById("wrapper-table-filter").innerHTML = this.responseText;
        }
    }
    ajax.open("POST", "getFilterProfit.php", true);
    ajax.send(form_date);
}

function changeStatus(e)
{
    var id_user = e;
    var form_date = new FormData();
    form_date.append("id_user", id_user);
    var ajax = new XMLHttpRequest();

    ajax.onload = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById("wrapper-page").innerHTML = this.responseText;
        }
    }
    ajax.open("POST", "../admin/setUserStatus.php", true);
    ajax.send(form_date);
}

function deleteUser(e)
{
    var id_user = e;
    var form_date = new FormData();
    form_date.append("id_user", id_user);
    var ajax = new XMLHttpRequest();

    ajax.onload = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            document.getElementById("wrapper-page").innerHTML = this.responseText;
        }
    }
    ajax.open("POST", "../admin/deleteUser.php", true);
    ajax.send(form_date);
}