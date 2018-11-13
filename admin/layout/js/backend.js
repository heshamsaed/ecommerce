$(function (){
    
   'use strict';
    //Hide PlaceGolder on focus
    $('[placeholder]').focus(function (){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function (){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });
    
    //Add Asterisk on Required field
    $('input').each(function(){
       if($(this).attr('required') === 'required'){
           $(this).after('<span class="asterisk">*</span>');
        }
    });
    //validattion form
    
    $.validate({
    lang: 'en'
  });
    //show password
    
    var pass = $('.password');
    
    $('.showpass').hover(function (){
        
        pass.attr('type','text');
        
    }, function (){
        pass.attr('type','password');
    });



    $('.confirm').click(function (){
       return confirm('Are You Sure?');
    });

});



/*$("form").validate({
       
       errorClass: "my-error-class",

       validClass: "my-valid-class"
       
   });*/