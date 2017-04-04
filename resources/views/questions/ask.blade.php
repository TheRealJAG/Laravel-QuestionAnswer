@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                        <div id="questions">
                            <legend class="text-left">
                                <h1>Ask a question...</h1>
                            </legend>
                        </div>


                            @if( !Auth::check() )
                                <p>You must be registered and logged in to ask a question. <a href="/register">Register Here</a></p>
                            @else
                                {{ Form::open( array('url'=>'question','class' =>'form-horizontal') ) }}
                                {{ Form::token() }}
                                <div class="form-group">
                                    <div class="col-md-10">
                                        {!! Form::text('question', null, [
                                            'class'                         => 'form-control',
                                            'placeholder'                   => 'Should be in the form of an interview question...',
                                            'required'
                                        ]) !!}
                                    </div>

                                    <div class="col-md-2">
                                        {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="tab-pane" id="TabCareerInfo" name="Career History">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="txtTags">Skill Level</label><br>
                                                    {{ Form::select('level', ['Beginner' => 'Beginner', 'Intermediate' => 'Intermediate', 'Advanced' =>'Advanced']) }}<br><br>
                                                </div>
                                                <div class="col-md-9">
                                                    <label for="txtTags">Tags Available</label>
                                                        @if ( !$tags->isEmpty() )
                                                            @foreach( $tags as $tag )
                                                            <small><a href="/tag/{{ $tag->name }}">{{ $tag->name }}</a>,</small>
                                                            @endforeach
                                                        @endif
                                                    </small>

                                                    {!! Form::text('tags', null, [
                                                        'class'                         => 'form-control',
                                                        'id'                   => 'txtTags',
                                                        'name'                   => 'tags',
                                                        'data-role'                   => 'tagsinput',
                                                        'placeholder'                   => 'Add Tag',
                                                        'required'
                                                    ]) !!}

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ Form::close() }}
                            @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('modals.login')