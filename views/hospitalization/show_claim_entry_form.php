<?php 
/**
 * @todo : move all inline javascript to new js file and include that file in header page
 * 
 */
$this->load->helper('form');
$this->load->view('common/header');?>
<title>Claim Entry</title>
<?php $this->load->view('common/header_logo_block'); 
$this->load->view('common/header_search');
?>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('base_url'); ?>assets/css/jquery.autocomplete.css" />
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/jquery-ui-1.7.1.custom.min.js"; ?>"></script>
<script type='text/javascript' src='<?php echo $this->config->item('base_url'); ?>assets/js/jquery.autocomplete.js'></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<script type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>assets/js/claim_entry.js"></script>
<style type="text/css" >
	.err{
	     font-size:12px;
	     color:red;
	    }
</style>

</head>
<body>

<!-- Body Start -->
<div id="main">
  <!--Preauth Box End-->
  <div class="hospit_box">
    	<div class="green_left"><div class="green_right">
    	  <div class="green_middle"><span class="head_box">Claim entry</span></div></div></div>
          <div class="green_body">
          		<div id="left_col">                
                    <div class="yelo_left"><div class="yelo_right">
    	  <div class="yelo_middle"><span class="head_box">Policy details</span></div></div></div>
        <div class="yelo_body" style="padding:8px;">
        
        <?php $this->load->view('hospitalization/hospitalization_context', $short_context); ?>
        
        
		          
        <br class="spacer" /></div>

      <div class="yelobtm_left" ><div class="yelobtm_right"><div class="yelobtm_middle"></div></div></div>
      
  	  </div>                
       <div id="right_col">
    	<div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Claim entry</span></div></div></div>
          <div class="blue_body">
		
          
          
		<form method="POST" id="claim_entry_form" name="claim_entry_form" enctype="multipart/form-data">                        
            <div class="form_row">
              <div class="form_leftB">Claim Form Number</div>
              <div class="form_right">
                <input type="text" name="claim_form_number" value="<?php echo $values['claim_form_number']; ?>" size="10" class="required">
                &nbsp;<?php echo form_error('claim_form_number'); ?>
              </div>
            </div>
            
            <div class="form_row">
              <div class="form_leftB">Claim Filling Date</div>
              <div class="form_right">
               <input name="filling_date" id="filling_date" type="text" size="10" value="<?php echo $values['filling_date']; ?>" class="datepicker required" /> <?php echo form_error('filling_date'); ?>
              </div>
            </div><br>

<div class="form_row" >
              <div class="form_leftB">Claim By</div>
              <div class="form_right">
              <?php
                 echo form_dropdown('claim_by', array('Hospital','Individual','Pharmacy'),$values['claim_by']) ;
                ?>
              </div>
            </div>


            <div class="form_row">
              <div class="form_leftB">Upload claim form</div>
              <div class="form_right">
                <input type="file" name="claim_form"/>
              </div>
            </div><br />
            
           <div> <?php echo form_error('form_rows_data'); ?> </div>
            
            <div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Claims items</span></div></div></div>
          <div class="blue_body" style="padding:10px;">
            <table width="100%" border="0" cellspacing="2" cellpadding="2" id="claimItemTable">
              <tr class="head">
                <td width="13%">Type</td>
                <td width="13%">Subtype</td>
                <td width="10%">Item Name</td>
                <td width="10%">Number</td>
                <td width="10%">Unit cost</td>
                <td width="12%">Total Cost</td>
                <td width="12%">Claimed Amount</td>
                <td width="20%">Comment</td>
                <td width="20%">Remove</td>
              </tr>
       <?php 
		$amount = 0;
		$claimed_amount = 0;
               foreach ($values['claim_cost_items_rows'] as $claim_cost_item) {
       	
//       	$rec = $hosp_cost_item_obj->find($claim_cost_item->hospitalization_cost_item_id);
         
      // 	$rec = $hosp_cost_item_obj->find(23);
       	
       	?>     
            <tr class="grey_bg">
              <td> <?php echo $claim_cost_item->item_type; ?> </td>
              <td><?php echo $claim_cost_item->item_subtype; ?></td>
              <td><?php echo $claim_cost_item->item_name; ?></td>
              <td> <?php echo $claim_cost_item->number_of_times; ?>  </td>
              <td> <?php echo $claim_cost_item->rate; ?> </td>
              <td><?php echo ($claim_cost_item->amount); ?></td>
              <td><?php echo $claim_cost_item->claimed_amount; ?> </td>
              <td> <?php echo $claim_cost_item->comment; ?>  </td>
  	      <td onmousedown="removeRow(this)"><a href="#">Remove</a></td>
            </tr>
        <?php 
  		$amount += $claim_cost_item->amount;
  		$claimed_amount += $claim_cost_item->claimed_amount;
		} ?>    
            </table>
            
            <table border="0" width="100%">
            	<tr class="approve">            		
            		<td colspan="5" width="50%" align="right"><b><label id="tot_cost">Total cost : <?php echo $amount; ?> </label></b>&nbsp;&nbsp; </td>
            		<td colspan="2">&nbsp;&nbsp;<b><label id="tot_claim_cost" style="width:200px">Total Claimed Cost : <?php echo $claimed_amount ; ?> </label></b></td>
            	</tr>        
            	<tr>            	 	
            	 	<td colspan="7" align="right"> <input type="button" name="submit" id="add_new_claim" value="Add another claim item" class="submit"  />
            	 	</td>
            	</tr>    	
            </table>

            <div class="form_row" style="padding-top:10px;">
              <!--<div class="form_leftB">&nbsp;</div>-->
              <div style="float:left">              
	              <input type="hidden" id="total_claimed_cost" name="total_claimed_cost" value="<?php echo $claimed_amount; ?>">
	              <input type="hidden" id="total_cost" name="total_cost" value="<?php echo $amount; ?>">
	              <input type="hidden" name="hospitalization_id" value="2">
	              <input type="hidden" name="form_rows_data" id="form_rows_data" value="">
