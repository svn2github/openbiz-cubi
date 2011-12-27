/* 
 * jQuery - Textbox Hinter plugin v1.0
 * http://www.aakashweb.com/
 * Copyright 2010, Aakash Chakravarthy
 * Released under the MIT License.
 */

(function($j){
	$j.fn.tbHinter = function(options) {

	var defaults = {
		text: 'Enter a text ...'   		
	};
	
	var options = $j.extend(defaults, options);

	return this.each(function(){
	
		$j(this).focus(function(){
			if($j(this).val() == options.text){
				$j(this).val('');
				$j(this).css('font-style','normal');
				$j(this).css('color','#333333');
			}
		});
		
		$j(this).blur(function(){
			if($j(this).val() == ''){
				$j(this).val(options.text);
				$j(this).css('color','#CCCCCC');
				$j(this).css('font-style','italic');
			}
		});
		
		$j(this).blur();
		
	});
};
})(jQuery);