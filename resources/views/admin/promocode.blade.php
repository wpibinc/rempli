
<form name="promocode" method="post" action="{{route('admin.promocodecreate')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="user_id" value="0">
    <input type="hidden" name="auto_subscription" value="1">
    <input type="hidden" name="is_free" value="1">
    <input type="hidden" name="current_quantity">
    <input type="hidden" name="promocode">
    <div class="row">
        <div class="col-md-2">
            <div>Срок действия промо кода: </div>
            <select name="duration" id="month" onchange="" size="1">
                <option value="1">1 Месяц</option>
                <option value="2">2 Месяца</option>
                <option value="3">3 Месяца</option>
                <option value="4">4 Месяца</option>
                <option value="5">5 Месяцев</option>
                <option value="6">6 Месяцев</option>
            </select>
        </div>
        <div class="col-md-2">
            <div>Количество доставок в месяц: </div>
            <input type="number" value="4" min="4" max="28" name="total_quantity">
        </div>
        <div class="col-md-3">
            <a href="#" id="gen">Генерировать промо код: </a>
            <span id="short_link"></span>
        </div>
        <div class="col-md-2">
            <input type="submit" name="save" value="Сохранить">
        </div>
    </div>
</form>
<div class='promoCode wrapper-acaunt'>
    <div class="table-responsive">
        <table class="table" style="margin-top: 20px">
            <tr>
                <th></th>
                <th>Срок действия, мес.</th>
                <th>Количество доставок в месяц, шт.</th>
                <th>Промо-код</th>
            </tr>
            <?php $i = 0; ?>
            @foreach($subscriptions as $subscription)
                <tr>
                    <td><?php echo ++$i ?></td>
                    <td>{{$subscription->duration}}</td>
                    <td>{{$subscription->total_quantity}}</td>
                    <td>{{$subscription->promocode}}</td>
                </tr>
            @endforeach
        </table>
        <div>{{$subscriptions->render() }}</div>
    </div>
</div>
<script>
    $(function() {
        function str_rand() {
            var result       = '';
            var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            var max_position = words.length - 1;
            for( i = 0; i < 1; ++i ) {
                position = Math.floor ( Math.random() * max_position );
                result = result + words.substring(position, position + 1);
            }
            return result;
        }

        $("#gen").click(function() {
            $("#short_link").text(str_rand()+str_rand()+str_rand()+'-'+str_rand()+str_rand()+str_rand()+'-'+str_rand()+str_rand()+str_rand()+'-'+str_rand()+str_rand()+str_rand());
        });
    });
    $(document).on('change', 'input[name="total_quantity"]', function () {
        var total_quantity = $('input[name="total_quantity"]').val();
        $('input[name="current_quantity"]').val(total_quantity);
    });
    $(document).on('click', '#gen', function () {
        var promocode = $('#short_link').text();
        $('input[name="promocode"]').val(promocode);
    });
</script>