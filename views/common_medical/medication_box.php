	    <link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
	    <style type="text/css">
		
</style>
      <script  type="text/javascript">
		// Have to assign the medications_list while inline - it should be
		// be available on document load
		var medications_list = new Array();      
		medications_list = [      
			<?php	
			foreach ($product_stocks as $prod_stock) {
				$total_qty=0;
				$product_r = $this->product->find_by('id',$prod_stock);
				if($product_r->product_type === 'MEDICATION'){
					foreach ($product_batch_details as $prod){
						if($prod->product_id===$prod_stock){
							$total_qty=$total_qty+$prod->quantity;
						}	
					}
					$name = $product_r->name;
					if (isset ($product_r->generic_name) && !($product_r->generic_name === ""))
						$name = $name . '(' . $product_r->generic_name . ')';
			
					if (isset ($product_r->strength) && !($product_r->strength === "") && isset ($product_r->form) && !($product_r->form === "") && isset ($product_r->strength_unit) && !($product_r->strength_unit === ""))
						$name = $name . ' -'.$product_r->form. '-' . $product_r->strength . ' ' . $product_r->strength_unit;
					$rate = $product_r->mrp;
					?>
					{id: '<?php echo $product_r->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>', quantity: '<?php echo round($total_qty,2); ?>'},
				<?php	
				}
			}
			?>
		];
		var opd_product_list = new Array();
		opd_product_list = [
			<?php	
			foreach ($product_stocks as $prod_stock) {
				$total_qty=0; 
				$product_r = $this->product->find_by('id',$prod_stock);
				if($product_r->product_type === 'OUTPATIENTPRODUCTS' && $product_r->product_order_type!='MADETOORDER'){
					foreach ($product_batch_details as $prod){
						if($prod->product_id===$prod_stock){
							$total_qty=$total_qty+$prod->quantity;
						}	
					}
					$name = $product_r->name;
					$order_type=$product_r->product_order_type;
					if (isset ($product_r->generic_name) && !($product_r->generic_name === ""))
						$name = $name . '(' . $product_r->generic_name . ')';
			
					if (isset ($product_r->strength) && !($product_r->strength === "") && isset ($product_r->form) && !($product_r->form === "") &&  isset ($product_r->strength_unit) && !($product_r->strength_unit === ""))
						$name = $name . ' -'.$product_r->form. '-' . $product_r->strength . ' ' . $product_r->strength_unit;
					$rate = $product_r->mrp;
					?>
					{id: '<?php echo $product_r->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>', order_type: '<?php echo $order_type; ?>', quantity: '<?php echo round($total_qty,2); ?>'},
				<?php	
				}
			}
			$product_to_order=$this->product->where('product_type','OUTPATIENTPRODUCTS')->where('product_order_type','MADETOORDER')->find_all();
			foreach ($product_to_order as $prod_stock) {
					$name = $prod_stock->name;
					$order_type=$prod_stock->product_order_type;
					if (isset ($prod_stock->generic_name) && !($prod_stock->generic_name === ""))
						$name = $name . '(' . $prod_stock->generic_name . ')';
			
					if (isset ($prod_stock->strength) && !($prod_stock->strength === "") && isset ($product_r->form) && !($product_r->form === "") &&  isset ($prod_stock->strength_unit) && !($prod_stock->strength_unit === ""))
						$name = $name . ' -'.$product_r->form. '-' . $product_r->strength . ' ' . $product_r->strength_unit;
					$rate = $prod_stock->mrp;
					?>
					{id: '<?php echo $prod_stock->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>', order_type: '<?php echo $order_type; ?>'},
				<?php	
				
			}
			?>
		];
		var service_list = new Array();
		service_list = [
			<?php	
				foreach ($opd_service_list as $service_list) {
						$service_name = $service_list->name;
						$service_rate = $service_list->price;
						?>
						{id: '<?php echo $service_list->id; ?>', name: '<?php echo $service_name; ?>', rate: '<?php echo $service_rate; ?>'},
					<?php	
				}
			?>
  		];



		
		//service_list = [{id:'1',name:'service1',rate:'4'},{id:'2',name:'service2',rate:'100'},{id:'3',name:'service3',rate:'200'},{id:'4',name:'service4',rate:'300'},{id:'5',name:'service5',rate:'500'}];
      </script>
      
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common_medical/medication_box.js"; ?>"></script>
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/opd_product_autocomplete.js"; ?>"></script>
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
      
      <div class="form_row" style="margin-bottom:10px;">
		<div class="form_newbtn" align="left" style="float:left;">
		  <input id="show_medication_box" type="button" value="Add Item" />
		  <input id="medication_row_id" type="hidden" value="1"/>
		</div>
      </div>
      
      
      <div id="edit_medication_box">
		  <div class="form_row" style="padding-left:15px;">
		    <div class="form_left">Item Type</div>
		    <div class="form_right">
		      <select name="medication_type" id="medication_type">
				<option value="medication">Drugs</option>
				<option value="opdproducts">Out Patient Products</option>
				<option value="services">Services</option>
		      </select>
		    </div>
		  </div>
		  
		  <!--Start Of medication box-->
		  <div class="form_data" id="medication_box">
		    <fieldset>
		      <legend>Details</legend>
		      	<div class="form_row" style="margin-top:10px;">
					<div class="form_left">Name of medicine</div>
					<div class="form_right">
						<input id="medication_name" type="text" value="" size="26"/>
						<input id="medication_product_id" type="hidden"/> 
						<input id="medication_rate" type="hidden" />
					</div>
					<div class="form_right">Qty in Batch &nbsp;</div>
					<div class="form_right" id="medication_stock_qty" ></div>
		  		</div>
		      	
		      	<div class="form_row">
					<div class="form_left">Frequency&nbsp;</div>
					<div class="form_right">
			  			<select name="medication_frequency" id="medication_frequency">
			    			<option value="BID">BID</option>
			    			<option value="OD">OD</option>
			   			 	<option value="Once">Once</option>
			    			<option value="TID">TID</option>
			  			</select>
					</div>
		      	</div>
		      
		      <div class="form_row">
				<div class="form_left">Route of Administration</div>
				<div class="form_right">
			  		<select name="medication_administration_route" id="medication_administration_route">
			    		<option value="Oral Solid">Oral Solid</option>
					    <option value="Oral Liquid">Oral Liquid</option>
					    <option value="Topical">Topical</option>
					    <option value="SC">SC</option>
					    <option value="PR">PR</option>
					    <option value="IV">IV</option>
					    <option value="IM">IM</option>
					    <option value="Procedure">Procedure</option>
					    <option value="Consumable">Consumable</option>
			  		</select>
				</div>
		      </div>
		      
		      <div class="form_row">
				<div class="form_left">Duration</div>
				<div class="form_right">
			  		<input id="medication_duration" type="text" value="" size="5" />
			  		&nbsp;	
			  		<select name="medication_duration_type" id="medication_duration_type">
				    	<option value="days">days</option>
				    	<option value="once">once</option>
				    	<option value="hours">hours</option>
				  </select>
				  <label class="error" id="error_duration_quantity" style="display:none">Duration value should be numeric  </label>
				</div>
		      </div>
		      
		      <div class="form_row">
		      	<div class="form_left">&nbsp;</div>
				<div class="form_right">
			  		<div class="form_newbtn" align="right">
			    		<input id="add_medication" type="button" value="Add"/>
			  		</div>
				</div>
		      </div>
		  </div>
		  <!--End Of medication box-->
		  
		  <!--Start Of OPD Product box-->
		  <div class="form_data" id="opdproducts_box" style="display:none;">
		    <fieldset>
		      <legend>Details</legend>
		      	<div class="form_row" style="margin-top:10px;">
					<div class="form_left">Name of OP product</div>
					<div class="form_right">
						<input id="opd_product_name" type="text" value="" size="26"/>
						<input id="opd_product_product_id" type="hidden"/> 
						<input id="opd_product_rate" type="hidden" />
					</div>
					<div class="form_right">Qty in Batch &nbsp;</div>
					<div class="form_right" id="op_product_stock_qty" ></div>
		  		</div>
		      	
		      	<div class="form_row">
					<div class="form_left">Number of pieces&nbsp;</div>
					<div class="form_right">
			  			<input id="opd_product_pieces" type="text" value="" size=3/><label class="error" id="error_opd_quantity" style="display:none">Pieces quantity should be numeric  </label>
			  			
					</div>
		      	</div>
		      
		      <div class="form_row">
				<div class="form_left">&nbsp;</div>
				<div class="form_right">
			  		<input id="opd_product_order_type" type="checkbox"/>
			  		Product given out
				</div>
		      </div>
		      
		      <div class="form_row">
		      	<div class="form_left">&nbsp;</div>
				<div class="form_right">
			  		<div class="form_newbtn" align="right">
			    		<input id="add_opd_product" type="button" value="Add"/>
			  		</div>
				</div>
		      </div>
		  </div>
		  <!--End Of OPD Product box-->
		  
		  <!--Start Of services box-->
		  <div class="form_data" id="services_box" style="display:none;">
		    <fieldset>
		      <legend>Details</legend>
		      	<div class="form_row" style="margin-top:10px;">
					<div class="form_left">Name of service</div>
					<div class="form_right">
						<input id="service_name" type="text" value="" size="26"/>
						<input id="service_id" type="hidden"/> 
						<input id="service_rate" type="hidden" />
					</div>
		  		</div>
		      	
		      <div class="form_row">
		      	<div class="form_left">&nbsp;</div>
				<div class="form_right">
			  		<div class="form_newbtn" align="right">
			    		<input id="add_service" type="button" value="Add"/>
			  		</div>
				</div>
		      </div>
		  </div>
		  <!--End Of services box-->
      </div>
	<table id="medications" width="100%" border="0" cellspacing="2" cellpadding="2">
		<tr class="head">
		  <td width="35%">Name</td>
		  <td width="5%">Freq</td>
		  <td width="5%">Dur / pieces</td>
		  <td width="5%">Unit</td>
		  <td width="10%">Route</td>
		  <td width="10%">Remove</a></td>
		</tr>
      </table>
  
	