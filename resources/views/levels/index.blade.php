@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="hidden-xs hidden-sm col-md-3">

                <div class="panel panel-default">
                    <div class="panel-body">
                      Something can go here...
                    </div>
                </div>


        </div>

        <div class="col-md-9">

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="questions">
                                <legend class="text-left">Recent Questions</legend>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection