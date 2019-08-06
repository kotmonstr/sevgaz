function showContent(id) {

    if (jQuery('#tab-'+ id).hasClass('active')){
        jQuery('#'+ id).css('display','none');
        jQuery('#tab-'+ id).removeClass('active');
    }else{

        jQuery('.tab-content').hide();
        jQuery('li').removeClass('active');

        jQuery('#'+id).show('slow');
        jQuery('#tab-' + id).addClass('active');
    }
}