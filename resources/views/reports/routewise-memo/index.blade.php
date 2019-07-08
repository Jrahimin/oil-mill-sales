@extends('layouts.app_v2')

@section('content')
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-info">
            <div class="panel-heading">

            </div>
            <div class="panel-body">
                <form class="form-inline" action="{{ route('route_memo') }}">
                    <div class="form-group">
                        <label for="route_id">Routes</label>
                        <select class="form-control" name="route_id">
                            <option value="">-- Select Route --</option>
                            @foreach($routes as $index=>$route)
                                <option value="{{ $index }}">{{ $route }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_from">From:</label>
                        <input type="date" class="form-control" name="date_from">
                    </div>
                    <div class="form-group">
                        <label for="date_to">To:</label>
                        <input type="date" class="form-control" name="date_to">
                    </div>

                    <button type="submit" class="btn btn-info">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
