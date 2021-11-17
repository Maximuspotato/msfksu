<table>
        <thead>
        <tr>
            <th style="background:#eaed37">Article code</th>
            <th style="background:#eaed37">Price</th>
            <th style="background:#eaed37">Valid until</th>
            <th style="background:#eaed37">Unit</th>
            <th style="background:#eaed37">SUD</th>
            <th style="background:#eaed37">Lead Time(days)</th>
            <th style="background:#eaed37">In stock</th>
            <th style="background:#eaed37">Description</th>
            <th style="background:#eaed37">Details</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td>{{ $item->article_code }}</td>
                @if (session()->get('currency') == 'usd')
                    <td>{{number_format($item->price*Session::get('KES_USD'),'2','.','')}}</td>
                @elseif(session()->get('currency') == 'eur')
                    <td>{{number_format($item->price*Session::get('KES_EUR'),'2','.','')}}</td>
                @elseif(session()->get('currency') == 'chf')
                    <td>{{number_format($item->price*Session::get('KES_EUR'),'2','.','')}}</td>
                @else
                    <td>{{$item->price}}</td>
                @endif
                <td>{{ $item->valid }}</td>
                <td>{{ $item->unit }}</td>
                <td>{{ $item->sud }}</td>
                <td>{{$item->lead_time}}</td>
                <td>{{$item->stock}}</td>
                @if (session()->get('language') == 'en')
                    <td>{{$item->desc_eng}}</td>
                @elseif(session()->get('language') == 'fr')
                    @if ($item->desc_fra == '')
                        <td>{{$item->desc_eng}}</td>
                    @else
                        <td>{{$item->desc_fra}}</td>
                    @endif
                @elseif(session()->get('language') == 'es')
                    @if ($item->desc_spa == "")
                        <td>{{$item->desc_eng}}</td>
                    @else
                        <td>{{$item->desc_spa}}</td>
                    @endif
                @elseif(session()->get('language') == '')
                    <td>{{$item->desc_eng}}</td>
                @endif
                <td>{{$item->details}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>