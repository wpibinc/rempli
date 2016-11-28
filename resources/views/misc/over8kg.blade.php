<div class="message"></div>
<input type="hidden" name="haveSubs" value="{{$haveSubs}}">
<input type="hidden" name="mass" value="{{$order->mass}}">
@if($order->invoice)
    <div>
        Счет за превышение веса выставлен.<br>Оплатить до: {{\Carbon\Carbon::parse($order->invoice->last_pay_day)->format('Y-m-d H:i')}}
    </div>
@endif
@if($haveSubs)
    <div class="col-md-12 invoice" style="display: none">
        <input type="button" class="invoice-button" name="invoice-button" value="Выставить счет на 300р">
    </div>
@endif
<script>
    $(document).on('change', 'select[name="status"]', function () {
        if ( $('input[name="haveSubs"]').val() == 1 &&  /*parseInt($('input[name="mass"]').val()) >= 8000 && */$('select[name="status"] option:selected').val() == 'выполнен') {
            $('.invoice').show();
        } else {
            $('.invoice').hide();
        }
    });

    $(document).on('click','.invoice-button',function() {
        $_token = "{!! csrf_token() !!}";
        $.ajax({
            type: "POST",
            url: "/invoice/order",
            data: {
                'user_id':{{$order->user->id}},
                'order_id':{{$order->id}},
                'title':'Превышение веса',
                'price':300,
                '_token':$_token
            },
            success: function(data) {
                var alert_class = '';
                if(!data.status) {
                    alert_class = 'warning';
                } else {
                    $('.invoice').hide();
                    alert_class = 'success';
                }
                $('.message').html(
                        '<div class="alert alert-' + alert_class + ' alert-message">' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '<span aria-hidden="true">×</span>' +
                        '</button>' +
                        data.msg+
                        '</div>'
                );
                return false;
            }
        });
    });
</script>