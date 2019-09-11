<table>
    <thead>
        <tr>
            <th><b>MSF Code</b></th>
            <th><b>Description</b></th>
            <th></th>
            <th><b>Availabilty Supplier</b></th>
            <th><b>Delivery to KSU</b></th>
            <th><b>Specifications</b></th>
            <th><b>Weight</b></th>
            <th><b>Volume</b></th>
            <th><b>Packaging</b></th>
            <th><b>SUD</b></th>
            <th><b>Quantity</b></th>
            <th><b>Unit price excl. VAT</b></th>
            <th><b>Price excl. VAT</b></th>
            <th><b>VAT</b></th>
            <th><b>Price incl. VAT</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td></td>
                <td></td>
                <td>{{$item->attributes->lead_time}}</td>
                <td>{{$item->attributes->comment}}</td>
                <td>{{$item->attributes->weight}}</td>
                <td>{{$item->attributes->volume}}</td>
                <td>{{$item->attributes->unit}}</td>
                <td>{{$item->attributes->sud}}</td>
                <td>{{$item->quantity}}</td>
                <td>{{$item->price}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>