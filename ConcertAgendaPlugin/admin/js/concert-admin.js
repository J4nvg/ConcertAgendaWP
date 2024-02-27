jQuery(document).ready(function ($) {
    $('.concert-upload-button').click(function (e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Upload Image',
            multiple: false
        }).open()
        .on('select', function () {
            var uploadedImage = image.state().get('selection').first();
            var imageURL = uploadedImage.toJSON().url;
            $('#concert_fallback_image').val(imageURL);
        });
    });
});
