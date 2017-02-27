$(document).ready(function () {


    var $formImage = $("div#appbundle_figure_images");
    var indexImage = $formImage.find("div.well").length;

    console.log(indexImage);

    var $formVideo = $("div#appbundle_figure_videos");
    var indexVideo = $formVideo.find("div.well").length;

    console.log(indexVideo);

    if (indexImage == 0) {
        addImage($formImage);
    }

    $formImage.children("div").each(function () {
        addDeleteLink($(this))
    });

    $formVideo.children("div").each(function(){
        addDeleteLink($(this))
    });


    $("#add_image").click(function (e) {
        e.preventDefault();
        addImage($formImage);
        return false;
    });


    $("#add_video").click(function (e) {
        e.preventDefault();
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

    function addDeleteLink($fields) {

        var $deleteLink = $('<a href="#" class="btn btn-danger del_field">Supprimer</a>');

        $fields.children(".well").append($deleteLink);

        $deleteLink.click(function (e) {
            e.preventDefault();
            $fields.remove();
            return false;
        });
    }

})
;