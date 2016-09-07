$(document).on('ready', function(){
    $(".change-user-info").on('click', function(){
        
        var token = $("input[name=_token]").val();
        var email = $(".account .email input").val();
        var phone = $(".account .phone input").val();
        var fname = $(".account .fname input").val();
        var sname = $(".account .sname input").val();
        $.ajax({
            url: '/change-user-info',
            method: 'post',
            data: {
                email: email,
                phone: phone,
                fname: fname,
                sname: sname,
                _token: token,
                action: "changeinfo"
            },
            success: function(res){
                if(res.success){
                    alert('ok');
                    $(".account p.error").text('');
                }else{
                    $(".account p.error").text(res.err);
                }
                
            }
        });
    });
    
    $(".change-password").on('click', function(){
        var res = confirm('Вы уверены?');
        if(!res){
            return;
        }
        var pass = $(".account .password input").val();
        var token = $("input[name=_token]").val();
        $.ajax({
            url: '/change-user-info',
            method: 'post',
            data: {
                pass: pass,
                _token: token,
                action: "changepassword"
            },
            success: function(res){
                if(res.success){
                    $(".account p.error").text('');
                    alert("ok");
                }else{
                    $(".account p.error").text(res.err);
                }
            }
        });
    });
    
    $(".")
    
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
                    var row = "<tr><td>"+street+"</td><td>"+home+"</td><td>"+korp+"</td><td>"+flat+"</td><td><a class='adress-del' href='javascript:void(0)'>Удалить</a></td></tr>";
                    $('.adresses tbody').append(row);
                    $(".adresses .add-form input").val('');
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
    
    $(document).on('click', '.order-get-more', function(){
        var id = $(this).attr('data-id');
        var row = $(this).parents('tr');
        var button = $(this);
        if(button.siblings('.order-details').find('.item').length&&$(this).hasClass('active')){
            button.siblings('.order-details').hide();
            button.removeClass('active');
            button.text('Подробнее');
            return false;
        }else if(button.siblings('.order-details').find('.item').length&&!$(this).hasClass('active')){
            button.siblings('.order-details').show();
            button.addClass('active');
            button.text('Скрыть');
            return true;
        }
        
        $.ajax({
            url: 'get-order-details',
            method: 'get',
            data: {
                id: id
            },
            success: function(res){
                if(res){
                    row.find('.order-details').append(res);
                    button.addClass('active');
                    button.text('Скрыть');
                }
            }
        });
    });
    
});

