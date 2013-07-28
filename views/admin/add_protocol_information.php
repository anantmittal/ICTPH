
<?php $this->load->helper('form');
$this->load->view('common/header');
?>

<meta
	http-equiv="Content-Language" content="en" />
<meta name="GENERATOR"
	content="Zend Studio" />
<meta
	http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Protocol Information</title>

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
}
#new{
	padding:13px 0 0 220px; 
	width:900px;
}

.largeselect {
	width: 200px;
}
li a{
}
li a:visited {
	color:#ff0000;
	font-weight:bold;
}
#add_element_table{
	padding: 5px 0px 0px 5px;
	
}
#add_element_table tr td{
	padding-bottom: 5px;
}
</style>
<link
	href="<?php echo $this->config->item('base_url'); ?>assets/css/site.css"
	rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo $this->config->item('base_url'); ?>assets/jquery.treeview/demo/screen.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->config->item('base_url'); ?>assets/jquery.treeview/jquery.treeview.css" type="text/css" />
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/jquery.treeview/jquery.treeview.js"></script>

<script type="text/javascript">
$(document).ready(function(){
    $("#example").treeview({
    	control: "#treecontrol",
    	 collapsed: true,
    	 animated: "fast"
    });

	$("#add_root_paret_href").click(function() {
		$("#add_root_element_table").show();
		//Show contents
		$("#ros_right_content").hide();
		//Show Add element Div
		$("#add_element_table").hide();
		$("#new").hide();//hide meassage
	});
	$("#action_items").click(function() {
		$("#new").hide();//hide meassage
	});
});
$(document).ready(function(){
	$('#node_types').change(function(){
		hideRosErrorMessages();
		var selected_type = $('#node_types :selected').val();
		if(selected_type=='RADIO'){
			$("#name_element").hide();
			$("#options_element").show();
		}else if(selected_type=='SELECT' || selected_type=='FOLLOWUP'){
			$("#name_element").show();
			$("#options_element").show();
		}else{
			$("#options_element").hide();
			$("#name_element").show();
		}
	});
	$('#node_types').change();
});

function populateRightContent(nodeId,nodeName,nodeType,parentId,parentName){

	//Hide Root Parent add element
	$("#add_root_element_table").hide();
	
	//Populate contents
	$("#node_name_element").html();
	$("#node_name_element").html(nodeName);
	$("#node_Type_element").html();
	$("#node_Type_element").html(nodeType);
	$("#node_parent_name_element").html();
	$("#node_parent_name_element").html(parentName);
	//Show contents
	$("#ros_right_content").show();
	//Show Add element Div
	$("#add_element_table").show();
	//hide message
	$("#new").hide();

	$("#hidden_fields").html();
	 var nodeIdHtml = "<input type='hidden' value='"+nodeId+"' name='nodeId'/>";
	 var nodeNameHtml = "<input type='hidden' value='"+nodeName+"' name='nodeName'/>";
	 var nodeParentIdHtml = "<input type='hidden' value='"+parentId+"' name='parentId'/>";
	$("#hidden_fields").html(nodeIdHtml+nodeNameHtml+nodeParentIdHtml);	
}
function deleteNode(){
	var r=confirm("Are you sure you want to delete. All sub-trees will be deleted. ");
	if (r==true)
	  {
		document.forms["add_delete_node"].action = "<?php echo $this->config->item('base_url').'index.php/admin/visit_document_configuration/protocol_information/delete'?>";
		document.forms["add_delete_node"].submit();
	  }
}

function addNode(){
	if(validateElement()){
		document.forms["add_delete_node"].action = "<?php echo $this->config->item('base_url').'index.php/admin/visit_document_configuration/protocol_information/add'?>";
		document.forms["add_delete_node"].submit();
	}	
}

function addRootNode(){
	if(validateParent()){
		document.forms["add_root_node"].action = "<?php echo $this->config->item('base_url').'index.php/admin/visit_document_configuration/protocol_information/add_root_element'?>";
		document.forms["add_root_node"].submit();
	}
}

