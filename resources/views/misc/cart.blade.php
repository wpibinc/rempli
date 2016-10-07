
@if ($order != null)
    <table class="table table-striped">
    @foreach($order as $item)

        <?php
        $avp = \App\AvProduct::where('id', $item->objectId)->first();
        $p = \App\Product::where('id', $item->objectId)->first();
        ?>
        @if($avp == null)
            <tr>
                <td>{{ $p->price * $item->count }} руб.</td>
                <td><img src="{{ $p->img }}" alt="" width="100px"></td>
                <td>{{ $p->product_name }}</td>
                <td>{{ $item->count }} шт.</td>
                <td>Комментарий:<br> {{$item->comment}}</td>
            </tr>
        @else
                <tr>
                    <td>{{ $item->count }} шт.</td>
                    <td><img src="http://av.ru{{ $avp->image }}" alt="" width="100px"></td>
                    <td>{{ $avp->name }}</td>
                    <td>{{ $avp->price * $item->count }} руб.</td>
                    <td>Комментарий:<br> {{$item->comment}}</td>
                </tr>

        @endif
    @endforeach
    </table>
@endif

