/******/ (() => {
    // webpackBootstrap
    /******/ "use strict";
    /*!*****************************************************!*\
  !*** ../demo1/src/js/pages/custom/login/login-3.js ***!
  \*****************************************************/

    // Class Definition
    var KTLogin = (function () {
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

        var _handleFormSignin = function () {
            var form = KTUtil.getById("kt_login_singin_form");
            var formSubmitUrl = KTUtil.attr(form, "action");
            var formSubmitButton = KTUtil.getById(
                "kt_login_singin_form_submit_button"
            );

            if (!form) {
                return;
            }

            FormValidation.formValidation(form, {
                fields: {
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
                    KTUtil.btnWait(
                        formSubmitButton,
                        _buttonSpinnerClasses,
                        "Please wait",
                        true
                    );

                    var thisForm = document.getElementById(
                        "kt_login_singin_form"
                    );
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
                            if (data.type === "success") {
                                notify(
                                    "Success",
                                    "Logged in Successfully",
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
                                            notify(
                                                "Error",
                                                value2[0],
                                                "danger"
                                            );
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
                        "Sorry, looks like there are some<br> errors detected, please try again.",
                        "danger"
                    );
                });
        };

        var _handleFormForgot = function () {
            var form = KTUtil.getById("kt_login_forgot_form");
            var formSubmitUrl = KTUtil.attr(form, "action");
            var formSubmitButton = KTUtil.getById(
                "kt_login_forgot_form_submit_button"
            );

            if (!form) {
                return;
            }

            FormValidation.formValidation(form, {
                fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: "Email is required",
                            },
                            emailAddress: {
                                message:
                                    "The value is not a valid email address",
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
                        "Please wait"
                    );

                    // Simulate Ajax request
                    setTimeout(function () {
                        KTUtil.btnRelease(formSubmitButton);
                    }, 2000);
                })
                .on("core.form.invalid", function () {
                    Swal.fire({
                        text:
                            "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton:
                                "btn font-weight-bold btn-light-primary",
                        },
                    }).then(function () {
                        KTUtil.scrollTop();
                    });
                });
        };

        // Public Functions
        return {
            init: function () {
                _handleFormSignin();
                _handleFormForgot();
            },
        };
    })();

    // Class Initialization
    jQuery(document).ready(function () {
        KTLogin.init();
    });

    /******/
})();
//# sourceMappingURL=login-3.js.map
