


<?php if(isset($edit_test_group)){
 	$val="Edit";
 }else{
 	$val="Add";
 }?>
<tr><td colspan="3" align="center"><strong><?php echo  $val;?> Test Group</strong></td></tr>
<tr>
	<td ><strong>Name</strong><span style="color:#FF0000">*</span></td>
	<td ><strong>:</strong></td>
		<td ><input type="text" name="test_group_name" id="test_group_name" value="<?php if(isset($edit_test_group)){ echo $edit_test_group->name; } ?>" <?php if(isset($edit_test_group)){?> disabled<?php }?> />
		<input type='hidden' name='test_group_id' id='test_group_id' value='<?php if(isset($edit_test_group)) echo $edit_test_group->id; else echo "" ; ?>' />
		<label class="error" id="error_add_test_group" style="display:none"> Test Group name is required </label>
		<?php if(isset($edit_test_group)){
    	echo "<input type='hidden' name='test_group_name' id='test_group_name_hidden' value='$edit_test_group->name' />";
    }?>
	</td>
	
</tr>

<tr>
	<td ><strong>Description<strong></strong></td>
	<td ><strong>:</strong></td>
	<td ><textarea rows="3" cols="25" name="test_group_desc" id="test_group_desc" value="<?php if(isset($edit_test_group)) echo $edit_test_group->description; else echo "" ; ?>"><?php if(isset($edit_test_group)) echo $edit_test_group->description; else echo "" ; ?></textarea></td>
</tr>
<tr>
	<td colspan='3' align="center"><strong>Add Tests To The Group<strong></strong></td>
	
</tr>
<tr>
	<td ><strong>Test name</strong></td>
	<td ><strong>:</strong></td>
	<td ><input type="text" name="test_name" id="test_name" value="" />
		<label class="error" id="error_add_test" style="display:none"> Please enter Test name  </label>
		<input id="test_id" type="hidden"/>
		<input id="test_cost" type="hidden"/>
		<input id="add_test" type="button" value="Add">
		 <label class="error" id="add_test_error" style="display:none"> Please add atleast 1 Test  </label>
	 </td>
	
</tr>

<tr>
	<td colspan="3" >
      <table id="tests" width="100%" cellspacing="2" cellpadding="2" style="border:1px solid;">
		<tr class="scm_head">
		  <td width="60%">Test name</td>
		  <td width="11%">Cost</td>
		   <td width="8%">Remove</td>
		</tr>
		  
	
		<?php
			$i=1;
			if(isset($test_config_details)){
				foreach($test_config_details as $config_details){?>
				
				
				<tr>
					
					<?php 
					 $name=$this->test_types->find_by('id',$config_details->test_id);
						if(empty($name->description)){
					 		$test_name=$name->name;
						}else{
							$test_name=$name->name.'-'.$name->description;
						}
						$test_cost=$name->cost;?>
						
						
						
					<td><input type="hidden" id="test_<?php echo $i;?>_name" name="test_[<?php echo $i;?>][name]" value="<?php echo $test_name;?>"/><?php echo $test_name;?></td>
					<td><input type="hidden" id="test_<?php echo $i;?>_cost" name="test_[<?php echo $i;?>][cost]" value="<?php echo $test_cost;?>"/><?php echo $test_cost;?></td>
					<input type="hidden" name="test_[<?php echo $i;?>][test_id]" value="<?php echo $config_details->test_id;?>" id="test_<?php echo $i;?>_test_id"/>
					<td onmousedown="removeRow(this)"><a href="#" >Remove</a></td>
					<?php $i= $i+1;?>
						<?php }?>
				
				
				</tr>
					<?php }?>
				<input id="test_row_id" type="hidden" value="<?php echo $i;?>"/> 
		</table>
	</td>
</tr>



<tr>
	<td colspan="3" align="center"><strong>Add Consumables to The Group<strong></strong></td>
	
