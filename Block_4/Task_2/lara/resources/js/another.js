import $ from 'jquery';

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).on('click', '.delete-post', function () {
    const post = $(this).closest('.post');
    const postId = post.find('.pid').text().trim();

    $.ajax({
        url: '/posts/' + postId,
        type: 'DELETE',
    })
    .then(function (response) {
        post.remove();
    })
    .catch(function(error){
        console.error('Ошибка удаления: ', error)
    });
});

$('.update-post').click(function () {
    
    $.ajax({
        url: '/posts/updated',
        type: 'GET',
    })
    .then(function (htmlUpdatedPosts) {
        $('#post-container').html(htmlUpdatedPosts);
    })
    .catch(function(error){
        console.error('Ошибка обновления постов: ', error);
    });
})