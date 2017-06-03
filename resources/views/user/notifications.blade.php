@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-push-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <legend class="text-left">
                                    <h1>My Notifications</h1>
                                </legend>

                                @if (!$user->unreadNotifications->isEmpty())
                                    <div id="questions">
                                        <legend class="text-left">New Notifications</legend>
                                    </div>
                                    <ul style="list-style-type: none; padding-left:0px;">
                                        @foreach ($user->unreadNotifications as $notification)
                                            <?php $question = \App\Question::findOrFail($notification->data['question_id']); ?>
                                            <?php $user_name = App\User::find($notification->data['user_id'])->name; ?>
                                            @if ($notification->type == 'App\Notifications\Answer' && $notification->unread())
                                                <li><span class="label label-primary">ANSWER</span> <a href="/question/{{$question->id}}/{{ App\Classes\URL::get_slug($question->question) }}" title="{{ e($question->question) }}">{{ e($question->question) }}</a> by <a href="/user/{{$notification->data['user_id']}}/">{{$user_name}}</a> {{ e($notification->created_at->diffForHumans()) }}</li>
                                            @elseif($notification->type == 'App\Notifications\Vote' && $notification->unread())
                                                <li><span class="label label-success"> {!! ($notification->data['vote'] == 1 ? '<i class="fa fa-arrow-up" aria-hidden="true"></i>' : '<i class="fa fa-arrow-down" aria-hidden="true"></i>') !!}&nbsp;VOTE</span> <a href="/question/{{$question->id}}/{{ App\Classes\URL::get_slug($question->question) }}" title="{{ e($question->question) }}">{{ e($question->question) }}</a> by <a href="/user/{{$notification->data['user_id']}}/">{{$user_name}}</a> {{ e($notification->created_at->diffForHumans()) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @endif
                                <div id="questions">
                                    <legend class="text-left">All Notifications</legend>
                                </div>
                                <ul style="list-style-type: none; padding-left:0px;">
                                    @if ($user->notifications->isEmpty())
                                        <li>You have no notifications</li>
                                    @endif
                                    @foreach ($user->notifications as $notification)
                                        <?php $question = \App\Question::findOrFail($notification->data['question_id']); ?>
                                        <?php $user_name = App\User::find($notification->data['user_id'])->name; ?>
                                        @if ($notification->type == 'App\Notifications\Answer' && !$notification->unread())
                                            <li><span class="label label-primary">ANSWER</span> <a href="/question/{{$question->id}}/{{ App\Classes\URL::get_slug($question->question) }}" title="{{ e($question->question) }}">{{ e($question->question) }}</a> by <a href="/user/{{$notification->data['user_id']}}/">{{$user_name}}</a> {{ e($notification->created_at->diffForHumans()) }}</li>
                                        @elseif($notification->type == 'App\Notifications\Vote' && !$notification->unread())
                                            <li><span class="label label-success">&nbsp;{!! ($notification->data['vote'] == 1 ? '<i class="fa fa-arrow-up" aria-hidden="true"></i>' : '<i class="fa fa-arrow-down" aria-hidden="true"></i>') !!}&nbsp;VOTE&nbsp;</span> <a href="/question/{{$question->id}}/{{ App\Classes\URL::get_slug($question->question) }}" title="{{ e($question->question) }}">{{ e($question->question) }}</a> by <a href="/user/{{$notification->data['user_id']}}/">{{$user_name}}</a> {{ e($notification->created_at->diffForHumans()) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                                <?php $user->unreadNotifications->markAsRead(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-md-pull-9">
                @include('layouts.sidebar_auth')
                @include('layouts.sidebar')
            </div>
        </div>
    </div>
@endsection