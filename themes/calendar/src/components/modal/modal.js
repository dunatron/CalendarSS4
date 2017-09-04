/* jslint browser: true*/
/* global $, jQuery, happLoader*/

/**
 * Modal selectors
 */
const eventModal = $('#eventModal');
const addEventModal = $('#addEventModal');
const filterModal = $('#filterModal');
const searchModal = $('#searchModal');

/**
 * Modal functions
 */
function modalBodyIsScrollable(modal) {
  $(modal).on('show.bs.modal', function () {
    $(this).find('.modal-body').css({
      'max-height': '100%',
    });
  });
}

function modalIsDraggable(modal) {
  $(modal).draggable({
    handle: '.modal-dialog',
  });
}

function modalIsResizable(modal) {
  $(modal).find('.modal-content').resizable({
    minHeight: 300,
    minWidth: 300,
  });
}

/**
 * eventModal
 */
modalIsDraggable(eventModal);
modalIsResizable(eventModal);
modalBodyIsScrollable(eventModal);

/**
 * addEventModal
 */
modalIsDraggable(addEventModal);
modalIsResizable(addEventModal);
modalBodyIsScrollable(addEventModal);

/**
 * filterModal
 */
modalIsDraggable(filterModal);
modalIsResizable(filterModal);
modalBodyIsScrollable(filterModal);

/**
 * searchModal
 */
modalIsDraggable(searchModal);
modalIsResizable(searchModal);
modalBodyIsScrollable(searchModal);

