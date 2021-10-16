function transcredits()
{
$=jQuery;	
transfertype=$("#transtype").val();

if(transfertype=='add')
	{
	$("#pricingdiv").fadeIn(500);
	$("#taxdiv").fadeIn(500);
	$("#totalamtdiv").fadeIn(500);
	}
if(transfertype=='deduct' || transfertype=='')
	{
	$("#pricingdiv").fadeOut(500);
	$("#taxdiv").fadeOut(500);
	$("#totalamtdiv").fadeOut(500);
	$("#pricing").val("");
	$("#taxonsms").val("");
	}	

}


function creditpricing()
{
	$=jQuery;
	vol=$("#volumeofcredits").val();
	var numbers=/^[0-9]+$/;
	
	if(!vol.match(numbers))
	{
		if(vol!=='')
		{
		alert("Enter Only Numbers");
		$("#volumeofcredits").val("");
		return false;
		}
	}
	amt=$("#pricing").val();
	taxis=$("#taxonsms").val();
	
	totamt= vol * amt ;

	plustax=totamt * taxis/100;
	
	netamt=totamt + plustax;
	finalvalue=netamt/100;
	$("#totalamt").val(parseInt(finalvalue));	
}