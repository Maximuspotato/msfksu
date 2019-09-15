<div style="font-family: Arial, Helvetica, sans-serif;">
<div>
    <table style="width:100%; table-layout:fixed;">
        <tbody>
            <tr>
                <td style="width:30%"><img src="{{public_path()}}/assets/img/logo.png" alt=""></td>
                <td style="width:60%;"><h1>INTERNAL REQUEST</h1></td>
                <td><b>NR.:</b></td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div><br>
<div>
<table style="width:100% table-layout:fixed;">
    <tbody>
        <tr>
            <td style="width:20%"><b>DATE:</b></td>
            <td style="width:40%; word-wrap:break-word">{{$info['date']}}</td>
            <td style="width:20%"><b>DESTINATION:</b></td>
            <td style="word-wrap:break-word">{{$info['destination']}}</td>
        </tr>
        <tr>
            <td style="width:20%"><b>REQUESTED BY:</b></td>
            <td style="width:40%; word-wrap:break-word">{{$info['name']}} {{$info['position']}}</td>
            <td style="width:20%"><b>DELIVER TO:</b></td>
            <td style="word-wrap:break-word">{{$info['delivery']}}</td>
        </tr>
        <tr>
            <td style="width:20%"><b>PURPOSE:</b></td>
            <td style="width:40%; word-wrap:break-word">{{$info['purpose']}}</td>
            <td style="width:20%"><b>DELIVER BEFORE:</b></td>
            <td style="word-wrap:break-word">{{$info['rdd']}}</td>
        </tr>
    </tbody>
</table>
</div><br>
<div>
    <table style="width:100% table-layout:fixed; border-collapse: collapse;">
        <td style="width:64.45%;"></td>
        <td style="width:15%; border:0.5px solid black; text-align:center">Quantity</td>
        <td style=""></td>
    </table>
</div>
<div>
<table style="width:100% table-layout:fixed; border-collapse: collapse;">
    <tr>
        <td style="width:2%; border:0.5px solid black"><b>Item</b></td>
        <td style="width:12%; border:0.5px solid black;"><b>Item code</b></td>
        <td style="width:27%; border:0.5px solid black"><b>Description</b></td>
        <td style="width:17%; border:0.5px solid black"><b>Picture</b></td>
        <td style="width:5%; border:0.5px solid black"><b>QTY</b></td>
        <td style="width:5%; border:0.5px solid black; font-size:12px">Stock</td>
        <td style="width:5%; border:0.5px solid black; font-size:12px">Local purchase</td>
        <td style="width:5%; border:0.5px solid black; font-size:12px">Order</td>
        <td style="border:0.5px solid black"><b>Remarks</b></td>
    </tr>
    @php
        $i = 1;
    @endphp
    @foreach ($items as $item)
        <tr>
            <td style="border:0.5px solid black; word-wrap:break-word">{{$i++}}</td>
            <td style="border:0.5px solid black; word-wrap:break-word">{{$item->id}}</td>
            <td style="border:0.5px solid black; word-wrap:break-word">{{$item->name}}</td>
            <td style="border:0.5px solid black;">
                @if ($info['pic'] == "on")
                    @if ($item->attributes->pic != "https://res.cloudinary.com/ksucatalog/image/upload/v1565681241/media/camp_gzviph.png")
                        <img src="{{$item->attributes->pic}}" alt="" height="80">
                    @endif
                @endif
            </td>
            <td style="border:0.5px solid black; word-wrap:break-word">{{$item->quantity}}</td>
            <td style="border:0.5px solid black;"></td>
            <td style="border:0.5px solid black;"></td>
            <td style="border:0.5px solid black;"></td>
            <td style="border:0.5px solid black; word-wrap:break-word">{{$item->comment}}</td>
        </tr>
    @endforeach
</table>
</div><br>
<div>
    <table style="width:100% table-layout:fixed; border-collapse: collapse;">
        <tr>
            <td style="width:10%"></td>
            <td style="width:18%; border:0.5px solid black">Requestor</td>
            <td style="width:18%; border:0.5px solid black">Budget holder</td>
            <td style="width:18%; border:0.5px solid black">Supply</td>
            <td style="width:18%; border:0.5px solid black">Storekeeper</td>
            <td style="width:18%; border:0.5px solid black">Receiver</td>
        </tr>
        <tr>
            <td>Name</td>
            <td style="border:0.5px solid black; word-wrap:break-word">{{$info['name']}}</td>
            <td style="border:0.5px solid black"></td>
            <td style="border:0.5px solid black"></td>
            <td style="border:0.5px solid black"></td>
            <td style="border:0.5px solid black"></td>
        </tr>
        <tr>
            <td>Signature</td>
            <td style="border:0.5px solid black;"></td>
            <td style="border:0.5px solid black"></td>
            <td style="border:0.5px solid black"></td>
            <td style="border:0.5px solid black"></td>
            <td style="border:0.5px solid black"></td>
        </tr>
        <tr>
            <td>Date</td>
            <td style="border:0.5px solid black; word-wrap:break-word">{{$info['date']}}</td>
            <td style="border:0.5px solid black"></td>
            <td style="border:0.5px solid black"></td>
            <td style="border:0.5px solid black"></td>
            <td style="border:0.5px solid black"></td>
        </tr>
    </table>
</div>
</div>