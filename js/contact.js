$("#contact-form").submit(function(e)
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
                location.href = 'send_success.php';
            } else if (response.status == "NULL"){
                location.reload();
            } else if (response.status == "FAIL"){
                location.href = 'send_fail.php';
            }
        },
	});
    e.preventDefault();	//STOP default action
});