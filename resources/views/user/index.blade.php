@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="questions">
                            <legend class="text-left">
                                <h1>Info</h1>
                            </legend>
                        </div>
                        <ul class="sidebar-nav sidebar-divider">
                            <li><strong>Joined</strong>: {{$user->created_at->diffForHumans()}}</li>
                            <li><strong>Questions</strong>: {{$questions->count()}}</li>
                            <li><strong>Answers</strong>: {{$answers->count()}}</li>
                        </ul>
                    </div>
                </div>

                @include('layouts.sidebar')

            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="questions">
                            <legend class="text-left"><h1>{{ $user->name }}'s Profile</h1></legend>
                        </div>
                            @if ( $questions->isEmpty() )
                                <p> This user has not asked any questions.</p>
                            @else
                                <div id="questions">
                                    <legend class="text-left">Recent Questions </legend>
                                </div>
                                <ul style="list-style-type: none; padding-left:0px;">
                                    @foreach( $questions as $question )
                                        <li> @include('containers.question')
                                            @if($questions->last() != $question)
                                                <hr>
                                            @endif
                                        </li>
                                    @endforeach
                                    <li><a href="/user/{{ $user->id }}/questions">Show All</a></li>
                                </ul>
                            @endif
                            @if ( $answers->isEmpty() )
                                <p> This user has not asked any answers.</p>
                            @else
                                <div id="answers">
                                    <legend class="text-left">Recent Answers</legend>
                                </div>
                                <ul style="list-style-type: none;">
                                    @foreach( $answers as $answer )
                                        <li>
                                            <div class="row panel">
                                                <div class="col-md-12">
                                                    <div class="header">
                                                        <h4 style="margin: 0;display: inline;"><a href="/question/{{$answer->question_id}}/{{ \App\Question::get_url($answer->question->question) }}">{{ ucfirst($answer->question->question) }}</a></h4> <small>{{ e($answer->created_at->diffForHumans()) }}</small>
                                                        <p>{{ e($answer->answer) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                    <li class="pull-right"><a href="/user/{{ $user->id }}/answers">Show All Answers</a></li>
                                </ul>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection