"use strict";

// Class Definition
var KTStaff = (function () {
    var _buttonSpinnerClasses = "spinner spinner-right spinner-white pr-15";
	var _avatar;

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

    var _handleStaffSubmit = function () {
        var form = KTUtil.getById("kt_staff_add_form");
        var formSubmitUrl = KTUtil.attr(form, "action");
        var formSubmitButton = KTUtil.getById("kt_staff_add_btn");

        if (!form) {
            return;
        }

        FormValidation.formValidation(form, {
            fields: {
                role_id: {
                    validators: {
                        notEmpty: {
                            message: "User role is required",
                        },
                    },
                },
                first_name: {
                    validators: {
                        notEmpty: {
                            message: "First name is required",
                        },
                    },
                },
                last_name: {
                    validators: {
                        notEmpty: {
                            message: "Last name is required",
                        },
                    },
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: "Email is required",
                        },
                        emailAddress: {
                            message: "Invalid email address",
                        },
                    },
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: "Password is required",
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

                var thisForm = document.getElementById("kt_staff_add_form");
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
                                "Staff added successfully",
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

    var _handleStaffUpdate = function () {
        var form = KTUtil.getById("kt_staff_update_form");
        var formSubmitUrl = KTUtil.attr(form, "action");
        var formSubmitButton = KTUtil.getById("kt_staff_update_btn");

        if (!form) {
            return;
        }

        FormValidation.formValidation(form, {
            fields: {
                role_id: {
                    validators: {
                        notEmpty: {
                            message: "User role is required",
                        },
                    },
                },
                first_name: {
                    validators: {
                        notEmpty: {
                            message: "First name is required",
                        },
                    },
                },
                last_name: {
                    validators: {
                        notEmpty: {
                            message: "Last name is required",
                        },
                    },
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: "Email is required",
                        },
                        emailAddress: {
                            message: "Invalid email address",
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

                var thisForm = document.getElementById("kt_staff_update_form");
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
                                "Staff updated successfully",
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

    var _handleStaffRemove = function () {
        $("#kt_datatable").on("click", ".remove-btn", function () {
            var id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "This will remove the Staff and related data",
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
                    return fetch(`staff/${id}`, {
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
                                    "Staff removed successfully",
                                    "success"
                                );

                                $("#kt_datatable")
                                    .DataTable()
                                    .ajax.reload(null, false);
                            } else {
                                notify(
                                    "Error",
                                    "Unknown error occurred. Please try again later.",
                                    "danger"
                                );
                            }
                        })
                        .catch((error) => {
                            if (response.status == 403) {
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

    var _handleStaffTable = function () {
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
                { data: "name" },
                { data: "role" },
                { data: "status" },
                { data: "action", responsivePriority: -1 },
            ],
            columnDefs: [
                {
                    targets: 0,
                    visible: false,
                },
                {
                    targets: -1,
                    title: "Actions",
                    width: "120px",
                    orderable: false,
                    render: function (data, type, full, meta) {
                        var edit_btn = "";
                        var remove_btn = "";

                        if ($("#kt_datatable").data("edit")) {
                            edit_btn +=
                                `<a href="staff/` +
                                full.id +
                                `/edit" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit Staff">
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
                                `" href="javascript:;" class="btn btn-sm btn-clean btn-icon remove-btn" title="Remove Staff">
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

                        if ($("#kt_datatable").data("id") == full.id)  {
                            remove_btn = '';
                        }

                        return edit_btn + remove_btn;
                    },
                },
                {
                    width: "75px",
                    targets: -2,
                    render: function (data, type, full, meta) {
                        var status = {
                            1: {
                                title: "Enabled",
                                class: "label-light-success",
                            },
                            0: {
                                title: "Disabled",
                                class: " label-light-danger",
                            },
                        };
                        if (typeof status[data] === "undefined") {
                            return data;
                        }
                        return (
                            '<span data-status="' +
                            full.status +
                            '" data-id="' +
                            full.id +
                            '" class="status-badge label label-lg font-weight-bold ' +
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

    var _handleLoadPermissions = function () {
        $(".kt-selectpicker").on("change", function () {
            if ($(this).val() != "") {
                KTApp.block(".card-body");

                $.ajax({
                    url: `${$(this).val()}/load-permissions-to-role`,
                    method: "GET",
                    dataType: "html",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (data) {
                        $("#permissions_list").html(
                            '<h3 class="text-dark font-weight-bold mb-10">User Permissions:</h3>'
                        );
                        $("#permissions_list").append(data);
                        KTApp.unblock(".card-body");
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
                        } else {
                            notify(
                                "Error",
                                "Unknown error occurred. Please try again later.",
                                "danger"
                            );
                        }
                        KTApp.unblock(".card-body");
                    },
                });

                $(".permissions-section").removeClass("d-none");
            } else {
                $(".permissions-section").addClass("d-none");
            }
        });
    };

    var _handleStatusToggle = function () {
        $("#kt_datatable").on("click", ".status-badge", function () {

            if ($("#kt_datatable").data("id") != $(this).data("id"))  {
                var id = $(this).data("id");
                var status = $(this).data("status");

                if (status == "1") {
                    var action = "disable";
                    var req_status = "0";
                } else {
                    var action = "enable";
                    var req_status = "1";
                }

                var data = new FormData();
                data.append("table", "users");
                data.append("status", req_status);

                Swal.fire({
                    title: "Are you sure?",
                    text: `This will ${action} the staff`,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: `Yes, Confirm!`,
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true,
                    showLoaderOnConfirm: true,
                    customClass: {
                        confirmButton: "btn btn-danger",
                        cancelButton: "btn btn-default",
                    },
                    preConfirm: () => {
                        return fetch(`toggle-status/${id}`, {
                            method: "POST",
                            body: data,
                            dataType: "json",
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                        })
                            .then((response) => {
                                if (response.status == 200) {
                                    if (status == "1") {
                                        var status_txt = "disabled";
                                    } else {
                                        var status_txt = "enabled";
                                    }
                                    notify(
                                        "Success",
                                        `Staff ${status_txt} successfully`,
                                        "success"
                                    );

                                    $("#kt_datatable")
                                        .DataTable()
                                        .ajax.reload(null, false);
                                } else {
                                    notify(
                                        "Error",
                                        "Unknown error occurred. Please try again later.",
                                        "danger"
                                    );
                                }
                            })
                            .catch((error) => {
                                if (response.status == 403) {
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
            }
        });
    };

	var _initAvatar = function () {
		_avatar = new KTImageInput('kt_staff_add_avatar');
	}

    // Public Functions
    return {
        init: function () {
            _handleStaffSubmit();
            _handleStaffUpdate();
            _handleStaffRemove();
            _handleStaffTable();
            _handleLoadPermissions();
            _handleStatusToggle();
			_initAvatar();
        },
    };
})();

// Class Initialization
jQuery(document).ready(function () {
    KTStaff.init();

    $(".kt-selectpicker").selectpicker();
});
