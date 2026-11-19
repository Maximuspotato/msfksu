@extends('layouts.app')

@section('content')
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Warehouse picking</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('warehouse-picking.generate') }}">
                        @csrf
                        <div class="form-group">
                            <label for="target_doc_no">Document number</label>
                            <input
                                class="form-control"
                                id="target_doc_no"
                                name="target_doc_no"
                                type="text"
                                value="{{ old('target_doc_no') }}"
                                maxlength="100"
                                required
                                autofocus
                            >
                        </div>
                        <button class="btn btn-primary" type="submit">Generate picking workbook</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
