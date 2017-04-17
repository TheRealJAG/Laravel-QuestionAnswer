@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="hidden-xs hidden-sm col-md-3">
            @if (Auth::id())
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
                                <a href="/questions/top" title="Top Questions"><i class="fa fa-fire" style="color: #4285F4;"></i> <strong>Top Questions</strong></a>
                            </li>
                            <li>
                                <a href="/questions/new" title="New Questions"><i class="fa fa-lightbulb-o" style="color: #4285F4;"></i> <strong>New Questions</strong></a>
                            </li>
                        </ul>

                    </div>
                </div>
            @endif
            @include('containers.tags')
        </div>
        <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                            @include('containers.question')
                                <br/>
                            <!-- Show the answer form -->
                                @if ((isset(Auth::user()->id) && Auth::user()->id != $question->user_id) && in_array(Auth::user()->id,$answer_ids) == FALSE)
                                    <id id="post-answer">
                                        @if( isset(Auth::user()->id) && !Auth::check())
                                            <p>Please <a href="/login">login</a> to post an answer for this question</p>
                                        @else
                                            {{ Form::open( array('url'=>'answer','class' =>'form-horizontal') ) }}
                                            {{ Form::token() }}
                                            {{ Form::hidden('question_id',$question->id) }}
                                            {{ Form::hidden('question_url', App\Question::get_url($question->question)) }}

                                            <div class="form-group">
                                                <div class="col-md-10">
                                                    {!! Form::text('answer', null, [
                                                        'class'                         => 'form-control',
                                                        'placeholder'                   => 'Enter an answer here...',
                                                        'required'
                                                    ]) !!}
                                                </div>
                                                <div class="col-md-2">
                                                    {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
                                                </div>
                                            </div>

                                            {{ Form::close() }}
                                        @endif
                                    </id>
                                @endif
                            <!-- END Show the answer form -->
                                @if ( !$answers->isEmpty() )
                                    <div id="answers">
                                        <legend class="text-left">Answers</legend>
                                    </div>
                                    @foreach( $answers as $answer )
                                        @include('containers.answer')
                                    @endforeach
                                @endif
                                <br>
                                @if ( $recent_questions->isEmpty() )
                                    <p>No Relevant Questions</p>
                                @else
                                    <div id="questions">
                                        <legend class="text-left">Relevant Questions</legend>
                                    </div>
                                    @foreach( $recent_questions as $question )
                                        @include('containers.question')
                                        <hr>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection