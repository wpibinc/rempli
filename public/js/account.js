$(document).on('ready', function(){
    $(".change-user-info").on('click', function(){
        var param = jQuery(this).siblings('input').attr('name');
        var value = jQuery(this).siblings('input').val();
        var token = jQuery("input[name=_token]").val();
        $.ajax({
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
    
    $(".add-adress").on('click', function(){
        var street = $('#street-input').val();
        var home = $('#house').val();
        var korp = $('#korp').val();
        var flat = $('#flat').val();
        var token = $("input[name=_token]").val();
        $.ajax({
            url: '/add-adress',
            method: 'post',
            dataType: 'json',
            data:{
                _token: token,
                street: street,
                home: home,
                korp: korp,
                flat: flat,
            },
            success: function(res){
                if(res.success){
                    var row = "<tr><td>"+street+"</td><td>"+home+"</td><td>"+korp+"</td><td>"+flat+"</td><td><a class='adress-del' href='javascruipt:void(0)'>Удалить</a></td></tr>";
                    $('.adresses tbody').append(row);
                }
            }
        });
    });
    
    $(document).on('click', '.adress-del', function(){
        var id = $(this).attr('data-id');
        var row = $(this).parents("tr");
        var token = $("input[name=_token]").val();
        $.ajax({
            url: '/delete-adress',
            method: 'post',
            dataType: 'json',
            data:{
                _token: token,
                id: id
            },
            success: function(res){
                if(res.success){
                    row.remove();
                }
            }
        });
        
    });
    
});

