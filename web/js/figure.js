$(document).ready(function () {


    function loadComment(page) {
        $.ajax({
            url: window.location.href + '/comment/' + page,
            type: 'GET',
            success: function (data) {
                $('#comment_figure').replaceWith(data);
                submitForm();
                paginator();
            }
        });
    }

    function submitForm() {
        $('#form_comment').submit(function (e) {
            e.preventDefault();

            var content = $(this).serialize();

            $.ajax({
                url: window.location.href + '/comment',
                type: 'POST',
                data: content,
                success: function (data) {

                    $('#comment_figure').replaceWith(data);
                    $('#appbundle_comment_content').val('');
                    submitForm();
                }
            })
        });
    }

    function paginator(){
        $('.pagin').click(function(e){
            e.preventDefault();
            loadComment(parseInt($(this).text()))
        })
    }

    loadComment(1);

});