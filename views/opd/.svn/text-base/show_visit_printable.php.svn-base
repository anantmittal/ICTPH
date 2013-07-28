<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <style type="text/css">
	h1 {font-size:15px;}
	h2 {font-size:12px;}
	body,table,p {font-size:10px;}
      </style>
      
      <script type="text/javascript" >
	base_url = "<?php echo $this->config->item('base_url'); ?>";
	var visit_id="<?php echo $visit->id; ?>";
	var username="<?php echo $this->session->userdata('username'); ?>";
	var person_id="<?php echo $person->id; ?>";
      </script>
      
      <title>Bill Details</title> 
      
  </head>
  
  <body>
    <img src="<?php echo "{$this->config->item('logo_file')}"?>" height="50" alt="" align="right"/>
    <h1>Bill No <?php echo $visit->id.' Date:'. $date.', '.$visit->related('provider_location')->get()->name; ?></h2>
<!--    <table>
      <tr>
	<td>Bill Number: </td>
	<td><?php echo $visit->id;?></td>
      </tr>
      <tr>
	<td>Date:</td>
	<td><?php echo $date; ?></td>
	<td><?php // echo Date_util::date_display_format($visit->date); ?></td>
      </tr>
      <tr>
	<td>Provider:</td>
	<td><?php echo $visit->related('provider')->get()->full_name; ?></td>
      </tr>
      <tr>
	<td>Location:</td>
	<td><?php echo $visit->related('provider_location')->get()->name; ?></td>
      </tr>
      <?php
	$fv = $visit->followup_to_visit_id;
	if ($fv != 0) {
      ?>
      <tr>
	<td>Followup to:</td>
	<td>Visit <?php echo $fv; ?></td>
      </tr>
      <?php } ?>
    </table>
    <hr/>-->
    

<h2>Patient: <?php echo ucfirst($person->full_name);?> (<?php echo $person->gender.', '. $age.' yrs'; ?>) (ID <?php echo $policy_id; ?>)</h2>


    
    <hr>
<!--    <h2>Visit Details</h2> -->
    <table width="100%" border="1">
      <tr>
	<td width="13%">Chief complaint</td>
	<td><?php echo $visit->chief_complaint; ?></td>
      </tr>
      <tr>
	<td width="13%">Vitals</td>
	<?php
	$visit_vitals = $visit->related('visit_vitals')->get(); 
?>
	<td> <?php echo Utils::print_vitals($visit_vitals); ?></td>
      </tr>

	<tr>
	  <td>Tests</td>
	  <td>
	    <?php 
//	    $test_entries = $visit->related('visit_test_entries')->get();
	    $test_entries = $visit->related('visit_cost_item_entries')->where('visit_cost_item_entries.type','"Test"',false)->get();
	    if (empty($test_entries)) {
	    ?>
	    No tests done
	    <?php } else { ?>
	    
	    <table border=1 width="100%">
	      <tr>
		<th width="40%">Test</td>
		<th width="40%">Result</td>
		<th width="20%">Amount (Rs)</td>
	      </tr>
	      
	      <?php /**/;
	      foreach ($test_entries as $t) {
//		$this->load->model('opd/visit_cost_item_entry_model', 'visit_cost_item_entry');
		$this->load->model('opd/test_types_model', 'test_types');
		$this->load->model('opd/visit_test_entry_model', 'visit_test_entry');
	        $tt = $this->test_types->find_by('name',$t->subtype);
	      ?>
	      <tr>
		<td><?php echo $t->subtype;?></td>
		<td>
			<?php 
			if($tt->type == 'Strip')
			{
				if($tt->bill_type == 'Single')
				{
	        			$test_rec = $this->visit_test_entry->find_by('visit_cost_item_entry_id',$t->id);
					echo $test_rec->result; 
				}
				else
				{
	        			$test_recs = $this->visit_test_entry->find_all_by('visit_cost_item_entry_id',$t->id);
					echo '<table>';
					foreach($test_recs as $test_rec)
					{
						$para = $this->test_types->find($test_rec->test_type_id);
						echo '<tr><td>'.$para->name.'</td><td>'.$test_rec->result.'</td></tr>';
					}
					echo '</table>';
				}
			}
			else
				echo '<i>Report not ready</i>'; 
			?>
		</td>
                <td><?php echo $t->cost; ?></td>
	      </tr>
	      <?php
	      }
	      ?>
	    </table>
	    <?php
	    }
	    ?>
	  </td>
	</tr>	

	<tr>
	  <td >Medications<br/></td>
	    <div>
	   <td> 
	    <?php
	    $med_entries = $visit->related('visit_medication_entries')->get();
	    if (empty($med_entries)) {
	    ?>
	    No medications prescribed
	    <?php } else { ?>
	    <table width=100% border="1">
	      <tr>
		<th width="45%">Drug</td>
		<th width="5%">Freq</td>
		<th width="10%">Days</td>
		<th width="10%">Qty</td>
		<th width="5%">Rate</td>
		<th width="5%">Tot</td>
	      </tr>
	      
	      <?php /**/;
	      foreach ($med_entries as $m) {
	      if($m->product_id == 0)
		continue;
	      $p = $m->related('product')->get();
	      $this->load->model('opd/visit_cost_item_entry_model', 'visit_cost_item_entry');
	      $c = $this->visit_cost_item_entry->find($m->visit_cost_item_entry_id);
	      ?>
	      <tr>
	      <td><?php echo $p->name." (".$p->generic_name.", ".$p->strength." ".$p->strength_unit.")"; ?></td>
	      <td><?php echo Utils::print_frequency($m->frequency); ?></td>
	      <td><?php echo $m->duration; ?></td>
	      <?php if ($c) { ?>
	      <td><?php echo $c->number." ".$p->retail_unit; ?></td>
	      <td><?php echo $c->rate; ?></td>
	      <td><?php echo $c->cost; ?></td> </tr>
	      <?php } else { ?>
	      <td/><td/><td/>
	      <?php } ?>
	      <?php
	      }
	      ?>
	    </table>
	    <?php
	    }
	    ?>
	    </div>
	  </td>
	</tr>
	
	<tr>
	  <td>Referrals</td>
	  <td>
	    <?php /**/;
	    foreach ($visit->related('visit_referral_entries')->get() as $r)
	    echo $r->speciality.", &nbsp;";
	    ?>
	  </td>
	</tr>
	
	<tr>
	  <td>Billing</td>
	  <td>
	    <table width=100% border=1>
	      <?php /**/;
	      $b = array();
	      $b["Consultation"] = 0; $b["test"] = 0; $b["medication"] = 0;$b["opdproducts"] = 0; $b["services"] = 0;
	      foreach ($visit->related('visit_cost_item_entries')->get() as $c) {
	        if (!$b[$c->type])
	          $b[$c->type] = 0;
	        $b[$c->type] += $c->cost;
          }
	      ?>
	      <tr>
		<td width="50%">Consultation</td>
		<td width="50%" align="right"><?php echo $b["Consultation"];?></td>
	      </tr>
	    <!--<tr>
		<td width="50%">Procedures</td>
		<td width="50%" align="right"><?php echo $b["procedure"];?></td>
	      </tr>-->
	      <tr>
		<td>Tests</td>
		<td align="right"><?php echo $b["test"];?></td>
	      </tr>
	      <tr>
		<td align="right"><i>Service tax</i></td>
		<td align="right">0</td>
	      </tr>
	      <tr>
		<td>Medications and Services</td>
		<td align="right"><?php echo $b["medication"] + $b["services"];?></td>
	      </tr>
	      <tr>
		<td align="right"><i>VAT</i></td>
		<td align="right">0</td>
	      </tr>
	      <tr>
		<td><b>Total</b></td>
		<td align="right"><?php echo $b["Consultation"]+$b["test"]+$b["medication"]+ $b["services"]; //+ $b["Procedure"]; ?></td>
	      </tr>
	      <tr>
		<td><b>Billed Amount</b></td>
		<td align="right"><b><?php echo $visit->paid_amount; ?></b></td>
	      </tr>
	    </table>
	  </td>
	</tr>
      </table>

