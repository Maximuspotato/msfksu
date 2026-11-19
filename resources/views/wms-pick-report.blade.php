@extends('layouts.app')

@section('content')
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>WMS Picking Details Report</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <p>
                <a class="btn btn-primary" href="{{ url()->current() }}?export=xlsx">Export to Excel</a>
            </p>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            @foreach ($columns as $column)
                                <th>{{ $column }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            <tr>
                                @foreach ($columns as $column)
                                    <td>
                                        @if ($column === 'Workbook file')
                                            <a href="{{ asset('storage/'.$row[$column]) }}" target="_blank" rel="noopener">{{ $row[$column] }}</a>
                                        @else
                                            {{ $row[$column] }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ count($columns) }}">No picking workbook details found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
