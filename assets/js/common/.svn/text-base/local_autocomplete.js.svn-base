(function($) {
    
    $.fn.extend({
      local_autocomplete: function(data, target1,target2,target3,target4,target5,target6,target7) {
	  this.autocomplete(data, {
	    minChars: 0, max: 12, autoFill: true, mustMatch: true,
	    matchContains: true, scrollHeight: 220,

	    formatItem: function(item) {
	      return item.name;
	    }
	  }).result(function(event, item) {
		  if(item != null || item != undefined){
		    $('#' + target1).val(item.id);
		    if(item.rate != null || item.rate != undefined){
		    	$('#' + target2).val(item.rate);
		    }
		    if(item.retail_unit != null || item.retail_unit != undefined){
		    	$('#' + target3).val(item.retail_unit);
		    	$('#' + target3).text(item.retail_unit);
		    }
		    if(item.purchase_unit != null || item.purchase_unit != undefined){
		    	$('#' + target4).text(item.purchase_unit);
		    }
		    if(item.quantity != null || item.quantity != undefined){
		    	$('#' + target5).text(item.quantity);
		    }
		    if(item.mrp != null || item.mrp != undefined){
		    	
		    	$('#' + target6).text(item.mrp);
		    }
		    if(item.order_type=="READY"){
		    	$('#' + target7).attr("checked", true);
		    	$("#opd_visit_id").val("");
		    	$("#opd_visit_id").attr("disabled", true);
		    }else{
		    	$('#' + target7).attr("checked", false);
		    	$("#opd_visit_id").removeAttr("disabled");
		    }
		    
		    
		  }
	  });
	}
      });
  })(jQuery);
