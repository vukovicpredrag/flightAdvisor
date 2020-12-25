$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(document).ready(function() {

    $('#importDataButton').click( function (e) {

        $('#overlay').show();
        $('#loader').show();

    });

    $('#findFlight').click( function (e) {

        $('#overlay').show();
        $('#loader').show();

    });

    $('.write-comment').click( function (e) {

        e.preventDefault();

        $(this).siblings('.write-comment-box').toggle();

    });

    $('.delete-comment').click( function (e) {

        e.preventDefault();

        let commentBox = $(this).parent();

        commentBox.css('display','none');
        confirm("Are yoy sure you want to delete this comment?")

        $.ajax({
            url: $(this).attr('data-url'),
            method: 'DELETE',
            success: function (response) {

                let data = JSON.parse(response)

                if(data.status == true){
                    commentBox.css('display','none');
                }

            }
        });
    });


    $("body").on('click', '.edit-comment', function (e) {

        $(this).siblings('.comment-text').attr('disabled',false)
        $(this).text('Save');
        $(this).toggleClass('update-comment');

    });

    $("body").on('click', '.update-comment', function (e) {

        $(this).addClass('edit-comment');
        $(this).text('Edit');

        let comment     = $(this).siblings('.comment-text');
        let commentText = $(this).siblings('.comment-text').val();
        let updated     = $(this).siblings('.updated-comment');

        $.ajax({
            url: $(this).attr('data-url'),
            data: {comment: commentText},
            method: 'PUT',
            success: function (response) {
                let data = JSON.parse(response)
                if(data.status == true){
                    comment.attr('disabled',true)
                    updated.text('updated: 0 secounds ago')
                }
            }
        });

    })

    $('.comments-number').change( function () {

        let commentNumber = $(this).val();

        window.location = window.location.protocol  + '?limit=' + commentNumber

    })


     const route = $('#citySearch').attr( 'data-cites-url' );

    $("#cityFrom").select2({
        placeholder: "",
        multiple: false,
        minimumInputLength: 1,
        ajax: {
            url: route,
            dataType: 'json',
            quietMillis: 250,
            data: function(term, city) {
                return {
                    q: term,
                    city: city || 1
                };
            },
            results: function(data, page) {

                return {results: data};

            },
            cache: true
        },
    });

    $("#cityTo").select2({
        placeholder: "",
        multiple: false,
        minimumInputLength: 1,
        ajax: {
            url: route,
            dataType: 'json',
            quietMillis: 250,
            data: function(term, city) {
                return {
                    q: term,
                    city: city || 1
                };
            },
            results: function(data, page) {

                return {results: data};

            },
            cache: true
        },
    });

    $("#citySearchBox").select2();

})

