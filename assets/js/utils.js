
function show(thisobj,divName) {
	obj = thisobj;
	var element;
	for(i=0;i<5;i++)	
	{		
        element = document.getElementById("addiction"+i);         
        element.checked=false;	    
	}
	var selBoxes=document.getElementById(divName).getElementsByTagName("select");
	for(i=0;i<selBoxes.length;i++)
	{
		selBoxes[i].selectedIndex=0;
	}
	var inpBox=document.getElementById(divName).getElementsByTagName("input");
	for(i=0;i<inpBox.length;i++)
	{
		if(inpBox[i].type=="text")
		inpBox[i].value="";
	}
  document.getElementById(divName).style.display="block"; 
}

function hide(divName) {
  document.getElementById(divName).style.display="none";
}

function fill_name(fieldName, value) {
  document.getElementById(fieldName).value  = value;
}

function uncheckAllWithPrefix(prefix, count)
{
  for(i=0;i<count;i++) {		
    document.getElementById(prefix+i).checked=false;	    
  }
}

function concatAllChecked(prefix, count) {
  var final_string = "";
  var element;   
  
  for(i=0;i<count;i++) {
    element = document.getElementById("addiction"+i);         
    if(element.checked == true) {
      final_string += element.value + ", ";
    }
  }
  return final_string;
}

function calculateAge(date, month, year, age,divName) { 		
  var str;
 
  date = document.getElementById(date).value; 
  month = document.getElementById(month).value;
  year = document.getElementById(year).value;
  age  = document.getElementById(age).value; 
  

  if(date != 0 && month != 0 && year != 0) {
    str = year+'-' + month + '-' + date;
    obj.value = str;	
  }

  
  else if(age != '' && !isNaN(age))
      {   
      	if(age < 1 || age > 120)   	
      	  alert('Please enter proper Age');	      	  
      	else
      	{        	
	      obj.value = age;	     
      	}
      } 
      
      hide(divName);
}


//jquery auto complete code start here


var actual_val;
$(document).ready(function() 
{
	
	$(".bdate").click (function(){
		 
			$("#bDateDiv").toggle();
			//id = $(this).attr("title");
			obj = this;
			
	});
	
	 
	 $(".addict").click (function(){
	 	$("#addictionDiv").toggle();
	 	obj = this;
	 }); 
	
	 $(".close_btn").click(function(){
	 	$("#bDateDiv").hide();
	 	$("#addictionDiv").hide();
	 });
	 
	function findValueCallback(event, data, formatted) 
	{			
		$("<li>").html(!data ? "No match!" : "Marathi name: " + formatted+" English name: " + data[1]).appendTo("#result");	
	}

	function formatResult(row) 
	{
	return row[0].replace(/(<.+?>)/gi, '');
	}
	
	$(":text").result(findValueCallback).next().click(function() 
	{		
		$(this).prev().search();
	});
	
	         
     $(".memname").autocomplete(base_url+"index.php/common/name_autocomplete",
	{
		width: 260,
		selectFirst: false
	});

	$(".memname").result(
	    function(event, data, formatted) 
	    {	    	
		  if (data)
		     $(this).parent().next().find("input").val(data[1]);}
          );     
          
});
