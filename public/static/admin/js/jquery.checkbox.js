;(function($){
	$.fn.checkboxClass = function(){
		var checked = function(obj){	
			if(obj.is(':checked')){
				var pid = obj.data('pid');
				if(typeof pid == 'undefined'){
					return false;
				}	
				var thisObj = $("[type='checkbox'][data-id='"+pid+"']");							
				thisObj.attr('checked',true);
				checked(thisObj);				
			}else{
				var id = obj.data('id');
				if(typeof id == 'undefined'){
					return false;
				}
				var thisObj = $("[type='checkbox'][data-pid='"+id+"']");
				thisObj.attr('checked',false);
				checked(thisObj);	
			}
		}		
		$(this).click(function(){
			var obj = $(this);
			checked(obj);
		});
	}
})(jQuery)
