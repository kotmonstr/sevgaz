function showContent(id) {
    //console.log(id);
    //console.log(this);

    jQuery('.tab-content').hide();
    jQuery('#'+id).show('slow');

    jQuery('li').removeClass('active');
    jQuery('#tab-' + id).addClass('active');



}