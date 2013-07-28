<head>
<title>OPD Home Page</title>
<?php echo '<link rel="stylesheet" type="text/css" href="'.base_url().'/assets/css/plsp/plspprint.css"/>';?>
</head>

<table class="intro"><tr><td class="imagecell">
<?php echo '<img src="'.base_url().'/assets/images/common_images/sgv_logo.png" width="70" height="70">';?>
</td><td><h1>SughaVazhvu Healthcare</h1><h3>Household Screening Report</h3></td><td class="emptycell"></td></tr></table>
<table align="center" width="70%" border="1" cellpadding="5">
<caption>Household Details</caption>
	<tr><td>Address</td><td><?php echo $street_address;?></td></tr>
	<tr><td>Village</td><td><?php echo $village_name;?></td></tr>
	<tr><td>Contact Number(s)</td><td><?php echo $contact_number;?></td></tr>
</table>
</br>
<table align="center" width="70%" border="1" cellpadding="5">
<tr>
	<th>Individual ID</th>
	<th>Full Name</th>
	<th>Gender</th>
	<th>Relation</th>
	<th>Age</th>
	<th>Corrections (if any)</th>
</tr>
<?php foreach($individuals as $household_member):?>
	<tr>
	<td><?php echo $household_member['individual_id'];?></td>
	<td><?php echo $household_member['full_name'];?></td>
	<td><?php echo $household_member['gender'];?></td>
	<td><?php echo $household_member['relation'];?></td>
	<td><?php echo $household_member['age'];?></td>
	<td></td>
	</tr>
<?php endforeach;?>
</table>
<p>
<b>Receipt of Household Reports:</b></br>

I have received all the reports for the members of my family (listed in the
table above) from my SughaVazhvu Guide.</br></br>
Signature of recipient: _______________________________________</br></br>
Name of recipient:_______________________________________
</p>
</br>

