<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/visit/addendum_box.js"; ?>"></script>
<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/datepicker_.js"; ?>"></script>
<div class="form_row" style="margin-bottom:10px;">
  <div class="form_newbtn" align="left">
    <input id="add_addendum" type="button" value="Add Note"/>
  </div>
</div>

<table id="addendums" width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="head">
    <td width="15%">Date</td>
    <td width="10%">Author</td>
    <td width="65%">Note</td>
    <td width="10%">Edit</td>
  </tr>
  
  <?php foreach ($visit->related('visit_addendums')->get() as $a) { ?>
	 
	  <tr id="<?php echo 'addendum-'.$a->id; ?>">
	    <td colspan=4>
	     	<form  method="POST" id="addendum_edit_<?php echo $a->id;?>">
	     		<table width="100%" border="0" cellspacing="2" cellpadding="2">
	     			<tr>
	     				<td width="15%" id="edit_date_<?php echo $a->id;?>">
					    	<div class="audit_<?php echo $a->id;?>"><?php echo $a->date; ?></div>
					    </td>
					    <td width="10%"><?php echo $a->username; ?></td>
					    <td width="65%" id="edit_addendum_<?php echo $a->id; ?>">
					    	<div class="audit_<?php echo $a->id;?>"><?php echo $a->addendum; ?></div>
					    </td>
					    <td width="10%" id="edit_button_<?php echo $a->id; ?>" onclick="editAddendum('<?php echo $a->date; ?>','<?php echo $a->addendum; ?>','<?php echo $a->id; ?>')">
					    	<div class="audit_<?php echo $a->id;?>">
					    		<a href="javascript:void(0);" >Edit</a>
					    	</div>
					     </td>
	     			</tr>
	     		</table>
	     	</form>
	    </td>
	  </tr>
  <?php } ?>
  
</table>

<div id="addenddum-page-loader" style="display: none;">
	<h3>Please wait...</h3>
	<?php echo '<img src="'.base_url().'/assets/images/common_images/loader.gif" alt="loader">';?>
	<p><small id="page-load-content">...Please wait, adding note to visit.</small></p>
</div>
<div id="edit_addendum_box" style="display:none;">
  <div class="blue_left"><div class="blue_right"><div class="blue_middle"><span class="head_box">Add Note</span></div></div></div>

  <div class="blue_body">
    <div class="form_row">
      <div class="form_leftB">Date</div>
      <div class="form_right">
<!--	<input id="date" class="datepicker check_dateFormat hasDatepicker" type="text" style="width: 140px;" value="DD/MM/YYYY" name="date"/>
	<img class="ui-datepicker-trigger" src="<?php echo "{$this->config->item('base_url')}assets/images/common_images/img_datepicker.gif"; ?>"
	alt="" title=""/> -->
	<input id="datepicker" type="text" name="datepicker"/>
	<input id="date" type="hidden" name="date"/>
      </div>
    </div>

    <div class="form_row">
      <div class="form_leftB">Note</div>
      <div class="form_right">
	<input id="addendum" name="addendum" type="text"/>
      </div>
    </div>
	
	 <br />
    <input type="checkbox" name="sendemail" value="sendemail" id="sendemail" checked> <b>Send email</b> </input>
    <br />
    <br />
    <input id="submit" type="button" value="Submit" class="submit"/>
  </div>

  <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
</div>
