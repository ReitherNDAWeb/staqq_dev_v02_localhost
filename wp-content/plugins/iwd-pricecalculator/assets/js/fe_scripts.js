/** */


if(jQuery('#iwd-calculator-form').length > 0 ) {
    jQuery(document).on('submit', '#iwd-calculator-form', function(event){
        event.preventDefault();         
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php', 
            type: 'post', 
            dataType: 'JSON', 
            data: jQuery('#iwd-calculator-form').serialize()
        }).done(function(data){    
            if(data.success == true && typeof data.html != 'undefined') {
                jQuery('#iwd-ajax-container').html(data.html); 
            }
        });  
    });
    
    jQuery(document).on('submit', '#iwd-calculator-contact-form', function(event){
        event.preventDefault();         
        jQuery.ajax({
            url: '/wp-admin/admin-ajax.php', 
            type: 'post', 
            dataType: 'JSON', 
            data: jQuery('#iwd-calculator-contact-form').serialize()
        }).done(function(data){    
            if(data.success == true && typeof data.html != 'undefined') {
                jQuery('#iwd-calculator').html(data.html); 
            }
        });  
    });
}