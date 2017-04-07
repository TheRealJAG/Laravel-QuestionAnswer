@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="hidden-xs hidden-sm col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="sidebar-nav sidebar-divider">
                        <li><a href="/questions/top"><i class="fa fa-fire" style="color: #4285F4;"></i> Top Questions</a></li>
                        <li><a href="/questions/new"><i class="fa fa-lightbulb-o" style="color: #4285F4;"></i> New Questions</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body"><h2></h2>
                            <h1>Page Not Found</h1>
                            <P>The page you are looking for can not be found!</P>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection