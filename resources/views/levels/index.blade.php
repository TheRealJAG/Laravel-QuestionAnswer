@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="hidden-xs hidden-sm col-md-3">
            @include('containers.tags')
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="questions">
                                <legend class="text-left">Recent Questions</legend>
                            </div>

                            @if ( $questions->isEmpty() )
                                <p>No questions for this level.</p>
                            @else
                                @foreach( $questions as $question )
                                    @include('containers.question')
                                    <hr>
                                @endforeach
                            @endif

                            {{ $questions->links() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection