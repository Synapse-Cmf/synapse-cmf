((Dropzone) => {
  Dropzone.options.synapseImageUpload = {
    maxFilesize: 2,
    init: function() {
        this.on('error', function(file, response) {
            $(file.previewElement).find('.dz-error-message').text(response.error_full_message);
        });
    }
  }
})(Dropzone);
