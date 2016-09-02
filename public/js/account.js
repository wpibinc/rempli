jQuery(document).on('ready', function($){
    jQuery(".change-user-info").on('click', function(){
        var param = jQuery(this).siblings('input').attr('name');
        var value = jQuery(this).siblings('input').val();
        var token = jQuery("input[name=_token]").val();
        jQuery.ajax({
            url: '/change-user-info',
            method: 'post',
            data: {
                param: param,
                value: value,
                _token: token
            },
            success: function(res){
                alert('ok');
            }
        });
    });
});

