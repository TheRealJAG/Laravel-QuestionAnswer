<?php
// todo clean this up
$answer_count = json_decode($question->answer_count,true);
if (isset($answer_count[0])) {
    $answer_number = $answer_count[0]['total'];
} else  {
    $answer_number = 0;
}
$shown = false;
?>

<!-- Question Container-->
<div class="row">
    <div class="col-xs-10 col-md-11">
        <h4 style="color: #2a88bd;font-weight: bolder;margin-top: 0;margin-bottom: 0px;"><a href="/question/{{$question->id}}/{{ App\Classes\URL::get_slug($question->question) }}" title="{{ e($question->question) }}">{{ e($question->question) }}</a></h4>
        <span>
                <small>
                    <strong>
                        {{date('F dS Y', strtotime($question->created_at))}}
                        {{ $answer_number >= 1 ? ' with ' . $answer_number . ' ' . str_plural('answer', $answer_number) : ''  }}
                    </strong>
                </small>
            </span>
    </div>
</div>
<!-- END Question Container-->