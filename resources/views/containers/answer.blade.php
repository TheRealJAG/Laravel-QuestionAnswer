<!-- Answer Container-->
    <div class="row">
        <div class="col-xs-2 col-md-1">
            {{ Form::open(['url' => 'vote', 'class' => 'vote']) }}
            {{ Form::token() }}
            <div class="upvote vote_answer" data-answer="{{$answer->id}}" data-uid="{{Auth::id()}}">
                <a id="a-upvote"  class="upvote vote {{ $answer->user_id == Auth::id() ? 'vote_disabled' : '' }} {{ $answer->votes && $answer->votes->contains('user_id', Auth::id()) ? ($answer->votes->where('user_id', Auth::id())->first()->vote == 1 ? 'upvote-on' : null) : null}}" data-vote="1"></a>
                <span class="count" id="a-{{$answer->id}}">{{ $answer->votes->sum('vote') }}</span>
                <a id="a-downvote" class="downvote vote {{ $answer->user_id == Auth::id() ? 'vote_disabled' : '' }} {{ $answer->votes && $answer->votes->contains('user_id', Auth::id()) ? ($answer->votes->where('user_id', Auth::id())->first()->vote <= 0 ? 'downvote-on' : null) : null}}" data-vote="-1"></a>
            </div>
            {{ Form::close() }}
        </div>

        <div class="col-xs-10 col-md-11">

            @if (isset(Auth::user()->id) && $answer->user->id == Auth::user()->id)
                <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
                <div data-type="textarea" data-pk="{{ $answer->id }}" class="answer editable editable-click editable-open editable-custom"  data-title="EDIT"><h4 style="margin: 0;display: inline;">{{ e($answer->answer) }}</h4></div>
            @else
                <h4 style="margin: 0;display: inline;word-wrap:break-word;">{{ $answer->answer }}</h4>
            @endif

            @if ($answer->created_at != $answer->updated_at)
                <P class="text-right" style="margin-top: 10px"><strong><small><a href="/user/{{$answer->user->id}}" title="{{ $answer->user->name }}">{{ ucfirst($answer->user->name) }}</a> | edited {{ e($answer->updated_at->diffForHumans()) }}</small></strong></P>
            @else
                <P class="text-right" style="margin-top: 10px"><strong><small><a href="/user/{{$answer->user->id}}" title="{{ $answer->user->name }}">{{ ucfirst($answer->user->name) }}</a> | {{ e($answer->created_at->diffForHumans()) }}</small></strong></P>
            @endif

        </div>
    </div>
<br><!-- todo remove br and use css for exact positioning -->
<!-- End Answer Container-->
