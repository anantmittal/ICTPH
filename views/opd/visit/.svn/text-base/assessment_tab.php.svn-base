<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript">
$(document).ready(function(){
    var diagnosis = [ <?php foreach ($opd_diagnosis_list as $d) { echo "'".$d->value."',";} ?>
    ];
        
    $("#differential_diagnosis").autocomplete(diagnosis, { 
      multiple: true,
      mustMatch: true,
      matchContains: true,
      autoFill: true
	});

});
</script>
	
<table>  
  <tbody>
    <!-- tr>
      <td>Assessment: </td>
      <td><textarea cols="50" rows="4" id="assessment_txt" name="assessment"><?php if (isset($visit_obj)) {echo $visit_obj->assessment;} ?></textarea></td>  
    </tr -->
    
    <tr>
      <td>Diagnosis:</td>
	<?php 
		$current_diagnosis = '';
		if(isset($visit_obj))
		{
			$i=0;
			foreach($visit_diagnosis as $d)
			{
				if($d->diagnosis != '')
				{
					if($i > 0)
						$current_diagnosis = $current_diagnosis.',';
					$current_diagnosis = $current_diagnosis.$d->diagnosis;
					$i++;
				}
			}
		}
	?>

      <td><input type="text" size="60" id="differential_diagnosis" name="differential_diagnosis" value="<?php echo $current_diagnosis;?>"/></td>
    </tr>
    
    <tr>
      <td>Risk Level:</td>
      <td>
		<?php 
              	    $levels = array('Very Low' =>'Very Low', 'Low' =>'Low', 'Moderate' => 'Moderate', 'High' => 'High', 'Very High' => 'Very High');
		     if (isset($visit_obj)) {$current_level = $visit_obj->risk_level;} else {$current_level ='Very Low';}
                    echo form_dropdown('risk_level', $levels, $current_level,'id="risk_level"');
		?>
      </td>
    </tr>
    <tr valign="top">
      <td valign="top">Protocol Information:</td>
      <td>
	
		<table class="grid" width="100%" >
		  <tr>
		  	<td>
		  	 	
			  <div class='gridcellheader' style='padding:7px 7px 4px;'>Y</div>
			  <div class='gridcellheader' style='padding:7px 7px 4px;'>N</div>
			  <div class='gridcellheader' style='padding:7px 7px 4px;'>N/A</div>
		  	</td>
		  </tr>
		  
			  <tr>
				  <td>  
				  <?php /**/;
				  	$jtp = $protocol_information_tree;
				  	$i = 0;
				  	$is_yes=false;
	  				$is_no=false;
	  				$details="";
	  				$visible_elements = array();
				  	
				  	// All first level nodes will have parent Node as _head which is
				  	// equal to -1
				  	foreach ($protocol_information_tree->getRootParents() as $node) {
				  		$clean_name = "protocol_".remove_whitespace1($node->getValue());
					  	if(isset($visit_protocol)){
				  			$is_yes = node_exists2($node->getValue(),$visit_protocol);
				  			$is_no = no_protocol($node->getValue(),$visit_protocol);
				  		}
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
				  		$js1 = "onclick='javascript:$(&quot;#{$clean_name}&quot;).show(500);'";
				  		echo form_radio($radio1,'',$is_yes,$js1);
				  		if($is_yes){
							array_push($visible_elements,$clean_name);
						}
				  		echo "</div>";

				  		echo "<div class='gridcell'>";
				  		$radio2 = array (
				  			'name'        => "$nameparser"."[status]",
				  			'id'          => "{$clean_name}_top_No",
				  			'value'       => 'No',
				  		);
				  		echo " <input type='hidden' name='{$nameparser}[name]' value='{$node->getValue()}'> ";
				  		$js2 = "onclick='javascript:$(&quot;#{$clean_name}&quot;).hide(500);'";
				  		echo form_radio($radio2,'',$is_no,$js2);
				  		echo "</div>";

				  		echo "<div class='gridcell'>";
				  		$radio3 = array (
				  			'name'        => "$nameparser"."[status]",
				  			'id'          => "{$clean_name}_top_NA",
				  			'value'       => 'NA',
				  		);
				  		$js3 = "onclick='javascript:$(&quot;#{$clean_name}&quot;).hide(500);'";
				  		echo form_radio($radio3,'','',$js3);
				  		echo "</div>";	
				  		if(isset($visit_protocol)){
				  			$details = get_child2($node->getValue(),$visit_protocol);
				  		}
				  		// we get here details of each root node i.e json struture
				  		//echo $details;
				    	printNode3($node, $protocol_information_tree,$nameparser,'',$visible_elements,$details);
				    	echo "</div><div class='clear'></div>";
				    	 $i++;
				    }
					
				    function printNode3 ($node, $protocol_information_tree,$nameparser,$j=0,$visible_elements,$details) {				    	
				    	$clean_name = "protocol_".remove_whitespace1($node->getValue());
				    	if($node->getParent() != -1){
				    		$nameparser = $nameparser."[$j]";
				    	}
				    	if($node->getParent() != -1){
				    		$clean_name = "protocol_".remove_whitespace1($node->getValue())."_".$node->getParent();
				    	}
					    if($node->getType() == 'CHECKBOX' && $node->getParent() != -1){
					    	$pos = strpos($details,strtolower($node->getValue()));
					    	$is_checked = false;
						    if($pos === false) {
							 	$is_checked = false;
							}
							else {
							 	$is_checked = true;
							}
							$checkBox = array (
								'name'        => "{$nameparser}"."[value]",
								'value'       => "{$node->getValue()}",
								'id'          => "{$clean_name}"."_id",
							);
							
							$jsCB = "onclick='javascript:checkbox_onclick(&quot;#{$clean_name}&quot;);'";
							echo  form_checkbox($checkBox,'',$is_checked,$jsCB);
							echo ucwords($node->getValue());
							echo "<br />";
						}else if($node->getType() == 'RADIO' && $node->getParent() != -1 ){							
							$radio_array = explode(",",($node->getDetails()));
							for ($i = 0; $i < sizeof($radio_array); $i++) {
								$radio_value = $radio_array[$i];
								$pos = strpos($details,$radio_array[$i]);
								$is_checked = false;
							    if($pos === false) {
								 	$is_checked = false;
								}
								else {
								 	$is_checked = true;
								}
								$radio = array (
													'name'        => "{$nameparser}",
													'value'       => "{$radio_value}",
												);
								$jsR = "onclick='javascript:$(&quot;#{$clean_name}&quot;).show(500);'";
								echo  form_radio($radio,'',$is_checked,$jsR);
								echo ucwords($radio_value);
							}
							echo "<br />";
						}else if($node->getType() == 'SELECT' && $node->getParent() != -1 ){
							$select_array = explode(",",($node->getDetails()));
							$select_values_array = array();
							$selected_value = "";
							foreach ($select_array as $key => $value){
								$select_values_array[$value.",".$node->getValue()] = $value;
								$pos=strpos($details,$value.",".$node->getValue());	
						    	if($pos === false) {
									 //$selected_value = "";
								}else {
								 	 $selected_value = $value.",".$node->getValue(); 	 
								}
							}
							//$jsR = "onclick='javascript:$(&quot;#{$clean_name}&quot;).show();'";
							echo ucwords($node->getValue());
							echo  form_dropdown("{$nameparser}",$select_values_array,$selected_value);
							echo "<br />";
						}
						else if($node->getType() == 'FOLLOWUP' && $node->getParent() != -1 ){							
							$select_array = explode(",",($node->getDetails()));
							$select_values_array = array();
							$selected_value = "";
							foreach ($select_array as $key => $value){
								$select_values_array[$value.",".$node->getValue()] = $value;
								$pos=strpos($details,$value.",".$node->getValue());
								if($pos === false) {
									//$selected_value = "";
								}else {
									$selected_value = $value.",".$node->getValue();									
								}
							}
							// get date from json structure
							$date_value="";
							if (preg_match ("#([0-9]{1,2})/([0-9]{1,2})/([0-9]{4})#s", $details, $regs)) {
								$date_value = "$regs[1]/$regs[2]/$regs[3]";
							}					
							
							echo ucwords($node->getValue());
							$rootNode = get_root_node($node->getParent(),$protocol_information_tree,$node->getValue());							
							echo  form_dropdown("followup_protocol_value_$rootNode",$select_values_array,$selected_value);
							if(!empty($date_value)){
								echo "<br /><input name= \"followup_protocol_date_$rootNode\" id= \"followup_date_$rootNode\" type=\"text\" value=\"$date_value\" class =\"datepicker check_dateFormat\" /> ";
							}else{
								echo "<br /><input name= \"followup_protocol_date_$rootNode\" id= \"followup_date_$rootNode\" type=\"text\" value=\"DD/MM/YYYY\" class =\"datepicker check_dateFormat\" /> ";
							}
													
						}
						else if($node->getType() == 'TEXTBOX' && $node->getParent() != -1 ){
							$val="";
							if($details !== ''){
								$json_object = json_decode($details);
								if(isset($json_object->name)){
									//$val = ucwords($json_object->name);	 // textbox are always populated with empty value						
								}
							}							
							$text = array (
								'name'        => "{$nameparser}",
								'size'        => '20',
							);
							
							echo ucwords($node->getValue());
							echo  form_input($text,$val);
							
							echo "<br />";
						}else if($node->getType() == 'TEXT' && $node->getParent() != -1 ){      
							echo  form_label(ucwords($node->getValue()),"{$nameparser}");
							echo "<br />";
						}else{
							echo "<div class='gridcell'>".ucwords($node->getValue())."</div></div></br>";
						}
						
				    	$children = $node->getChildren();
				    	if(!empty($children)){
				    		$j=0;
				    		if($node->getType() == 'TEXT' && $node->getParent() != -1){
				    			echo "<div class='griddropdown' id = '{$clean_name}'><span>";
				    		}else{
				    			echo "<div class='griddropdown' id = '{$clean_name}' style='display:none;'><span>";
				    		}
				    		$child_details = "";
				    		foreach ($children as $childUid) {
				    			$childnode = $protocol_information_tree->getNode($childUid);
				    			//$child_details = get_sub_child_value2($childnode,$details);
				    			printNode3($childnode, $protocol_information_tree,$nameparser,$j,$visible_elements,$details);
				    			$j++;
				    		}
				    		echo "</span></div>";
				    	}
				   	
					}
					echo '<script language=javascript>';
							foreach ($visible_elements as $elements) {
								echo "$('#$elements').show(500);";
							}
					echo '</script>'		
					
				  ?>
				  <div class="clear"></div>
			     </td>
		  	</tr>
		</table>
      </td>
    </tr>
    <?php
	
		function node_exists2($value,$visit_protocol){							
			$ret_val = false;
			if(isset($visit_protocol)){ 
				foreach($visit_protocol as $protocol_row){
					if(ucwords($protocol_row->name) == ucwords($value) && ucwords($protocol_row->status)=='Yes'){
						$ret_val = true;
						break;
					}
				}
			 }
			 return $ret_val;
		}
		function no_protocol($value,$visit_protocol){							
			$ret_val = false;
			if(isset($visit_protocol)){ 
				foreach($visit_protocol as $protocol_row){
					if(ucwords($protocol_row->name) == ucwords($value) && ucwords($protocol_row->status)=='No'){
						$ret_val = true;
						break;
					}
				}
			 }
			 return $ret_val;
		}
		
		function get_child2($value,$visit_protocol){
			$ret_val = "";
			if(isset($visit_protocol)){
				foreach($visit_protocol as $protocol_row){
					if(ucwords($protocol_row->name) == ucwords($value)){
						$ret_val .= $protocol_row->details;
					}
				}
			 }
			 return $ret_val;
		}
		
		//Now this function is not being used
		/*function get_sub_child_value2($value,$details){						
			$ret_val = "";
			if(empty($details)){
				return $ret_val;
			}
			$parent_json = json_decode($details);
			if(!isset($parent_json)){
				return $details;
			}
			$childern_json_array = $parent_json->children;
		    for ($i = 0; $i < sizeof($childern_json_array); $i++) {
		    	$json_object = $childern_json_array[$i];
		    	if($json_object->name == '' && isset($json_object->children)){
		    		$ret_val = json_encode($childern_json_array[$i]);
		    		break;
		    	}else if($json_object->name == strtolower($value->getValue())){
		    		$ret_val = json_encode($childern_json_array[$i]);
		    		break;
		    	}else if(($value->getType() == 'RADIO' || $value->getType() == 'SELECT') 
		    				&& strpos($details,strtolower($json_object->name))){
		    		$ret_val = json_encode($childern_json_array[$i]);
		    		break;
		    	}else if($value->getType() == 'TEXTBOX'){
		    		$ret_val = json_encode($childern_json_array[$i]);
		    		break;
		    	}
		    }
			return $ret_val;
		}
		*/
		
		function get_root_node($uid,$protocol_information_tree,$followup){
			$j="";
			$test = $protocol_information_tree->getNode($uid);
			if($test->getParent() != -1){
				return get_root_node($test->getParent(),$protocol_information_tree,$followup);
			}else{
				$rootValue = $test->getValue();
				$rootValueArray = explode(" " ,$rootValue);				
				$rootValueStr = "";
				for($i=0; $i < sizeof($rootValueArray);$i++){					
					$rootValueStr .= $rootValueArray[$i]."_";
				}				
				$parent =  substr($rootValueStr , 0, -1); // to trim _ 
				
				echo "<input type =\"hidden\" value =\"{$test->getValue()}\" name =\"followup_root_{$parent}\" >";
				$j = $parent;
			}
			return $j;
			
		}
	 ?>
  </tbody>
</table>
