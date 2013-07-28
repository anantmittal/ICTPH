<?php
$this->load->helper('form');
$this->load->view('common/header');
?>
<link
	href="<?php echo "{$this->config->item('base_url')}assets/css/site.css";?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo "{$this->config->item('base_url')}assets/css/jquery-ui-1.7.2.custom.css";?>"
	rel="stylesheet" type="text/css" />
<link
	href="<?php echo "{$this->config->item('base_url')}assets/css/tabs.css";?>"
	rel="stylesheet" type="text/css" />

<script
	type="text/javascript"
	src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
<script
	type="text/javascript"
	src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>

<script type="text/javascript">
  var visit_id="<?php echo $visit->id; ?>";
  var policy_id="<?php echo $policy_id; ?>";
  var username="<?php echo $this->session->userdata('username'); ?>";
  var base_url= "<?php echo $this->config->item('base_url');?>";
</script>
<!--    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/show_overview_resp.js"; ?>"></script> -->

<script type="text/javascript">
$(document).ready(function(){
	var hew = "<?php echo $hew_login;?>";
	if(hew){
		$('#audit_tr').hide();
		$('#edit_tr').hide();
		$('#doctor_tr').hide();
	}	
		
});

</script>
<title>Visit Details</title>

</head>

<body>
	<?php /*>*/;
	$this->load->view('common/header_logo_block');
	$this->load->view('common/header_search');
	?>

	<!--Head end-->
	<!-- Body Start -->
	<div id="main">


		<div id="leftcol">

			<div class="yelo_left">
				<div class="yelo_right">
					<div class="yelo_middle">
						<span class="head_box">Patient Details</span>
					</div>
				</div>
			</div>

			<div class="yelo_body" style="padding: 8px;">
				<?php $this->load->view('opd/patient_context', $person, $household); ?>
				<?php $this->load->view('opd/menu', $person); ?>
			</div>

			<div class="yelobtm_left">
				<div class="yelobtm_right">
					<div class="yelobtm_middle"></div>
				</div>
			</div>

		</div>

		<div id="rightcol">

			<div class="blue_left">
				<div class="blue_right">
					<div class="blue_middle">
						<span class="head_box">Visit Details</span>
					</div>
				</div>
			</div>
			<div class="blue_body" style="padding: 10px;">

				<!-- TODO - remove the hardcoded values below -->
				<table>
					<tr>
						<td width="10%">Date</td>
						<td width="10%"><?php echo Date_util::to_display($visit->date); ?>
						</td>
						<td width="10%" colspan="2" />
						<?php if($visit->valid_state=='Valid' || $visit->valid_state=='Pre-consulted')
						{
			$printable_url = $this->config->item('base_url').'index.php/opd/visit/show_printable/'.$visit->id.'/'.$policy_id; ?>
						<input type="button" value="Print"
							onClick="window.open('<?php echo $printable_url; ?>');">
						<?php }
						else	{ echo '<u><b> VISIT IS INVALID. CANNOT PRINT </b></u>.';
} ?>
					</tr>
					</tr>
					<tr> 
						<td> Patient Satisfaction survey </td>
						<td width = "10%"><a href ="http://www.surveymonkey.com/s.aspx?sm=aL08rRPOUQSalC729SQatQ%3d%3d">Survey</a><td>
							
					</tr>

					<tr>
						<td width="10%">Payment status</td>
						<td width="10%"><?php echo $visit->bill_paid; ?></td>
						<td width="10%" colspan="2" />
						<?php if($visit->bill_paid=='No')
						{
			$update_payment_url = $this->config->item('base_url').'index.php/opd/visit/bill_paid/'.$visit->id.'/'.$policy_id; ?>
						<a href="<?php echo $update_payment_url; ?>"><?php echo 'Change Bill Paid Status'; ?>
						</a>
						<?php } ?>
						</td>
					</tr>

					<tr>
						<td>Provider:</td>
						<td><?php echo $visit->related('provider')->get()->full_name; ?></td>
						<td>Location:</td>
						<td><?php echo $visit->related('provider_location')->get()->name; ?>
						</td>
					</tr>

					<?php
					$fv = $visit->followup_to_visit_id;
					if ($fv != 0) {
						?>
					<tr>
						<td>Followup to:</td>
						<td colspan="3">Visit <a
							href="<?php
		    echo $this->config->item('base_url').'index.php/opd/visit/show/'.$fv; ?>">
								<?php echo $fv ?>
						</a>
						</td>
					</tr>

					<?php
					}
					?>

					<tr>
						<td>Chief complaint:</td>
						<td colspan="3"><?php echo $visit->chief_complaint; ?></td>
					</tr>

					<tr>
						<td>HPI:</td>
						<td colspan="3"><?php echo $visit->hpi; ?></td>
					</tr>

					<tr>
						<td>Vitals:</td>
						<?php
						$visit_vitals = $visit->related('visit_vitals')->get();
						?>
						<td colspan="3"><?php echo Utils::print_vitals($visit_vitals); ?>
						</td>
					</tr>

					<tr>
						<td>Auscultation:</td>
						<?php
						$visit_auscult = $visit->related('visit_auscults')->get();
						?>
						<td colspan="3"><?php echo Utils::print_auscult($visit_auscult); ?>
						</td>
					</tr>

					<tr>
						<td>Vision Details:</td>
						<?php
						$vision_details = $visit->related('visit_visuals')->get();
						?>
						<td colspan="3"><?php echo Utils::print_vision($vision_details); ?>
						</td>
					</tr>

					<tr>
						<td>Vision Prescription Details:</td>
						<?php
						$vision_prescription_details = $visit->related('visit_visual_prescriptions')->get();
						?>
						<td colspan="3"><?php  Utils::print_vision_prescription_details($vision_prescription_details); ?>
						</td>
					</tr>

					<tr>
						<td>Review of systems:</td>
						<td colspan="3" class="grid"><?php
						$ros_entries = $visit->related('visit_ros_entries')->get();
						if (empty($ros_entries)) {
							?> No system abnormalities recorded <?php } else { ?>

							<table class="grid" width="100%">
								<tr class="head">
									<td width="20%">System</td>
									<td width="10%">Problem</td>
									<td width="70%">Details</td>
								</tr>

								<?php /**/;
		      foreach ($ros_entries as $r) {
		      	if ($r->status == 'NA')
		      		continue;
		      	?>
								<tr class="gridrow">
									<td class="gridcell"><?php echo ucwords($r->name); ?></td>
									<td class="gridcell"><?php echo ucwords($r->status); ?></td>
									<td class="gridcell"><?php /**/;
									if ($r->status == 'Yes') {
										$details = $r->details;
										if($details != null){
											$displayer->parse_vist_json($details);
										}

									}
									?>
								
								</tr>
								<?php
		      }
		      ?>
							</table> <?php
							}
							?>
						</td>
					</tr>

					<tr>
						<td>Physical exams:</td>
						<td colspan="3"><?php 
						$physical_exam_entries = $visit->related('visit_physical_exam_entries')->get();
						if (empty($physical_exam_entries)) {
							?> No physical exam abnormalities recorded <?php } else { ?>

							<table class="grid" width="100%">
								<tr class="head">
									<td width="20%">Test</td>
									<td width="10%">Status</td>
									<td width="70%">Details</td>
								</tr>

								<?php /**/;
								foreach ($physical_exam_entries as $p) {
									if ($p->status == 'NA')
		        continue;
									?>
								<tr class="gridrow">
									<td class="gridcell"><?php echo ucwords($p->test); ?></td>
									<td class="gridcell"><?php echo ucwords($p->status); ?></td>
									<td class="gridcell"><?php /**/;
									if ($p->status == 'Abnormal') {
				      $details = $p->details;
				      $displayer->parse_vist_json($details);
									}
									?>
									</td>
								</tr>
								<?php
								}
								?>
							</table> <?php
							}
							?>
						</td>
					</tr>

					<tr>
						<td valign="top">Tests:<br> <?php if($visit->lab_report_delivered=='No')
						{
							$report_delivered_url = $this->config->item('base_url').'index.php/opd/visit/report_delivered/'.$visit->id.'/'.$policy_id; ?>
							<a href="<?php echo $report_delivered_url; ?>"><?php echo 'Confirm Report Delivered'; ?>
						</a> <?php }
						else { echo "Lab Report has been delivered";
						}
						?> <br> <?php		$report_url = $this->config->item('base_url').'index.php/opd/lab/print_report/'.$visit->id.'/'.$policy_id; ?>
							<input type="button" value="Print Report"
							onClick="window.open('<?php echo $report_url; ?>');">
						</td>
						<td colspan="3"><?php 
						$test_entries = $visit->related('visit_test_entries')->get();
						if (empty($test_entries)) {
							?> No tests done <?php } else { ?>
							<form action="<?php echo $this->config->item('base_url').'index.php/opd/lab/update_test_values/'.$visit->id;?>"
											method="POST">
							<table border="1px" class="grid" style="border-collapse: collapse;" cellpadding="5">
								<tr class="head">
									<th width="50%">Test
									
									</th>
									<th width="50%">Result
									
									</th>
								</tr>

								<?php /**/;
								//To allow editing of tests within 1 month of visit
								$today = date("Y-m-d");
								$newdate = strtotime ( '-1 months' , strtotime($today)) ;
								$newdate = date ( "Y-m-d", $newdate );
								$i = 0;
								foreach ($test_entries as $t) {
									$this->load->model('opd/test_types_model', 'test_types');
									$tt = $this->test_types->find($t->test_type_id);
									
									if($tt->type === "Strip"  ||  $tt->type === "Procedure"){
									?>
										<tr>
											<td><?php echo $tt->name; ?></td>
											<td>
												<?php 
												if($t->result != '')
													echo $t->result;
												else{ ?>
													<?php if($tt->result_type =='Number'){ ?>
														<input type="text" name="result[<?php echo $i ?>][value]" />
													<?php } else { ?>
														<input type="radio" name="result[<?php echo $i ?>][value]" value="Positive">P
														<input type="radio" name="result[<?php echo $i ?>][value]" value="Negative">N
													<?php }  ?>
														<input type="hidden" name="result[<?php echo $i ?>][test_id]" value="<?php echo $t->test_type_id ?>">
														<input type="hidden" name="result[<?php echo $i ?>][name]" value="<?php echo $tt->name ?>">
												<?php } ?>
											</td>
										</tr>
								<?php  }else{?>
										<tr>
											<td><?php echo $tt->name; ?></td>
											<td>
												
												<?php 
													 if($tt->result_type =='Number'){ 
														 
													 	 if($newdate < $visit->date){?>
															<input type="text" name="result[<?php echo $i ?>][value]"  value="<?php if($t->result != ''){ echo $t->result; }?>"/>
													<?php }else{
													 		echo $t->result;	
														  }	  
													} else {
														 if($newdate < $visit->date){?>
															<input type="radio" name="result[<?php echo $i ?>][value]"  <?php if($t->result != ''){ if($t->result=="Positive" ){?>checked="checked"<?php }}?> value="Positive">P
															<input type="radio" name="result[<?php echo $i ?>][value]"  <?php if($t->result != ''){ if($t->result=="Negative"){?>checked="checked" <?php }}?> value="Negative">N 
													<?php }else{
															echo $t->result;
													  	}	 
													}?>
												<input type="hidden" name="result[<?php echo $i ?>][test_id]" value="<?php echo $t->test_type_id ?>">
												<input type="hidden" name="result[<?php echo $i ?>][name]" value="<?php echo $tt->name ?>">
											</td>
										</tr>
								<?php }
									$i++;
								}?>
								<tr>
									<td colspan="2" align="right">
										<input type="submit" name="submit_res" value="Update Result"
														class="submit" />
									</td>
								</tr>
							</table>
							</form>  
							<?php } ?>
						</td>
					</tr>

					<tr>
						<td>Diagnosis:</td>
						<td colspan="3"><?php /**/;
						foreach ($visit->related('visit_diagnosis_entries')->get() as $d)
							echo $d->diagnosis.", &nbsp;";
						?>
						</td>
					</tr>

					<tr>
						<td>Protocol Information:</td>
						<td colspan="3" class="grid"><?php
						$protocol_information_entries = $visit->related('visit_protocol_information_entries')->get();//Protocol Information
						if (empty($protocol_information_entries)) {
							?> No information recorded <?php } else { ?>

							<table class="grid" width="100%">
								<tr class="head">
									<td width="20%">Protocol</td>
									<td width="10%">Checklist</td>
									<td width="70%">Details</td>
								</tr>

								<?php /**/;
								foreach ($protocol_information_entries as $protocol) {
			      if ($protocol->status == 'NA'  )
			      	continue;
			      if($protocol->status != 'NA' && (strpos($protocol->name,'_followup') || !strcmp($protocol->name,'_followup')))
			      	continue;
			      ?>
								<tr class="gridrow">
									<td class="gridcell"><?php echo ucwords($protocol->name); ?></td>
									<td class="gridcell"><?php echo ucwords($protocol->status); ?>
									</td>
									<td class="gridcell"><?php /**/;
									if ($protocol->status == 'Yes') {
										$details = $protocol->details;
										if($details != null){
											$displayer->parse_vist_json($details);
										}
									}
									?>
								
								</tr>
								<?php
								}
								?>
							</table> <?php
							}
			    ?>
						</td>
					</tr>

					<?php if(isset($show_assign_section)) { ?>
					<tr>
						<form
							action="<?php echo $this->config->item('base_url').'index.php/opd/visit/assign_followup/'.$visit->id.'/';?>"
							method="POST">
							<td>Assign Followup:</td>
							<td colspan="3" class="grid"><?php
							$followup_information_entries = $visit->related('followup_informations')->get();//Protocol Followup Information
							?>

								<table class="grid" width="100%">
									<tr class="head">
										<td width="20%">Protocol</td>
										<td width="30%">Due date</td>
										<td width="50%">Assign to</td>
									</tr>

									<?php $i=1; 
			 	foreach ($followup_information_entries as $protocol_rec) {     ?>
									<tr class="gridrow">
										<td class="gridcell"><a
											href="<?php echo $this->config->item('base_url').'index.php/opd/visit/show_followup/'.$protocol_rec->id;?>"><?php echo ucwords($protocol_rec->protocol); ?>
										</a></td>
										<td class="gridcell"><?php echo ucwords($protocol_rec->due_date); ?>
										</td>
										<td class="gridcell"><?php echo form_dropdown('username_'.$i, $username_list,$protocol_rec->assigned_to,'id=usernames'); ?>
										</td>
									</tr>
									<?php $i++; 
} ?>
									<tr>
										<td></td>
										<td></td>
										<td><input type="submit" name="submit" value="Submit"
											class="submit" /></td>
									</tr>
								</table>
							</td>
						</form>
					</tr>
					<?php  }  ?>
					<tr>
						<td>Assessment:</td>
						<td colspan="3"><?php 
						echo $visit->assessment.", &nbsp;";
						?>
						</td>
					</tr>

					<tr>
						<td>Risk Level:</td>
						<td colspan="3"><?php 
						echo $visit->risk_level.", &nbsp;";
						?>
						</td>
					</tr>

					<tr>
						<td>Medications:</td>
						<td colspan="3"><?php
						$med_entries = $visit->related('visit_medication_entries')->get();
						if (empty($med_entries)) {
							?> No medications prescribed <?php } else { ?>

							<table border=1 class="grid">
								<tr class="head">
									<td width="40%">Drug</td>
									<td width="10%">Frequency</td>
									<td width="10%">Duration</td>
									<td width="10%">Route</td>

								</tr>

								<?php /**/;
								foreach ($med_entries as $m) {
			      $p = $m->related('product')->get();
			      ?>
								<tr>
									<td><?php echo $p->name." (".$p->generic_name.", ".$p->strength." ".$p->strength_unit.")"; ?>
									</td>
									<td><?php echo $m->frequency; ?></td>
									<td><?php echo $m->duration.' '.$m->duration_type; ?></td>
									<td><?php echo $m->administration_route; ?></td>
								</tr>
								<?php
								}
								?>
							</table> <?php
							}
							?>
						</td>
					</tr>

					<tr>
						<td>OP Products:</td>
						<td colspan="3"><?php
						$is_given_column_required=false;
						$opproducts_entries = $visit->related('visit_opdproduct_entries')->get();
						foreach ($opproducts_entries as $opproduct) {
							if($opproduct->product_given_out==='no'){
								$is_given_column_required=true;
							}
						}
						if (empty($opproducts_entries)) {
							?> No OP products prescribed <?php } else { ?>

							<table border=1 class="grid">
								<tr class="head">
									<td width="40%">OP Product</td>
									<td width="10%">Pieces</td>
									<td width="10%">Is Product given Out</td>
									<?php if($is_given_column_required){?><td width="10%">Give Product</td><?php }?>
								</tr>

								<?php /**/;
								foreach ($opproducts_entries as $opproduct) {
			      $p = $opproduct->related('product')->get();
			      ?>
								<tr>
									<td><?php echo $p->name." (".$p->generic_name.", ".$p->strength." ".$p->strength_unit.")"; ?>
									</td>
									<td><?php echo $opproduct->number; ?></td>
									<td><?php echo ucwords($opproduct->product_given_out); ?></td>
									<?php if($is_given_column_required){?>
										<td>
											<form action="<?php echo $this->config->item('base_url').'index.php/opd/visit/update_md_to_ordr_prod/'.$opproduct->visit_id.'/'.$opproduct->product_id.'/'.$policy_id.'/';?>" method="POST">
				      							<?php  if($opproduct->product_given_out==='no'){?><input type='submit'  value='Give' <?php if($visit->bill_paid=='No' || $opproduct->is_present_in_stock==='No'){?>disabled='disabled'<?php }?> /><?php }?>
				      						</form>
				      					</td>
				      					<?php }?>
								</tr>
								<?php
								}
								?>
							</table> <?php
							}
							?>
						</td>
					</tr>

					<tr>
						<td>Services:</td>
						<td colspan="3"><?php
						$service_entries = $visit->related('visit_service_entries')->get();
						if (empty($service_entries)) {
							?> No Services Suggested <?php } else { ?>

							<table border=1 class="grid">
								<tr class="head">
									<td width="40%">Service</td>
								</tr>

								<?php /**/;
								foreach ($service_entries as $service) {
									?>
								<tr>
									<td><?php echo ucwords($service->name); ?></td>
								</tr>
								<?php
								}
								?>
							</table> <?php
							}
							?>
						</td>
					</tr>

					<tr>
						<td>Referrals:</td>
						<td colspan="3"><?php /**/;
						foreach ($visit->related('visit_referral_entries')->get() as $r)
							echo $r->speciality.", &nbsp;";
						?>
						</td>
					</tr>

					<tr>
						<td>Follow Up:</td>
						<td colspan="3"><?php
						if($chw_id == 0)
						{
							echo "No CHW Follow up Suggested";
						}
			else { ?> <a
							href="<?php echo $this->config->item('base_url').'index.php/chw/chw/show/'.$chw_id; ?>">
								<?php echo $chw_name ?>
						</a> <?php } ?>
						</td>
					</tr>

					<tr>
						<td>Billing:</td>
						<td colspan="3">
							<table border=1 class="grid">
								<tr class="head">
									<td width="20%">Type</td>
									<td width="30%">Name</td>
									<td width="10%">Quantity</td>
									<td width="10%">Rate</td>
								</tr>

								<?php /**/;
								foreach ($visit->related('visit_cost_item_entries')->get() as $c) {
									?>
								<tr>
									<td><?php echo ucwords($c->type); ?></td>
									<td><?php echo $c->subtype; ?></td>
									<td><?php echo $c->number; ?></td>
									<td><?php echo $c->rate; ?></td>
								</tr>
								<?php
								}
								?>
							</table>
						</td>
					</tr>

					<tr id="doctor_tr">
						<td width="10%">Doctor Approval Status</td>
						<td width="10%"><?php echo $visit->approved; ?></td>
						<td width="10%" colspan="2" />
						<?php if($visit->approved=='Unseen')
						{
			$update_approved_url = $this->config->item('base_url').'index.php/opd/provider/approve_visit/'.$visit->id.'/Approved/'.$policy_id; ?>
						<a href="<?php echo $update_approved_url; ?>"><?php echo 'Approve the Visit'; ?>
						</a>
						<?php 
			$update_approved_url = $this->config->item('base_url').'index.php/opd/provider/approve_visit/'.$visit->id.'/Rejected/'.$policy_id; ?>
						<a href="<?php echo $update_approved_url; ?>"><?php echo 'Reject the Visit'; ?>
						</a>
						<?php 
			} ?>
						</td>
					</tr>

					<tr id="edit_tr">
						<td width="10%">Edit visit details</td>
						<td width="10%" colspan="3" />
						<?php $edit_url = $this->config->item('base_url').'index.php/opd/visit/edit_visit/'.$visit->id.'/'.$policy_id; ?>
						<input type="button" value="Edit Visit Details"
							onClick="window.location = '<?php echo $edit_url; ?>'">
						<!--		<a href="<?php echo $edit_url; ?>"><?php echo 'Edit the visit details'; ?></a> -->
						</td>
					</tr>

					<tr>
					
					
					<tr id="audit_tr">
						<td width="10%">Audit Status</td>
						<td width="10%"><b><?php echo $visit->audit_status; ?> </b></td>
						<td width="10%" colspan="2" />
						<?php if($visit->audit_status=='unseen' || $visit->audit_status=='open')
						{
			$update_approved_url = $this->config->item('base_url').'index.php/opd/provider/audit_close/'.$visit->id.'/'.$policy_id; ?>
						<a href="<?php echo $update_approved_url; ?>"><?php echo 'Close the Audit Trail'; ?>
						</a>
						<?php 
			} ?>
						</td>
					</tr>
				</table>

			</div>
			<div class="bluebtm_left">
				<div class="bluebtm_right">
					<div class="bluebtm_middle"></div>
				</div>
			</div>
			<br />


			<div class="blue_left">
				<div class="blue_right">
					<div class="blue_middle">
						<span class="head_box">Notes</span>
					</div>
				</div>
			</div>
			<div class="blue_body" style="padding: 10px;">
				<?php $this->load->view('opd/visit/addendum_box', $visit->related('visit_addendums')->get()); ?>
			</div>
			<div class="bluebtm_left">
				<div class="bluebtm_right">
					<div class="bluebtm_middle"></div>
				</div>
			</div>

		</div>

	</div>
</body>
</html>
