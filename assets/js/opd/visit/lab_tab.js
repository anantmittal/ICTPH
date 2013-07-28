function check_text(id){
		//$('#tests_'+id+'_error').html("Value Required");
		var test_val=$('#tests_'+id+'_result').val();
		if($.trim(test_val)==''){
			$('#tests_'+id+'_result').focus();
			$('#tests_'+id+'_error').show();
		}else{
			$('#tests_'+id+'_error').hide();
		}	
	}

	//check for duplicate barcodes 
	function check_duplicate_barcode(id){
		var ajax_check_required=true;
		var selected_barcode=$('#barcode_'+id).val();
		var selected_barcode_location=$('#location_'+id+' :selected' ).val();
		var barcode_number=$('#bar_code_number').val();
		if($.trim(selected_barcode)!=''){
			for(var i=0;i<barcode_number;i++){
				if(i!=id){
					if(($.trim($('#barcode_'+i).val())==$.trim(selected_barcode)) && ($('#location_'+i+':visible').val() == selected_barcode_location)){
						alert("Duplicate Barcode");
						$('#barcode_'+id).val('');
						ajax_check_required=false;
						
					}
				}	
			}
			if(ajax_check_required===true){
				$("#page-loader").show();
				$.ajax({
					type: "POST",
					url:barcode_url,
					dataType: "text",
					data: {
						new_barcode: selected_barcode,
						new_barcode_location: selected_barcode_location
					},
					success: function(result) {
						if(result==1){
							$("#page-loader").hide();
							alert(" Barcode already exists for this location");
							$('#barcode_'+id).val('');
						}
						$("#page-loader").hide();
			     	},
			     	complete :function(){
			     		$("#page-loader").hide();
			     	},
					failure : function(){
						alert("failed");
						$("#page-loader").hide();
					},
					error : function(e){
						alert("error");
						$("#page-loader").hide();
					}
				});
			}
		}
	}