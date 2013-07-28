<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<title>Task Calendar</title>
<link rel='stylesheet' type='text/css' href="<?php echo $this->config->item('base_url'); ?>assets/css/theme.css" />
<link rel='stylesheet' type='text/css' href="<?php echo $this->config->item('base_url'); ?>assets/css/fullcalendar.css" />
<link rel='stylesheet' type='text/css' href="<?php echo $this->config->item('base_url'); ?>assets/css/fullcalendar.print.css" media='print' />
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.5.2.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.8.11.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/fullcalendar.js"; ?>"></script>

<style type='text/css'>
	
	#calendar {
		width: 950px;
		margin: 0 auto;
		}
		
	.cal_filters{
		float:left;
		padding: 13px; 
		padding-bottom: 0px; 
	}
	.cal_filters_contents{
		width: 950px;
		margin: 0 auto;
		padding : 10px;
		padding-left: 90px;
	}
	.cal_filters_contents table td {
		padding-right:20px;
	}
	#follow_up_color_code_box{
		width:12px;
		height:12px;
		float:left;
		-webkit-border-radius: 2px;
    	-moz-border-radius: 2px;
    	border-radius: 2px;
	}
	#follow_up_color_code_box_upper{
		float:right;
		padding-right:10px;
		
	}
	#follow_up_color_code_box_upper span{
		font-size: 11px;
		font-family: sans-serif;
		font-weight: bold;
		paddding-top:5px;
	}
</style>

<script type='text/javascript'>

	$(document).ready(function() {		
				
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			theme: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			editable: true,
			events: function(start, end, callback) {
					var start_date = start.getFullYear()+"-"+(start.getMonth()+1)+"-"+start.getDate(); //This is used only in week and day view
					var end_date = end.getFullYear()+"-"+(end.getMonth()+1)+"-"+end.getDate(); //This is used only in week and day view
					$.ajax({
					type: "POST",
            		url: "<?php echo $this->config->item('base_url').'index.php/opd/visit/fetch_cal_data/';?>",
            		dataType: "json",
            		data: {
               		 	// our hypothetical feed requires UNIX timestamps
	                	start: Math.round(start.getTime() / 1000),
	                	end: Math.round(end.getTime() / 1000),
	                	view_type: getViewType(),
	                	month : getCurrentMonth(),
	                	year : getCurrentYear(),
	                	start_date : start_date,
	                	end_date : end_date,
	                	filters:getFilterData()
            		},
            		success: function(result) {
            			//alert(result);
            			var obj = jQuery.parseJSON(result);
            			createFilters(obj.filters);
            			var events = [];
            			$.each(obj.event_data,function(key,value){
            				events.push({
	            				id:value.id,
			                	title: value.title,
			                    start: value.start,
			                    url:value.url,
			                    color:value.color
		                	});
            			});
	                	callback(events);
            		},
            		failure : function(){
            			alert("failed");
            		},
            		error : function(e){
            			alert("error");
            		}
            	});
    		},
			eventClick: function(event) {
				// opens events in a popup window 
				window.open(event.url, '_self' ,'gcalevent', 'width=700,height=600');
				return false;
			},
			dayClick: function(date, allDay, jsEvent, view) {

        		if(view != 'basicDay'){
        			changeToDayView(date);
        		}

    		},
			lazyFetching: false,
		});
		
	});
	
	function changeToDayView(date){
		$('#calendar').fullCalendar( 'gotoDate', date);
		$('#calendar').fullCalendar( 'changeView', 'basicDay' );
	}

	function getFilterData(){
		var existing_checked_protocols = "";
		$("input:checkbox[name^='filters']").each(function() {
			var value = $(this).val();
			var isChecked = $('#'+value+'_filter_id').is(':checked');
			if(isChecked){
				existing_checked_protocols = existing_checked_protocols + value + ",";
			}
		});
		return existing_checked_protocols.substring(0, existing_checked_protocols.length-1);
	}
	
	function getViewType(){
		var view = $('#calendar').fullCalendar('getView');
		return view.name;
	}
	
	function getCurrentMonth(){
		var d = $('#calendar').fullCalendar('getDate');
		return d.getMonth()+1;
	}
	
	function getCurrentYear(){
		var d = $('#calendar').fullCalendar('getDate');
		return d.getFullYear();
	}

	function createFilters(filters){
		$("#filter_contents").html("");
		var content = "<table><tr>";
		var is_any_filter_selected = "false";
		for(var i= 0; i < filters.length; i++){
			var filter = filters[i];
			var selected = "";
			if(filter.is_selected == "true"){
				selected = "checked";
				is_any_filter_selected = "true";
			}
			var id = filter.filter_value+"_filter_id";
			content += "<td>";
			content += '<input type = checkbox '+selected+' id="'+id+'" value="'+filter.filter_value+'" name=filters onClick="onFilterClick(this)" />'+filter.filter_name;
			content += "</td>";
		}
		content += "</tr></table>";
		$("#filter_contents").html(content);
		if(is_any_filter_selected == "false"){
			$("#all_filter_id").attr("checked",true);
		}
	}

	// gets called when checkboxes are checked or unchecked 
	function onFilterClick(element){
		if(element.value == "all"){
			var isChecked = $('#'+element.id).is(':checked');
			if(isChecked){			
				//$('#'+element.id).attr('checked','checked');
				$("input:checkbox[name^='filters']").each(function() {
					var protocolValue =  $(this).val();
					if(protocolValue != "all")
						$('#'+protocolValue+"_filter_id").attr('checked',false);
		        });
			}	
		}else{ 	// Handles : When 'All' checkbox is already checked and then trying to check some other checkbox(s) then 'All' checkbox is unchecked
			var isChecked = $('#all_filter_id').is(':checked');
			if(isChecked){			
				$('#all_filter_id').attr('checked',false);
			}
		}
 		$('#calendar').fullCalendar( 'refetchEvents' );
 	}

	// gets called when an event is dragged and dropped   (ajax call) 
	function updateEventDateOnDrag(eventId,dayDelta){
		var post_data ='event_id='+eventId+ '&day_delta='+dayDelta;
		$.ajax({
		    type: "POST",
		    url: "<?php echo $this->config->item('base_url').'index.php/opd/visit/update_event_date/';?>",
		    data: post_data,
		    dataType: 'html',
		    success: function(result) {
			   //alert(result);
		    }
			   
		});
	}	
		

</script>

</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>
<div id="main">
		<div class="blue_left">
			<div class="blue_right">
				<div class="blue_middle">
					<span class="head_box">Task Calendar</span>
				</div>
			</div>
		</div>
		<div class="blue_body">
			<div align="right">
			<?php $color_codes_array = $this->config->item('follow_up_color_codes');
				foreach ($color_codes_array as $key => $value){
					echo '<div id="follow_up_color_code_box_upper">';
						echo '<div id="follow_up_color_code_box" style="background:'.$value.'">&nbsp;</div>';
						echo '<span>'.ucwords(str_replace("_", " ",$key)).'</span>';
					echo '</div>';
				}
			?>
			</div>
			<div align="left" id="filter_label" class="cal_filters"><strong>Filters : </strong></div>
			<div align="left" id="filter_contents" class="cal_filters_contents"></div>
			<div id='calendar'></div>
		</div>
			
		<div class="bluebtm_left">
			<div class="bluebtm_right">
				<div class="bluebtm_middle"></div>
			</div>
		</div>
</div>
</body>
</html>
<?php $this->load->view('common/footer.php'); ?>