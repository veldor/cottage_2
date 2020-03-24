/*global sendAjax, handleModalForm */
$(function () {
    "use strict";
    // при нажатии на кнопку добавления участка подгужу форму создания участка
    let addNewCottageBtn = $('button#addNewCottageBtn');
    addNewCottageBtn.on('click.add', function () {
        sendAjax('get', '/form/cottage-add', handleModalForm);
    });
});