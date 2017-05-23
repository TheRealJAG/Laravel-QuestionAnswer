<div class="panel panel-default">
    <div class="panel-body">
        <legend class="text-left">
            <h3>Tags</h3>
        </legend>
        <ul class="sidebar-nav sidebar-divider">
            @if ( !$tags->isEmpty() )
                @foreach( $tags as $tag )
                    @if ($tag->questions->count() > 0)
                        <li style="color: black;"><a href="/tag/{{ App\Classes\URL::get_slug($tag->name) }}" title="{{$tag->name}} Questions"> <i class="fa fa-ellipsis-v" style="color: #4285F4;"></i> <strong>{{ $tag->name }}</strong> <span class="badge badge-info pull-right" style="margin-top: 15px">{{$tag->questions->count()}}</span></a></li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</div>