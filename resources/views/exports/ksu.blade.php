<table>
    <thead>
    <tr>
        <th style="background:#ffcc99">Product Code</th>
        <th style="background:#ffcc99">Product Description</th>
        <th style="background:#ffcc99">UoM</th>
        <th style="background:#ffcc99">Min Qty</th>
        <th style="background:#ffcc99">Unit Price</th>
        <th style="background:#ffcc99">Rounding</th>
        <th style="background:#ffcc99">Min order quantity</th>
        <th style="background:#ffcc99">Comment</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{ $item->article_code }}</td>
            <td>{{ $item->desc_eng }}</td>
            <td>{{ $item->unit }}</td>
            <td>1</td>
            <td>{{$item->price}}</td>
            <td>1</td>
            <td>1</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>