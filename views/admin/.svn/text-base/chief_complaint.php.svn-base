<?php $this->load->helper('form');
$this->load->view('common/header');
?>

<meta
	http-equiv="Content-Language" content="en" />
<meta name="GENERATOR"
	content="Zend Studio" />
<meta
	http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Chief Compliants</title>

<style>
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	margin: 0px;
	padding: 0px;
}

.maindiv {
	width: 550px;
	margin: auto;
	border: #000000 1px solid;
}

.mainhead {
	background-color: #aaaaaa;
}

.tablehead {
	background-color: #d7d7d7;
}

.row {
	background-color: #e7e7e7;
}

.data_table tr {
	font-size: 11px;
	height: 25px;
	background-color: #e8e8e8;
}

.largeselect {
	width: 200px;
}
</style>
<link
	href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css"
	rel="stylesheet" type="text/css">
	<!--<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-1.3.2.min.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.2.custom.min.js"; ?>"></script>
    
     --><script  type="text/javascript">
//Creating javascript array from php array.
var system_list = new Array();      

/*$( function() {
    $( '.checkAll' ).live( 'change', function() {
        $( '.cb-element' ).attr( 'checked', $( this ).is( ':checked' ) ? 'checked' : '' );
        $( this ).next().text( $( this ).is( ':checked' ) ? 'Uncheck All' : 'Check All' );
    });
    $( '.cb-element' ).live( 'change', function() {
        $( '.cb-element' ).length == $( '.cb-element:checked' ).length ? $( '.checkAll' ).attr( 'checked', 'checked' ).next().text( 'Uncheck All' ) : $( '.checkAll' ).attr( 'checked', '' ).next().text( 'Check All' );

    });
});*/

function toggleChecked(status) {
	$(".cb-element").each( function() {
	$(this).attr("checked",status);
	});
}
	

function validateAddDiagnosisForm(){
	
}

</script>
</head>
<body bgcolor="#FFFFFF" text="#000000"
	link="#FF9966" vlink="#FF9966" alink="#FFCC99">

	<?php $this->load->view('common/header_logo_block');
	$this->load->view('common/header_search');
	?>
	<?php if(isset($success_message) && $success_message != ''){
		echo "<div class='success'>$success_message </div>";
	}
	?>
	<?php if(isset($error_server) && $error_server != ''){
		echo "<div class='error'>$error_server </div>";
	}
	?>
	
	<!--Main Page-->
	<div id="main">

		<div id="leftcol">
			<div class="yelo_left">
				<div class="yelo_right">
					<div class="yelo_middle">
						<span class="head_box">Visit Document Configuration</span>
					</div>
				</div>
			</div>
			<div class="yelo_body" style="padding: 8px;">
				<div class="action_items" ><a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/diagnosis">Diagnosis Configuration</a></div>
				<div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/ros">ROS Configuration</a></div>
				<div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/physical_exam">Physical Exam Configuration</a></div>
				<div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/protocol_information">Protocol Information Configuration</a></div>
			    <div class="action_items" style="font-weight: bold"> <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/chief_complaint">Chief Complaints</a></div>
			    
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
						<span class="head_box">Chief Complaints</span>
					</div>
				</div>
			</div>
			<div class="blue_body" style="padding: 8px;">
					<table width="600" border="0" align="center" cellpadding="5"
						cellspacing="1" class="data_table" id="add_diagno_table">
						<tr>
							<td width="60%" valign="top">
							<form method="POST"
									action="<?php echo $this->config->item('base_url').'index.php/admin/visit_document_configuration/chief_complaint/add'?>"
									onSubmit="return validateAddDiagnosisForm()">
								<table id="left_inner_table">
									<!--<tr>
										<td><strong>System<strong></strong></td>
										<td><?php echo form_dropdown ( 'system_name', $distnict_system,'','id="system_names"' ); ?></td>
									</tr>
									
									--><?php 
										  for ($i=1; $i < 11; $i++) {
  									?>	
									<tr>
									    <td> <?php echo $i;?>: </td>
									    <td> <input type="text" name="added_value[]" value=""/></td>
									</tr>
									<?php } ?>
									
									<tr>
											<td ><label class="error" id="error_diagno_name" style="display:none">Atleast 1 field is required.</label></td>
									</tr>
									
									<tr>
										<td width="100%" align="right" colspan="2"><input type="submit"
								value="Add" name="submit" class="submit" /></td>
									</tr>
									
								</table>
								</form>
							</td>
							<td width="40%" valign="top">
							    <div style="float:left;padding:5px;"><a href="javascript:void(0)" onclick="toggleChecked('checked')" align="left">Check all</a></div>
								<div style="padding:5px;"><a href="javascript:void(0)" onclick="toggleChecked('')" align="left">Un Check all</a></div>
								
								<form method="POST"
									action="<?php echo $this->config->item('base_url').'index.php/admin/visit_document_configuration/chief_complaint/delete'?>"
									onSubmit="return validateAddDiagnosisForm()">
								<!--<div style="float:left;padding:5px;"><a href="javascript:void(0)" onclick="toggleChecked('checked')">Check all</a></div>
								<div style="padding:5px;"><a href="javascript:void(0)" onclick="toggleChecked('')">Un Check all</a></div>
								<div id="system_hidden"></div>
								--><table id="right_inner_table">
								    
									
  
									<tr><?php
                                         foreach ($chief_complaint_list as $chief_complaint){
                                         	if($chief_complaint->id !== "1"){
		                                      $id = $chief_complaint->id;
		                                      $value = $chief_complaint->value;
		                                      $system = $chief_complaint->system;
	                                    
	                                          echo "<input type='checkbox' class='cb-element'  name='delete_diagonsis[]' value='$value'   />";
	                                          echo ucwords(addslashes($value));
	                                          echo "<br/>";
                                         	}
                                         }
                                    ?>
									</tr>
								
								</table>
								<div style="padding:10px;"   valign="bottom">
									<input type="submit" value="Delete" name="submit" class="submit" /></div>
								</form>
							</td>
						</tr>

					</table>
					<br />
					<table align="center" valign="top">
						<tr>
							<td width="50%" align="center">
							
							
						</tr>
					</table>
			</div>
			<div class="bluebtm_left">
				<div class="bluebtm_right">
					<div class="bluebtm_middle"></div>
				</div>
			</div>
		</div>
		<br class="spacer" />


	</div>
	</div>
	<!--Body Ends-->

	<?php $this->load->view('common/footer.php'); ?>
