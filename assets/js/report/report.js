//Corechart package has to be loaded because google chart API has been used for all the charts.
google.load("visualization", "1", {packages:["corechart"]});


/**********************************************************************************/
/*	METHODS FOR REPORTS START HERE. EACH REPORT HAS 3 METHODS.*/
/**********************************************************************************/


/**********************************************************************************************************************************************************/
/*	FIRST METHOD => IT IS CALLED BY THE VIEW FILE OF THE PARTICULAR REPORT. It gets the data from the user which he/she has entered on the view
	page of the report. It contains an ajax method, which calls a method in controller file to fetch the needed information using the data user 
	has provided. It also calls the second and the third method. 
	
	SECOND METHOD => THIS METHOD IS CALLED BY THE FIRST METHOD. IT USES THE INFORMATION THAT WE NEED TO PLOT THE GRAPHICAL REPORT. IT SAVES THE
	INFORMATION IN TWO FORMS. FIRST, IN HTML TABLE. AND SECOND IN A CSV STRING.  THESE TWO FORMS OF INFORMATION IS THEN USED BY AN AJAX METHOD 
	TO CREATE A PDF AND CSV FILE WHICH CAN BE DOWNLOADED. THIS AJAX METHOD ALSO TAKES THE EMAIL ADDRESS PROVIDED BY THE USER ON THE VIEW PAGE OF
	THE REPORT TO ALLOW THE USER TO MAIL THE 'CSV' FILE.
	
	THIRD METHOD => THIS METHOD IS CALLED BY THE FIRST METHOD. It draws the chart using the information. *******/
	
	
//	P.S. -> The last report,i.e. risk factor combination report only has two methods because we are not drawing any chart for this report.
/**********************************************************************************************************************************************************/
	

/**********************************************************************************************************************************************************/
//	I will explain how things are working in the first report. All other reports work the same way.
/**********************************************************************************************************************************************************/
	



/*****************************DIAGNOSIS CHART*****************************/ 

