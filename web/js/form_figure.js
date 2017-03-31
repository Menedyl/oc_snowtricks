$(document).ready(function () {


    var $formImage = $("div#appbundle_figure_images");
    var indexImage = $('.image').length;

    var $formVideo = $("div#appbundle_figure_videos");
    var indexVideo = $('.video').length;


    if (indexImage < 1) {
        addImage($formImage);
    }

    if (indexImage > 1) {
        $('.image').each(function (index) {
            if (index > 0) {
                addDeleteLink($(this), true);
            }
        });
    }

    if (indexVideo > 0){
        $('.video').each(function(){
            addDeleteLink($(this), true);
        });
    }


    $("#add_image").click(function () {
        addImage($formImage);
        return false;
    });


    $("#add_video").click(function () {
        addVideo($formVideo);
        return false;
    });


    function addImage($formImage) {


        var fieldsImage = $formImage.attr("data-prototype")
            .replace(/__name__/g, indexImage + 1);


        var $fieldsImage = $(fieldsImage);


        $formImage.append($fieldsImage);

        if (indexImage !== 0) {
            addDeleteLink($fieldsImage);
        }


        indexImage++;
    }


    function addVideo($formVideo) {

        var fieldsVideo = $formVideo.attr("data-prototype")
            .replace(/__name__/g, indexVideo + 1);

        var $fieldsVideo = $(fieldsVideo);

        $formVideo.append($fieldsVideo);

        addDeleteLink($fieldsVideo);

        indexVideo++;
    }

    function addDeleteLink($fields, add) {

        var $deleteLink = $('<a href="#" class="btn btn-danger del_field">Supprimer</a>');

        if (!add) {
            $fields.children(".well").append($deleteLink);
        } else {
            $fields.append($deleteLink);
        }

        $deleteLink.click(function () {
            $fields.remove();
            return false;
        });
    }


})
;