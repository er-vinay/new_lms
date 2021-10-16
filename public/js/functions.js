function countwordcontact() {
	
    var value = document.getElementById('contactnumberst').value;

	var regex = /\s+/gi;
	if(value!=='')
	{
		
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
	
	jQuery('#totalcontacts').html(wordCount);
	jQuery('#totalcontactrow').val(wordCount);
	}
	else
	{
		jQuery('#totalcontacts').html("0");
		jQuery('#totalcontactrow').val("0");
	}
}


		jQuery(function(){
			jQuery('*[name=date]').appendDtpicker();
			$('*[name=date]').val("");

		});
	
		jQuery(document).ready(function()
		{
			jQuery("#scheduleison").click(function()
			{
				jQuery("#schedulenew").toggle();
			});
		});
	
jQuery(document).ready(function(){
jQuery("#removeduplicate").click(function(){
	
	if(jQuery("#contactnumberst").val()!='')
 	{
	alert("Please Wait For Few Seconds, Duplicacy Will Be Removed Soon");
	}
	//var remove = ['1','2','3','4','5','6'];   
	//position=arrDistinct.indexOf(remove);
	//for(i=0;i< position;i++)
	//	{	
		//  arrDistinct.splice(position);
	//} 
   var arr = jQuery("#contactnumberst").val().split("\n");
   var arrDistinct = new Array();
   jQuery(arr).each(function(index, item) {
      if(jQuery.inArray(item, arrDistinct) == -1)
        arrDistinct.push(item); 		   
  });
	
 jQuery("#contactnumberst").val(arrDistinct.join('\n'));

  return countwordcontact();
  
});
});



