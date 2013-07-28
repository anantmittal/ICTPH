
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/admin/add_service.js"; ?>"></script>

<?php if(isset($edit_service)){
 	$val="Edit";
 }else{
 	$val="Add";
 }?>
<tr><td colspan="3" align="center"><strong><?php echo  $val;?> Service</strong></td></tr>
<tr>
	<td ><strong>Service Name</strong><span style="color:#FF0000">*</span></td>
	<td ><strong>:</strong></td>
	<td ><input type="text" name="service_name" id="service_name" value="<?php if(isset($edit_service)){ echo $edit_service->name; } ?>" <?php if(isset($edit_service)){?> disabled<?php }?> />
		<input type='hidden' name='service_id' id='service_id' value='<?php if(isset($edit_service)) echo $edit_service->id; else echo "" ; ?>' />
		<label class="error" id="error_add_service" style="display:none"> Service name is required </label>
		<?php if(isset($edit_service)){
    	echo "<input type='hidden' name='service_name' id='service_name_hidden' value='$edit_service->name' />";
    }?>
	</td>
</tr>

<tr>
	<td ><strong>Description<strong></strong></td>
	<td ><strong>:</strong></td>
	<td ><textarea rows="3" cols="25" name="service_desc" id="service_desc" value="<?php if(isset($edit_service)) echo $edit_service->description; else echo "" ; ?>"><?php if(isset($edit_service)) echo $edit_service->description; else echo "" ; ?></textarea></td>
</tr>
<tr>
	<td ><strong>Price<strong></strong><span style="color:#FF0000">*</span></td>
	<td ><strong>:</strong></td>
	<td ><input type="text" name="service_price" id="service_price" value='<?php if(isset($edit_service)) echo $edit_service->price; else echo "" ; ?>'/>
	<label class="error" id="error_add_price" style="display:none"> Price is required and should be numeric </label></td>
</tr>

<tr>
	<td colspan="3" align="center"><strong>Add Consumable to Service</strong></td>
	
</tr>
<tr>
	<td ><strong>Consumable name<strong></strong></td>
	<td ><strong>:</strong></td>
	<td ><input type="text" id="consumable_name"  value=""/><label class="error" id="error_add_drug" style="display:none"> Please enter consumable name  </label>
		<input id="consumable_product_id" type="hidden"/> 
		
	</td>
	
</tr>
<tr>
	<td ><strong>Consumable quantity<strong></strong></td>
	<td ><strong>:</strong></td>
	<td > <div style="float:left"> <input type="text" id="consumable_quantity"  value=""/></div>
	 <div class="ret_purch_unit"><div class="consumable_style" ><b>Ret Unit:</b></div><div  class="consumable_style" id="consumable_retail_unit" ></div></div>
		<div class="ret_purch_unit"><div  class="consumable_style" >&nbsp;&nbsp;&nbsp;<b>Purc Unit:</b></div><div  class="consumable_style" id="consumable_purchase_unit"  ></div></div>
		 <div class="consumable_style" ><label class="error" id="error_add_quantity" style="display:none"> Please enter quantity  </label></div>
	     <div class="consumable_style" ><label class="error" id="error_numeric_quantity" style="display:none">Consumable quantity should be numeric  </label></div>
	 	
	
	  </td>
</tr>
<tr>
	<td colspan="3" align="center" ><input id="add_consumable" type="button" value="Add"> <label class="error" id="error_add_row" style="display:none"> Please add atleast 1 Consumable  </label></td>
</tr>

<tr>
	<td colspan="3" align="center"><strong>Add Medications to Service</strong></td>
	
</tr>
<tr>
	<td ><strong>Medication name<strong></strong></td>
	<td ><strong>:</strong></td>
	<td ><input type="text" id="medication_name"  value=""/><label class="error" id="error_add_med_drug" style="display:none"> Please enter medication name  </label>
		<input id="medication_product_id" type="hidden"/> 
		
	</td>
	
</tr>
<tr>
	<td><strong>Medication quantity<strong></strong></td>
	<td><strong>:</strong></td>
	<td> <div style="float:left"> <input type="text" id="medication_quantity"  value=""/></div>
	 <div class="ret_purch_unit"><div class="consumable_style" ><b>Ret Unit:</b></div><div  class="consumable_style" id="medication_retail_unit" ></div></div>
		<div class="ret_purch_unit"><div  class="consumable_style" >&nbsp;&nbsp;&nbsp;<b>Purc Unit:</b></div><div  class="consumable_style" id="medication_purchase_unit"  ></div></div>
		 <div class="consumable_style" ><label class="error" id="error_add_med_quantity" style="display:none"> Please enter quantity  </label></div>
	     <div class="consumable_style" ><label class="error" id="error_numeric_med_quantity" style="display:none">Medication quantity should be numeric  </label></div>
	 	
	
	  </td>
</tr>
<tr>
	<td colspan="3" align="center" ><input id="add_medication" type="button" value="Add"> <label class="error" id="error_add_med_row" style="display:none"> Please add atleast 1 Consumable  </label></td>
</tr>

<tr>
	<td colspan="3" >
      <table id="consumables" width="600px" cellspacing="2" cellpadding="2" style="border:1px solid;">
		<tr class="scm_head">
		  <td width="330px">Name</td>
		  <td width="60px">Qty</td>
		  <td width="60px">Type</td>
		  <td width="90px">Retail Unit</td>
		  <td width="60px">Remove</a></td>
		</tr>
		 <?php
		$i=1;
		if(isset($service_config_details)){
			foreach($service_config_details as $config_details){?>
			<tr>
				
				<?php 
				 $name=$this->product->find_by('id',$config_details->product_id);
					$product_name=$name->name;?>
					
					
					
				<td><input type="hidden" id="selected_<?php echo $i;?>_consumable" name="selected_[<?php echo $i;?>][consumable]" value="<?php echo $product_name;?>"/><?php echo $product_name;?></td>
				<td><input type="hidden" id="selected_<?php echo $i;?>_quantity" name="selected_[<?php echo $i;?>][quantity]" value="<?php echo $config_details->product_quantity;?>"/><?php echo $config_details->product_quantity;?></td>
				<td><?php if( $name->product_type=="MEDICATION")echo "Medication"; else if($name->product_type=="CONSUMABLES") echo "Consumable";?></td>
				<input type="hidden" name="selected_[<?php echo $i;?>][product_id]" value="<?php echo $config_details->product_id;?>" id="selected_<?php echo $i;?>_product_id"/>
				<td><?php echo $name->retail_unit;?></td>
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