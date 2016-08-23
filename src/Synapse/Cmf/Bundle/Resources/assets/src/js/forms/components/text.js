$(() => {
  CKEDITOR.basePath = '/bundles/synapsecmf/vendor/ckeditor/';

  /**
   * Text component CKEditor init
   */
  $('.synapse-rich-editor').each((index, elt) => {
    const $htmlAreaForm = $(elt);
    CKEDITOR.replace($htmlAreaForm.prop('id'), {
      customConfig: '',
      contentsCss: [],
      language: 'en',
      toolbar: [
        [ 'Bold','Italic','Underline','Strike' ],
        [ 'NumberedList','BulletedList','-','Outdent','Indent'],
        [ 'Cut','Copy','Paste','-','Undo','Redo' ]
      ]
    });
  });
});
