<head>
<LINK REL=StyleSheet HREF="<?php echo base_url()."assets/css/plsp/cohortsummary.css";?>" TYPE="text/css" MEDIA=screen>
</head>
<?php $this->load->view('survey/plsp/templateheader',array('title'=>'Cohort Summary'));?>

<table border="0" align="center" width="60%">
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">Cohort Summary</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">


		<table border="1" align="center" width="95%">
			<tr>
				<th rowspan="2">ID</th>
				<th rowspan="2">Name</th>
				<th rowspan="2">Household</th>
				<th rowspan="2">Visit Details (Count)</th>
				<th colspan="4">PISP</th>
			</tr>
			<tr>
				<th>Type</th>
				<th>Report</th>
				<th>Risk Count</th>
				<th>Risk Summary</th>
			</tr>
			<?php $hh ="x";
				$class="first"; ?>
			<?php foreach($data as $individual): ?>
			<?php
				if($hh != $individual['household'])
				{
					$class=($class=="first")?"second":"first";
					$hh = $individual['household'];
				}
				echo "<tr class=\"".$class."\">";
			?>
			
				<td><?php echo $individual['org_id'];?> </td>
				<td><?php echo $individual['name'];?> </td>
				<td><?php echo '<a href="'.$individual['household_link'].'">'.$individual['household'].'</a>';?> </td>
				<td><?php echo '<a href="'.$individual['visit_link'].'">Visits</a> ('.$individual['visit_count'].')';?> </td>
				<td><?php echo $individual['age_group'];?> </td>
				<td><?php echo $individual['plsp_link'];?></td>
				<td <?php echo 'class="risk'.$individual['risk_count'].'"';?>><?php echo $individual['risk_count'];?></td>
				<td> <?php foreach($individual['risk_summary'] as $summ) echo $summ."<br/>";?> </td>
			</tr>
			<? endforeach; ?>

		</table>
		<br/>
		
		</div>
		
		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></div>
		</div>
		</div>
		</td>
	</tr>
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">Cohort Actions</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">
		<table>
		<tr><td><a href="<?php echo base_url();?>/index.php/demographic/cohort/household_roster/<?php echo $cohort_id;?>">Print consolidate household roster</a></td></tr>
		</table>
		</div>
		<div class="bluebtm_left">
		<div class="bluebtm_right">
		<div class="bluebtm_middle" /></div>
		</div>
		</div>
		</td>
	
</table>
<?php $this->load->view('common/footer.php'); ?>
