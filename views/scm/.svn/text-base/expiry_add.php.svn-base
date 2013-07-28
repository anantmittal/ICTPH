<?php

$this->load->helper ( 'form' );
$this->load->view ( 'common/header' );
?>
	<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.5.2.min.js"; ?>"></script>
    <link href="<?php echo "{$this->config->item('base_url')}assets/css/jquery.autocomplete.css";?>" rel="stylesheet" type="text/css"/>
      <script  type="text/javascript">
			// Have to assign the medications_list while inline - it should be
			// be available on document load
			var order_medications_list = new Array();      
			order_medications_list = [      
			<?php
			foreach ($product_batchwise_list as $product) {
				$product_id=$product;
				$product_r =$this->product->where('id',$product_id)->find();
				if($product_r->product_type=='MEDICATION'){
					$name = $product_r->name;
					$rate = $product_r->purchase_price;
					?>
					{id: '<?php echo $product_r->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>'},
					<?php
					}
				}
			?>
			];

			var order_consumable_list = new Array();      
			order_consumable_list = [      
			<?php
			foreach ($product_batchwise_list as $product) {
				$product_id=$product;
				$product_r =$this->product->where('id',$product_id)->find();
				if($product_r->product_type=='CONSUMABLES'){
					$name = $product_r->name;
					$rate = $product_r->purchase_price;
					?>
					{id: '<?php echo $product_r->id; ?>', name: '<?php echo $name; ?>', rate: '<?php echo $rate; ?>'},
					<?php
					}
				}
			?>
			];
			
			$(document).ready(function(){
				
			  $('#add_medication').click(function() {
				  if($.trim($("#medication_name").val()) == "" ){
						return ;
					}
				  $("#page-loader").show();
				  var product_id=$("#medication_product_id").val();
				  var from_id= $("#from_id").val();
				  var ajax_url="<?php echo $this->config->item('base_url').'index.php/scm/stock/find_batchwise_products/' ;?>";
				 // alert(from_id);
				 load_ajax(product_id,from_id,ajax_url);
					
				});

			  $('#add_consumable').click(function() {
				  if($.trim($("#consumable_name").val()) == "" ){
						return ;
					}
				  $("#page-loader").show();
				  var product_id=$("#consumable_product_id").val();
				  var from_id= $("#from_id").val();
				  var ajax_url="<?php echo $this->config->item('base_url').'index.php/scm/stock/find_batchwise_products/' ;?>";
				 // alert(from_id);
				 load_ajax(product_id,from_id,ajax_url);
					
				});
				  
			});


	
      </script>
      
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery.autocomplete.js"; ?>"></script>
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/common/local_autocomplete.js"; ?>"></script>
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/scm/expire_scm_item.js"; ?>"></script>
      <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
		
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>

<title><?php
	echo 'Add Expiry Details';
?></title>
</head>
<body>
<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>

<?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'><span>$success_message</span><div><a href='".$this->config->item('base_url').$filename."'>A  $filetype file has been created. Click here to download.</a></div> </div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>

<div id="page-loader" style="display:none">
											<h3>Please wait...</h3>
											<?php echo '<img src="'.base_url().'/assets/images/common_images/loader.gif" alt="loader">';?>
											<p><small id="page-load-content"> loading Batchwise Stocks.</small></p>
										</div>