function validateElement(){	
	var retVal = true;
	hideRosErrorMessages();
	var selected_type = $('#node_types :selected').val();
	if(selected_type=='RADIO'){
		if($.trim($("#child_value_text").val())==""){ 
			$('#error_option').show();	
			retVal = false;
		}
	}else if(selected_type=='SELECT'){
		if($.trim($("#child_name_text").val())==""){
			$('#error_name').show();	
			retVal = false;
		}
		if($.trim($("#child_value_text").val())==""){
			$('#error_option').show();	
			retVal = false;
		}
	}else{
		if($.trim($("#child_name_text").val())==""){
			$('#error_name').show();	
			retVal = false;
		}
	}	
	return retVal;
}

function validateParent(){	
	var retVal = true;
	hideRosErrorMessages();
	if($.trim($("#root_name_text").val())==""){
		$('#error_root_name').show();	
		retVal = false;
	}
	return retVal;
}

function hideRosErrorMessages (){
	$('.error1').hide();	
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
				<div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/diagnosis">Diagnosis Configuration</a></div>
				<div class="action_items"> <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/ros">ROS Configuration</a></div>
				<div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/physical_exam">Physical Exam Configuration</a></div>
				<div class="action_items" style="font-weight: bold"><a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/protocol_information">Protocol Information Configuration</a></div>
			    <div class="action_items" > <a href="<?php echo $this->config->item('base_url');?>index.php/admin/visit_document_configuration/chief_complaint">Chief Complaints</a></div>
			
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
						<span class="head_box">Protocol Information Configuration</span>
					</div>
				</div>
			</div>
			<div class="blue_body" style="padding: 8px;">
				<table width="680" border="0" align="center" cellpadding="5"
						cellspacing="1" class="data_table">
						<tr class="gridrow">
						    <td id="ros_left_content" width="65%" valign="top" style="border-right:1px solid #ccc;">
							    <div id="treecontrol" style="display: block;">
									<a href="javascript:void(0);" title="Collapse the entire tree below"><img src="<?php echo "{$this->config->item('base_url')}"?>assets/jquery.treeview/images/minus.gif"> Collapse All</a>
									<a href="javascript:void(0);" title="Expand the entire tree below"><img src="<?php echo "{$this->config->item('base_url')}"?>assets/jquery.treeview/images/plus.gif"> Expand All</a>
									<a href="javascript:void(0);" title="Toggle the tree below, opening closed branches, closing open branches">Toggle All</a>
									<a href="javascript:void(0);" id="add_root_paret_href">Add New Root Parent</a>
								</div>
								<?php 
							    	$jtp = $protocol_information_tree;
							    	echo '<ul id="example" class="treeview-gray treeview">';
							    	foreach ($protocol_information_tree->getRootParents() as $node) {
							    			printNode($node, $protocol_information_tree);
							    	}
									echo '</ul>';
			
									function printNode ($node, $protocol_information_tree) {
										echo '<li>';
										$node_id = $node->getUid();
										$node_name = ucwords($node->getValue());
										$node_type = $node->getType();
										$parent_id = $node->getParent();
										$parent_name = "";
										if($parent_id == -1){
											$parent_id = "";
											$parent_name = "Root Parent";
										}else{
											$parent_name = $protocol_information_tree->getValue($parent_id);
										}
										//To Escape Single quotes
										$temp_node_name = $node_name;
										$temp_node_name = str_replace("'", "&#39;",$temp_node_name);
										$temp_parent_name = $parent_name;
										$temp_parent_name = str_replace("'", "&#39;",$parent_name);
										
										echo "<a href='javascript:void(0);' onclick='populateRightContent(\"$node_id\",\"$temp_node_name\",\"$node_type\",\"$parent_id\",\"$temp_parent_name\");'>".$node_name."</a>";
										$children = $node->getChildren();
							    		if(!empty($children)){
							    			echo "<ul>";
							    			foreach ($children as $childUid) {
							    				$childnode = $protocol_information_tree->getNode($childUid);
							    				printNode($childnode, $protocol_information_tree);
							    			}
							    			echo "</ul>";
							    		}
										echo "</li>";
									}
							    ?>
							</td>
							<td id="ros_right" width="35%" valign="top">
								<table width="100%" id="ros_right_content" style="display: none">
									<tr>
										<td width="40%"><strong></strong></td>
										<td><strong> </strong></td>
										<td id="node_Id_element" width="45%"></td>
										<td  align="right" width="15%"><a href="javascript:void(0);" id="delete_node_element" onclick="deleteNode();"><img src = "<?php echo "{$this->config->item('base_url')}"?>assets/jquery.treeview/images/delete_node.gif" /></a></td>
									</tr>
									<tr>
										<td valign="top"><strong>Node name</strong></td>
										<td valign="top"><strong> :</strong></td>
										<td valign="top" id="node_name_element"></td>
									</tr>
									<tr>
										<td valign="top"><strong>Node Type</strong></td>
										<td valign="top"><strong> :</strong></td>
										<td valign="top" id="node_Type_element"></td>
									</tr>
									<tr>
										<td valign="top"><strong>Parent name</strong></td>
										<td valign="top"><strong> :</strong></td>
										<td valign="top" id="node_parent_name_element"></td>
									</tr>
								</table>
								
								<form method="POST" id="add_delete_node">
									<div id="hidden_fields" style='display:none'></div>
									<table width="100%" id="add_element_table" style="display: none">
										<tr><th valign="top" colspan="3">Add Element</th></tr>
										
										<tr>
											<td><strong>Type</strong><span style="color:#FF0000">*</span></td>
											<td><strong> :</strong></td>
											<td><?php $options = array(
														'TEXT' => 'Text only',
	                  									'CHECKBOX'  => 'Checkbox',
	                  									'RADIO'    => 'Radio Button',
	                  									'TEXTBOX'   => 'Text Box',
	                  									'SELECT' => 'Dropdown',	                  									
	                  									'FOLLOWUP' => 'Follow-up'
	                									);
												echo form_dropdown('node_type', $options,'','id="node_types"');
												?>
											</td>
										</tr>
										<tr id="name_element">
											<td width="59%"><strong>Name</strong><span style="color:#FF0000">*</span></td>
											<td width="2%"><strong> :</strong></td>
											<td width="39%"><input type="text" name="newChildElement" id="child_name_text"/></td>
										</tr>
										<tr>
											<td colspan="3" ><label class="error1" id="error_name" style="display:none">The Name field is required.</label></td>
										</tr>
										<tr id="options_element" style="height:50px;">
											<td valign="top" width="59%"><strong><span id="value_label">Options</span><span style="color:#FF0000">*</span></strong></td>
											<td valign="top" width="2%"><strong> :</strong></td>
											<td valign="top" width="39%"><input type="text" name="commaSeparatedValues" id="child_value_text"/>
												<br />
												<div style="color: #6D7B8D" >
													<b>Please enter</b> one value for option or more <b>comma separated</b> values.
												</div>
											</td>
										</tr>
										<tr>
											<td colspan="3" ><label class="error1" id="error_option" style="display:none">The Option field is required.</label></td>
										</tr>
										<tr>
											<td colspan="3" align="right"><input type="button" value="Add Element" onclick="addNode();" /></td>
										</tr>
									</table>
								</form>
								<form method="POST" id="add_root_node">
									<table width="100%" id="add_root_element_table">
										<tr><th valign="top" colspan="3">Add Root parent</th></tr>
										<tr>
											<td width="60%"><strong>Name</strong><span style="color:#FF0000">*</span></td>
											<td><strong> :</strong></td>
											<td width="40%"><input type="text" name="newRootParent" id="root_name_text" /></td>
										</tr>
										<tr>
											<td colspan="3" ><label class="error1" id="error_root_name" style="display:none">The Name field is required.</label></td>
										</tr>
										<tr>
											<td colspan="3" align="right"><input type="button" value="Add Element" onclick="addRootNode();" /></td>
										</tr>
									
									</table>
								 </form>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div class="bluebtm_left">
				<div class="bluebtm_right">
					<div class="bluebtm_middle"></div>
				</div>
			</div>
		</div>
		<br class="spacer" />


	</div>
	<!--Body Ends-->

	<?php $this->load->view('common/footer.php'); ?>

