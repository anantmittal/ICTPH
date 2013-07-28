<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/visit/subjective_tab.js"; ?>"></script>
<script type="text/javascript">
</script>
  <table>
  <tbody>
    <tr>
      <td>Chief Complaint: </td>
      
      <td>
      <select  name='chief_complaint'>
      <?php  foreach ($chief_complaint_list as $row)
      {?>
      <option  value="<?php   echo ucwords($row->value); ?>" 
      		<?php 
      			if(isset($visit_obj) && $visit_obj->chief_complaint === ucwords($row->value)){
      				echo "selected";
      			}else if(ucwords($row->value) === ucwords("Not Mentioned")){
      				echo "selected";
      			}else{
      				echo "";
      			}
      			?>> <?php   echo ucwords($row->value); ?> 
      </option>
      <?php 
      }?>
      </select>   
     
	 </td>
	
        </tr>
    
    <tr>
      <td>HPI:</td>
	<?php
		if(isset($visit_obj))
			$current_hpi = $visit_obj->hpi;
		else
			$current_hpi = '';
	?>
      <td><textarea width="100%" id="hpi" name="hpi"><?php echo $current_hpi; ?></textarea></td> 
    </tr>
<!--
   <tr>
      <td></td> 
      <td><input id="load_ros_values" type="button" class="submit" value="Load Values"></input></td>
    </tr>
-->
    <tr valign="top">
      <td valign="top">Review of Systems:</td>
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
				  	$jtr = $review_of_system_tree;
				  	$i = 0;
				  	$level = 0;
	  				$is_yes=false;
	  				$is_no=false;
	  				$details="";
	  				$visible_elements = array();
				  	// All first level nodes will have parent Node as _head which is
				  	// equal to -1
				  	foreach ($review_of_system_tree->getRootParents() as $node) {
				  		$clean_name = "ros_".remove_whitespace1($node->getValue());
					  	if(isset($visit_ros)){
				  			$is_yes = node_exists1($node->getValue(),$visit_ros);
				  			$is_no = no_ros($node->getValue(),$visit_ros);
				  		}
				  		if($node->getParent() != -1){
				    		$clean_name = "ros_".remove_whitespace1($node->getValue())."_".$node->getParent();
				    	}
				  		$nameparser = "ros[$i]";
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
					  	if(isset($visit_ros)){
				  			$details = get_child1($node->getValue(),$visit_ros);
				  		}				  		
				    	printNode1($node, $review_of_system_tree,$nameparser,'',$details,$visible_elements);
				    	echo "</div><div class='clear'></div>";
				    	 $i++;
				    }
					
				    function printNode1 ($node, $review_of_system_tree,$nameparser,$j=0,$details,$visible_elements) {
				    	$clean_name = "ros_".remove_whitespace1($node->getValue());
				    	if($node->getParent() != -1){
				    		$nameparser = $nameparser."[$j]";
				    	}
				    	if($node->getParent() != -1){
				    		$clean_name = "ros_".remove_whitespace1($node->getValue())."_".$node->getParent();
				    	}if($node->getType() == 'CHECKBOX' && $node->getParent() != -1){
				    		
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
								$pos = strpos($details,strtolower($radio_array[$i]));
						    	$is_checked = false;
							    if($pos === false) {
								 	$is_checked = false;
								}else {
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
						else if($node->getType() == 'TEXTBOX' && $node->getParent() != -1 ){
							$val="";
							if($details !== ''){
								$json_object = json_decode($details);
								if(isset($json_object->name)){
									$val = ucwords($json_object->name);							
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
				    			$childnode = $review_of_system_tree->getNode($childUid);
				    			 $child_details = get_sub_child_value1($childnode,$details);
				    			printNode1($childnode, $review_of_system_tree,$nameparser,$j,$child_details,$visible_elements);
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
	
		function node_exists1($value,$visit_ros){							
			$ret_val = false;
			if(isset($visit_ros)){ 
				foreach($visit_ros as $ros_row){
					if(ucwords($ros_row->name) == ucwords($value) && ucwords($ros_row->status)=='Yes'){
						$ret_val = true;
						break;
					}
				}
			 }
			 return $ret_val;
		}
		
		function no_ros($value,$visit_ros){							
			$ret_val = false;
			if(isset($visit_ros)){ 
				foreach($visit_ros as $ros_row){
					if(ucwords($ros_row->name) == ucwords($value) && ucwords($ros_row->status)=='No'){
						$ret_val = true;
						break;
					}
				}
			 }
			 return $ret_val;
		}
		
		function get_child1($value,$visit_ros){							
			$ret_val = false;
			if(isset($visit_ros)){ 
				foreach($visit_ros as $ros_row){
					if(ucwords($ros_row->name) == ucwords($value)){
						return $ros_row->details;
					}
				}
			 }
			 return $ret_val;
		}
		
		function get_sub_child_value1($value,$details){						
			$ret_val = "";
			if(empty($details)){
				return $ret_val;
			}
			$parent_json = json_decode($details);
			if(!isset($parent_json)){
				return $details;
			}
			if(isset($parent_json->children)){
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
			}
			return $ret_val;
		}
	 ?>
  </tbody>
  </table>