<!--	              <input type="hidden" name="form_rows_data" id="form_rows_data" <?php echo 'value="'.$values['claim_cost_items_rows'].'"' ; ?>> -->
	              <input type="submit" name="submit" id="submit_form_data" value="Submit values" class="submit"  />
	             
              </form>
              </div>
              <!--<div class="form_right"  style="float:right">
              <input type="button" name="submit" id="add_new_claim" value="Add another claim item" class="submit"  />
               
              </div>-->
            </div>
          </div>
          <div class="bluebtm_left" ><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br />
          <div id="add_claim" style="display:none;">

 <div class="blue_left"><div class="blue_right">
    	  <div class="blue_middle"><span class="head_box">Claims items</span></div></div></div>
          <div class="blue_body">

            <div class="form_row">
              <div class="form_leftB">Item Type</div>
              <div class="form_right">
   <?php   echo form_dropdown('item_type', $this->config->item('item_type'), '', 'id="item_type"');  ?>              
              </div>
            </div>
            
            <div class="form_row">
              <div class="form_leftB">Subtype</div>
              <div class="form_right">
              <select name="subtype" id="subtype" >
              </select>
                <input type="text" name="subtype" id="subtype_txt" class="memname" style="display:none" disabled>
              </div>
            </div>
            
            <div class="form_row">
              <div class="form_leftB"><label for="item_name">Item Name</label></div>
              <div class="form_right">
            <!-- <input name="item_name" id="item_name" type="text" class="" value="<?php echo set_value('item_name');?>" />  -->
          <input name="item_name" id="item_name" type="text" class="" value="" /> 
              </div>
            </div>

            <div class="form_row">
              <div class="form_leftB"><label for="number_of_times">Number of times</label></div>
              <div class="form_right">

              <input name="number_of_times" id="number_of_times" class="to_calc required digits" type="text" value="<?php echo set_value('number_of_times');?>" />
              <?php echo form_error('number_of_times'); ?>
              </div><label id="error_num_of_times" class="error" style="display:none;" ></label>
            </div>

            <div class="form_row">
              <div class="form_leftB">Rate</div>
              <div class="form_right">
                <input name="rate" id="rate" type="text"  class="to_calc required digits" value="<?php echo set_value('rate'); ?>" />
                <?php echo form_error('rate'); ?>
              </div><label id="error_rate" class="error" style="display:none;"> "Rate" field should number</label>
            </div>
            <div class="form_row">
              <div class="form_leftB">Total</div>
              <div class="form_right"><strong class="total">Rs. 0</strong></div>
            </div>
            <div class="form_row">
              <div class="form_leftB">Claim Amount</div>
              <div class="form_right">
                <input name="claim_amount" id="claim_amount" type="text" value="<?php echo set_value('claim_amount'); ?>" class="required digits" />
                <?php echo form_error('claim_amount'); ?>
              </div><label id="error_claim_amount" class="error" style="display:none;"></label>
            </div>
            <div class="form_row" style="margin-top:20px;">
              <div class="form_leftB"><label for="comment">Comment</label></div>
              <div class="form_right">
                <input name="comment" id="comment" class="" type="text" value="" />
              </div>
            </div>
            <div class="form_row" style="margin-top:20px;">
              <div class="form_leftB">&nbsp;</div>
              <div class="form_right">
              <input type="button" name="submit_btn" value="Submit" class="submit" id="addrow"/></div>
            </div>
          </div>

          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    </div>
    </div>
          <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    </div>
          
          <br class="spacer" /></div>
          <div class="greenbtm_left"><div class="greenbtm_right"><div class="greenbtm_middle"></div></div></div>
    </div>
<br class="spacer" /></div>
<!-- Body End -->

<?php $this->load->view('common/footer'); ?>
