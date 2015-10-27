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
                    } else if (response.status == "FAIL"){
                        
                    }
		},
		error: function(jqXHR, textStatus, errorThrown) 
		{
		}
	});
    e.preventDefault();	//STOP default action
});
	
$("#ajaxform").submit(); //SUBMIT FORM