function diagnosis_chart_ajax()
{ 
    	var from_date = $("#from_date").val();       //Fetching from_date from the view page.
    	var to_date = $('#to_date').val();	//Fetching to_date from the view page.
    	var rmhc = $("#location_id option:selected").val(); 	//Fetching provider location id of the rmhc from the view page.
    	var rmhc_name = $("#location_id option:selected").text();//Fetching location name from the view page. This is needed for the table which will be drawn in pdf
    	
    	url = base_url+'index.php/mne/graphical_reports/diagnosis_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date ,'rmhc_name':rmhc_name}, //AJAX method. we send all the data chosen by user.
		   function(result)
		   {	// 'data' is the information that we receive back.
		   	pie_data=[['Diagnosis', 'No of cases']];
		   	charting_data_others = data[0];
		   	charting_data_all = data[1];
		      	for(x in charting_data_others)
		      	{	
		   		element = [x,charting_data_others[x]];
		      		pie_data.push(element);
		      	}
		   
        		draw_diagnosis_Chart();
        		get_pdf_and_csv_for_diagnosis_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_diagnosis_chart()
{
	//table_html is for pdf file.	
	//csv_string is for csv file.
	
	
	table_html = '<div style="height:50px;" align="center"><b>Split by diagnosis Report</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Diagnosis</td><td>No. of cases</td></tr>';
	
	csv_string = "Diagnosis,number of cases\n";
	for(x in charting_data_all)
	{
		table_html+='<tr><td>'+x+'<td>'+charting_data_all[x]+'</td></tr>';
		csv_string+=x+','+charting_data_all[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_diagnosis';	
	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },//AJAX method. 
		function(result)
		{	
			// 'url' and 'mail_sent' is the information we receive back.
			
			link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
			$('#rep_link').html(link);
			$('#mail_status').html(mail_sent);
	
		},'script');
		 
}
       
function draw_diagnosis_Chart() 
{
        var data = google.visualization.arrayToDataTable(pie_data);
        var options = { width:950, height:800, title: 'Diagnosis Chart' };
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

 /*****************************END OF DIAGNOSIS CHART*****************************/

/*****************************CHIEF COMPLAINTS CHART*****************************/ 

function chief_complaint_chart_ajax()
{
	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	url = base_url+'index.php/mne/graphical_reports/chief_complaint_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name  },
		   function(result)
		   {	
		   	pie_data=[['Chief Complaints', 'No of cases']];
		   	charting_data_others = data[0];
		   	charting_data_all = data[1];
		      	for(x in charting_data_others)
		      	{	
		   		element = [x,charting_data_others[x]];
		      		pie_data.push(element);
		      	}
		  
        		draw_chief_complaint_Chart();
        		get_pdf_and_csv_for_chief_complaint_chart();
       		   },'script');
}

function get_pdf_and_csv_for_chief_complaint_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Split by chief complaints Report</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Chief Complaints</td><td>No. of cases</td></tr>';
	
	csv_string = "Diagnosis,number of cases\n";
	for(x in charting_data_all)
	{
		table_html+='<tr><td>'+x+'<td>'+charting_data_all[x]+'</td></tr>';
		csv_string+=x+','+charting_data_all[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_chief_complaints';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';
	

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_chief_complaint_Chart() 
{
        var data = google.visualization.arrayToDataTable(pie_data);
        var options = { width:950, height:800, title: 'Chief Complaint Chart' };
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

 /*****************************END OF CHIEF COMPLAINTS CHART*****************************/ 

/*****************************GENDER DISTRIBUTION CHART*****************************/

function gender_distribution_chart_ajax()
{
	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	url = base_url+'index.php/mne/graphical_reports/gender_distribution_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	pie_data=[['Chief Complaints', 'No of cases']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		pie_data.push(element);
		      	}
		   
        		draw_gender_distribution_Chart();
        		get_pdf_and_csv_for_gender_distribution_chart();
       		   },'script');
}

function get_pdf_and_csv_for_gender_distribution_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Split by gender distribution Report</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Gender</td><td>No. of cases</td></tr>';
	csv_string = "Gender Distribution,number of cases\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	
	filename = 'uploads/report/list_of_gender_distribution';	
	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename},function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_gender_distribution_Chart() 
{
        var data = google.visualization.arrayToDataTable(pie_data);
        var options = { width:950, height:800, title: 'Gender Distribution Chart' };
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

/*****************************END OF GENDER DISTRIBUTION CHART*****************************/	 

 /********************EYE RELATED DIAGNOSIS CHART**************/
 
 function eye_diagnosis_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	
    	url = base_url+'index.php/mne/graphical_reports/eye_diagnosis_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	pie_data=[['Diagnosis', 'No of cases']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		pie_data.push(element);
		      	}
		 
        		draw_eye_diagnosis_Chart();
        		get_pdf_and_csv_for_eye_diagnosis_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_eye_diagnosis_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Split by eye diagnosis Report</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Diagnosis</td><td>No. of cases</td></tr>';
	csv_string = "Diagnosis,Number of cases\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_eye_diagnosis';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_eye_diagnosis_Chart() 
{
        var data = google.visualization.arrayToDataTable(pie_data);
        var options = { width:950, height:800, title: 'Eye Diagnosis Chart' };
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}
 
/********************END OF EYE RELATED DIAGNOSIS CHART**************/

/*********************AGE DISTRIBUTION CHART****************/

function age_distribution_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	url = base_url+'index.php/mne/graphical_reports/age_distribution_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	column_data=[['Age Distribution', 'No of cases']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		column_data.push(element);
		      	}
		  
        		draw_age_distribution_Chart();
        		get_pdf_and_csv_for_age_distribution_chart();

       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_age_distribution_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Split by age distribution Report</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Age Distribution</td><td>No. of cases</td></tr>';
	csv_string = "Age Distribution,Number of cases\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	var email_address = $("#email_address").val();
	filename = 'uploads/report/list_of_age_distribution';	
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename},function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_age_distribution_Chart() 
{
        var data = google.visualization.arrayToDataTable(column_data);
        var options = { title: 'Age Distribution Chart', width:950, height:800, hAxis: {title: 'Age Distribution',  titleTextStyle: {color: 'red'}}, vAxis: {title: 'No. Of Cases',  titleTextStyle: {color: 'red'}} };
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

/*********************END OF AGE DISTRIBUTION CHART****************/

/*********************AVERAGE TIME FOR EACH VISIT CHART****************/

function avg_time_visit_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	url = base_url+'index.php/mne/graphical_reports/avg_time_visit_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	combo_data=[['Dates','Global Average','Average Time']];
		   
		   	avg_time = data[0];
		   	
		   	
		      	for(date in avg_time)
		      	{	
		   		element = [date,data[1],avg_time[date]];	
		      		combo_data.push(element);
		      	}
		    
        		draw_avg_time_visit_Chart();
        		get_pdf_and_csv_for_avg_time_visit_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_avg_time_visit_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Average time taken for each visit report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Date</td><td>Global Average time taken for each visit</td><td>Average time taken for each visit</td></tr>';
	
	avg_time = data[0];
	csv_string = 'Dates,Global Average,Average Time\n';
	for(date in avg_time)
	{
		table_html+='<tr><td>'+date+'<td>'+data[1]+'minutes'+'<td>'+avg_time[date]+'minutes'+'</td></tr>';
		csv_string+=date+','+data[1]+','+avg_time[date]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_avg_time_visit';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_avg_time_visit_Chart() 
{
        var data = google.visualization.arrayToDataTable(combo_data);
        var options = { title: 'Average time taken for each Visit Chart', width:950, height:800, vAxis: {title: "Average time taken for each Visit"},
          hAxis: {title: "Days"}, series: [{type:'line'},{}]};
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

/*********************END OF AVERAGE TIME FOR EACH VISIT CHART****************/

/*********************AVERAGE TIME FOR EACH PISP CHART****************/

function avg_time_pisp_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	url = base_url+'index.php/mne/graphical_reports/avg_time_pisp_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	combo_data=[['Dates','Global Average','Average time taken for a pisp']];
		   
		   	avg_time = data[0];
		   
		   	
		      	for(date in avg_time)
		      	{	
		   		element = [date,data[1],avg_time[date]];
		   		
		   		
		      		combo_data.push(element);
		      	}
		   
        		draw_avg_time_pisp_Chart();
        		get_pdf_and_csv_for_avg_time_pisp_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_avg_time_pisp_chart()
{	
	
	table_html = '<div style="height:50px;" align="center"><b>Average time taken for each pisp report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Date</td><td>Global Average time taken for each pisp</td><td>Average time taken for each pisp</td></tr>';
	
	avg_time = data[0];
	csv_string = 'Dates,Global Average,Average Time\n';
	for(date in avg_time)
	{
		table_html+='<tr><td>'+date+'<td>'+data[1]+'minutes'+'<td>'+avg_time[date]+'minutes'+'</td></tr>';
		csv_string+=date+','+data[1]+','+avg_time[date]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_avg_time_pisp';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_avg_time_pisp_Chart() 
{
        var data = google.visualization.arrayToDataTable(combo_data);
          var options = { title: 'Average time taken for each Pisp Chart', width:950, height:800, vAxis: {title: "Average time taken for each Pisp"},
          hAxis: {title: "Days"}, series: [{type:'line'},{}]};
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

/*********************END OF AVERAGE TIME FOR EACH PISP CHART****************/

/*********************AVERAGE NUMBER OF PATIENT VISIT CHART****************/

function avg_patient_visit_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	url = base_url+'index.php/mne/graphical_reports/avg_patient_visit_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	combo_data=[['Dates', 'Average Patient Visit','Global Average','Average Free Patient Visit','Global Free Patient Average']];
		   
		   	avg_num = data[0];
		   	avg_free = data[2];
		   	
		      	for(date in avg_num)
		      	{	
		   		element = [date,avg_num[date],data[1],avg_free[date],data[3]];
		   		
		   		
		      		combo_data.push(element);
		      	}
		   
        		draw_avg_patient_visit_Chart();
        		get_pdf_and_csv_for_avg_patient_visit_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_avg_patient_visit_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Split by eye diagnosis Report</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Date</td><td>Average number of patient visits</td><td>Global Average of patient visits</td><td>Average number of free patient visits</td><td>Global Average of free patient visits</td></tr>';
	avg_num = data[0];
	avg_free = data[2];
	csv_string = 'Dates,Average Patient Visit,Global Average,Average Free Patient Visit,Global Free Patient Average\n';
	for(date in avg_num)
	{
		table_html+='<tr><td>'+date+'<td>'+avg_num[date]+'<td>'+data[1]+'<td>'+avg_free[date]+'<td>'+data[3]+'</td></tr>';
		csv_string+=date+','+avg_num[date]+','+data[1]+','+avg_free[date]+','+data[3]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_avg_patient_visit';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_avg_patient_visit_Chart() 
{
        var data = google.visualization.arrayToDataTable(combo_data);
        var options = { title: 'Average Number of Patients Chart' ,width:950, height:800, vAxis: {title: "Average number of patients"},
          hAxis: {title: "Days"},seriesType: "line",series: {2: {color: 'grey',type: "line"}}};
	var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

/*********************END OF AVERAGE NUMBER OF PATIENT VISIT CHART****************/

/*********************AGE DISTRIBUTION CHART BY DIAGNOSIS/CHIEF COMPLAINTS****************/

function age_distribution_by_diagnosis_cc_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rep_feature = $("#rep_features").val();
	var rep_option = $("#rep_options").val();
	var rmhc_name = $("#location_id option:selected").text();
    	
    	url = base_url+'index.php/mne/graphical_reports/age_distribution_by_diagnosis_cc_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date, 'rep_feature':rep_feature, 'rep_option':rep_option ,'rmhc_name':rmhc_name},
		   function(result)
		   {	
		   	column_data=[['Age Distribution', 'No of cases']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		column_data.push(element);
		      	}
		    
        		draw_age_distribution_by_diagnosis_cc_Chart();
        		get_pdf_and_csv_for_age_distribution_by_diagnosis_cc_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_age_distribution_by_diagnosis_cc_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Split by age distribution by diagnosis/chief complaints Report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td><td>Feature</td><td>Option</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'<td>'+rep_feature+'<td>'+rep_option+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Age Distribution</td><td>No. of cases</td></tr>';
	csv_string = "Age Distribution,No of cases\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_age_distribution_by_diagnosis_cc';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	},'script');
		 
}
       
function draw_age_distribution_by_diagnosis_cc_Chart() 
{
        var data = google.visualization.arrayToDataTable(column_data);
        var options = { title: 'Age Distribution Chart', width:950, height:800, hAxis: {title: 'Age Distribution',  titleTextStyle: {color: 'red'}}, vAxis: {title: 'No. Of Cases',  titleTextStyle: {color: 'red'}} };
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

/*********************END OF AGE DISTRIBUTION CHART BY DIAGNOSIS/CHIEF COMPLAINTS****************/

/*********************AVERAGE BILL AMOUNTS PER PATIENT CHART****************/


function avg_bill_amounts_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rep_feature = $("#rep_features").val();
	var rep_option = $("#rep_options").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	url = base_url+'index.php/mne/graphical_reports/avg_bill_amounts_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rep_feature':rep_feature, 'rep_option':rep_option,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	combo_data=[['Dates', 'Average Bill Amount','Global Average']];
		   
		   	avg_num = data[0];
		   	
		      	for(date in avg_num)
		      	{	
		   		element = [date,avg_num[date],data[1]];
		   		combo_data.push(element);
		      	}
		   
        		draw_avg_bill_amounts_Chart();
        		get_pdf_and_csv_for_avg_bill_amounts_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_avg_bill_amounts_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Average bill amounts per patient report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td><td>Feature</td><td>Option</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'<td>'+rep_feature+'<td>'+rep_option+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Date</td><td>Average Bill Amount</td><td>Global Average </td></tr>';
	avg_num = data[0];
	csv_string = 'Dates,Average Bill Amount,Global Average\n';
	for(date in avg_num)
	{
		table_html+='<tr><td>'+date+'<td>'+avg_num[date]+'<td>'+data[1]+'</td></tr>';
		csv_string+=date+','+avg_num[date]+','+data[1]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_avg_bill_amounts';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_avg_bill_amounts_Chart() 
{
        var data = google.visualization.arrayToDataTable(combo_data);
        var options = { title: 'AVERAGE BILL AMOUNTS PER PATIENT CHART', width:950, height:800, vAxis: {title: "Average bill amount per patient"},
          hAxis: {title: "Days"}, seriesType: "line", series: {1: {type: "line"}}};
	var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

/*********************END OF AVERAGE BILL AMOUNTS PER PATIENT CHART****************/

/*********************Cost of medication/services/lab tests dispensed/conducted CHART****************/

function cost_med_serv_tests_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	
    	url = base_url+'index.php/mne/graphical_reports/cost_med_serv_tests_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	num = data[0];
			num_vis = data[2];
			
		   	var i;
		   	i=0;
		      	for(date in num)
		      	{	
		      		i=i+1;
		      		var str = 'Date: '+date+'\n'+'Cost incurred: '+num[date]+'\n'+'Number of visits: '+num_vis[date];
		      		if(i==1)
		      		{
		      			combo_data = [[date,num[date],str,data[1],num_vis[date]]];
		      		}
		      		else 
		      		{
			   		element = [date,num[date],str,data[1],num_vis[date]];		   		
			   	   	combo_data.push(element);
			      	}
		      	}
        		draw_cost_med_serv_tests_Chart();
        		get_pdf_and_csv_for_cost_med_serv_tests_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_cost_med_serv_tests_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Cost of medication/services/lab tests dispensed/conducted report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Date</td><td>Cost per day</td><td>Global Average </td><td>Visits per day </td></tr>';
	num = data[0];
	num_vis = data[2];
	csv_string = "Date,Cost per day,Global Average,Visits per Day\n";
	for(date in num)
	{
		table_html+='<tr><td>'+date+'<td>'+num[date]+'<td>'+data[1]+'<td>'+num_vis[date]+'</td></tr>';
		csv_string+=date+','+num[date]+','+data[1]+','+num_vis[date]+'\n';
	}
	total_cost = '<b>'+'Total Approximate cost incurred: Rs.'+ data[3]+'(This includes camp visits)'+'</b>';
	
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_cost_med_serv_tests';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
	$('#cost_status').html(total_cost);
	
		 
}
       
function draw_cost_med_serv_tests_Chart() 
{
   
        var data = new google.visualization.DataTable();
	data.addColumn('string', 'Days');
	data.addColumn('number', 'Cost Per Day'); 
	data.addColumn({type:'string', role:'tooltip'});
	data.addColumn('number', 'Global Average');
	data.addColumn('number', 'Visits per day'); 
	

	data.addRows(combo_data);
        var options = { title: 'Cost of medication/services/lab tests dispensed/conducted CHART', width:950, height:800, vAxis: {title: "Cost per day"},
          hAxis: {title: "Days"}, seriesType: "line", series: {1: {type: "line"}}};
	var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}


/*********************END OF Cost of medication/services/lab tests dispensed/conducted CHART****************/

/*********************Average Cost of medication/services/lab tests dispensed/conducted CHART****************/

function avg_cost_med_serv_tests_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	
    	url = base_url+'index.php/mne/graphical_reports/avg_cost_med_serv_tests_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		    function(result)
		   {	
		   	combo_data=[['Dates', 'Average Cost per day','Global Average of average cost per day']];
		   
		   	avg_num = data[0];
		   	
		      	for(date in avg_num)
		      	{	
		   		element = [date,avg_num[date],data[1]];
		   		
		   		
		      		combo_data.push(element);
		      	}
		 
        		draw_avg_cost_med_serv_tests_Chart();
        		get_pdf_for_avg_cost_med_serv_tests_chart();
       		   },'script');
}     		  
      
   
function get_pdf_for_avg_cost_med_serv_tests_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Split by eye diagnosis Report</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Date</td><td>Average Cost per day</td><td>Global Average of average cost per day</td></tr>';
	num = data[0];
	csv_string = "Date,Average Cost per day,Global Average Cost per day\n";
	for(date in num)
	{
		table_html+='<tr><td>'+date+'<td>'+num[date]+'<td>'+data[1]+'</td></tr>';
		csv_string+=date+','+num[date]+','+data[1]+'\n';
	}
	
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_avg_cost_med_serv_tests';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';
	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename},function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
	
	
		 
}
       
function draw_avg_cost_med_serv_tests_Chart() 
{
   
        var data = google.visualization.arrayToDataTable(combo_data);
	
        var options = { title: 'Average Cost of medication/services/lab tests dispensed/conducted CHART', width:950, height:800, vAxis: {title: "Average Cost per day"},
          hAxis: {title: "Days"}, seriesType: "line", series: {1: {type: "line"}}};
	var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}


/*********************END OF average Cost of medication/services/lab tests dispensed/conducted CHART****************/

/*********************Diagnostic tests split by billed/free CHART****************/

function diagnostic_tests_billed_free_chart_ajax()
{
	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	url = base_url+'index.php/mne/graphical_reports/diagnostic_tests_billed_free_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	column_data=[['Diagnostic Tests', 'No. of paid cases','No. of free cases']];
		   	paid = data[0];
		   	free = data[1];
		      	for(diagnostic_tests in data[0])
		      	{	
		      		if(free[diagnostic_tests]==undefined)
		      			free[diagnostic_tests]=0;
		   		element = [diagnostic_tests, paid[diagnostic_tests], free[diagnostic_tests]];
		      		column_data.push(element);
		      	}
		   
        		draw_diagnostic_tests_billed_free_Chart();
        		get_pdf_and_csv_for_diagnostic_tests_billed_free_chart();
       		   },'script');
}

function get_pdf_and_csv_for_diagnostic_tests_billed_free_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Diagnostic tests split by billed vs free report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Diagnostic Tests</td><td>No. of paid cases</td><td>No. of free cases</td></tr>';
	csv_string = "Diagnostic Tests,No. of paid cases,No. of free cases\n";
	for(diagnostic_tests in data[0])
	{
		table_html+='<tr><td>'+diagnostic_tests+'<td>'+paid[diagnostic_tests]+'<td>'+free[diagnostic_tests]+'</td></tr>';
		csv_string+=diagnostic_tests+','+paid[diagnostic_tests]+','+free[diagnostic_tests]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_diagnostic_tests_billed_free';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename},function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_diagnostic_tests_billed_free_Chart() 
{
        var data = google.visualization.arrayToDataTable(column_data);
        var options = {fontSize: 12, width:950, height:800, title: 'Diagnostic tests split by billed vs free Chart', isStacked: true, vAxis: {title: "No. of cases"},
          hAxis: {title: "Diagnostic Tests"}, series: [{color: 'blue'}, {color: 'grey'}]   };
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

/*********************END OF Diagnostic tests split by billed/free CHART****************/

/*********************Number of new cards created in each clinic CHART****************/

function number_new_cards_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	
	
    	
    	url = base_url+'index.php/mne/graphical_reports/number_new_cards_chart_call';
	$.post(url,{ 'from_date':from_date,'to_date':to_date},
		   function(result)
		   {	
		   	column_data=[['RMHC', 'No, of new cards']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		column_data.push(element);
		      	}
		   
        		draw_number_new_cards_Chart();
        		get_pdf_and_csv_for_number_new_cards_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_number_new_cards_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Number of new cards created in each clinic report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>RMHC</td><td>No. of new cards</td></tr>';
	csv_string = "RMHC,Number of new cards\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_number_new_cards';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_number_new_cards_Chart() 
{
        var data = google.visualization.arrayToDataTable(column_data);
        var options = { title: 'Number of new cards created in each clinic Chart', width:950, height:800, hAxis: {title: 'RMHCs',  titleTextStyle: {color: 'red'}}, vAxis: {title: 'No. Of new cards',  titleTextStyle: {color: 'red'}} };
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}


/*********************END OF Number of new cards created in each clinic CHART****************/

/*****************************DIAGNOSIS SPLIT BY SYSTEM CHART*****************************/ 

function diagnosis_system_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	url = base_url+'index.php/mne/graphical_reports/diagnosis_system_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	pie_data=[['System Name', 'No of cases']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		pie_data.push(element);
		      	}
		 
        		draw_diagnosis_system_Chart();
        		get_pdf_and_csv_for_diagnosis_system_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_diagnosis_system_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Split of diagnosis by system names Report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>System Name</td><td>No. of cases</td></tr>';
	csv_string = "System name,Number of cases\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_diagnosis_system';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_diagnosis_system_Chart() 
{
        var data = google.visualization.arrayToDataTable(pie_data);
        var options = { width:950, height:800, title: 'Diagnosis Chart split by System Name' };
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

/*****************************END OF DIAGNOSIS SPLIT BY SYSTEM CHART*****************************/ 

/*********************GENDER DISTRIBUTION CHART BY DIAGNOSIS/CHIEF COMPLAINTS****************/

function gender_distribution_by_diagnosis_cc_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rep_feature = $("#rep_features").val();
	var rep_option = $("#rep_options").val();
	var rmhc_name = $("#location_id option:selected").text();
	
    	
    	url = base_url+'index.php/mne/graphical_reports/gender_distribution_by_diagnosis_cc_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date, 'rep_feature':rep_feature, 'rep_option':rep_option, 'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	column_data=[['Gender Distribution', 'No of cases']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		column_data.push(element);
		      	}
		   
        		draw_gender_distribution_by_diagnosis_cc_Chart();
        		get_pdf_for_gender_distribution_by_diagnosis_cc_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_for_gender_distribution_by_diagnosis_cc_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Split by gender distribution by diagnosis/chief complaints Report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td><td>Feature</td><td>Option</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'<td>'+rep_feature+'<td>'+rep_option+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Gender Distribution</td><td>No. of cases</td></tr>';
	csv_string = "Gender Distribution,Number of cases\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_gender_distribution_by_diagnosis_cc';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_gender_distribution_by_diagnosis_cc_Chart() 
{
        var data = google.visualization.arrayToDataTable(column_data);
        var options = { title: 'Gender Distribution Chart', width:950, height:800, hAxis: {title: 'Gender Distribution',  titleTextStyle: {color: 'red'}}, vAxis: {title: 'No. Of Cases',  titleTextStyle: {color: 'red'}} };
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}

/*********************END OF GENDER DISTRIBUTION CHART BY DIAGNOSIS/CHIEF COMPLAINTS****************/

/*********************SPLIT OF OPD PRODUCTS CHART****************/

function opd_products_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	url = base_url+'index.php/mne/graphical_reports/opd_products_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	pie_data=[['OPD Products Distribution', 'No of cases']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		pie_data.push(element);
		      	}
		  
        		draw_opd_products_Chart();
        		get_pdf_and_csv_for_opd_products_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_opd_products_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Split of opd products report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>OPD Products Distribution</td><td>No. of cases</td></tr>';
	csv_string = "OPD Products Distribution,Number of cases\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_opd_products';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename},function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_opd_products_Chart() 
{
        var data = google.visualization.arrayToDataTable(pie_data);
        var options = { title: 'OPD Products Distribution Chart', width:950, height:800, hAxis: {title: 'OPD Products Distribution',  titleTextStyle: {color: 'red'}}, vAxis: {title: 'No. Of Cases',  titleTextStyle: {color: 'red'}} };
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}


/*********************END OF SPLIT OF OPD PRODUCTS CHART****************/

/*********************REPEATED VISITS CHART****************/

function repeated_visits_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	url = base_url+'index.php/mne/graphical_reports/repeated_visits_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	column_data=[['Repeated visits', 'No of cases']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		column_data.push(element);
		      	}
		   
        		draw_repeated_visits_Chart();
        		get_pdf_and_csv_for_repeated_visits_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_repeated_visits_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Number of repeated visits Report</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Repeated visits</td><td>No. of cases</td></tr>';
	csv_string = "Repeated Visits,Number of cases\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_repeated_visits';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename},function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	},'script');
		 
}
       
function draw_repeated_visits_Chart() 
{
        var data = google.visualization.arrayToDataTable(column_data);
        var options = { title: 'Repeated Visits Chart', width:950, height:800, hAxis: {title: 'Repeated visits',  titleTextStyle: {color: 'red'}}, vAxis: {title: 'No. Of Cases',  titleTextStyle: {color: 'red'}} };
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}


/*********************END OF REPEATED VISITS CHART****************/

/*********************NUMBER OF PATIENTS SEEN BY EACH DOCTOR CHART****************/

function number_patients_by_doctor_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
    	
    	url = base_url+'index.php/mne/graphical_reports/number_patients_by_doctor_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	pie_data=[['Doctor\'s Name', 'No of cases']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		pie_data.push(element);
		      	}
		    
        		draw_number_patients_by_doctor_Chart();
        		get_pdf_and_csv_for_number_patients_by_doctor_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_number_patients_by_doctor_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Number OF Patients Seen By Each Doctor Report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Doctor Name</td><td>No. of cases</td></tr>';
	csv_string = "Doctor's Name,Number of cases\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_number_patients_by_doctor';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_number_patients_by_doctor_Chart() 
{
	var data = google.visualization.arrayToDataTable(pie_data);
        var options = { width:950, height:800, title: 'NUMBER OF PATIENTS SEEN BY EACH DOCTOR CHART' };
	var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}


/*********************END OF NUMBER OF PATIENTS SEEN BY EACH DOCTOR CHART****************/

/*********************INVENTORY CONSUMED IN CLINICS CHART****************/

function inventory_consumed_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rep_feature = $("#product_type option:selected").val();
	var rep_option = $("#generic_id").val();
	var rmhc_name = $("#location_id option:selected").text();
	
    	
    	url = base_url+'index.php/mne/graphical_reports/inventory_consumed_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date, 'rep_feature':rep_feature, 'rep_option':rep_option, 'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	
		   	column_data=[['Brand Name', 'Total no. consumed']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		column_data.push(element);
		      	}
		    
        		draw_inventory_consumed_Chart();
        		get_pdf_and_csv_for_inventory_consumed_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_inventory_consumed_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Inventory consumed in Clinics Report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td><td>Feature</td><td>Generic ID</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'<td>'+rep_feature+'<td>'+rep_option+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Brand Name</td><td>Total No. consumed</td></tr>';
	csv_string = "Brand Name,Total No. Consumed\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_inventory_consumed';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{ 'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_inventory_consumed_Chart() 
{
        var data = google.visualization.arrayToDataTable(column_data);
        var options = { title: 'Inventory Consumed Chart', width:950, height:800, hAxis: {title: 'Brand Name',  titleTextStyle: {color: 'red'}}, vAxis: {title: 'Total  No. Consumed',  titleTextStyle: {color: 'red'}} };
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}


/*********************END OF INVENTORY CONSUMED IN CLINICS CHART****************/


/*********************RISK FACTOR ONE CHART****************/

function risk_factor_one_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
	
    	
    	url = base_url+'index.php/mne/graphical_reports/risk_factor_one_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	column_data=[['Risk Factors', 'Total number']];
		   
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		column_data.push(element);
		      	}
        		draw_risk_factor_one_Chart();
        		get_pdf_and_csv_for_risk_factor_one_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_risk_factor_one_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>CVD Risk Factor Aggregation Report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Risk Factors</td><td>Total No. </td></tr>';
	csv_string = "Risk Factors,Total Number\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_risk_factor_aggregation';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_risk_factor_one_Chart() 
{
        var data = google.visualization.arrayToDataTable(column_data);
        var options = { title: 'CVD Risk Factor Aggregation Chart', width:950, height:800, hAxis: {title: 'Risk Factors',  titleTextStyle: {color: 'red'}}, vAxis: {title: 'Total  No.',  titleTextStyle: {color: 'red'}} };
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}


/*********************END OF RISK FACTOR ONE CHART****************/

	
/*********************RISK FACTOR two CHART****************/

function risk_factor_two_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
	
    	
    	url = base_url+'index.php/mne/graphical_reports/risk_factor_two_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date,'rmhc_name':rmhc_name },
		   function(result)
		   {	
		   	column_data=[['Number of risk factors', 'Total number']];
		      	for(x in data)
		      	{	
		   		element = [x,data[x]];
		      		column_data.push(element);
		      	}
		  
        		draw_risk_factor_two_Chart();
        		get_pdf_and_csv_for_risk_factor_two_chart();
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_risk_factor_two_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Count of CVD Risk Factor Report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:250px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Number of Risk Factors</td><td>Total No. </td></tr>';
	csv_string = "Number of Risk Factors,Number of cases\n";
	for(x in data)
	{
		table_html+='<tr><td>'+x+'<td>'+data[x]+'</td></tr>';
		csv_string+=x+','+data[x]+'\n';
	}
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_count_CVD_risk_factor';	
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{	
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       
function draw_risk_factor_two_Chart() 
{
        var data = google.visualization.arrayToDataTable(column_data);
        var options = { title: 'Count of CVD Risk Factor Chart', width:950, height:800, hAxis: {title: 'Number of risk factors',  titleTextStyle: {color: 'red'}}, vAxis: {title: 'Total  Number',  titleTextStyle: {color: 'red'}} };
	var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
}


/*********************END OF RISK FACTOR two CHART****************/



/*********************RISK FACTOR combination CHART****************/

function risk_factor_combination_chart_ajax()
{ 
    	var from_date = $("#from_date").val();
    	var to_date = $('#to_date').val();
    	var rmhc = $("#location_id option:selected").val();
    	var rmhc_name = $("#location_id option:selected").text();
	var risk_factor_ids = new Array();
	
	var risk_factor;
	var risk_ids = new Array();
	
	for(i=1;i<=6;i++)
	{
		var id_value = "#"+i+":checked";
		risk_factor = $(id_value).val();
		risk_factor_ids[i-1] = risk_factor;
		
	}
	for(i=0;i<risk_factor_ids.length;i++)
	{
		if(risk_factor_ids[i])
		{
			risk_ids.push(risk_factor_ids[i]);
		}
	}   
	 
    	
    	url = base_url+'index.php/mne/graphical_reports/risk_factor_combination_chart_call';
	$.post(url,{ 'rmhc':rmhc ,'from_date':from_date,'to_date':to_date, 'risk_ids[]':risk_ids, 'rmhc_name':rmhc_name},
		   function(result)
		   {	    	
        		get_pdf_and_csv_for_risk_factor_combination_chart();
        		
       		   },'script');
    
}     		  
      
   
function get_pdf_and_csv_for_risk_factor_combination_chart()
{
	table_html = '<div style="height:50px;" align="center"><b>Risk Factors Combination Report.</b></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Risk Factor</td><td>Risk Factor Id</td></tr><tr><td>Age</td><td>1</td></tr><tr><td>BMI</td><td>2</td></tr><tr><td>WHR</td><td>3</td></tr><tr><td>Tobacco Consumption</td><td>4</td></tr><tr><td>High BP</td><td>5</td></tr><tr><td>Personal History</td><td>6</td></tr>';
	table_html+='</table></div>';	
	table_html+= '<div style="height:50px;" align="center"></div><div style="height:100px;"><table style="width=350px;height=150px;" align="center" border="1"><tr><td>Location</td><td>From Date</td><td>To Date</td><td>Risk Factor Ids</td></tr>';
	table_html+='<tr><td>'+rmhc_name+'<td>'+from_date+'<td>'+to_date+'<td>'+risk_ids+'</td></tr></table></div>';
	table_html+= '<div style="overflow:auto;height:70px;"><table style="width=350px;height=150px;" border="1" ><tr><td>Number of people having all risk factors</td><td>Number of people having also having either <br /> diabetes, hypertension or hyperlipidemia</td><td>Total Number of people</tr>';
	table_html+='<tr><td align="center">'+data[0]+'<td align="center">'+data[1]+'<td align="center">'+data[2]+'</td></tr>';
	
	table_html+='</table></div>';	
	table_html+= '<p style=" position: absolute; bottom: 0; left: 0; width: 100%; text-align: center;">This data is the sole proprietory of Sughavazhvu health care. It is illegal to copy or publish any part of this data without due permission from Sughavazhvu Health Care pvt ltd.</p>';
	filename = 'uploads/report/list_of_risk_factor_combination';	
	table_html_view = '<div style="overflow:auto;height:70px;"><table width="100%" border="0" ><tr class="head"><td>Number of people having all risk factors</td><td>Number of people having also having either <br /> diabetes, hypertension or hyperlipidemia</td><td>Total Number of people</tr>';
	
	table_html_view+='<tr class="head; grey_bg"><td align="center">'+data[0]+'<td align="center">'+data[1]+'<td align="center">'+data[2]+'</td></tr>';
	
	table_html_view+='</table></div>';	
	csv_string = "Number of people having all risk factors,Number of people having also having either diabetes, hypertension or hyperlipidemia,Total Number of people\n";
	csv_string+=data[0]+','+data[1]+','+data[2];
	$('#table_status').html(table_html_view);
	var email_address = $("#email_address").val();
	url = base_url+'index.php/mne/graphical_reports/get_pdf_and_csv_rep';

	$.post(url,{'table_html':table_html,'csv_string':csv_string, 'email_address':email_address,'filename':filename },function(result)
	{			
		link = '<a href="'+url+'.csv'+'">Click to download csv report</a>'+'\t'+'<a href="'+url+'.pdf'+'">Click to download pdf report</a>';
		
		$('#rep_link').html(link);
		$('#mail_status').html(mail_sent);
	
	},'script');
		 
}
       

/*********************END OF RISK FACTOR combination CHART****************/


	

  
    


  
    
