<?php $this->load->helper('form');
	  $this->load->view('common/header');
?>
<meta http-equiv="Content-Language" content="en" />
<meta name="GENERATOR" content="Zend Studio" />

<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script>
function checkbox_onclick(divId){
	if($(divId+"_id").is(':checked')){
		$(divId).show();
	}else{
		$(divId).hide();
	}
}

function checkbox_onclick2(divId){
	if($(divId+"_id").is(':checked')){
		$(divId).show();
	}else{
		$(divId).hide();
	}
}

function checkbox_onclick1(divId){
	if($(divId+"_top_Yes").is(':checked')){
		$(divId).show();
	}else{
		$(divId).hide();
	}
}


</script>
<title>Protocol Information Report </title>

<style>
	body{
		font-family:Arial, Helvetica, sans-serif;
		font-size:11px;
		color:#666666;
		margin:0px;
		padding:0px;
	}
	.maindiv
	{
	width:550px;
	margin:auto;
	border:#000000 1px solid;
	}
	.mainhead{background-color : #aaaaaa;}
	.tablehead{background-color : #d7d7d7;}
	.row{   background-color : #e7e7e7;}
	.data_table tr{
		font-size:11px;
		height:25px;
		background-color:#e8e8e8;
	}
	
	.largeselect {   width:200px; }

</style>
<link href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">

<?php $this->load->view('common/header_logo_block');
      $this->load->view('common/header_search');
?>

<!--Main Page-->
<?php echo validation_errors(); ?>
<form method="POST">
	<table align="center"  border="1" width="800px">
		<tr><td colspan="2" align="center"  valign="middle"><h4>Enter From and To dates For Generating Protocol Information Report.</h4> </td></tr>
	     <tr>
			     <td><b>From Date</b> </td>
			     <td>
			       <input name="from_date" id="from_date" type="text" value="<?php echo $from_date; ?>" class="datepicker check_dateFormat"  style="width:140px;"  />
			     </td>
		  </tr>
		  <tr>
			     <td> <b>To Date</b> </td>
			     <td>
			       <input name="to_date" id="to_date" type="text" value="<?php echo $to_date; ?>" class="datepicker check_dateFormat"  style="width:140px;"  />
			     </td>
	     </tr>
	     <tr>
	         <td colspan="6"  align="center"><b>From date should be before To date</b> </td>        
	     </tr>
		<tr>	
			<td><b>Location:</b></td>
			
				<td><form id ="provider_form" action = "<?php echo $this->config->item('base_url').'index.php/opd/visit/select_locn';?>" method="POST">
					<?php 
					$locations = $this->session->userdata('locations');
						if(sizeof($locations)==1){
							$loc="";
							$val="";
							foreach ( $locations as $key=>$value ) {
				       					$loc = $value;
				       					$val=$key;
							}
							echo ' <b>'.$loc.'</b>';			
							echo "<input type=\"hidden\" name=\"provider_location_id\" value='$val'>";
						}
						else{
							echo form_dropdown ( 'provider_location_id', $locations,'' );
						}
					?>
								
				</form>			
			</td>
		</tr>
			
		<tr valign="top"  >
	      <td valign="top"><b>Protocol Information:</b></td>
	      <td>
		    <table  align="center">
			  
		      <tr>
			    <td>  
				  <?php /**/;
				  	$jtp = $protocol_information_tree;
				  	$i = 0;
				  	// All first level nodes will have parent Node as _head which is
				  	// equal to -1
				  	foreach ($protocol_information_tree->getRootParents() as $node) {
				  		$clean_name = "protocol_".remove_whitespace1($node->getValue());
				  		if($node->getParent() != -1){
				    		$clean_name = "protocol_".remove_whitespace1($node->getValue())."_".$node->getParent();
				    		
				    	}
				  		$nameparser = "protocol_information[$i]";
				  		echo "<div class='gridrow'>";
				  		echo "<div>";
				  		echo "<div class='gridcell'>";
				  		$radio1 = array( 
				  		    'name'        => "$nameparser"."[status]",
				  		    'id'          => "{$clean_name}_top_Yes",
				  		    'value'       => 'Yes',
				  		    'style'		  => 'display:horizontal',
				  		);
				  		echo " <input type='hidden' name='{$nameparser}[name]' value='{$node->getValue()}'> ";
				  		$js1 = "onclick='javascript:checkbox_onclick1(&quot;#{$clean_name}&quot;);'";
				  		echo form_checkbox($radio1,'','',$js1);
				  		echo "</div>";
				  					  		
				    	printNode3($node, $protocol_information_tree,$nameparser,'');
				    	echo "</div><div class='clear'></div>";
				    	 $i++;
				    }
					
				    function printNode3 ($node, $protocol_information_tree,$nameparser,$j=0) {
				    	$clean_name = "protocol_".remove_whitespace1($node->getValue());
				    	if($node->getParent() != -1){
				    		$nameparser = $nameparser."[$j]";
				    	}
				    	if($node->getParent() != -1){
				    		$clean_name = "protocol_".remove_whitespace1($node->getValue())."_".$node->getParent();
				    	}
					    if($node->getType() == 'CHECKBOX' && $node->getParent() != -1){
					    	
							$checkBox = array (
								'name'        => "{$nameparser}"."[value]",
								'value'       => "{$node->getValue()}",
								'id'          => "{$clean_name}"."_id",
							);
							
							$jsCB = "onclick='javascript:checkbox_onclick(&quot;#{$clean_name}&quot;);'";
							echo  form_checkbox($checkBox,'','',$jsCB);
							echo "(".ucwords(strtolower($node->getType())).")&nbsp;".ucwords($node->getValue());
							echo "<br />";
						}else if($node->getType() == 'RADIO' && $node->getParent() != -1 ){
							$radio_array = $node->getDetails();							
							$replaced_string=str_replace(',','|',$radio_array);	
							$replaced_string=$replaced_string.'|';
							$radio = array (
													'name'        => "{$nameparser}",
													'value'       => "{$replaced_string}",
												);
								$jsR = "onclick='javascript:$(&quot;#{$clean_name}&quot;).show();'";
								echo  form_checkbox($radio,'','',$jsR);
								echo "(".ucwords(strtolower($node->getType())).")&nbsp;".ucwords($radio_array);
							
							echo "<br />";
						}else if($node->getType() == 'SELECT' && $node->getParent() != -1 ){
							$select_array = explode(",",($node->getDetails()));
							$select_values_array = array();
							$select_options='';
							foreach ($select_array as $key => $value){
								$select_values_array[$value.",".$node->getValue()] = $value;
								$select_options=$select_options.''.$value."_".$node->getValue().'|';
							}
							echo  form_checkbox("{$nameparser}",$select_options);
							echo "(".ucwords(strtolower($node->getType())).")&nbsp;".ucwords($node->getValue());
							echo "<br />";
						}else if($node->getType() == 'FOLLOWUP' && $node->getParent() != -1 ){
							//to prevent text(ie follow up name) from getting displayed on screen 
						}else if($node->getType() == 'TEXTBOX' && $node->getParent() != -1 ){					
							$text = array (
								'name'        => "{$nameparser}",
								'size'        => '20',
							);
							echo  form_checkbox($text,$node->getValue());
							echo "(".ucwords(strtolower($node->getType())).")&nbsp;".ucwords($node->getValue());
							
							
							echo "<br />";
						}else if($node->getType() == 'TEXT' && $node->getParent() != -1 ){      
							$checkBox = array (
								'name'        => "{$nameparser}"."[value]",
								'id'          => "{$clean_name}"."_id",
								'value'       =>  "{$node->getValue()}",
							);
							$jsCB = "onclick='javascript:checkbox_onclick(&quot;#{$clean_name}&quot;);'";
							
							echo  form_checkbox($checkBox,'','',$jsCB);
							//echo  "<input type='hidden' name='{$nameparser}' value='{$node->getValue()}' />";
							echo "(".ucwords(strtolower($node->getType())).")&nbsp;".ucwords($node->getValue());
							echo "<br />";
						}else{
							echo "<div class='gridcell'>".ucwords($node->getValue())."</div></div></br>";
						}
						
				    	$children = $node->getChildren();
				    	if(!empty($children)){
				    		$j=0;
				    		echo "<div class='griddropdown' id = '{$clean_name}' style='display:none;'><span>";
				    		$child_details = "";
				    		foreach ($children as $childUid) {
				    			$childnode = $protocol_information_tree->getNode($childUid);
				    			printNode3($childnode, $protocol_information_tree,$nameparser,$j);
				    			$j++;
				    		}
				    		echo "</span></div>";
				    	}
				   	
					}

					function remove_whitespace1($name) {
						$temp_str = preg_replace('#[ ,\/()+]#s', '_', ltrim(rtrim($name)));
						return str_replace("'", "_",$temp_str);
					}
					
				  ?>
					  <div class="clear"></div>
				     </td>
			  	</tr>
			</table>
	      </td>
	    </tr>

		<tr>	
			<td colspan="2" align="center">
			<input type="submit" name="get_report" value="Create Report"> </td>
		</tr>
		<?php	
			if(isset($protocol_visits_filename))
			{ ?>
	   <tr class="row">
  			 <td colspan="4" > <a href="<?php echo $this->config->item('base_url').'/uploads/visits/configuration_report/protocol_configuration_report/'.$protocol_visits_filename;?>"> Report generated. Click here to download. </a> </td>
  		</tr>
		<?php }else if(isset($no_data) && $no_data){
			?>
		<tr class="row">
  			 <td colspan="4" ><h4 style="color:#f00"> No data found for the given date range.</h4> </td>
  		</tr>
			
		<?php } ?>
	</table>
</form>
<br><br>


<!--Body Ends-->

<?php $this->load->view('common/footer.php'); ?>