<?php if($visit->type != 'Diagnostic') { ?>
<h2>Doctor details (Name, Qualification, Registration No,Signature):<u><?php echo 'Dr. '.$visit->related('provider')->get()->full_name.',   '.$visit->related('provider')->get()->qualification.',      '.$visit->related('provider')->get()->registration_number;?></u>
<img src="<?php echo $this->config->item('base_url').substr($sig_file_name,strlen($this->config->item('base_path'))); ?>" height="50" alt=""/>
</h2>
<?php } ?>

<br /> 
    <hr />
      <table width="100%" border="1">
        <tr><b>Copy for RMHC</b></tr>
	<tr>
	  <td width="55%">
	  <table width="100%" border=1>
	    <tr>
		<td>Bill No:</td>
		<td><?php echo $visit->id; ?> </td>
	    </tr>
	    <tr>
	    	<td>Bill Date:</td>
		<td><?php echo $date; ?> </td>
	    </tr>
	    <tr>
	    	<td>Patient Details:</td>
		<td><?php echo ucfirst($person->full_name);?> (<?php echo $person->gender.', '. $age.' yrs'; ?>) (ID <?php echo $policy_id; ?>)</td>
	    </tr>
	  </table>
	  </td>
	  <td width="45%">
	    <table width="100%">
	    <tr>
		<td>Drugs as billed received</td>
	        <td>Received Amount:<b><u><?php echo "Rs.  ".$visit->paid_amount ;?></u></b></td>
	    </tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr></tr>
	    <tr>
	    	<td>Patient's Signature</td>
	    	<td>Signature and Stamp of PFSPL </td>
	    </tr>
	    </table>
	  </td>
	</tr>
      </table>

<br />
    <hr />
      <table width="100%" border="1">
        <tr><b>Copy for PFSPL</b></tr>
	<tr>
	  <td width="55%">
	  <table width="100%" border=1>
	    <tr>
		<td>Bill No:</td>
		<td><?php echo $visit->id; ?> </td>
	    </tr>
	    <tr>
	    	<td>Bill Date:</td>
		<td><?php echo $date; ?> </td>
	    </tr>
	    <tr>
	    	<td>Patient Details:</td>
		<td><?php echo ucfirst($person->full_name);?> (<?php echo $person->gender.', '. $age.' yrs'; ?>) (ID <?php echo $policy_id; ?>)</td>
	    </tr>
	  </table>
	  </td>
	  <td width="45%">
	    Received Payment of Amount:<b><u><?php echo "Rs.  ".$visit->paid_amount ;?></u></b><br/><br/><br/><br />
	    Signature and Stamp of the cash handler
	  </td>
	</tr>
      </table>

    </body>
</html>
