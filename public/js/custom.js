 "use strict";
$(document).ready(function () {

    select2();
    datatable();
    ckediter();
    setInterval(() => {
        feather.replace();
    }, 1000);
});

$(document).on("click", ".customModal", function () {

    var modalTitle = $(this).data("title");
    var modalUrl = $(this).data("url");
    var modalSize = $(this).data("size") == "" ? "md" : $(this).data("size");
    $("#customModal .modal-title").html(modalTitle);
    $("#customModal .modal-dialog").addClass("modal-" + modalSize);
    $.ajax({
        url: modalUrl,
        success: function (result) {
            if (result.status == "error") {
                notifier.show(
                    "Error!",
                    result.messages,
                    "error",
                    errorImg,
                    4000
                );
            } else {
                $("#customModal .body").html(result);
                $("#customModal").modal("show");
                select2();
                ckediter();
            }
        },
        error: function (result) {},
    });
});

// basic message
$(document).on("click", ".confirm_dialog", function (e) {

    var title = $(this).attr("data-dialog-title");
    if (title == undefined) {
        var title = "Are you sure you want to delete this record ?";
    }
    var text = $(this).attr("data-dialog-text");
    if (text == undefined) {
        var text = "This record can not be restore after delete. Do you want to confirm?";
    }
    var dialogForm = $(this).closest("form");
    Swal.fire({
        title: title,
        text: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((data) => {
        if (data.isConfirmed) {
            dialogForm.submit();
        }
    });
});

// common
$(document).on("click", ".common_confirm_dialog", function (e) {

    var dialogForm = $(this).closest("form");
    var actions = $(this).data("actions");
    Swal.fire({
        title: "Are you sure you want to delete " + actions + " ?",
        text: "This " +
            actions +
            " can not be restore after delete. Do you want to confirm?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((data) => {
        if (data.isConfirmed) {
            dialogForm.submit();
        }
    });
});

$(document).on("click", ".fc-day-grid-event", function (e) {

    e.preventDefault();
    var event = $(this);
    var modalTitle = $(this).find(".fc-content .fc-title").html();
    var modalSize = "md";
    var modalUrl = $(this).attr("href");
    $("#customModal .modal-title").html(modalTitle);
    $("#customModal .modal-dialog").addClass("modal-" + modalSize);
    $.ajax({
        url: modalUrl,
        success: function (result) {
            $("#customModal .modal-body").html(result);
            $("#customModal").modal("show");
        },
        error: function (result) {},
    });
});

// Track last notification to prevent duplicates
var lastNotification = {
    title: '',
    message: '',
    timestamp: 0
};

function toastrs(title, message, status) {
    // Ensure message is a string and not an object
    if (typeof message !== 'string') {
        if (message && typeof message === 'object') {
            // If it's an object, try to extract a meaningful message
            if (message.message) {
                message = message.message;
            } else if (message.msg) {
                message = message.msg;
            } else if (Array.isArray(message) && message.length > 0) {
                message = message[0];
            } else {
                message = 'An error occurred';
            }
        } else {
            message = String(message || 'An error occurred');
        }
    }

    // Ensure message is not empty
    if (!message || message.trim() === '') {
        message = 'An error occurred';
    }

    // Normalize title
    var normalizedTitle = (title === "Success" || title === "Success!") ? "Success!" : "Error!";
    var normalizedMessage = message.trim();

    // Prevent duplicate notifications within 1 second
    var now = Date.now();
    if (lastNotification.title === normalizedTitle && 
        lastNotification.message === normalizedMessage && 
        (now - lastNotification.timestamp) < 1000) {
        return; // Skip duplicate notification
    }

    // Clear existing notifications of the same type before showing new one
    var existingNotifications = document.querySelectorAll('.notifier');
    if (existingNotifications.length > 0) {
        existingNotifications.forEach(function(notif) {
            // Remove notifications with same title and message
            var notifTitle = notif.querySelector('.notifier-title');
            var notifBody = notif.querySelector('.notifier-body');
            if (notifTitle && notifBody) {
                if (notifTitle.textContent.trim() === normalizedTitle && 
                    notifBody.textContent.trim() === normalizedMessage) {
                    notif.remove();
                }
            }
        });
    }

    // Update last notification
    lastNotification = {
        title: normalizedTitle,
        message: normalizedMessage,
        timestamp: now
    };

    if (status == "success" || status === "Success") {
        notifier.show("Success!", normalizedMessage, "success", successImg, 4000);
    } else {
        // Use proper error title and type
        notifier.show("Error!", normalizedMessage, "error", errorImg, 4000);
    }
}

function convertArrayToJson(form) {

    var data = $(form).serializeArray();
    var indexed_array = {};

    $.map(data, function (n, i) {
        indexed_array[n["name"]] = n["value"];
    });

    return indexed_array;
}

function select2() {

    if ($(".basic-select").length > 0) {
        $(".basic-select").each(function () {
            var basic_select = new Choices(this, {
                searchEnabled: false,
                removeItemButton: false,

            });
        });
    }

    if ($(".hidesearch").length > 0) {
        $(".hidesearch").each(function () {
            var basic_select = new Choices(this, {
                searchEnabled: false,
                removeItemButton: true,

            });
        });
    }
}

function ckediter(editer_id = "") {

    if (editer_id == "") {
        editer_id = "#classic-editor";
    }
    if ($(editer_id).length > 0) {
        ClassicEditor.create(document.querySelector(editer_id), {
                // Add configuration options here

            })
            .then((editor) => {
                // Set the minimum height directly // editor.ui.view.editable.element.style.minHeight = '300px';
            })
            .catch((error) => {
                console.error(error);
            });
    }
}

function datatable() {


    if ($(".basic-datatable").length > 0) {
        $(".basic-datatable").DataTable({
            scrollX: true,
            dom: "Bfrtip",
            buttons: ["copy", "csv", "excel", "print"],
        });
    }

    if ($(".advance-datatable").length > 0) {
        $(".advance-datatable").DataTable({
            scrollX: true,
            ordering: false,
            stateSave: false,
            dom: "Bfrtip",
            buttons: [{
                    extend: "excelHtml5",
                    exportOptions: {
                        columns: ":visible",
                    },
                },
                {
                    extend: "pdfHtml5",
                    exportOptions: {
                        columns: ":visible",
                    },
                },
                {
                    extend: "copyHtml5",
                    exportOptions: {
                        columns: ":visible",
                    },
                },

                "colvis",
            ],
        });
    }
}
