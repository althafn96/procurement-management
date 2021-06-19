"use strict";

// Class Definition
var KTInvoice = (function () {

    var _handleInvoiceTable = function () {
        var table = $("#kt_datatable");

        if (table.length < 1) {
            return;
        }

        // begin first table
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
                { data: "invoice_no" },
                { data: "client" },
                { data: "date" },
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
                        var view_btn = "";

                        view_btn +=
                                `<a href="invoices/` + full.id + `" class="btn btn-sm btn-clean btn-icon mr-2" title="View Invoice">
                                            <span class="svg-icon svg-icon-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                                        <path d="M10.5857864,12 L5.46446609,6.87867966 C5.0739418,6.48815536 5.0739418,5.85499039 5.46446609,5.46446609 C5.85499039,5.0739418 6.48815536,5.0739418 6.87867966,5.46446609 L12,10.5857864 L18.1923882,4.39339828 C18.5829124,4.00287399 19.2160774,4.00287399 19.6066017,4.39339828 C19.997126,4.78392257 19.997126,5.41708755 19.6066017,5.80761184 L13.4142136,12 L19.6066017,18.1923882 C19.997126,18.5829124 19.997126,19.2160774 19.6066017,19.6066017 C19.2160774,19.997126 18.5829124,19.997126 18.1923882,19.6066017 L12,13.4142136 L6.87867966,18.5355339 C6.48815536,18.9260582 5.85499039,18.9260582 5.46446609,18.5355339 C5.0739418,18.1450096 5.0739418,17.5118446 5.46446609,17.1213203 L10.5857864,12 Z" fill="#000000" opacity="0.3" transform="translate(12.535534, 12.000000) rotate(-360.000000) translate(-12.535534, -12.000000) "/>
                                                        <path d="M6,18 L9,18 C9.66666667,18.1143819 10,18.4477153 10,19 C10,19.5522847 9.66666667,19.8856181 9,20 L4,20 L4,15 C4,14.3333333 4.33333333,14 5,14 C5.66666667,14 6,14.3333333 6,15 L6,18 Z M18,18 L18,15 C18.1143819,14.3333333 18.4477153,14 19,14 C19.5522847,14 19.8856181,14.3333333 20,15 L20,20 L15,20 C14.3333333,20 14,19.6666667 14,19 C14,18.3333333 14.3333333,18 15,18 L18,18 Z M18,6 L15,6 C14.3333333,5.88561808 14,5.55228475 14,5 C14,4.44771525 14.3333333,4.11438192 15,4 L20,4 L20,9 C20,9.66666667 19.6666667,10 19,10 C18.3333333,10 18,9.66666667 18,9 L18,6 Z M6,6 L6,9 C5.88561808,9.66666667 5.55228475,10 5,10 C4.44771525,10 4.11438192,9.66666667 4,9 L4,4 L9,4 C9.66666667,4 10,4.33333333 10,5 C10,5.66666667 9.66666667,6 9,6 L6,6 Z" fill="#000000" fill-rule="nonzero"/>
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                        `;

                        return view_btn;
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
                    api.columns(2).visible(false);
                }
            },
        });
    };

    // Public Functions
    return {
        init: function () {
            _handleInvoiceTable();
        },
    };
})();

// Class Initialization
jQuery(document).ready(function () {
    KTInvoice.init();
});
