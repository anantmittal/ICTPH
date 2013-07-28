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
    
<!--    <h2>Patient Details</h2>-->
<h2>Patient: <?php echo ucfirst($person->full_name);?> (<?php echo $person->gender.', '. $age.' yrs'; ?>) (ID <?php echo $policy_id; ?>)</h2>

<!--    <table width="100%">
      <tr>
	<td width="10%">Patient Name</td>
	<td width="40%"><?php echo ucfirst($person->full_name); ?> (<?php if($person->gender == 'M')echo "Male"; else echo "Female"; ?>) (ID <?php echo $person->id; ?>)</td>
	<td width="25%">Date of Birth: </td>
	<td width="25%"><?php echo $person->date_of_birth; ?></td>
	</tr>
	<tr>
	  <td>Contact: </td>
	  <td colspan="3">
	    <?php echo $household->street_address; ?>
	    <?php echo $household->related("village_city")->name; ?>
	  </td>
	</tr>
      </table>-->
    
    <hr>

	    <?php 
	    $test_entries = $visit->related('visit_test_entries')->get();
	    if (empty($test_entries)) {
	    ?>
	    No tests done
	    <?php } else { ?>
	    
	    <table border=1 width="100%">
	      <tr>
		<th width="5%">SN</td>
		<th width="40%">Parameter</td>
		<th width="40%">Normal Values</td>
		<th width="15%">Measured Value</td>
	      </tr>
	      
	      <?php /**/;
		$i=0;
	      foreach ($test_entries as $t) {
		$i++;
		$this->load->model('opd/test_types_model', 'test_types');
	        $tt = $this->test_types->find($t->test_type_id);
	      ?>
	      <tr>
		<td><?php echo $i.'.'; ?></td>
		<td><?php echo $tt->name; ?></td>
		<td><?php echo $tt->description;?></td>
		<td>
			<?php 
			if($t->result !='')
					echo $t->result; 
			else
				echo '<i>Report not ready</i>'; 
			?>
		</td>
	      </tr>
	      <?php
	      }
	      ?>
	    </table>
	    <?php
	    }
	    ?>

<!--
<h2>Doctor details (Name, Qualification, Registration No,Signature):<u><?php echo 'Dr. '.$doctor->full_name.',   '.$doctor->qualification.',      '.$doctor->registration_number;?></u>
<img src="<?php echo $this->config->item('base_url').substr($sig_file_name,strlen($this->config->item('base_path'))); ?>" height="50" alt=""/>
</h2>
-->

    </body>
</html>