</tr>
<tr>
	<td ><strong>Consumable name<strong></strong></td>
	<td ><strong>:</strong></td>
	<td ><input type="text" id="selected_consumable"  value=""/><label class="error" id="error_add_drug" style="display:none"> Please enter consumable name  </label>
		<input id="consumable_product_id" type="hidden"/> 
		
	</td>
	
</tr>
<tr>
	<td ><strong>Consumable quantity(lab)<strong></strong></td>
	<td ><strong>:</strong></td>
	<td ><div style="float:left"><input type="text" id="selected_quantity_lab"  value=""/></div>
		
		<div class="ret_purch_unit"><div class="consumable_style" ><b>Ret Unit:</b></div><div  class="consumable_style" id="consumable_retail_unit" ></div></div>
		<div class="ret_purch_unit"><div  class="consumable_style" >&nbsp;&nbsp;&nbsp;<b>Purc Unit:</b></div><div  class="consumable_style" id="consumable_purchase_unit"  ></div></div>
		<div class="consumable_style" ><label class="error" id="error_add_quantity_lab" style="display:none"> Please enter quantity  </label></div>
	  <div class="consumable_style" ><label class="error" id="error_numeric_quantity_lab" style="display:none">Consumable quantity should be numeric  </label></div>
	  </td>
</tr>
<tr>
	<td ><strong>Consumable quantity(clinic)<strong></strong></td>
	<td ><strong>:</strong></td>
	<td ><input type="text" id="selected_quantity_clinic"  value=""/>
		<label class="error" id="error_add_quantity_clinic" style="display:none"> Please enter quantity  </label>
	  <label class="error" id="error_numeric_quantity_clinic" style="display:none">Consumable quantity should be numeric  </label>

	 </td>
</tr>
<tr>
	<td colspan="3" align="center" ><input id="add_consumable" type="button" value="Add"> <label class="error" id="error_add_row" style="display:none"> Please add atleast 1 Consumable  </label></td>
</tr>

<tr>
	<td colspan="3" >
      <table id="consumables" width="100%" cellspacing="2" cellpadding="2" style="border:1px solid;">
		<tr class="scm_head">
		  <td width="55%">Name</td>
		  <td width="18%">Qty(lab)</td>
		   <td width="15%">Qty(clinic)</td>
		    <td width="18%">Retail Unit</td>
		  <td width="17%">Remove</a></td>
		</tr>
		 <?php
		$i=1;
		if(isset($consumable_config_details)){
			foreach($consumable_config_details as $config_details){?>
			<tr>
				
				<?php 
				 $name=$this->product->find_by('id',$config_details->product_id);
					$product_name=$name->name;?>
					
					
					
				<td><input type="hidden" id="selected_<?php echo $i;?>_consumable" name="selected_[<?php echo $i;?>][consumable]" value="<?php echo $product_name;?>"/><?php echo $product_name;?></td>
				<td><input type="hidden" id="selected_<?php echo $i;?>_quantity_lab" name="selected_[<?php echo $i;?>][quantity_lab]" value="<?php echo $config_details->quantity_lab;?>"/><?php echo $config_details->quantity_lab;?></td>
				<td><input type="hidden" id="selected_<?php echo $i;?>_quantity_clinic" name="selected_[<?php echo $i;?>][quantity_clinic]" value="<?php echo $config_details->quantity_clinic;?>"/><?php echo $config_details->quantity_clinic;?></td>
				<td><?php echo $name->retail_unit;?></td>
				<input type="hidden" name="selected_[<?php echo $i;?>][product_id]" value="<?php echo $config_details->product_id;?>" id="selected_<?php echo $i;?>_product_id"/>
				<td onmousedown="removeRow(this)"><a href="#" >Remove</a></td>
				<?php $i= $i+1;?>
					<?php }?>
			
			
				</tr>
				<?php }?>
			<input id="consumable_row_id" type="hidden" value="<?php echo $i;?>"/>
		  </table>
		</td>
	</tr> 
	
	<tr>
		<td width="100%" align="right" colspan="3"><input type="submit"
		value="Submit" name="submit" class="submit" /></td>
	</tr>
