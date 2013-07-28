(function($) {
    
    $.fn.extend({
      opd_product_autocomplete: function(data, target1,target2,target3,target4) {
	  this.autocomplete(data, {
	    minChars: 0, max: 12, autoFill: true, mustMatch: true,
	    matchContains: true, scrollHeight: 220,

	    formatItem: function(item) {
	      return item.name;
	    }
	  }).result(function(event, item) {
		  if(item != null || item != undefined){
		    $('#' + target1).val(item.id);
		    $('#' + target2).val(item.rate);
		    if(item.order_type=="READY"){
		    	$('#' + target3).attr("checked", true);
		    }else{
		    	$('#' + target3).attr("checked", false);
		    }
		    if(item.quantity != null || item.quantity != undefined){
		    	$('#' + target4).html(item.quantity);
		    }
		  }
	  });
	}
      });
  })(jQuery);
