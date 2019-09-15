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
            <td>{{number_format(Cart::get($item->id)->getPriceSum()*Session::get('KES_EUR'),'2','.','')}}</td>
            <td></td>
            <td>EUR</td>
            <td>{{$item->attributes->comment}}</td>
        </tr>
    @endforeach
    </tbody>
</table>