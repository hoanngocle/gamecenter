$("#comment-form").submit(function(e)
{
	var postData = $(this).serializeArray();
	var formURL = $(this).attr("action");
	$.ajax(
	{
            url : formURL,
            type: "POST",
            dataType: "json",
            data : postData,
            success: function(response)
            {
                if(response.status == "OK"){
                    location.reload();
                } else if (response.status == "NULL"){
                    location.reload();
                } else if (response.status == "FAIL"){

                }
            },
	});
    e.preventDefault();	//STOP default action
});