<script type="text/javascript" src="<?php echo "{$this->config->item('base_url')}assets/js/opd/history/illness_box.js"; ?>"></script>

<div class="form_row" style="margin-bottom:10px;">
  <div class="form_newbtn" align="left">
    <!-- TODO: add javascript to add an illness -->
    <input id="add_illness" type="button" value="Add illness"/>
  </div>
</div>

<table id="illnesses" width="100%" border="0" cellspacing="2" cellpadding="2">
  <!-- TODO: Any additional fields required? -->
  <tr class="head">
    <td width="20%">Illness </td>
    <td width="10%">Status</td>
    <td width="5%">Start date</td>
    <td width="5%">End date</td>
    <td width="15%">Visit(s)</td>
    <td width="30%">Comment</td>
    <td width="15%">Next Action(s)</td>
  </tr>
  
  <?php foreach ($illnesses as $i) { ?>
  <tr id="<?php echo 'illness-'.$i->id; ?>"
    <?php if ($i->status == 'Past') { ?>
    class="grey_bg"
    <?php } else { ?>
    class="red_bg"
    <?php } ?>
    >

    <td><?php echo $i->name; ?></td>
    <td><?php echo $i->status; ?></td>
    <td><?php echo $i->start_date; ?></td>
    <td>
      <?php if ($i->end_date) { ?>
      <?php echo $i->end_date; ?>
      <?php } ?>
    </td>
    <td><?php if ($i->visit_id) { ?>
      <a href="<?php echo $this->config->item('base_url').'index.php/opd/visit/show/'.$i->visit_id; ?>"><?php echo $i->visit_id; ?></a>;
      <?php } ?>
    </td>
    <td><?php echo $i->comment; ?></td>
    <td>
      <a id="<?php echo 'illness-edit-'.$i->id; ?>"
	href="<?php echo $this->config->item('base_url').'index.php/opd/history/edit_illness/'.$i->id; ?>">edit</a>
    </td>
  </tr>
  <?php } ?>

</table>


<div id="edit_illness_box" style="display:none;">
  <div class="blue_left"><div class="blue_right"><div class="blue_middle"><span class="head_box">Add / edit illness</span></div></div></div>

  <div class="blue_body">
    <div class="form_row">
      <div class="form_leftB">Illness name</div>
      <div class="form_right">
	<input id="illness_name" type="text" name="illness[name]"/>
      </div>
    </div>

    <div class="form_row">
      <div class="form_leftB">Status</div>
      <div class="form_right">
	<select id="illness_status" name="illness[status]">
	  <option value="Current">Current</option>
	  <option value="Past">Past</option>
	</select>
      </div>
    </div>

    <div class="form_row">
      <div class="form_leftB">Start date</div>
      <div class="form_right">
	<input id="illness_start_date" name="illness[start date]" type="text"/>
      </div>
    </div>

    <input id="illness_submit" type="button" value="Submit" class="submit"/>
  </div>

  <div class="bluebtm_left"><div class="bluebtm_right"><div class="bluebtm_middle"></div></div></div>
</div>