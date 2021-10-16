jQuery(document).ready(function()
{
	
	jQuery("#yuoji").click(function()
	{		
username=jQuery("#username").val();
password=jQuery("#inputPassword").val();
if(username=='')
{
	jQuery("#msgstatus").addClass("alert-danger").fadeIn(10).text("Please Enter Username");
}
else
{
	if(password=='')
	{
		jQuery("#msgstatus").addClass("alert-danger").fadeIn(10).text("Please Enter Password");
	}
	else
	{
		datastring='username='+username+'&password='+password;
		jQuery.ajax({
				type:'POST',
				url:'pages/loginuserid',
				data:datastring,
				beforeSend:function()
				{
					
					jQuery("#msgstatus").addClass("alert-danger").fadeIn(10).text("Please Wait....");
				},
				success:function(data)
				{
					jQuery("#msgstatus").removeClass("alert-danger").fadeIn(10).html(data);	
				}
				
			
		});
		
		
	}
	
}
	
	});
});