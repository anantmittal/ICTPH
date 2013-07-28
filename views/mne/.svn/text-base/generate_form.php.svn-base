<?php
//@TODO need to add support for checbox and file html element.
//@TODO change functionality from if else to swith case using that the code will be clener
$this->load->helper('form'); ?>
<html>
<head></head>
<body>
<?php echo form_open('query_builder/save'); ?>
<table align="center">
<?php
foreach ($form_data as $form_data_row) {

	echo '<tr><td align="left" valign="top">'. form_label($form_data_row['label']) .'</td><td>';

	if($form_data_row['form_input_type'] == 'input' || $form_data_row['form_input_type'] == 'password'	) {
		$data = array(
		'name'        => &$form_data_row['field'],
		'id'          => &$form_data_row['field'],
		'maxlength'   => &$form_data_row['length_value']
		);

		if($form_data_row['form_input_type'] == 'input')
			echo form_input($data);
		elseif ($form_data_row['form_input_type'] == 'password')
			echo form_password($data);
		unset($data);
	}

	if ($form_data_row['form_input_type'] == 'textarea') {
		$data = array(
		'name'        => &$form_data_row['field'],
		'id'          => &$form_data_row['field'],
		'rows'        => 3,
		'cols'		  => 25
		);
		echo form_textarea($data);
		unset($data);
	}

	if($form_data_row['form_input_type'] == 'radio') {
		$data = array(
		'name'        => &$form_data_row['field']
		);

		foreach ($form_data_row['form_input_values'] as $input_values)  {
			$data['value'] = &$input_values['value'];
			echo '   '.form_radio($data) . ' '.$input_values['label'];
		}
		unset($data);
	}

	if($form_data_row['form_input_type'] == 'select') {
		$other_data = "id ='$form_data_row[field]'";


		foreach ($form_data_row['form_input_values'] as $input_values)  {
			$options[$input_values['value']] = $input_values['label'];
		}
		echo form_dropdown($form_data_row['field'], $options, '', $other_data);
		//    echo print_r($options);
		unset($data);
	}

	echo '</td></tr>';
}

?>
<tr><td> &nbsp;</td> <td align="right"><input type="submit" value="Submit"> </td>  </tr>
</table>
</form>
</body>
</html>