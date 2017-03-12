$(document).ready(function () {


    function loadMessage(page) {
        $.ajax({
            url: window.location.href + '/message/' + page,
            type: 'GET',
            success: function (data) {
                $('#message_figure').replaceWith(data);
                submitForm();
                paginator();
            }
        });
    }

    function submitForm() {
        $('#form_message').submit(function (e) {
            e.preventDefault();

            var content = $(this).serialize();

            $.ajax({
                url: window.location.href + '/message',
                type: 'POST',
                data: content,
                success: function (data) {

                    $('#message_figure').replaceWith(data);
                    $('#appbundle_message_content').val('');
                    submitForm();
                }
            })
        });
    }

    function paginator(){
        $('.pagin').click(function(e){
            e.preventDefault();
            loadMessage(parseInt($(this).text()))
        })
    }

    loadMessage(1);

});