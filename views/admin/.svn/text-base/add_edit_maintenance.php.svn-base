<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/admin/add_maintenance.js"; ?>"></script>
<?php if(isset($edit_maintenance)){
 	$val="Edit";
 }else{
 	$val="Add";
 }?>
<tr><td colspan="3" align="center"><strong><?php echo  $val;?> Maintenance</strong></td></tr>
<tr>
	<td ><strong> Name</strong><span style="color:#FF0000">*</span></td>
	<td ><strong>:</strong></td>
	<td ><input type="text" name="maintenance_name" id="maintenance_name" value="<?php if(isset($edit_maintenance)){ echo $edit_maintenance->name; } ?>" <?php if(isset($edit_maintenance)){?> disabled<?php }?> />
		<input type='hidden' name='maintenance_id' id='maintenance_id' value='<?php if(isset($edit_maintenance)) echo $edit_maintenance->id; else echo "" ; ?>' />
		<label class="error" id="error_add_maintenance" style="display:none"> Name is required </label>
		<?php if(isset($edit_maintenance)){
    	echo "<input type='hidden' name='maintenance_name' id='maintenance_name_hidden' value='$edit_maintenance->name' />";
    }?>
	</td>
</tr>

<tr>
	<td ><strong>Description<strong></strong></td>
	<td ><strong>:</strong></td>
	<td ><textarea rows="3" cols="25" name="maintenance_desc" id="maintenance_desc" value="<?php if(isset($edit_maintenance)) echo $edit_maintenance->description; else echo "" ; ?>"><?php if(isset($edit_maintenance)) echo $edit_maintenance->description; else echo "" ; ?></textarea></td>
</tr>

<tr>
	<td colspan="3" align="center"><strong>Add Consumable to Maintenance<strong></strong></td>
	
</tr>
<tr>
	<td ><strong>Consumable name<strong></strong></td>
	<td ><strong>:</strong></td>
	<td ><input type="text" id="selected_consumable"  value=""/><label class="error" id="error_add_drug" style="display:none"> Please enter consumable name  </label>
		<input id="consumable_product_id" type="hidden"/> 
		
	</td>
	
</tr>
<tr>
	<td ><strong>Consumable quantity<strong></strong></td>
	<td ><strong>:</strong></td>
	<td ><div style="float:left"><input type="text" id="selected_quantity"  value=""/></div>
		<div class="ret_purch_unit"> <div class="consumable_style" ><b>Ret Unit:</b></div><div  class="consumable_style" id="consumable_retail_unit" ></div></div>
		<div class="ret_purch_unit"><div  class="consumable_style" >&nbsp;&nbsp;&nbsp;<b>Purc Unit:</b></div><div  class="consumable_style" id="consumable_purchase_unit"  ></div></div>
		 <div class="consumable_style" ><label class="error" id="error_add_quantity" style="display:none"> Please enter quantity  </label></div>
	  <div class="consumable_style" ><label class="error" id="error_numeric_quantity" style="display:none">Consumable quantity should be numeric  </label></div>
	
	 	
	
	  </td>
</tr>
<tr>
	<td colspan="3" align="center" ><input id="add_consumable" type="button" value="Add"> <label class="error" id="error_add_row" style="display:none"> Please add atleast 1 Consumable  </label></td>
</tr>

<tr>
	<td colspan="3" >
      <table id="consumables" width="100%" cellspacing="2" cellpadding="2" style="border:1px solid;">
		<tr class="scm_head">
		  <td width="65%">Name</td>
		  <td width="18%">Qty</td>
		   <td width="18%">Retail Unit</td>
		  <td width="17%">Remove</a></td>
		</tr>
		 <?php
		$i=1;
		if(isset($maintenance_config_details)){
			foreach($maintenance_config_details as $config_details){?>
			<tr>
				
				<?php 
				 $name=$this->product->find_by('id',$config_details->product_id);
					$product_name=$name->name;?>
					
					
					
				<td><input type="hidden" id="selected_<?php echo $i;?>_consumable" name="selected_[<?php echo $i;?>][consumable]" value="<?php echo $product_name;?>"/><?php echo $product_name;?></td>
				<td><input type="hidden" id="selected_<?php echo $i;?>_quantity" name="selected_[<?php echo $i;?>][quantity]" value="<?php echo $config_details->product_quantity_lab;?>"/><?php echo $config_details->product_quantity_lab;?></td>
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