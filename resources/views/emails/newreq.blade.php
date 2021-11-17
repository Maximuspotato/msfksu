<h3>Hello!</h3>
<br>

<div>
<p>{{$data['surname']}} {{$data['lastname']}} ({{Auth::user()->email}}) from {{Auth::user()->OC}} requested below quotation.</p>
    <div>
        <p>
            <b>Unidata code: </b>
            <span>
                @if (empty($data['article_code']))
                    N/A
                @else
                    {{$data['article_code']}}
                @endif
            </span>
        </p>
        <p>
            <b>Description: </b>
            <span>
                {{$data['description']}}
            </span>
        </p>
        <p>
            <b>Quantity: </b>
            <span>
                {{$data['quantity']}}
            </span>
        </p>
        <p>
            <b>Indicative budget: </b>
            <span>
                {{$data['budget']}}
            </span>
        </p>
        <p>
            <b>Expeted delivery date: </b>
            <span>
                @if (empty($data['ddate']))
                    N/A
                @else
                    {{$data['ddate']}}
                @endif
            </span>
        </p>
        <p>
            <b>Preferred transport mode: </b>
            <span>
                @if (empty($data['transport']))
                    N/A
                @else
                    {{$data['transport']}}
                @endif
            </span>
        </p>
        <p>
            <b>Brand: </b>
            <span>
                @if (empty($data['brand']))
                    N/A
                @else
                    {{$data['brand']}}
                @endif
            </span>
        </p>
        <p>
            <b>Specifications: </b>
            <span>
                @if (empty($data['specifications']))
                    N/A
                @else
                    {{$data['specifications']}}
                @endif
            </span>
        </p>
        <p>
            <b>Website link: </b>
            <span>
                @if (empty($data['website']))
                    N/A
                @else
                    <a href="{{$data['website']}}">Link</a>
                @endif
            </span>
        </p>
    </div>
</div>