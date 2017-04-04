/*

The main JS that powers the answer upvote functionality.
todo Make questions votable
*/

$(document).ready(function() {

    // Question Voting
    $('.vote_question').upvote();
    $('.vote_q').on('click', function (e) {
        var data = {vote: $(this).data('vote'), question_id: $(this).parent().data('question')};
        var uid = $(this).parent().data('uid');
        var question_id = $(this).parent().data('question');
        // Are we voting on an question?
        if ($(this).parent().data('question')) {

            // If the user has not been authenticate, throw a popover.
            if (uid == '') {
                var upvoted = $('.vote_question').upvote('upvoted');
                var downvoted = $('.vote_question').upvote('downvoted');
                $('a.upvote').removeClass('upvote-on');
                $('a.downvote').removeClass('downvote-on');
                $('#LoginModal').modal('show');
                return false;
            }

            // Laravel token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('[name="_token"]').val()
                }
            });

            // Cast the vote to php via jquery
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

            // If the user has not been authenticate, throw a popover.
            if (uid == '') {
                $('#LoginModal').modal('show');
                return;
            }

            // Laravel token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('[name="_token"]').val()
                }
            });

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