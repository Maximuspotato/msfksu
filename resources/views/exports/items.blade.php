<table>
    <thead>
    <tr>
        <th style="background:#ffcc99">Product Code</th>
        <th style="background:#ffcc99">Product Description</th>
        <th style="background:#ffcc99">Quantity</th>
        <th style="background:#ffcc99">UoM</th>
        <th style="background:#ffcc99">Price</th>
        <th style="background:#ffcc99">Delivery Request Date</th>
        <th style="background:#ffcc99">Currency</th>
        <th style="background:#ffcc99">Comment</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->attributes->unit }}</td>
            @if (session()->get('currency') == 'usd')
                <td>{{number_format(Cart::get($item->id)->getPriceSum()*Session::get('KES_USD'),'2','.','')}}</td>
            @elseif(session()->get('currency') == 'eur')
                <td>{{number_format(Cart::get($item->id)->getPriceSum()*Session::get('KES_EUR'),'2','.','')}}</td>
            @elseif(session()->get('currency') == 'chf')
                <td>{{number_format(Cart::get($item->id)->getPriceSum()*Session::get('KES_EUR'),'2','.','')}}</td>
            @else
                <td>{{Cart::get($item->id)->getPriceSum()}}</td>
            @endif
            <td></td>
            @if (session()->get('currency') == 'usd')
                <td>USD</td>
            @elseif(session()->get('currency') == 'eur')
                <td>EUR</td>
            @elseif(session()->get('currency') == 'chf')
                <td>CHF</td>
            @else
                <td>KSH</td>
            @endif
            <td>{{$item->attributes->comment}}</td>
        </tr>
    @endforeach
    </tbody>
</table>