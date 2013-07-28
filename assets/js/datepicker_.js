$(function() {
	$(".datepicker").datepicker({
	dateFormat: 'dd/mm/yy',
	showOn: 'button',
	buttonImage: base_url+'/assets/images/common_images/img_datepicker.gif',
	buttonImageOnly: true});
});
$(function() {
	$(".datepicker_hyphen").datepicker({
	dateFormat: 'dd-mm-yy',
	showOn: 'button',
	buttonImage: base_url+'/assets/images/common_images/img_datepicker.gif',
	buttonImageOnly: true});
});
