jQuery(document).ready(function()
{
	countwords();
	countwordcontact();
	
	
});

function countwords()
{
	var words= document.getElementById('smscontent').value;
	
	var totalwords= words.length;
	document.getElementById('wordsremain').innerHTML=totalwords;
	divid=document.getElementById('msgtype').value;
	
	if(divid=='unicodemsg' || divid=='unicodeflashmsg')
	{
		
		if(totalwords > 71)
		{
		dvdby=63;
		}
		else
		{
		dvdby=70;	
		}
	}
	else
	{
		if(totalwords > 161)
		{
		dvdby=153;
		}
		else
		{
		dvdby=160;
		}
		
		//var reg ="[^\x00-\x80]+";
		//if(words.match(reg)) 
		//{
		//document.getElementById('smscontent').value="";
  	    //$("#msgstatus").fadeIn().fadeOut(4000).html("Input Text Characters Only (If Error Persists then please Refresh The Page)");
   
  	 	//return false;
	  //}
		
	}
	if(totalwords > 0)
	{
		var ff= Math.ceil(totalwords / dvdby);
		
		document.getElementById('countsms').innerHTML=parseInt(ff);
		document.getElementById('countsmshidden').value=parseInt(ff);
		
	}
	if(totalwords == 0)
	{
	document.getElementById('countsms').innerHTML=0;
	document.getElementById('countsmshidden').value=0;	
	}
	
}
