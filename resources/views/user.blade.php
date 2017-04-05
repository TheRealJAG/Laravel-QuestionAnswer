@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if (Auth::id())
                            <ul class="sidebar-nav sidebar-divider">
                                <li><a href="/user/{{Auth::id()}}/questions" title="My Questions"><i class="fa fa-lightbulb-o" style="color: #4285F4;"></i> <strong>My Questions</strong></a></li>
                                <li><a href="/user/{{Auth::id()}}/answers" title="My Answers"><i class="fa fa-bullhorn" style="color: #4285F4;"></i> <strong>My Answers</strong></a></li>
                                <li><a href="/user/{{Auth::id()}}/participation" title="My Participation"><i class="fa fa-share-alt" style="color: #4285F4;"></i> <strong>My Participation</strong></a></li>
                            </ul>
                        @endif

                        <ul class="sidebar-nav sidebar-divider">
                            <li>
                                <a href="/questions/top"><i class="fa fa-fire" style="color: #4285F4;"></i> <strong>Top Questions</strong></a>
                            </li>
                            <li>
                                <a href="/questions/new"><i class="fa fa-lightbulb-o" style="color: #4285F4;"></i> <strong>New Questions</strong></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <h1>{{ $user->name }}</h1>

                        @if ( $questions->isEmpty() )
                            <p> This user has not asked any questions yet.</p>
                        @else

                            <div id="questions">
                                <legend class="text-left">Recent Questions</legend>
                            </div>

                            <ul style="list-style-type: none; padding-left:0px;">
                                @foreach( $questions as $question )
                                    <li>
                                        <div class="row panel">
                                            <div class="col-md-1">
                                                @if (count($question->answers) == 0)
                                                    <button type="button" class="btn btn-danger btn-xs">unanswered</button>
                                                @endif
                                            </div>
                                            <div class="col-md-11">
                                                <div class="header">
                                                    <h4 style="margin: 0;display: inline;"><a href="/question/{{$question->id}}/{{ \App\Question::get_url($question->question) }}" title="{{ e($question->question) }}">{{ e($question->question) }}</a></h4> <small>{{count($question->answers)}} Answers | {{ e($question->created_at->diffForHumans()) }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        @if ( $answers->isEmpty() )
                            <p> This user has not asked any questions yet.</p>
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
                                                    <h4 style="margin: 0;display: inline;"><a href="/question/{{$question->id}}/{{ \App\Question::get_url($question->question) }}" title="{{ e($question->question) }}">{{ ucfirst($answer->question->question) }}</a></h4> <small>{{ e($answer->created_at->diffForHumans()) }}</small>
                                                    <p>{{ e($answer->answer) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
