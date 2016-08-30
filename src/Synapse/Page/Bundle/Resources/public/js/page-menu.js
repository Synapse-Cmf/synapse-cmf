;(function ($, _) {

  'use strict';

  /**
   * insert `$elt` into `$container` element
   * @returns {Function}
   * @param $container
   */
  function insertElement($container) {
    return function ($elt) {
      return $container.append($elt);
    };
  }

  /**
   * create a new jQuery instance of `proto` element with substited `pos` value
   * @param proto
   * @returns {Function}
   */
  function duplicateElement(proto) {
    return function (pos) {
      return $(proto.replace(/__name__/g, pos));
    };
  }

  /**
   *
   * @param selector
   * @returns {Function}
   */
  function remove(selector) {
    return function($item) {
      return $item.closest(selector).remove();
    };
  }

  /**
   * update `position` information for each field `id` and `name` attributes
   * @param $container
   * @returns {Function}
   */
  function updateOrder($container) {
    return function () {
      return $container.find('.page-menu-item').each(function (pos, e) {
        var $position = $(this).find('.page-menu-item-position'),
          updater = updateOrderElement(pos)
          ;

        // update all fields attributes
        _.forEach([
            $(this),
            $(this).find('.page-menu-item-label'),
            $(this).find('.page-menu-item-page'),
            $position],
          function ($e) {
            updater($e);
          });

        // set real $position value
        $position.val(pos);
      });
    };
  }

  /**
   * update `position` value for each attribute in a given element $e
   * @param pos the position to set
   * @returns {Function}
   */
  function updateOrderElement(pos) {
    return function ($e) {
      var pId = /_data_data_\d+/g,
        pName = /\[data\]\[data\]\[\d+\]/g,
        newId = '_data_data_' + pos,
        newName = '[data][data][' + pos + ']'
        ;

      $e.attr('id', $e.attr('id').replace(pId, newId));

      if ($e.attr('name')) {
        $e.attr('name', $e.attr('name').replace(pName, newName));
      }

      return $e;
    };
  }


  /**
   * initialize page_menu component behavior
   * @param s css selector for collection fields container
   */
  function init($root) {
    var $pageMenuContainer = $root.find('.synapse-page-menu-data'),
      addElement = _.flow(
        duplicateElement($pageMenuContainer.data('prototype')),
        insertElement($pageMenuContainer),
        updateOrder($pageMenuContainer)
      ),
      removeElement = _.flow(
        remove('.page-menu-item'),
        updateOrder($pageMenuContainer)
      );

    return $root
      .on('click', 'a.add-page-menu', function (e) {
        e.preventDefault();
        addElement($pageMenuContainer.find('select').size());
      })
      .on('click', '.page-menu-item a[role="delete"]', function (e) {
        e.preventDefault();
        removeElement($(this));
      })
      .addClass('page-menu-initialized');
  }

  /**
   * jQuery plugin for binding page_menu behavior to html form
   * @returns {jQuery}
     */
  $.fn.synapsePageMenu = function () {

    $(this).not('.page-menu-initialized').each(function () {
      init($(this));
    });

    return this;
  };

}(jQuery, _));
