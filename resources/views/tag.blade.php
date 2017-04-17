@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3 hidden-xs  hidden-sm">
                @include('containers.tags')
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">

                        @if ( $questions->isEmpty() )
                            <p> There are no questions for this tag.</p>
                        @else

                            <div id="questions">
                                <legend class="text-left">
                                    <h1>{{$page_title}}</h1>
                                </legend>
                            </div>

                            <P>
                                <a href="/tag/{{strtolower($tag_info->name)}}" class="btn btn-primary btn-rounded btn-large {{$sort == 'new' ? 'disabled' : ''}}" role="button"><i class="fa fa-angle-right" style="color: white;"></i> <b>New</b></a>
                                <a href="/tag/{{strtolower($tag_info->name)}}/top" class="btn btn-primary btn-rounded btn-large {{$sort == 'top' ? 'disabled' : ''}}" role="button"><i class="fa fa-angle-right" style="color: white;"></i> <b>Top</b></a>
                                <a href="/tag/{{strtolower($tag_info->name)}}/most_answered" class="btn btn-primary btn-rounded btn-large {{$sort == 'top_answered' ? 'disabled' : ''}}" role="button"><i class="fa fa-angle-right" style="color: white;"></i> <b>Most Answered</b></a>
                                <a href="/tag/{{strtolower($tag_info->name)}}/unanswered" class="btn btn-primary btn-rounded btn-large {{$sort == 'not_answered' ? 'disabled' : ''}}" role="button"><i class="fa fa-angle-right" style="color: white;"></i> <b>Unanswered</b></a>
                            </P><br>

                                @foreach( $questions as $question )
                                    @include('containers.question')
                                    <hr>
                                @endforeach

                            {{ $questions->links() }}

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection