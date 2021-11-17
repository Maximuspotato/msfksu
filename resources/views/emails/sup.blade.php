<h3>Hello!</h3>
<br>

<div>
<p>{{$data['name']}} ({{Auth::user()->email}}) from {{Auth::user()->OC}} is requesting for supply rights.</p>
<p>Position: {{$data['position']}}</p>
<p>Supply related task: {{$data['task']}}</p>
</div>