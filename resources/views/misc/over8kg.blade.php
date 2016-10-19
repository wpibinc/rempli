<div class="message"></div>
<input type="hidden" name="haveSubs" value="{{$haveSubs}}">
<input type="hidden" name="mass" value="{{$order->mass}}">
{{--<label>Статус</label>
<div class="col-md-12">
    <select name="status">
        <option @if($order->status && $order->status == 'новый'){{ 'selected' }}@endif value="новый">Новый</option>
        <option @if($order->status && $order->status == 'в работе'){{ 'selected' }}@endif value="в работе">В работе</option>
        <option @if($order->status && $order->status == 'выполнен'){{ 'selected' }}@endif value="выполнен">Выполнен</option>
        <option @if($order->status && $order->status == 'отменен'){{ 'selected' }}@endif value="отменен">Отменен</option>
    </select>
</div>--}}
@if($haveSubs)
    <div class="col-md-12 invoice" style="display: none">
        <input type="button" class="invoice-button" name="invoice-button" value="Выставить счет на 300р">
    </div>
@endif
<script>
    $(document).on('change', 'select[name="status"]', function () {
        if ( $('input[name="haveSubs"]').val() == 1 &&  parseInt($('input[name="mass"]').val()) >= 8000 && $('select[name="status"] option:selected').val() == 'выполнен') {
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
                '_token':$_token
            },
            success: function(data) {
                var alert_class = '';
                if(!data.status) {
                    alert_class = 'warning';
                } else {
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