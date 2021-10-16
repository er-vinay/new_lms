function onlynumberscheck()
	{
		onlynumsty=/^[0-9 \s]+$/;
		nosval=$("#contactnumberst").val();
		
		if(nosval.match(onlynumsty))
		{
		}
		else
		{
			if(nosval!=='')
			{
			alert("Only Numbers");
			$("#contactnumberst").val("");
			}
		}
	}
	
	function countwordcontact() {
	
    var value = document.getElementById('contactnumberst').value;

	var regex = /\s+/gi;
	if(value!=='')
	{
		
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
	
	$('#totalcontacts').html(wordCount);
	$('#totalcontactrow').val(wordCount);
	
	}
	else
	{
		$('#totalcontacts').html("0");
		$('#totalcontactrow').val("0");	
	}
}
	




$(document).ready(function(){
$("#removeduplicate").click(function(){
	
	if($("#contactnumberst").val()!='')
 	{
	alert("Please Wait For Few Seconds, Duplicacy Will Be Removed Soon");
	}
	
   var arr = $("#contactnumberst").val().split("\n");
   var arrDistinct = new Array();
   $(arr).each(function(index, item) {
      if($.inArray(item, arrDistinct) == -1)
        arrDistinct.push(item); 		   
  });
	
 $("#contactnumberst").val(arrDistinct.join('\n'));

  return countwordcontact();
  
});
});

  