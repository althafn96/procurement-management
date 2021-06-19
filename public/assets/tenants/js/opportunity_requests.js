"use strict";

// Class Definition
var KTOpportunityRequest = (function () {
    var _buttonSpinnerClasses = "spinner spinner-right spinner-white pr-15";

    function notify(title, message, type) {
        $.notify(
            {
                title: title,
                message: message,
            },
            {
                type: type,
                allow_dismiss: true,
                newest_on_top: true,
                mouse_over: true,
                showProgressbar: false,
                spacing: 10,
                timer: 2000,
                placement: {
                    from: "top",
                    align: "right",
                },
                offset: {
                    x: 30,
                    y: 30,
                },
                delay: 1000,
                z_index: 10000,
                animate: {
                    enter: "animate__animated animate__fadeIn",
                    exit: "animate__animated animate__fadeOut",
                },
            }
        );
    }

    var _handleOpportunityRequestSubmit = function () {
        var form = KTUtil.getById("kt_opportunity_request_add_form");
        var formSubmitUrl = KTUtil.attr(form, "action");
        var formSubmitButton = KTUtil.getById("kt_opportunity_request_add_btn");

        if (!form) {
            return;
        }

        FormValidation.formValidation(form, {
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: "Title is required",
                        },
                    },
                },
                category_id: {
                    validators: {
                        notEmpty: {
                            message: "Category is required",
                        },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                bootstrap: new FormValidation.plugins.Bootstrap({
                    //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                    //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                }),
            },
        })
            .on("core.form.valid", function () {
                // Show loading state on button
                KTUtil.btnWait(
                    formSubmitButton,
                    _buttonSpinnerClasses,
                    "Please wait",
                    true
                );

                var thisForm = document.getElementById("kt_opportunity_request_add_form");
                $.ajax({
                    url: formSubmitUrl,
                    method: "POST",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    data: new FormData(thisForm),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.type == "success") {
                            notify(
                                "Success",
                                "Opportunity request added successfully",
                                "success"
                            );

                            setTimeout(function () {
                                location.href = data.url;
                            }, 1000);
                        } else {
                            notify(
                                "Error",
                                "Unknown error occurred. Please try again later.",
                                "danger"
                            );

                            KTUtil.btnRelease(formSubmitButton);
                        }
                    },
                    error: function (data) {
                        if (data.status == 422) {
                            var errors = JSON.parse(data.responseText);

                            $.each(errors, function (key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function (key2, value2) {
                                        notify("Error", value2[0], "danger");
                                    });
                                }
                            });
                        } else if (data.status == 403) {
                            var errors = JSON.parse(data.responseText);

                            notify(
                                "Error",
                                "You don't have neccessary permissions<br> to perform this action",
                                "danger"
                            );
                        } else if (data.status == 419) {

                            notify(
                                "Error",
                                data.responseJSON.message,
                                "danger"
                            );
                        } else {
                            notify(
                                "Error",
                                "Unknown error occurred. Please try again later.",
                                "danger"
                            );
                        }

                        KTUtil.btnRelease(formSubmitButton);
                    },
                });
            })
            .on("core.form.invalid", function () {
                notify(
                    "Error",
                    "Sorry, looks like there are some <br/> errors detected, please try again.",
                    "danger"
                );

                KTUtil.scrollTop();
            });
    };

    var _handleOpportunityRequestUpdate = function () {
        var form = KTUtil.getById("kt_opportunity_request_update_form");
        var formSubmitUrl = KTUtil.attr(form, "action");
        var formSubmitButton = KTUtil.getById("kt_opportunity_request_update_btn");

        if (!form) {
            return;
        }

        FormValidation.formValidation(form, {
            fields: {
                title: {
                    validators: {
                        notEmpty: {
                            message: "Title is required",
                        },
                    },
                },
                category_id: {
                    validators: {
                        notEmpty: {
                            message: "Category is required",
                        },
                    },
                }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                bootstrap: new FormValidation.plugins.Bootstrap({
                    //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                    //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                }),
            },
        })
            .on("core.form.valid", function () {
                // Show loading state on button
                KTUtil.btnWait(
                    formSubmitButton,
                    _buttonSpinnerClasses,
                    "Please wait",
                    true
                );

                var thisForm = document.getElementById("kt_opportunity_request_update_form");
                $.ajax({
                    url: formSubmitUrl,
                    method: "POST",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    data: new FormData(thisForm),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.type == "success") {
                            notify(
                                "Success",
                                "Opportunity request updated successfully",
                                "success"
                            );

                            KTUtil.btnRelease(formSubmitButton);
                        } else {
                            notify(
                                "Error",
                                "Unknown error occurred. Please try again later.",
                                "danger"
                            );

                            KTUtil.btnRelease(formSubmitButton);
                        }
                    },
                    error: function (data) {
                        if (data.status == 422) {
                            var errors = JSON.parse(data.responseText);

                            $.each(errors, function (key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function (key2, value2) {
                                        notify("Error", value2[0], "danger");
                                    });
                                }
                            });
                        } else if (data.status == 403) {
                            var errors = JSON.parse(data.responseText);

                            notify(
                                "Error",
                                "You don't have neccessary permissions<br> to perform this action",
                                "danger"
                            );
                        } else if (data.status == 419) {

                            notify(
                                "Error",
                                data.responseJSON.message,
                                "danger"
                            );
                        }  else {
                            notify(
                                "Error",
                                "Unknown error occurred. Please try again later.",
                                "danger"
                            );
                        }

                        KTUtil.btnRelease(formSubmitButton);
                    },
                });
            })
            .on("core.form.invalid", function () {
                notify(
                    "Error",
                    "Sorry, looks like there are some <br/> errors detected, please try again.",
                    "danger"
                );

                KTUtil.scrollTop();
            });
    };

    var _handleOpportunityRequestRemove = function () {
        $("#kt_datatable").on("click", ".remove-btn", function () {
            var id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "This will remove the Opportunity request and related data",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
                showLoaderOnConfirm: true,
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-default",
                },
                preConfirm: () => {
                    return fetch(`opportunity-requests/${id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                    })
                        .then((response) => {
                            if (response.status == 200) {
                                notify(
                                    "Success",
                                    "Opportunity request removed successfully",
                                    "success"
                                );

                                $("#kt_datatable")
                                    .DataTable()
                                    .ajax.reload(null, false);
                            } else if (response.status == 409) {

                                notify(
                                    "Error",
                                    'this opportunity request cannot be removed',
                                    "danger"
                                );

                            } else {
                                notify(
                                    "Error",
                                    "Unknown error occurred. Please try again later.",
                                    "danger"
                                );
                            }
                        })
                        .catch((error) => {
                            if (error.status == 403) {
                                notify(
                                    "Error",
                                    "You don't have neccessary permissions<br> to perform this action",
                                    "danger"
                                );
                            } else {
                                notify(
                                    "Error",
                                    "Unknown error occurred. Please try again later.",
                                    "danger"
                                );
                            }
                        });
                },
            });
        });
    };

    var _handleOpportunityRequestTable = function () {
        var table = $("#kt_datatable");

        if (table.length < 1) {
            return;
        }

        table.DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: table.data("url"),
                type: "GET",
            },
            order: [[0, "DESC"]],
            columns: [
                { data: "id" },
                { data: "title" },
                { data: "category" },
                { data: "status" },
                { data: "customer" },
                { data: "estimated_budget" },
                { data: "current_value" },
                { data: "savings" },
                { data: "supplier" },
                { data: "description", className: "none" },
                { data: "contract_start_date", className: "none" },
                { data: "contract_end_date", className: "none" },
                { data: "action", responsivePriority: -1 },
            ],
            columnDefs: [
                {
                    targets: 0,
                    render: function(data, type, full) {
                        return `#${full.id}`;
                    },
                },
                {
                    targets: 1,
                    width: "250px",
                },
                {
                    targets: -1,
                    title: "Actions",
                    width: "150px",
                    orderable: false,
                    render: function (data, type, full, meta) {
                        var edit_btn = "";
                        var remove_btn = "";
                        var add_to_project_btn = "";

                        if(full.status == 'Pending') {
                            if ($("#kt_datatable").data("acceptorreject")) {
                                add_to_project_btn = `
                                    <a
                                        data-id="`+full.id+`"
                                        data-title="`+full.title+`"
                                        data-description="`+full.description+`"
                                        data-estimated_budget="`+full.estimated_budget+`"
                                        data-supplier_id="`+full.supplier_id+`"
                                        data-contract_start_date="`+full.contract_start_date+`"
                                        data-contract_end_date="`+full.contract_end_date+`"
                                        data-category_id="`+full.category_id+`"
                                        class="btn btn-sm btn-clean btn-icon mr-2 change-status-btn" title="Update Status">
                                        <span class="svg-icon svg-icon-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"/>
                                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                                    <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                `;
                            }
                            if ($("#kt_datatable").data("edit")) {
                                edit_btn +=
                                    `<a href="opportunity-requests/` +
                                    full.id +
                                    `/edit" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit Opportunity Request">
                                                <span class="svg-icon svg-icon-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "></path>
                                                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"></rect>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </a>
                                            `;
                            }
                            if ($("#kt_datatable").data("remove")) {
                                remove_btn +=
                                    ` <a data-id="` +
                                    full.id +
                                    `" href="javascript:;" class="btn btn-sm btn-clean btn-icon remove-btn" title="Remove Opportunity Request">
                                                    <span class="svg-icon svg-icon-md">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                </a>
                                            `;
                            }
                        }

                        return add_to_project_btn + edit_btn + remove_btn;
                    },
                },
                {
                    width: "75px",
                    targets: 3,
                    render: function (data, type, full, meta) {
                        var status = {
                            'Accepted': {
                                title: "Accepted",
                                class: "label-light-success",
                            },
                            'Rejected': {
                                title: "Rejected",
                                class: "label-light-danger",
                            },
                            'Pending': {
                                title: "Pending",
                                class: " label-light-warning",
                            },
                        };
                        if (typeof status[data] === "undefined") {
                            return data;
                        }

                        return (
                            '<span class="status-badge label label-lg font-weight-bold ' +
                            status[data].class +
                            ' label-inline">' +
                            status[data].title +
                            "</span>"
                        );
                    },
                },
            ],
            drawCallback: function (settings) {
                var api = this.api();
                var $table = $(api.table().node());

                if (
                    $("#kt_datatable").data("edit") == "" &&
                    $("#kt_datatable").data("remove") == ""
                ) {
                    api.columns(-1).visible(false);
                }
            },
        });
    };

    var _handleAddNewSupplierClick = function() {
        $('body').on('change', '#supplier_id', function() {

            if($(this).val() == 'addnewsupplier') {
                $('#supplier_id').val('').trigger('change')

                $('#supplierAddModal').modal({
                    'static': 'backdrop',
                    'keyboard': false
                })
            }
        })
    }

    var _handleShowRequestRecieveModal = function() {
        $('body').on('click', '.change-status-btn', function() {
            $('#requestReceiveLabel').text($(this).data('title'));
            $('input[name="request_id"]').val($(this).data('id'));
            $('input[name="title"]').val($(this).data('title'));
            $('textarea[name="description"]').text($(this).data('description'));
            $('input[name="estimated_budget"]').val($(this).data('estimated_budget'));
            $('select[name="supplier_id"]').val($(this).data('supplier_id')).trigger('change');
            $('input[name="contract_start_date"]').val($(this).data('contract_start_date'));
            $('input[name="contract_end_date"]').val($(this).data('contract_end_date'));
            $('select[name="category_id"]').val($(this).data('category_id')).trigger('change');
            $('#requestReceive').modal({
                backdrop: 'static',
                keyboard: false
            });
        })
    }

    var _handleChangeOfStatusInForm = function() {
        $('body').on('change', 'select[name="status"]', function() {
            if($(this).val() == 'Accepted') {
                $('.assigning_user_field').css('display', '');
                $('#kt_project_add_btn').text('Add to Project');
            } else {
                $('.assigning_user_field').css('display', 'none');
                $('#kt_project_add_btn').text('Update Status');
            }
        })

        $('body').on('submit', '#kt_project_add_form', function(e) {
            e.preventDefault();

        })
    }

    var _handleAddToProjectBtn = function() {
        var form = KTUtil.getById("kt_project_add_form");
        var formSubmitUrl = KTUtil.attr(form, "action");
        var formSubmitButton = KTUtil.getById("kt_project_add_btn");

        if (!form) {
            return;
        }

        FormValidation.formValidation(form, {
            fields: {
                status: {
                    validators: {
                        notEmpty: {
                            message: "Status is required",
                        },
                    },
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                submitButton: new FormValidation.plugins.SubmitButton(),
                //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                bootstrap: new FormValidation.plugins.Bootstrap({
                    //	eleInvalidClass: '', // Repace with uncomment to hide bootstrap validation icons
                    //	eleValidClass: '',   // Repace with uncomment to hide bootstrap validation icons
                }),
            },
        })
            .on("core.form.valid", function () {
                // Show loading state on button
                KTUtil.btnWait(
                    formSubmitButton,
                    _buttonSpinnerClasses,
                    "Please wait",
                    true
                );

                var thisForm = document.getElementById("kt_project_add_form");

                $.ajax({
                    url: formSubmitUrl,
                    method: "POST",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    data: new FormData(thisForm),
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if (data.type == "success") {
                            notify(
                                "Success",
                                data.msg,
                                "success"
                            );

                            KTUtil.btnRelease(formSubmitButton);
                            $('#requestReceive').modal('toggle');

                            $("#kt_datatable")
                                .DataTable()
                                .ajax.reload(null, false);
                        } else {
                            notify(
                                "Error",
                                data.text,
                                "danger"
                            );

                            KTUtil.btnRelease(formSubmitButton);
                        }
                    },
                    error: function (data) {
                        if (data.status == 422) {
                            var errors = JSON.parse(data.responseText);

                            $.each(errors, function (key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function (key2, value2) {
                                        notify("Error", value2[0], "danger");
                                    });
                                }
                            });
                        } else if (data.status == 403) {
                            var errors = JSON.parse(data.responseText);

                            notify(
                                "Error",
                                "You don't have neccessary permissions<br> to perform this action",
                                "danger"
                            );
                        } else if (data.status == 419) {

                            notify(
                                "Error",
                                data.responseJSON.message,
                                "danger"
                            );
                        } else {
                            notify(
                                "Error",
                                "Unknown error occurred. Please try again later.",
                                "danger"
                            );
                        }

                        KTUtil.btnRelease(formSubmitButton);
                    },
                });
            })
            .on("core.form.invalid", function () {
                notify(
                    "Error",
                    "Sorry, looks like there are some <br/> errors detected, please try again.",
                    "danger"
                );

                KTUtil.scrollTop();
            });
    }

    // Public Functions
    return {
        init: function () {
            _handleOpportunityRequestSubmit();
            _handleOpportunityRequestUpdate();
            _handleOpportunityRequestRemove();
            _handleOpportunityRequestTable();
            _handleAddNewSupplierClick();
            _handleShowRequestRecieveModal();
            _handleChangeOfStatusInForm();
            _handleAddToProjectBtn();
        },
    };
})();

// Class Initialization
jQuery(document).ready(function () {
    KTOpportunityRequest.init();

    $(".kt-selectpicker").selectpicker({
        liveSearch: true
    });
    $(".kt-datepicker").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    });
    $('.assigning_user_field').css('display', 'none');
});
