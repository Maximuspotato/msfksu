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
                <textarea id="article-ckeditor" name="story" rows="10" maxlength="1000" style="width: 100%;" required></textarea><br>
                <input type="text" class="form-control" name="date" placeholder="Date" value="" required><br>
                <input type="text" class="form-control" name="time" placeholder="Time" value="" required><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
@endsection