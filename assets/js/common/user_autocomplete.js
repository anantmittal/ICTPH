(function($) 
{
    
	$.fn.extend(
	{
		user_autocomplete: function(data, target1) 
		{
			this.autocomplete(data,
			{
				minChars: 0, max: 50, autoFill: false, mustMatch: false,
		   		matchContains: true, scrollHeight: 220, scroll: true,
				formatItem: function(item) 
				{
		     			return item.name;
		   		}
		  	}).result(function(event, item) 
		  	{
				if(item != null || item != undefined)
				{
			 		$('#' + target1).val(item.id);
				}
		 	});
		},
		search: function(handler) 
		{
			return this.trigger("search", [handler]);
		}
		
    	});
})(jQuery);
