@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if ( $questions->isEmpty() )
                            This user has not participated yet.
                        @else
                            <div id="answers">
                                <legend class="text-left"><h1>{{ $user->name }} Participation</h1></legend>
                            </div>
                            <ul style="list-style-type: none; padding-left:10px;">
                                @foreach( $questions as $question )
                                    <li>@include('containers.question')</li>
                                @endforeach
                            </ul>
                            {{ $questions->links() }}
                            {{ $questions->total() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection