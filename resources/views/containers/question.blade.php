<!-- Question Container-->
    <div class="row">
        <div class="col-xs-2 col-md-1">
            {{ Form::open(['url' => 'vote', 'class' => 'vote']) }}
            {{ Form::token() }}
            <div class="upvote vote_question" data-question="{{$question->id}}" data-uid="{{Auth::id()}}">
                <a id="q-upvote" class="upvote vote_q {{ $question->user_id == Auth::id() ? 'vote_disabled' : '' }} {{ $question->votes && $question->votes->contains('user_id', Auth::id()) ? ($question->votes->where('user_id', Auth::id())->first()->vote == 1 ? 'upvote-on' : null) : null}}" data-vote="1"></a>
                <span class="count" id="q-{{$question->id}}">{{ $question->votes->sum('vote') }}</span>
                <a id="q-downvote" class="downvote vote_q {{ $question->user_id == Auth::id() ? 'vote_disabled' : '' }}  {{ $question->votes && $question->votes->contains('user_id', Auth::id()) ? ($question->votes->where('user_id', Auth::id())->first()->vote <= 0 ? 'downvote-on' : null) : null}}" data-vote="-1"></a>
            </div>
            {{ Form::close() }}
        </div>
        <div class="col-xs-10 col-md-11">
            <h3 style="color: #2a88bd;font-weight: bolder;margin-top: 0"><a href="/question/{{$question->id}}/{{ \App\Question::get_url($question->question) }}" title="{{ e($question->question) }}">{{ e($question->question) }}</a></h3>

            @if ( !$question->tags->isEmpty() )
                @foreach( $question->tags as $tag )
                    <a href="/tag/{{ strtolower($tag->name) }}" title="{{ $tag->name }} Interview Questions"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-hashtag" style="color: white;"></i> {{ $tag->name }}</button></a>
                @endforeach
            @endif

            <span>
                <a href=""><button type="button" class="btn btn-primary btn-xs disabled">{{ $question->level }}</button></a>
                <strong><small> Asked by <a href="/user/{{$question->user->id}}"  title="Click to view {{ $question->user->name }}'s profile">{{ucfirst($question->user->name)}}</a> {{date('F dS Y', strtotime($question->created_at))}} with {{ isset($question->answer_count[0]->total) ? $question->answer_count[0]->total . ' ' . str_plural('answer', $question->answer_count[0]->answer_count) : '0 answers'  }} </strong></small><br><br>
            </span>
        </div>
    </div>
<!-- END Question Container-->
