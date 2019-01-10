$(function () {

	'use strict';
    
    // switch between login and signup
    
    $('.login-page h1 span').click(function () {
        $(this).addClass('selected').siblings().removeClass('selected');
        $('.login-page form').hide();
        $('.'+ $(this).data('class')).fadeIn();
    });

    

	//hide placeholder on form focus

	$('[placeholder]').focus(function () {
		$(this).attr('data-text', $(this).attr('placeholder')); //get placeholder value to data-text
		$(this).attr('placeholder', '');
	}).blur(function () {
		$(this).attr('placeholder', $(this).attr('data-text'));
	});


	// add asterisk to required inputs
	$('input').each(function () {
		if ($(this).attr('required') === 'required') {
            $(this).after("<span class='asterisk'>*<span>");
        }

	});
    
    
    

    //confirmation messege on Button
    $('.confirm').click(function () {
        return confirm('Are You Sure?');

    });
    
    //live-preview in new ad page
    $('.live').keyup(function () {
        $($(this).data('class')).text($(this).val());
    });
    /*$('.live-name').keyup(function () {
        $('.live-preview .caption h3').text('$'+$(this).val());
    });
    $('.live-desc').keyup(function () {
        $('.live-preview .caption p').text($(this).val());
    });
    $('.live-price').keyup(function () {
        $('.live-preview span').text($(this).val());
    });*/
    
    
    
  
});