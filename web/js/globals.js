/*exported enableTabNavigation, sendAjax, handleModalForm */
// навигация по табам (при нажатии на таб добавляет его идентификатор к URL, после перезагрузки страницы перепрыгивает
// на ранее выбранный таб
function enableTabNavigation() {
    "use strict";
    let url = location.href.replace(/\/$/, "");
    if (location.hash) {
        const hash = url.split("#");
        $('a[href="#' + hash[1] + '"]').tab("show");
        url = location.href.replace(/\/#/, "#");
        history.replaceState(null, null, url);
    }

    $('a[data-toggle="tab"]').on("click", function () {
        let newUrl;
        const hash = $(this).attr("href");
        if (hash === "#home") {
            newUrl = url.split("#")[0];
        } else {
            newUrl = url.split("#")[0] + hash;
        }
        history.replaceState(null, null, newUrl);
    });
}

// ========================================================== ИНФОРМЕР

// СКРЫВАЮ ИНФОРМЕР
function closeAlert(alertDiv) {
    "use strict";
    const elemWidth = alertDiv[0].offsetWidth;
    alertDiv.animate({
        left: elemWidth
    }, 500, function () {
        alertDiv.animate({
            height: 0,
            opacity: 0
        }, 300, function () {
            alertDiv.remove();
        });
    });
}

// ПОКАЗЫВАЮ ИНФОРМЕР
function showAlert(alertDiv) {
    "use strict";
    // считаю расстояние от верха страницы до места, где располагается информер
    const topShift = alertDiv[0].offsetTop;
    const elemHeight = alertDiv[0].offsetHeight;
    let shift = topShift + elemHeight;
    alertDiv.css({'top': -shift + 'px', 'opacity': '0.1'});
    // анимирую появление информера
    alertDiv.animate({
        top: 0,
        opacity: 1
    }, 500, function () {
        // запускаю таймер самоуничтожения через 5 секунд
        setTimeout(function () {
            closeAlert(alertDiv)
        }, 50000);
    });

}

// СОЗДАЮ ИНФОРМЕР =====================================================================================================
function makeInformer(type, header, body) {
    "use strict";
    if (!body)
        body = '';
    const container = $('div#alertsContentDiv');
    const informer = $('<div class="alert-wrapper"><div class="alert alert-' + type + ' alert-dismissable my-alert"><div class="panel panel-' + type + '"><div class="panel-heading">' + header + '<button type="button" class="close">&times;</button></div><div class="panel-body">' + body + '</div></div></div></div>');
    informer.find('button.close').on('click.hide', function (e) {
        e.preventDefault();
        closeAlert(informer);
    });
    container.append(informer);
    showAlert(informer);
}

// Сериализация объектов ===============================================================================================
function serialize(obj) {
    "use strict";
    const str = [];
    for (let p in obj)
        if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
        }
    return str.join("&");
}

// Запрещу перезагрузку страницы на время выполнения операции ==========================================================
function ajaxDangerReload() {
    "use strict";
    $(window).on('beforeunload.ajax', function () {
        return "Необходимо заполнить все поля на странице!";
    });
}

// Верну нормальную перезагрузку страницы ==============================================================================
function ajaxNormalReload() {
    "use strict";
    $(window).off('beforeunload.ajax');
}

// отображение заблюривания при выполнении операции ====================================================================
function showWaiter() {
    /**
     * @param {{showLoading:string}} shader
     */
    "use strict";
    let shader = $('<div class="shader"></div>');
    $('body').append(shader).css({'overflow': 'hidden'});
    $('div.wrap, div.flyingSumm, div.modal').addClass('blurred');
    shader.showLoading();
}

// удалю заблюривание ==================================================================================================
function deleteWaiter() {
    /**
     * @param {{hideLoading:string}} shader
     */
    "use strict";
    $('div.wrap, div.flyingSumm, div.modal').removeClass('blurred');
    $('body').css({'overflow': ''});
    let shader = $('div.shader');
    if (shader.length > 0) {
        shader.hideLoading().remove();
    }
}

