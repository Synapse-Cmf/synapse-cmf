$(() => {
  // Synapse template form module
  $('.synapse-theme-form').each((index, elt) => {

    const $this = $(elt);

    // template and panel display
    const activePanels = (namespace, id) => {
      $this.find('.' + namespace + '-pane').removeClass('active')
        .filter('.' + namespace + '-' + id).addClass('active')
      ;
    };

    $this.find('.template-select')
      .change(e => { activePanels('template', $(e.target).val()); })
      .change()
    ;
    $this.find('.zone-select')
      .change(e => { activePanels('zone', $(e.target).val()); })
      .change()
    ;
  });
});
