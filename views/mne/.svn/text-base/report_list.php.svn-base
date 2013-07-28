<?php
$base_url       = $this->config->item('base_url');
$permission_url =  $base_url.'index.php/monitoring_evaluation/report/add_permission/'
/**
 * @todo : add pagination support for this functionality
 */
?>
<html>
<head>
<title>Report Listing</title>
</head>
<body bgcolor="#FFFFFF" text="#000000" link="#FF9966" vlink="#FF9966" alink="#FFCC99">
<table border="1" align="center" width="60%">
<tr> <td><b>ID</b></td> <td><b>Name</b></td>  <td><b>Author</b></td> <td><b>Author</b></td></tr>
<?php
foreach ($reports as $report_obj) {
echo '<tr>';
echo '<td>'.$report_obj->id.'</td><td>'.$report_obj->name.'</td><td>'.$report_obj->author.'</td>'  ;
echo '<td><a href="'.$permission_url.$report_obj->id.'">Add Permission </a></td>';
echo '</tr>';
 } ?>
</table>
</body>
</html>