<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/visit/billing_tab.js"; ?>"></script>

<div class="blue_left">
  <div class="blue_right"><div class="blue_middle"><span class="head_box">Consultation</span></div></div>
</div>


<div class="blue_body" style="padding:10px;">
  <table>
    <tr>
      <td width="20%">Consultation
	<input type="hidden" name="consultation[0][type]" value="Consultation">
      </td>
      <td width="50%"><?php echo $provider->type; ?>
	<input type="hidden" name="consultation[0][subtype]" value="<?php echo $provider->type; ?>" >
      </td>
<!--	<select name="cost_items[0][subtype]" selected="<?php $provider->type; ?>" >
	  <?php foreach ($consultation_types as $c) { ?>
	  <option value="<?php echo $c->name; ?>"><?php echo $c->name; ?> </option>
	  <?php } ?>
	</select>-->
      <td width="30%">
	<input name="consultation[0][rate]" id="cost_items_consultation" value="0">
	<input type="hidden" name="consultation[0][number]" value="1">
      </td>
      <td><input id="load_to_billing" type="button" class="submit" value="Load Data"></input></td>
    </tr>
  </table>
</div>

<div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
    <br/>
    
    <div class="blue_left">
      <div class="blue_right"><div class="blue_middle"><span class="head_box">Drugs</span></div></div>
    </div>
    
    <div class="blue_body" style="padding:10px;">
      
<!--	<tr>
	  <td></td>
	  <td></td>
	  <td></td>
	  <td><input id="load_medications" type="button" class="submit" value="Load from Medications"></input></td>
	</tr>-->
	<table id="cost_table">
	<tr class="head" id="medications_table_header">
	  <td width="60%">Drug</td>
	  <td width="10%">Quantity</td>
	  <td width="15%">Rate (Rs)</td>
	  <td width="15%">Total (Rs)</td>
	</tr>
	</table>
    </div>

    <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br/>
    
    
    <div class="blue_left">
      <div class="blue_right"><div class="blue_middle"><span class="head_box">Tests</span></div></div>
    </div>
    
    <div class="blue_body" style="padding:10px;">
   
   <table id="test_cost_table">
	<tr class="head">
	  <td width="60%">Test</td>
	  <td width="10%">Number</td>
	  <td width="30%">Rate (Rs)</td>
	</tr>	
  </table>
    </div>
    
    <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div><br/>
    
    
    <div class="blue_left">
      <div class="blue_right"><div class="blue_middle"><span class="head_box">Total</span></div></div>
    </div>
    
    <div class="blue_body" style="padding:10px;">
      <table>
	<tr>
	  <td width="70%"><b>Bill amount</b></td>
	  <td width="30%" id="cost_items_total"></td>
	</tr>
	<tr>
	  <td width="70%"><b>Actual payment</b></td>
	  <td><input type="text"
	      name="paid_amount" id="paid_amount">
	  </td>
	</tr>
      </table>
    </div>
    
    <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
