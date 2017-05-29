@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                @if ( $answers->isEmpty() )
                                    This user has not answered any questions yet.
                                @else
                                    <div id="answers">
                                        <legend class="text-left"><h1>{{ $user->name }} Answers</h1></legend>
                                    </div>
                                    <ul style="list-style-type: none;">
                                        @foreach( $answers as $answer )
                                            <li>
                                                <div class="row panel">
                                                    <div class="col-md-12">
                                                        <div class="header">
                                                            <h4 style="margin: 0;display: inline;"><a href="/question/{{$answer->question->id}}/{{ App\Classes\URL::get_slug($answer->question->question) }}" title="{{ e($answer->question->question) }}">{{ ucfirst($answer->question->question) }}</a></h4> <small>{{ e($answer->created_at->diffForHumans()) }}</small>
                                                            <p>{{ e($answer->answer) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    {{ $answers->links() }}
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

