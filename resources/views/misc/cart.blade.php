
@if ($order != null)
    <table class="table table-striped">
    @foreach($order as $item)

        <?php
        $avp = \App\AvProduct::where('id', $item->objectId)->first();
        $lap = \App\LaProduct::where('id', $item->objectId)->first();
        $mep = \App\MeProduct::where('id', $item->objectId)->first();
        $p = \App\Product::where('id', $item->objectId)->first();
        ?>
        @if($p)
            <tr>
                <td>{{ $p->price * $item->count }} руб.</td>
                <td><img src="{{ $p->img }}" alt="" width="100px"></td>
                <td>{{ $p->product_name }}</td>
                <td>{{ $item->count }} шт.</td>
                <td>Комментарий:<br> {{$item->comment}}</td>
            </tr>
        @elseif($avp)
                <tr>
                    <td>{{ $item->count }} шт.</td>
                    <td><img src="http://av.ru{{ $avp->image }}" alt="" width="100px"></td>
                    <td>{{ $avp->name }}</td>
                    <td>{{ $avp->price * $item->count }} руб.</td>
                    <td>Комментарий:<br> {{$item->comment}}</td>
                </tr>
        @elseif($lap)
                <tr>
                    <td>{{ $item->count }} шт.</td>
                    <td><img src="{{ $lap->image }}" alt="" width="100px"></td>
                    <td>{{ $lap->name }}</td>
                    <td>{{ $lap->price * $item->count }} руб.</td>
                    <td>Комментарий:<br> {{$item->comment}}</td>
                </tr>
        @elseif($mep)
                <tr>
                    <td>{{ $item->count }} шт.</td>
                    <td><img src="{{ $mep->image }}" alt="" width="100px"></td>
                    <td>{{ $mep->name }}</td>
                    <td>{{ $mep->price * $item->count }} руб.</td>
                    <td>Комментарий:<br> {{$item->comment}}</td>
                </tr>

        @endif
    @endforeach
    </table>
@endif

