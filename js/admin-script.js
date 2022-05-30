jQuery( document ).ready(function() {
    jQuery('select#user_status').on('change', function() {
        var status = this.value;
        var uid = jQuery(this).attr('data-uid');
        jQuery.ajax({
            method: 'POST',
            url: ajaxurl,
            data: { action: "change_user_status", status: status, uid: uid},
            dataType: "json",
            async:false,
            success: function (response) {

            }
        });
    });
    jQuery(".fancybox").fancybox();
});