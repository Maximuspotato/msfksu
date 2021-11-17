@extends('layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Add Story</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="section">
        <div class="container">
            <form action="{{URL('upload-story')}}" method="POST">
                @csrf
                <textarea id="article-ckeditor" name="story" rows="10" maxlength="1000" style="width: 100%;" required>
                    @if (count($stories) > 0)
                        @foreach ($stories as $story)
                            {{$story->details}}
                        @endforeach
                    @endif
                </textarea><br>
                <input type="hidden" class="form-control" name="date" placeholder="Date" value="25/05/94" required><br>
                <input type="hidden" class="form-control" name="time" placeholder="Time" value="0000 hrs" required><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
@endsection