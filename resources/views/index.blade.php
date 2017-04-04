@extends('layouts.app')

@section('content')
   <div class="container">

       <div class="hidden-xs hidden-sm col-md-3">

           @if (Auth::id())
               <div class="panel panel-default">
                   <div class="panel-body">
                           <ul class="sidebar-nav sidebar-divider">
                               <li>
                                   <a href="/user/{{Auth::id()}}/questions"><i class="fa fa-lightbulb-o" style="color: #4285F4;"></i> My Questions</a>
                               </li>
                               <li>
                                   <a href="/user/{{Auth::id()}}/answers"><i class="fa fa-bullhorn" style="color: #4285F4;"></i> My Answers</a>
                               </li>
                               <li>
                                   <a href="/user/{{Auth::id()}}/participation"><i class="fa fa-share-alt" style="color: #4285F4;"></i> My Participation</a>
                               </li>
                           </ul>
                           <ul class="sidebar-nav sidebar-divider">
                               <li>
                                   <a href="/questions/top"><i class="fa fa-fire" style="color: #4285F4;"></i> Top Questions</a>
                               </li>
                               <li>
                                   <a href="/questions/new"><i class="fa fa-lightbulb-o" style="color: #4285F4;"></i> New Questions</a>
                               </li>
                           </ul>
                   </div>
               </div>
           @endif

           @include('containers.tags')

       </div>

       <div class="col-md-9">
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
                           <div id="questions">
                               <legend class="text-left">Recent Questions</legend>
                           </div>

                           @foreach( $questions as $question )
                               @include('containers.question')
                           @endforeach

                           {{ $questions->links() }}

                       </div>
                   </div>
               </div>
           </div>
       </div>

       </div>






@endsection

@include('modals.login')