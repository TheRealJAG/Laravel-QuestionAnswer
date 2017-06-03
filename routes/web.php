<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Search
Route::get('/search/',['uses' => 'HomeController@search','as' => 'search']);

// Home
Route::get('/', 'HomeController@index');

// User Routes
Route::get('user/{id}', 'UserController@index');
Route::get('user/{id}/questions', 'UserController@questions');
Route::get('user/{id}/answers', 'UserController@answers');
Route::get('user/{id}/notifications', 'UserController@notifications');

// Question Routes
Route::get('question/edit/{id}', 'QuestionController@edit');
Route::get('questions/top', 'QuestionController@top');
Route::get('questions/new', 'QuestionController@newest');
Route::get('question/{id}/{question}', 'QuestionController@show');
Route::post('question', array( 'before'=>'csfr','uses'=>'QuestionController@insert' ) );
Route::post('question/edit', array( 'before'=>'csfr','uses'=>'QuestionController@edit_save' ) );

Route::get('question/ask', function () {
    return view('questions.ask', ['tags' => App\Tag::get()]);
});

// Answer Routes
Route::post('answer', array( 'before'=>'csfr','uses'=>'AnswerController@insert' ) );
Route::post('answer/update', array( 'before'=>'csfr','uses'=>'AnswerController@update' ) );

// Tag Routes
Route::get('tag/{id}', 'TagController@show_new');
Route::get('tag/{id}/top', 'TagController@show_top');
Route::get('tag/{id}/most_answered', 'TagController@show_most_answered');
Route::get('tag/{id}/unanswered', 'TagController@show_unanswered');

// Create a quick API to get data for the tags
Route::group(['prefix'=>'api','middleware' => 'auth'], function(){
    Route::get('find', function(Illuminate\Http\Request $request){
        $keyword = $request->input('keyword');
        $tags = DB::table('tags')->where('name','like','%'.$keyword.'%')
            ->select('tags.id','tags.name','tags.display')
            ->get();
        return json_encode($tags);
    })->name('api.tags');
});

// Votes
Route::post('vote/answer', array( 'before'=>'csfr','uses'=>'VoteController@vote_answer' ) );
Route::post('vote/question', array( 'before'=>'csfr','uses'=>'VoteController@vote_question' ) );