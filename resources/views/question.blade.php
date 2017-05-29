@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3">
                <div class="panel panel-default">

                    @if (Session::has('flash_message'))
                        <div class="alert alert-success">{!!Session::get('flash_message')!!}</div>
                    @endif

                    <div class="panel-body">
                        @include('containers.question_nolink')
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
                                    {{ Form::hidden('question_url', App\Classes\URL::get_slug($question->question)) }}

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
                                <legend class="text-left" style="font-size: 24px;">Relevant Questions</legend>
                            </div>
                            @foreach( $recent_questions as $question )
                                @include('containers.question_novote')
                                @if($recent_questions->last() != $question)
                                    <hr>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-pull-9">
                @include('layouts.sidebar_auth')
                @include('containers.tags')
                @include('layouts.sidebar')
            </div>
        </div>
    </div>
@endsection