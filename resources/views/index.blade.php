@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            @if ( Auth::guest() AND !app('request')->input('page') )
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div id="questions">
                                    <legend class="text-left">Interview Knowledge Base</legend>
                                </div>
                                <P>Interviewing in the tech industry can be very challenging especially when it comes to programming. Improving your interviewing communication skills can land you a higher paying job with a better company.</P>
                                <P>This site was created to improve your interviewing knowledge based upon your programming skills.</P>
                                <P>This site will help you demonstrate basic and advanced knowledge in your skillset.</P>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @if (!empty($top))
                                <legend class="text-left">
                                    <h1>Top Questions</h1>
                                </legend>
                                @foreach( $top as $question )
                                    @include('containers.question_novote')
                                    @if($top->last() != $question)
                                        <hr>
                                    @endif
                                @endforeach
                                <br>
                            @endif

                            <legend class="text-left">
                                <h1>Recent Questions</h1>
                            </legend>
                            @foreach( $questions as $question )
                                @include('containers.question')
                                @if($questions->last() != $question)
                                    <hr>
                                @endif
                            @endforeach
                            {{ $questions->links() }}
                        </div>
                    </div>
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