// ajax-запрос =========================================================================================================
function sendAjax(method, url, callback, attributes, isForm, silent) {
    "use strict";
    /**
     * @param {{responseJSON:string}} e
     */
    if (!silent) {
        showWaiter();
        ajaxDangerReload();
    }
    // проверю, не является ли ссылка на арртибуты ссылкой на форму
    if (attributes && attributes instanceof jQuery && attributes.is('form')) {
        attributes = attributes.serialize();
    } else if (isForm) {
        attributes = $(attributes).serialize();
    } else {
        attributes = serialize(attributes);
    }
    if (method === 'get') {
        $.ajax({
            method: method,
            data: attributes,
            url: url
        }).done(function (e) {
            deleteWaiter();
            ajaxNormalReload();
            callback(e);
        }).fail(function (e) {
            ajaxNormalReload();
            deleteWaiter();
            if (e.responseJSON) {
                makeInformer('danger', 'Системная ошибка', e.responseJSON.message);
            } else {
                makeInformer('info', 'Ответ системы', e.responseText);
            }
        });
    } else if (method === 'post') {
        $.ajax({
            data: attributes,
            method: method,
            url: url
        }).done(function (e) {
            deleteWaiter();
            ajaxNormalReload();
            callback(e);
        }).fail(function (e) {
            deleteWaiter();
            ajaxNormalReload();
            if (e.responseJSON) {
                makeInformer('danger', 'Системная ошибка', e.responseJSON.message);
            } else {
                makeInformer('info', 'Ответ системы', e.responseText);
            }
        });
    }
}


// Функция вызова пустого модального окна ==============================================================================
function makeModal(header, text, delayed) {
    "use strict";

    function extract(newModal) {
        $('body').append(newModal);
        ajaxDangerReload();
        newModal.modal({
            keyboard: true,
            show: true
        });
        newModal.on('hidden.bs.modal', function () {
            ajaxNormalReload();
            newModal.remove();
            $('div.wrap div.container, div.wrap nav').removeClass('blured');
        });
        $('div.wrap div.container, div.wrap nav').addClass('blured');
    }

    if (delayed) {
        // открытие модали поверх другой модали
        let modal = $("#myModal");
        if (modal.length === 1) {
            modal.modal('hide');
            let newModal = $('<div id="myModal" class="modal fade mode-choose"><div class="modal-dialog  modal-lg"><div class="modal-content"><div class="modal-header">' + header + '</div><div class="modal-body">' + text + '</div><div class="modal-footer"><button class="btn btn-danger"  data-dismiss="modal" type="button" id="cancelActionButton">Отмена</button></div></div></div>');
            modal.on('hidden.bs.modal', function () {
                modal.remove();
                if (!text)
                    text = '';
                extract(newModal);
            });
            return newModal;
        }
    }
    if (!text)
        text = '';
    let modal = $('<div id="myModal" class="modal fade mode-choose"><div class="modal-dialog  modal-lg"><div class="modal-content"><div class="modal-header">' + header + '</div><div class="modal-body">' + text + '</div><div class="modal-footer"><button class="btn btn-danger"  data-dismiss="modal" type="button" id="cancelActionButton">Отмена</button></div></div></div>');
    extract(modal);
    return modal;
}

// обработаю ответ на передачу формы через AJAX ========================================================================
function ajaxFormAnswerHandler(data) {
    "use strict";
    if (data.status === 1) {
        ajaxNormalReload();
        location.reload();
    } else if (data.message) {
        makeInformer('danger', "Ошибка", data.message);
    }
}

// обработка формы, переданной через AJAX ==============================================================================
function handleModalForm(data) {
    "use strict";
    let readyToSend = false;
    if (data.status && data.status === 1) {
        let modal = makeModal(data.header, data.data);
        let form = modal.find('form');
        form.on('afterValidate', function (event, messages) {
            if (messages) {
                let key;
                for (key in messages) {
                    if (messages.hasOwnProperty(key)) {
                        if (messages[key].length > 0) {
                            readyToSend = false;
                            return;
                        }
                    }
                }
                readyToSend = true;
            }
        });
        // при подтверждении форму не отправляю, жду валидации
        form.on('submit.sendByAjax', function (e) {
            e.preventDefault();
            if (readyToSend) {
                sendAjax('post',
                    form.attr('action'),
                    ajaxFormAnswerHandler,
                    form,
                    true);
            }
        });
    }
}