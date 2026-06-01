jQuery(document).ready(function($){
    var mediaUploader;

    $(document).on('click', '.upload_image_button', function(e) {
        e.preventDefault();
        
        var button = $(this);
        var itemContainer = button.closest('.repeater-item');
        var inputField = itemContainer.find('.preview-hidden-input');
        var mediaContainer = itemContainer.find('.preview_media_container');

        // Extend the wp.media object
        mediaUploader = wp.media({
            title: 'Choose Media',
            button: {
                text: 'Choose Media'
            },
            multiple: false,
            library: {
                type: ['image', 'video']
            }
        });

        // When a file is selected, grab the URL and set it as the text field's value
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            inputField.val(attachment.id);
            
            mediaContainer.empty();
            
            if (attachment.type === 'video') {
                mediaContainer.append('<video src="' + attachment.url + '" controls style="max-width: 150px; display: block;"></video>');
            } else {
                mediaContainer.append('<img src="' + attachment.url + '" style="max-width: 150px; display: block;" />');
            }
        });

        // Open the uploader dialog
        mediaUploader.open();
    });

    $(document).on('click', '.remove_image_button', function(e){
        e.preventDefault();
        var button = $(this);
        var itemContainer = button.closest('.repeater-item');
        
        // If there is more than one item, remove the row entirely. Otherwise just clear it.
        if ($('.repeater-item').length > 1) {
            itemContainer.remove();
        } else {
            itemContainer.find('.preview-hidden-input').val('');
            itemContainer.find('.preview_media_container').empty();
        }
    });

    // Add more previews
    $('#add_more_previews').click(function(e) {
        e.preventDefault();
        var repeater = $('#previews_repeater');
        var newRow = $('<div class="repeater-item">' +
            '<div class="preview_media_container" style="margin-bottom: 10px;"></div>' +
            '<input type="hidden" name="project_previews[]" class="preview-hidden-input" value="" />' +
            '<button type="button" class="button upload_image_button">Select Media</button>' +
            ' <button type="button" class="button remove_image_button">Remove</button>' +
        '</div>');
        repeater.append(newRow);
    });
});
