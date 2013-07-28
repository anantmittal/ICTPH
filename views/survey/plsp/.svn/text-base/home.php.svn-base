<?php $this->load->view('survey/plsp/templateheader',array('title'=>'Sughavazhvu'));?>

<table align="center" width="70%" border="1" cellpadding="5" class="main_table">
<tr> <td><h3>Message: <?php echo $this->session->userdata('msg');?></h3></td></tr>
<tr> <td><center><h3>HMIS-based PISP</h3></center></td></tr>
<ul>
<tr>
<td>
<a href="<?php echo $this->config->item('base_url').'index.php/admin/enrolment/add_sgv';?>">Add a new Household </a>
</td>
</tr>

 <tr>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/plsp/report/query_report';?>" method="POST">
Enter URN / Individual ID <input type="text" name="indi_org_id" /input> 

<input type="radio" name="language" value="english"> English
<input type="radio" name="language" value="tamilcode" checked> Tamil<br>
<input type="submit" name="submit_edit"  value="Get Report" class="submit" /input> 
</form>
</td> </tr>
</ul>
</table>
<br/>
<table align="center" width="70%" border="1" cellpadding="5">
<tr> <td><center><h3>OMR-based PISP</h3></center></td></tr>
<ul>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/plsp/report/highrisk';?>">High Risk Report</a>
</td> </tr>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/plsp/cvd/risk_buckets';?>">High Risk (CVD)</a>
</td> </tr>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/plsp/report/viewerrors';?>">View Errors</a>
</td> </tr>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/plsp/summarize/index';?>">Summarize Reports</a>
</td> </tr>
<tr> <td>
<a href="<?php echo $this->config->item('base_url').'index.php/plsp/configuration/index';?>">Configuration Parameters</a>
</td> </tr>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/plsp/queryhhform/index';?>" method="POST">
Enter Household Number <input type="text" name="hhname" /input> 
<input type="submit" name="submit_edit"  value="Get Household Details" class="submit" /input> 
</form>
</td> </tr>
<td>
<form action = "<?php echo $this->config->item('base_url').'index.php/plsp/report/get_plsp_details';?>" method="POST">
Enter Individual ID <input type="text" name="indiname" /input> 
<input type="submit" name="submit_edit"  value="Get PLSP Details" class="submit" /input> 
</form>
</td> </tr>
</ul>
</table>
<?php $this->load->view('demographic/cohort_home.php'); ?>
<?php $this->load->view('common/footer.php'); ?>
