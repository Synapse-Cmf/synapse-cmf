$(() => {
  const _templates = {
    add_element: () => `<a href="#" class="btn btn-default"><i class="fa fa-plus"></i></a>`,
    element_form: labels => `
      <li class="row">
        <div class="col-md-3"><input type="text" class="form-control" name="name" placeholder="${ labels.link.name }"></div>
        <div class="col-md-8"><input type="text" class="form-control" name="url" placeholder="${ labels.link.url }"></div>
        <div class="col-md-1">
          <a href="#" role="delete" class="btn btn-default">
            <i class="fa fa-times"></i>
          </a>
        </div>
      </li>
    `
  };

  /**
   * Menu component form generation
   */
  $('.synapse-tree-menu').each((index, elt) => {
    const $treeInputForm = $(elt);
    const $formContainer =$treeInputForm.parent('div');

    const labels = $treeInputForm.data('labels');
    const baseFormName = $treeInputForm.prop('name');

    const $addLinkBtn = $(_templates.add_element());
    const $linksContainer = $('<ul class="synapse-tree-elements"></ul>');

    $formContainer.append($linksContainer, $addLinkBtn);

    // tree building
    function rebuildLinkTree() {
      const $linkTree = $linksContainer.children().map((index, elt) => {
        const linkFormData = {};

        $(elt).find('input').each((index, elt) => {
          const $elt = $(elt);
          linkFormData[$elt.prop('name')] = $elt.val();
        });

        return linkFormData;
      });

      $treeInputForm.val(JSON.stringify($linkTree.get()));
    }

    // element add
    function createLinkForm(tree = []) {
      const $elementForm = $(_templates.element_form(labels));
      $linksContainer.append($elementForm);

      // values restoring
      _.forEach(tree, (value, key) => $elementForm.find(`[name=${ key }]`).val(value));

      // element delete
      $elementForm.find('a[role=delete]').on('click', e => {
        e.preventDefault();
        $elementForm.detach();
        rebuildLinkTree();
      });
    };

    // rebuild from existing data
    if ($treeInputForm.val()) {
      const values = JSON.parse($treeInputForm.val());
      _.forEach(values, (value) => createLinkForm(value));
    }

    // element changed
    $formContainer.on('input', '.synapse-tree-elements input', rebuildLinkTree);

    // new element
    $addLinkBtn.on('click', e => {
      e.preventDefault();
      createLinkForm();
    });
  });
});
