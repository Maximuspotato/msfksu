<table>
    <thead>
    <tr>
        <th style="background:#eaed37">Article code</th>
        <th style="background:#eaed37">Description</th>
        <th style="background:#eaed37">Purchase Price</th>
        <th style="background:#eaed37">Currency</th>
        <th style="background:#eaed37">Quantity</th>
        <th style="background:#eaed37">Batch</th>
        <th style="background:#eaed37">Expiry</th>
        <th style="background:#eaed37">Stock Owner</th>
        <th style="background:#eaed37">Comments</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{ $item->article_code }}</td>
            <td>{{$item->desc_eng}}</td>
            <td>{{ $item->purchase_price }}</td>
            <td>{{ $item->currency }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{$item->batch}}</td>
            <td>{{$item->expiry_date}}</td>
            <td>{{$item->stock_owner}}</td>
            <td>{{$item->comments}}</td>
        </tr>
    @endforeach
    </tbody>
</table>