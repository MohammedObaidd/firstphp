$(function(){


	// 'use strict';

	///form Login/////
	$('[placeholder]').focus(function(){

			$(this).attr('data-text',$(this).attr('placeholder'));
			$(this).attr('placeholder','');
 
	}).blur(function(){

		
	$(this).attr('placeholder',$(this).attr('data-text'));
	});



	$('input').each(function(){
		if($(this).attr('required')==='required')
		{
			$(this).after('<span class="asterisk">*</span>');
		}
	});
});