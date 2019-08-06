function showContent(id) {
    console.log(id);
    jQuery('.tab-content').hide();
    jQuery('#'+id).show('slow');



}