@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @if ( $questions->isEmpty() )
                                    {{ $user->name }} hasn't asked any questions yet. :(
                                @else
                                    <div id="questions">
                                        <legend class="text-left">
                                            <h1>{{ $user->name }} Questions</h1>
                                        </legend>
                                    </div>
                                    @foreach( $questions as $question )
                                        @include('containers.question')
                                        @if($questions->last() != $question)
                                            <hr>
                                        @endif
                                    @endforeach
                                    {{ $questions->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-pull-9">
                @include('layouts.sidebar_auth')
                @include('layouts.sidebar')
            </div>
        </div>
    </div>
@endsection