<div id="main">
	<table width="100%" align="center">
		<tr>
			<td>

				<div class="blue_left">
					<div class="blue_right">
						<div class="blue_middle"><span class="head_box">
							<?php
								echo 'Expire Medications,Consumables From Location: '.$location;
							?>
							</span>
						</div>
					</div>
				</div>
				<div class="blue_body" style="padding:10px">
					<form method="post"  onSubmit="return ValidateForm()">
						<table border="0" align="center" cellspacing = "5" cellpadding="5">
							<tr>
		     					
		     					<td style="height: auto;margin-bottom: 5px;padding-left: 75px;"><b>Type</b>
										<?php
										//@todo : Remove this array and put it in to config file
										$type_enums = array ('1' => 'Medication', '2' => 'Consumable');
											$selected = 'Medication';
										
										echo form_dropdown ( 'type', $type_enums, $selected,'id="type"' );
										?>
									</td>
		     					
		     					
		     					<td style="height: auto;margin-bottom: 5px;padding-left: 110px;"><b>Date:</b> 
		       						<input name="date" id="date" type="text" value="<?php echo $date; ?>" class="datepicker check_dateFormat"  style="width:100px;"  />
		       						<input type="hidden" name="bill_amount" id="bill_amount">
		       						<input type="hidden" value="<?php echo $expire_date; ?>" id="today_date">
									<input type="hidden" id="from_id" name="from_id" value="<?php echo $location_id;?>" />
		     					</td>	
							</tr>
								
								<tr>      
									<td colspan="2">  
										
									
						  				<div id='drug_id' style="height: auto;margin-bottom: 5px; padding: 0px 60px 0px 70px;">
						      				<fieldset>	
												<legend><b>Find Drug</b></legend>
							      				<div class="form_row" style="margin-top:10px;">
													<div class="form_left">Name of medicine<span style="color:#FF0000">*</span></div>
														<div class="form_right">
															<input id="medication_name" type="text" value="" class="required"/>
															<input id="medication_product_id" type="hidden"/> 
															<input id="medication_rate" type="hidden" />
															
														</div>
														<div style="float:left; padding-left:10px">
										    				<input id="add_medication" type="button" class="submit" value="Find"/>
										  				</div>
								      			</div>
							      				<div style="padding-left:150px"><label class="error" id="error_add_drug" style="display:none"> Please enter Drug name  </label></div>
									      		<div class="form_row">
													<div class="form_right">
										  				
													</div>
									      		</div>
					   						</fieldset>
						  				</div>
						  				
						  				<div id='consumable_id' style="height: auto;margin-bottom: 5px; padding: 0px 60px 0px 70px;">
						      				<fieldset>
												<legend><b>Find Consumable</b></legend>
					
							      				<div class="form_row" style="margin-top:10px;">
													<div class="form_left">Name of Consumable<span style="color:#FF0000">*</span></div>
														<div class="form_right">
															<input id="consumable_name" type="text" value="" class="required"/>
															<input id="consumable_product_id" type="hidden"/> 
															<input id="consumable_rate" type="hidden" />
															
															
														</div>
														<div style="float:left; padding-left:10px">
										    				<input id="add_consumable" type="button" class="submit" value="Find"/>
										  				</div>
										  				
								      			</div>
							      				<div style="padding-left:150px"><label class="error" id="error_add_consumable" style="display:none"> Please enter Consumable name  </label></div>
									      		<div class="form_row">
													<div class="form_right">
										  				
													</div>
									      		</div>
									      	</fieldset>
					
						  				</div>
								</td>
							</tr>
							<tr>
								<td colspan = "2"> <label class="error" id="error_add_row" style="display:none"> <b>Please select atleast 1 Drug to Expire </b></label>  </td>
							</tr>
							<tr>
								<td colspan="2">
								      <table id="medications" width="600px" cellspacing="2" cellpadding="2" style="border:1px solid;">
										
										<tr class="scm_head">
										
										  <td width="35%">Drug</td>
										  <td width="35%">Location</td>
										  <td width="5%">Batch Number</td>
										  <td width="5%">Expiry Date</td>
										  <td width="4%">Quantity</td>
										  <td width="16%">Expire</a></td>
										</tr>
										</table>
										
								</td>
							</tr> 
							
							<tr>
								<td colspan="2">
								<div style="font-weight: 700;width: 300px;"><span style="color:#FF0000">Selected Drugs will be Removed from Inventory</span></div>
								      <table id="expire_medications" width="600px" cellspacing="2" cellpadding="2" style="border:1px solid;">
											<tr class="scm_head">
											
												  <td width="35%">Drug</td>
												  <td width="35%">Location</td>
												  <td width="5%">Batch Number</td>
												  <td width="5%">Expiry Date</td>
												  <td width="4%">Quantity</td>
												  <td width="16%">Expire</td>
											</tr>
										</table>
										
								</td>
							</tr> 
							<tr >
								<td colspan="2">
									<b>Comment</b>
									<input type=text size=45 name="comment"/>
									<input id="medication_expire" type="submit" class="submit" value="Expire Drug"/>
								</td>
							</tr>
										
						</table>
					
					</form>	
				</div>
				<div class="bluebtm_left">
					<div class="bluebtm_right">
						<div class="bluebtm_middle" /></div>
					</div>
				</div>			
			</td>
		</tr>
	</table>
</div>



     


<?php
$this->load->view ( 'common/footer' );
?>
