<?php

/**
 * @todo : join with column will only show if selected table is second or higher in number.
 * @todo : remove ajax depedancy of getting table fields and bring all names while page loading
 * @todo : need to check many validation conditions whether 'group by' is selected or not and many.
 */
	$this->load->helper('form');
	$this->load->view ( 'common/header' );
?>

<script type="text/javascript">
var base_url = "<?php echo $this->config->item("base_url"); ?>";
</script>

<script type="text/javascript"
src='<?php echo $this->config->item("base_url")."assets/js/jquery-1.3.2.js"; ?>'>
</script>

<script type="text/javascript"
src='<?php echo $this->config->item("base_url")."assets/js/mne/define_sql_report.js"; ?>'>
</script>

<title>Create SQL Report Definition</title>
</head>
<body>

<?php
$this->load->view ( 'common/header_logo_block' );
$this->load->view ( 'common/header_search' );
?>

<table width="60%" align="center" >
	<tr>
		<td>
		<div class="blue_left">
		<div class="blue_right">
		<div class="blue_middle"><span class="head_box">
		<?php
		if (isset ( $edit_report ))
			echo 'Edit '. $edit_report->name.' Report';
		else
			echo 'Define SQL Report';
		?>
		</span></div>
		</div>
		</div>
		<div class="blue_body" style="padding: 10px;">

		<table border="0" align="center" width="">

		<form method="POST" >
		<tr><td><b>Name : </b></td><td> <input type="text" name="name" size=52 value="<?php if(isset($edit_report)) echo $edit_report->name;?>"><br></td></tr>
		<tr>
			<td><b>Description :</b></td>
			<td><textarea name="body" cols=60 rows=3 value="<?php if(isset($edit_report)) echo $edit_report->body;?>" ><?php if(isset($edit_report)) echo $edit_report->body;?></textarea> <br><br>
			<input name="report_id" id="report_id" value=" <?php if(isset($report_id)) echo $report_id;?>" type="hidden" />
			</td>
		</tr>
		<tr>
			<td> 
				<input type="button" id="show_variable_box" value="Add Variable"> 
	  			
				<?php for($i=1; $i <51; $i++) { ?>
	  			<input name="name_<?php echo $i;?>" id="name_<?php echo $i;?>" type="hidden" />
	  			<input name="alias_<?php echo $i;?>" id="alias_<?php echo $i;?>" type="hidden" />
	  			<input name="type_<?php echo $i;?>" id="type_<?php echo $i;?>" type="hidden" />
				<?php } ?>
			</td>
			<td>	
				<table border="1" id="variables" width=100%>
					<tr>
						<td><b>SN</b></td>  
						<td><b>Display Name</b></td>  
						<td><b>Variable Name</b></td>  
						<td><b>Type</b></td>
						<td><b>Remove</b></td>
					</tr>
					<?php $j=1;
					 if(isset($edit_variables)){
						foreach($edit_variables as $variables){?>
						<tr>
							<td><?php echo $j;?></td>
							<td><?php echo  $variables->name;?></td>
							<td><?php echo  $variables->alias;?></td>
							<td><?php echo  $variables->type;?></td>
							<td onmousedown="removeRow(this)"><a href="#" >Remove</a></td>
							<input name="name_<?php echo $j;?>" id="name_<?php echo $j;?>" value="<?php echo  $variables->name;?>" type="hidden" />
	  						<input name="alias_<?php echo $j;?>" id="alias_<?php echo $j;?>" value="<?php echo  $variables->alias;?>" type="hidden" />
	  						<input name="type_<?php echo $j;?>" id="type_<?php echo $j;?>" value="<?php echo  $variables->type;?>" type="hidden" />																																				
						<?php $j= $j+1; }	?>
						</tr>
					<?php 	}?>
					<input name="variable_row_id" id="variable_row_id" type="hidden" value="<?php echo $j;?>"/>
				</table>
			</td>
		</tr>

		<tr>
		<td></td>
		<td>
		   <div id="edit_variable_box" style="display:none;">
		   <table width="100%">
			<tr>
				<td colspan=2>
					<div class="blue_left"><div class="blue_right"><div class="blue_middle"><span class="head_box">Add Variable</span></div></div></div>
					<div class="blue_body">
					
				 		<table> 
							<tr>
								<td><b>Display Name (not be used in SQL Query)</b></td>  
								<td>
								<input id="variable_name" type="text" value="" />
								</td>
							</tr>
			
							<tr>
								<td><b>Variable Name (as to be used in SQL Query; Alphabets and numbers only; Dont use special characters)</b></td>  
								<td>
								<input id="variable_alias" type="text" value="" />
								</td>
							</tr>
			
							<tr>
								<td><b>Variable Type</b></td>
								<td>
						  		<select name="variable_type" id="variable_type">
						    		<option value="Text">Text</option>
						    		<option value="Date">Date</option>
						  		</select>
								</td>
							</tr>
				      
							<tr>
								<td colspan=2>
						    		<input id="add_variable" type="button" value="Add"/>
								</td>
							</tr>
						</table>
					</div>
					<div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
				</td>
			</tr>
		</table></div></td>

		<tr>
			<td><b>SQL Query (Add '$' before variable name above to refer to variable in the query):</b></td>
			<td><textarea name="sql_query" cols=60 rows=3 value="<?php if(isset($edit_report)) echo $edit_report->sql_query;?>"><?php if(isset($edit_report)) echo $edit_report->sql_query;?></textarea> <br><br></td>
		</tr>
		<tr>
			<td><b>Roles who can access report:</b>
			<select multiple size="<?php echo $num_roles;?>">
			</td>
			<td>
			<?php for($i=0; $i<$num_roles;$i++) { 
				$val=false;
				if(isset($edit_permitted_roles)){
				foreach($edit_permitted_roles as $key=>$role){
					if($role!=$roles[$i]['id']){
						$val=false;
					 }else{
					 	$val=true;
					 	break;
					 }
				  }
				}
			if($val==true){?>
				<INPUT NAME="roles[]" TYPE="CHECKBOX" checked="checked" VALUE="<?php echo $roles[$i]['id'];?>"><?php echo $roles[$i]['name'];?><BR>
			
			<?php }else{?>
				<INPUT NAME="roles[]" TYPE="CHECKBOX"  VALUE="<?php echo $roles[$i]['id'];?>"><?php echo $roles[$i]['name'];?><BR>
			<?php } }?>
			</select></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><input type="submit" class="submit" value="add_report"></td>
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
<?php
$this->load->view ( 'common/footer' );
?>
