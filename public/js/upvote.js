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

            // If visitor is guest
            // Throw a modal and correct the vote value
            if (uid == '') {
                var action = $(this).attr('id'); // upvote or downvote
                var new_vote_value = parseInt($( "#q-" +  $(this).parent().data('question')).text()); // score attempted, we either knock it back down or up.

                    if (action == 'q-upvote') {
                        var str = new_vote_value - 1;
                        $( "#q-" +  $(this).parent().data('question')).html(str);
                    } else if (action == 'q-downvote') {
                        var str = new_vote_value + 1;
                        $( "#q-" +  $(this).parent().data('question')).html(str);
                    }

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

            // If visitor is guest
            // Throw a modal and correct the vote value
            if (uid == '') {
                var action = $(this).attr('id'); // upvote or downvote
                var new_vote_value = parseInt($( "#a-" +  $(this).parent().data('answer')).text()); // score attempted, we either knock it back down or up.

                console.log(new_vote_value);

                if (action == 'a-upvote') {
                    var str = new_vote_value - 1;
                    $( "#a-" +  $(this).parent().data('answer')).html(str);
                } else if (action == 'a-downvote') {
                    var str = new_vote_value + 1;
                    $( "#a-" +  $(this).parent().data('answer')).html(str);
                }

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