'use strict';
(function($) {
    let lang = $('html').attr('lang');
    if ($.isFunction($.fn.dataTable)) {
        let optionLang = {
            'sLengthMenu': 'Display  _MENU_ records per page',
            'sSearch': 'Search:',
            'oPaginate': {
                'sFirst': 'First',
                'sPrevious': 'Previous',
                'sNext': 'Next',
                'sLast': 'Last',
            },
            'sEmptyTable': 'No data available',
            'sProcessing': 'Loading...',
            'sZeroRecords': 'No matching records found',
            'sInfo': 'Showing _START_ to _END_ of _TOTAL_ entries',
            'sInfoEmpty': 'Showing 0 to 0 of 0 entries',
            'sInfoFiltered': '(filtered from _MAX_ total entries)',
            'sInfoPostFix': '',
            'sUrl': '',
        };
        if (lang === 'vi') {
            optionLang = {
                'sEmptyTable': 'Không có dữ liệu',
                'sProcessing': 'Đang xử lý...',
                'sLengthMenu': 'Xem _MENU_ mục',
                'sZeroRecords': 'Không tìm thấy dòng nào phù hợp',
                'sInfo': 'Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục',
                'sInfoEmpty': 'Đang xem 0 đến 0 trong tổng số 0 mục',
                'sInfoFiltered': '(đượcc lọc từ _MAX_ mục)',
                'sInfoPostFix': '',
                'sSearch': 'Tìm:',
                'sUrl': '',
                'oPaginate': {
                    'sFirst': 'Đầu',
                    'sPrevious': 'Trước',
                    'sNext': 'Tiếp',
                    'sLast': 'Cuối',
                },
            };
        }
        //Datatable Pipleline
        $.fn.dataTable.pipeline = function(opts) {
            // Configuration options
            const conf = $.extend({
                pages: 5, // number of pages to cache
                url: '', // script url
                data: null, // function or object with parameters to send to the server
                // matching how `ajax.data` works in DataTables
                method: 'POST' // Ajax HTTP method
            }, opts);
            // Private variables for storing the cache
            let cacheLower = -1;
            let cacheUpper = null;
            let cacheLastRequest = null;
            let cacheLastJson = null;
            return function(request, drawCallback, settings) {
                let ajax = false;
                let requestStart = request.start;
                const drawStart = request.start;
                const requestLength = request.length;
                const requestEnd = requestStart + requestLength;
                if (settings.clearCache) {
                    // API requested that the cache be cleared
                    ajax = true;
                    settings.clearCache = false;
                } else if (cacheLower < 0 || requestStart < cacheLower ||
                    requestEnd > cacheUpper) {
                    // outside cached data - need to make a request
                    ajax = true;
                } else if (JSON.stringify(request.order) !==
                    JSON.stringify(cacheLastRequest.order) ||
                    JSON.stringify(request.columns) !==
                    JSON.stringify(cacheLastRequest.columns) ||
                    JSON.stringify(request.search) !==
                    JSON.stringify(cacheLastRequest.search)
                ) {
                    // properties changed (ordering, columns, searching)
                    ajax = true;
                }
                // Store the request for checking next time around
                cacheLastRequest = $.extend(true, {}, request);
                if (ajax) {
                    // Need data from the server
                    if (requestStart < cacheLower) {
                        requestStart = requestStart -
                            (requestLength * (conf.pages - 1));
                        if (requestStart < 0) {
                            requestStart = 0;
                        }
                    }
                    cacheLower = requestStart;
                    cacheUpper = requestStart + (requestLength * conf.pages);
                    request.start = requestStart;
                    request.length = requestLength * conf.pages;
                    // Provide the same `data` options as DataTables.
                    if ($.isFunction(conf.data)) {
                        // As a function it is executed with the data object as an arg
                        // for manipulation. If an object is returned, it is used as the
                        // data object to submit
                        const d = conf.data(request);
                        if (d) {
                            $.extend(request, d);
                        }
                    } else if ($.isPlainObject(conf.data)) {
                        // As an object, the data given extends the default
                        $.extend(request, conf.data);
                    }
                    settings.jqXHR = $.ajax({
                        'type': conf.method,
                        'url': conf.url,
                        'data': request,
                        'dataType': 'json',
                        'cache': false,
                        'success': function(json) {
                            cacheLastJson = $.extend(true, {}, json);
                            if (cacheLower !== drawStart) {
                                json.data.splice(0, drawStart - cacheLower);
                            }
                            json.data.splice(requestLength, json.data.length);
                            drawCallback(json);
                        },
                    });
                } else {
                    let json = $.extend(true, {}, cacheLastJson);
                    json.draw = request.draw; // Update the echo for each response
                    json.data.splice(0, requestStart - cacheLower);
                    json.data.splice(requestLength, json.data.length);
                    drawCallback(json);
                }
            };
        };
        //Datatable clear Pipleline
        $.fn.dataTable.Api.register('clearPipeline()', function() {
            $.blockUI();
            return this.iterator('table', function(settings) {
                settings.clearCache = true;
            });
        });
        //Datatable default config
        $.extend(true, $.fn.dataTable.defaults, {
            'oLanguage': optionLang,
            // 'info': false,
            'lengthChange': false,
            'searching': false,
            'columnDefs': [
                {
                    'targets': [0, -1],
                    'searchable': false,
                    'orderable': false,
                    'visible': true,
                },
                // {className: "text-center", "targets": '_all'}
            ],
            'order': [],
            'iDisplayLength': 10,
            // "aLengthMenu": [
            //     [10, 15, 20, 50, -1],
            //     [10, 15, 20, 50, 'all']
            // ],
        });
    }
    //BlockUI
    if ($.isFunction($.blockUI)) {
        let message = lang === 'vi' ? 'Vui lòng đợi...' : 'Please wait...';
        //BlockUI default config
        $.extend(true, $.blockUI.defaults, {
            message: '<i class="fa fa-spinner fa-spin"></i> ' + message,
            css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: 0.5,
                color: '#fff',
            },
            baseZ: 9999,
        });
    }
    //Bootbox
    if (typeof bootbox === 'object') {
        //Bootbox default config
        bootbox.setDefaults({
            locale: lang,
            show: true,
            backdrop: true,
            closeButton: true,
            animate: true,
            className: 'my-modal',
        });
    }
    //Select2
    if ($.isFunction($.fn.select2)) {
        let placeholder = lang === 'vi' ? 'Chọn' : 'Choose';
        //Select2 default config
        $.extend(true, $.fn.select2.defaults.defaults, {
            width: '100%',
            allowClear: true,
            placeholder: placeholder,
        });
        $('.select').select2();
        //Select2 ajax plugin
        $.fn.select2Ajax = function(options) {
            let settings = {
                ajax: {
                    url: options.url,
                    dataType: 'json',
                    delay: 50,
                    data: function(params) {
                        if ($.isFunction(options.data)) {
                            let parameters = options.data(params);
                            return $.extend(params, parameters);
                        }
                        return {
                            query: params.term, // search term
                            page: params.page,
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 10) <= data.total_count,
                            },
                        };
                    },
                    cache: true,
                },
                escapeMarkup: function(markup) {
                    return markup;
                },
                minimumInputLength: options.hasOwnProperty('minimumInputLength')
                    ? options.minimumInputLength
                    : 0,
                templateResult: options.hasOwnProperty('templateResult')
                    ? options.templateResult
                    : function(repo) {
                        if (repo.loading) return repo.text;
                        let column = typeof options.column !== 'undefined'
                            ? options.column
                            : '';
                        if (column !== '' &&
                            typeof repo[column] !== 'undefined') {
                            return '<div class=\'select2-result-repository clearfix\'><div class=\'select2-result-repository__title\'>' +
                                repo[column] + '</div>';
                        } else {
                            if (typeof repo['name'] !== 'undefined') {
                                return '<div class=\'select2-result-repository clearfix\'><div class=\'select2-result-repository__title\'>' +
                                    repo['name'] + '</div>';
                            }
                            if (typeof repo['code'] !== 'undefined') {
                                return '<div class=\'select2-result-repository clearfix\'><div class=\'select2-result-repository__title\'>' +
                                    repo['code'] + '</div>';
                            }
                        }
                    },
                templateSelection: options.hasOwnProperty('templateSelection')
                    ? options.templateSelection
                    : function(repo) {
                        let column = typeof options.column !== 'undefined'
                            ? options.column
                            : '';
                        let val = repo.text;
                        if (column !== '' &&
                            typeof repo[column] !== 'undefined') {
                            val = repo[column];
                        } else {
                            if (typeof repo.name !== 'undefined') {
                                val = repo['name'];
                            }
                            if (typeof repo.code !== 'undefined') {
                                val = repo['code'];
                            }
                        }
                        return val;
                    },
            };
            return this.select2(settings);
        };
    }
    // Timepicker
    if ($.isFunction($.fn.timepicker)) {
        $.extend(true, $.fn.timepicker.defaults, {
            showMeridian: false,
            explicitMode: true,
            defaultTime: false,
        });
        $('.timepicker').timepicker();
    }
    // Datepicker
    if ($.isFunction($.fn.datepicker)) {
        //Datepicker default config
        $.extend(true, $.fn.datepicker.defaults, {
            format: 'dd-mm-yyyy',
            autoclose: true,
            orientation: 'bottom left',
            todayHighlight: true,
            language: 'vi',
        });
        $('.datepicker, .input-group.date').datepicker();
    }
    // Alphanum
    if ($.isFunction($.fn.alphanum)) {
        //input có class alphanum chỉ được nhập chữ và số
        $('.alphanum').alphanum({
            allow: '-_,./%#@()*',
        });
        $('.email, .username').alphanum({
            allow: '@.-_',
        });
        $('.address').alphanum({
            allow: '.,/-',
        });
        //input có class number chỉ được nhập số
        $('.number').numeric();
        //input có class string chỉ được nhập chữ
        $('.string').alpha();
    }
    //Notification
    if (typeof toastr === 'object') {
        $.fn.noti = function(options) {
            let opts = {
                'closeButton': true,
                'debug': false,
                'positionClass': 'toast-top-right',
                'newestOnTop': true,
                'onclick': null,
                'showDuration': '1000',
                'hideDuration': '1000',
                'timeOut': '5000',
                'extendedTimeOut': '1000',
                'showEasing': 'swing',
                'hideEasing': 'linear',
                'showMethod': 'fadeIn',
                'hideMethod': 'fadeOut',
            };
            if (options.type === 'success') {
                toastr.success(options.content, options.title, opts);
            } else if (options.type === 'error') {
                toastr.error(options.content, options.title, opts);
            } else if (options.type === 'warning') {
                toastr.warning(options.content, options.title, opts);
            }
        };
    }
    //Bt tooltip
    if ($.isFunction($.fn.bt)) {
        $.fn.tooltip = function(options) {
            let btConfig = {
                trigger: 'none',
                clickAnywhereToClose: false,
                positions: ['top'],
                fill: 'rgba(33, 33, 33, .8)',
                spikeLength: 10,
                spikeGirth: 10,
                cssStyles: {
                    color: '#FFF',
                    fontSize: '11px',
                    textAlign: 'justify',
                    width: 'auto',
                },
            };
            $(this).bt(options.message, btConfig).btOn();
        };
    }
    //Jquery mask
    if ($.isFunction($.fn.mask)) {
        $('.ip-mask').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
            translation: {
                'Z': {
                    pattern: /[0-9]/, optional: true,
                },
            },
            placeholder: '___.___.___.___',
        });
    }
    //Currency input
    if (typeof numeral !== 'undefined' && $.isFunction(numeral)) {
        //numeral($("#txt_username_a").val()).value() // unformat
        $(document).on('change', '.currency', function() {
            let val = $(this).val();
            $(this).val(numeral(val).format('0,0.0'));
        });
    }
    //event cho nút check all & single ở table
    $(document).on('click', '.cb-all', function() {
        let cbSingle = $('.cb-single');
        let tr = cbSingle.parents('tr');
        if (!$(this).is(':checked')) {
            cbSingle.prop('checked', '');
            tr.removeClass('selected');
        } else {
            cbSingle.prop('checked', 'checked');
            tr.addClass('selected');
        }
    });
    //event cho nút check từng dòng ở table
    $(document).on('click', '.cb-single', function() {
        let cbSingle = $('.cb-single');
        let tr = $(this).parents('tr');
        let cbAll = $('.cb-all');
        if ($(this).is(':checked')) {
            tr.addClass('selected');
            if (cbSingle.length === $('.cb-single:checked').length) {
                cbAll.prop('checked', 'checked');
            } else {
                cbAll.prop('checked', '');
            }
        } else {
            tr.removeClass('selected');
            cbAll.prop('checked', '');
        }
    });
    //UnblockUI moi khi ajax chạy xong
    $(document).ajaxComplete($.unblockUI);
    //Show noti error khi ajax lỗi
    $(document).ajaxError(function(event, request) {
        $.unblockUI();
        // let reponse = _.split($(request.responseText).text(), 'Stack trace')[0].replace(/\n|\r/g, "");
        // console.log(reponse.substring(50, reponse.length));
        // $('body').noti({
        //     type: 'error',
        //     // title: `(#${request.status}) ` + reponse.substring(50, reponse.length)
        //     title: request.status,
        // });
    });
    //event change cho input co class can validate
    $(document).on('change', '.email, .require, .password', function() {
        if (!$(this).hasClass('detail-input')) {
            let result = utils.validateElement($(this));
            utils.addClassValidate($(this), result.hasError, result.message);
        }
    });
    //Set select text cho thẻ input focus
    $('input, textarea').focus(function() {
        $(this).select();
    });
    //Stackable modal
    $(document).on('hidden.bs.modal', function() {
        if ($('.modal:visible').length) {
            $('body').addClass('modal-open');
        }
    });
    //Datatable scroll header on modal
    $(document).on('shown.bs.modal', '.modal', function() {
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
    });
})(jQuery, window);
let utils = (function() {
    return {
        goToUrl(modelId, url){
            $.blockUI();
            if (modelId === '') {
                location.href = url;
            }
            location.href = url + '/' + modelId;
        },
        showModal(params, url, modalId) {
            $.blockUI();
            return $.ajax({
                url: url,
                data: params,
                type: 'POST',
                success: result => {
                    modalId.find('.modal-content').html(result);
                    modalId.modal({
                        backdrop: 'static',   // This disable for click outside event
                        keyboard: true        // This for keyboard event
                    });
                },
            });
        },
        getValues(element) {
            // return $(element).map(function() { return $(this).val() }).get();
            return _.map($('.' + element), (elem) => {
                return $(elem).val();
            });
        },
        //FORM UTIL
        showErrorSummary(result, container) {
            let title = 'Please fix the following errors:';
            let lang = $('html').attr('lang');
            if (lang === 'vi') {
                title = 'Vui lòng sửa các lỗi sau đây:';
            }
            let summary = 'Error';
            try {
                summary = `<ul>`;
                if (typeof result === 'string') {
                    summary += `<li> ${result} </li>`;
                } else {
                    for (let property in result) {
                        if (result.hasOwnProperty(property)) {
                            summary += `<li> ${result[property]} </li>`;
                        }
                    }
                }
                summary += `</ul>`;
            } catch (e) {
                summary = 'Error';
            }
            $(container).
                find('#error_summary').
                find('.alert').
                remove().
                end().
                append(
                    `<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>${title}</strong> ${summary}</div>`);
            $('html, body').animate({scrollTop: 0}, 'fast');
        },
        addClassValidate(element, hasError, message){
            if (hasError) {
                if (element.is('select')) {
                    element.select2('open');
                    element.next().
                        find('.select2-selection__rendered').
                        tooltip({message: message});
                    element.next().
                        find('.select2-selection').
                        removeClass('success').
                        addClass('error');
                } else {
                    element.tooltip({message: message});
                    element.removeClass('success').addClass('error');
                }
                return false;
            } else {
                if (element.is('select')) {
                    element.next().find('.select2-selection__rendered').btOff();
                    element.next().
                        find('.select2-selection').
                        removeClass('error').
                        addClass('success');
                } else {
                    if (element.hasClass('error')) {
                        element.removeClass('error').addClass('success');
                        element.btOff();
                    }
                }
            }
        },
        validateElement(element) {
            let message = '', hasError = false;
            let eleVal = $.trim(element.val());
            let lang = $('html').attr('lang');
            if (element.hasClass('require')) {
                if (eleVal === '' || eleVal === null) {
                    message = lang === 'en'
                        ? 'Please enter value'
                        : 'Vui lòng nhập giá trị';
                    if (element.is('select')) {
                        message = lang === 'en'
                            ? 'Please choose value'
                            : 'Vui lòng chọn giá trị';
                    }
                    hasError = true;
                }
            }
            if (element.hasClass('email')) {
                if (eleVal.match(
                        /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/) ===
                    null) {
                    message = lang === 'en'
                        ? 'Invalid email'
                        : 'Email không hợp lệ';
                    hasError = true;
                }
            }
            if (element.hasClass('password') && eleVal.length > 0) {
                //Regular Expressions.
                let regex = [];
                regex.push('[A-Z]'); //Uppercase Alphabet.
                regex.push('[a-z]'); //Lowercase Alphabet.
                regex.push('[0-9]'); //Digit.
                regex.push('[!@#$%^&*()_+=?></.,`~]'); //Special Character.
                let passed = 0;
                //Validate for each Regular Expression.
                for (let i = 0; i < regex.length; i++) {
                    if (new RegExp(regex[i]).test(eleVal)) {
                        passed++;
                    }
                }
                //Validate for length of Password.
                if (passed > 2 && eleVal.length > 8) {
                    passed++;
                }
                if (passed < 2) {
                    message = lang === 'en' ? 'Weak password' : 'Mật khẩu yếu';
                    hasError = true;
                }
            }
            return {message: message, hasError: hasError};
        },
        validate(containerId, excludeContainer) {
            let error = true, self = this;
            let container = $('#' + containerId);
            container.find(
                `.form-control:not(${excludeContainer} .form-control)`).
                each(function() {
                    let result = self.validateElement($(this));
                    let message = result.message;
                    error = result.hasError;
                    self.addClassValidate($(this), result.hasError, message);
                });
            if (container.find(
                    `.error:not(${excludeContainer} .error)`).length > 0) {
                return false;
            }
            return error !== true;
        },
        deleteRow(self, message, table){
            let id = self.data('id');
            let url = self.data('url');
            self.parents('tr').addClass('danger');
            bootbox.confirm({
                size: 'small',
                message: message,
                callback: function(result) {
                    if (result) {
                        $.blockUI();
                        $.post(url, {id: id}, function(result) {
                            if (result === '1') {
                                $('body').noti({
                                    type: 'success',
                                    content: 'Success',
                                });
                                table.clearPipeline().draw(false);
                            } else {
                                $('body').noti({
                                    type: 'error',
                                    content: 'Fail',
                                });
                            }
                        });
                    }
                    self.parents('tr').removeClass('danger');
                },
            });
        },
        submitForm(url, formData) {
            $.blockUI();
            return $.ajax(
                {
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                }
            );
        },
    };
})();