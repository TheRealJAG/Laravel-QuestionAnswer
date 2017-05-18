@if (Auth::id())
    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="sidebar-nav sidebar-divider">
                <li><a href="/user/{{Auth::id()}}/questions" title="My Questions"><i class="fa fa-lightbulb-o" style="color: #4285F4;"></i> <strong>My Questions</strong></a></li>
                <li><a href="/user/{{Auth::id()}}/answers" title="My Answers"><i class="fa fa-bullhorn" style="color: #4285F4;"></i> <strong>My Answers</strong></a></li>
                <li><a href="/user/{{Auth::id()}}/notifications" title="My Notifications"><i class="fa fa-share-alt" style="color: #4285F4;"></i> <strong>My Notifications</strong></a></li>
            </ul>
            <ul class="sidebar-nav sidebar-divider">
                <li><a href="/questions/top"><i class="fa fa-fire" style="color: #4285F4;"></i> Top Questions</a></li>
                <li><a href="/questions/new"><i class="fa fa-lightbulb-o" style="color: #4285F4;"></i> New Questions</a></li>
            </ul>
        </div>
    </div>
@endif