/*

Handle voting of questions and answers

*/

$(document).ready(function() {
    // Question Voting
    $('.vote_question').upvote();
    $('.vote_q').on('click', function (e) {
        var data = {vote: $(this).data('vote'), question_id: $(this).parent().data('question')};
        var uid = $(this).parent().data('uid');
        //var question_id = $(this).parent().data('question');

        if ($(this).parent().data('question')) {
            if (uid == '') { // visitor is guest, throw a modal and correct the vote value, reset arrow
                var action = $(this).attr('id'); // upvote or downvote action
                var new_vote_value = parseInt($( "#q-" +  $(this).parent().data('question')).text()); // get score attempted
                    if (action == 'q-upvote') { // if upvoted, downvote
                        $( "#q-" +  $(this).parent().data('question')).html(new_vote_value - 1); // assign new value
                    } else if (action == 'q-downvote') { // if downvoted, upvote
                        $( "#q-" +  $(this).parent().data('question')).html(new_vote_value + 1); // assign new value
                    }
                $('a.upvote').removeClass('upvote-on'); // remove upvote highlight
                $('a.downvote').removeClass('downvote-on'); // remove downvote highlight
                history.pushState("", "Login", "/login"); // push the state to /login
                $('#LoginModal').modal('show'); // show modal
                return false;
            }

            // X-CSRF-TOKEN
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()}});

            // Cast vote to PHP
            $.ajax({
                type: "POST",
                url: '/vote/question',
                dataType: 'JSON',
                data: data,
                success: function( data ) {
                    if(data.status == 'success') {
                        console.log(data.msg);
                    } else {
                        console.log(data.msg);
                    }
                }
            });
        }
    });
    // End Question Voting

    // Answer Voting
    $('.vote_answer').upvote();
    $('.vote').on('click', function (e) {
        var data = {vote: $(this).data('vote'), answer_id: $(this).parent().data('answer')};
        var uid = $(this).parent().data('uid');

        // Are we voting on an answer?
        if ($(this).parent().data('answer')) {

            // If visitor is guest
            // Throw a modal and correct the vote value
            if (uid == '') {
                var action = $(this).attr('id'); // upvote or downvote
                var new_vote_value = parseInt($( "#a-" +  $(this).parent().data('answer')).text()); // get score attempted

                if (action == 'a-upvote') { // if upvoted, downvote
                    $( "#a-" +  $(this).parent().data('answer')).html(new_vote_value - 1);
                } else if (action == 'a-downvote') { // if downvoted, upvote
                    $( "#a-" +  $(this).parent().data('answer')).html(new_vote_value + 1);
                }

                $('a.upvote').removeClass('upvote-on'); // remove upvote highlight
                $('a.downvote').removeClass('downvote-on'); // remove downvote highlight
                $('#LoginModal').modal('show'); // show modal
                return false;
            }

            // X-CSRF-TOKEN
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('[name="_token"]').val()}});

            // Cast the vote to php via jquesy
            $.ajax({
                type: "POST",
                url: '/vote/answer',
                dataType: 'JSON',
                data: data,
                success: function( data ) {
                    if(data.status == 'success') {
                        console.log(data.msg);
                    } else {
                        console.log(data.msg);
                    }
                }
            });
        }
    });
    // End Answer Voting
});