<h3>Hello!</h3>
<br>

<div>
<p>{{$data['fname']}} {{$data['lname']}} ({{Auth::user()->email}}) from {{Auth::user()->OC}} is requesting for a  quotation.</p>
<p>Please see attachment.</p>
    <div>
        <p>
            <b>Additional info: </b>
            <span>
                @if (empty($data['info']))
                    N/A
                @else
                    {{$data['info']}}
                @endif
            </span>
        </p>
    </div>
</div>