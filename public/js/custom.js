function BootEditor() {

}
$(document).ready(function () {

    if ($('textarea.editorme').length) {



        $('textarea.editorme').summernote({

            "height": 200

        });
    }



});


$(function () {
    if ($("#kt_stepper_example_basic").length > 0) {
        // Stepper lement
        var element = document.querySelector("#kt_stepper_example_basic");

        // Initialize Stepper
        var stepper = new KTStepper(element);

        // Handle next step
        stepper.on("kt.stepper.next", function (stepper) {
            stepper.goNext(); // go next step
        });

        // Handle previous step
        stepper.on("kt.stepper.previous", function (stepper) {
            stepper.goPrevious(); // go previous step
        });
    }

    $(document).on("click", ".deleteConfirm", function () {
        var route = $(this).data("route");
        var msg = $(this).data("msg");

        Swal.fire({
            title: "Are you sure?",
            text: msg,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = route;
            }
        });
    });

    $(".mytable").DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        pageLength: 15,
        ordering: true,
        info: true,
        autoWidth: true,
        responsive: true,
        dom: "Bfrtip",

        buttons: ["excel"],
    });

    $(".tox-statusbar__branding").hide();

    setInterval(function () {
        $(".paginate_button").addClass("bg-dark text-light shadow-lg");
    }, 1000);
});

/***Plugins  INtOnly INput*/

(function (a) {
    a.fn.extend({
        inputNumberFormat: function (c) {
            this.defaultOptions = {
                decimal: 2,
                decimalAuto: 2,
                separator: ".",
                separatorAuthorized: [".", ","],
                allowNegative: false,
            };
            var e = a.extend({}, this.defaultOptions, c);
            var d = function (i, f) {
                var h = [];



                var g = "^[0-9]+";
                if (f.allowNegative) {
                    g = "^-{0,1}[0-9]*";
                }
                if (f.decimal) {
                    g +=
                        "[" +
                        f.separatorAuthorized.join("") +
                        "]?[0-9]{0," +
                        f.decimal +
                        "}";
                    g = new RegExp(g + "$");
                    h = i.match(g);
                    if (!h) {
                        g =
                            "^[" +
                            f.separatorAuthorized.join("") +
                            "][0-9]{0," +
                            f.decimal +
                            "}";
                        g = new RegExp(g + "$");
                        h = i.match(g);
                    }
                } else {
                    g = new RegExp(g + "$");
                    h = i.match(g);
                }
                return h;
            };
            var b = function (k, f) {
                var j = k;
                if (!j) {
                    return j;
                }
                if (j == "-") {
                    return "";
                }
                j = j.replace(",", f.separator);
                if (f.decimal && f.decimalAuto) {
                    j =
                        Math.round(j * Math.pow(10, f.decimal)) /
                        Math.pow(10, f.decimal) +
                        "";
                    if (j.indexOf(f.separator) === -1) {
                        j += f.separator;
                    }
                    var h = f.decimalAuto - j.split(f.separator)[1].length;
                    for (var g = 1; g <= h; g++) {
                        j += "0";
                    }
                }
                return j;
            };
            return this.each(function () {
                var f = a(this);
                f.on("keypress", function (j) {
                    if (j.ctrlKey) {
                        return;
                    }
                    if (j.key.length > 1) {
                        return;
                    }
                    var i = a.extend({}, e, a(this).data());
                    var g = a(this).val().substr(0, j.target.selectionStart);
                    var h = a(this)
                        .val()
                        .substr(
                            j.target.selectionEnd,
                            a(this).val().length - 1
                        );
                    var k = g + j.key + h;
                    if (!d(k, i)) {
                        j.preventDefault();
                        return;
                    }
                });
                f.on("blur", function (h) {
                    var g = a.extend({}, e, a(this).data());
                    a(this).val(b(a(this).val(), g));
                });
                f.on("change", function (h) {
                    var g = a.extend({}, e, a(this).data());
                    a(this).val(b(a(this).val(), g));
                });
            });
        },
    });
})(jQuery);
/***Plugins */

$(function () {
    $("a[href='#']").on("click", function (e) {
        e.preventDefault();
    });

    $("input[type='search']").removeClass("form-control-solid");

    $(".table").addClass("table-bordered");

    if ($("#inputMonthlySalary").length > 0) {
        $("#inputMonthlySalary").inputNumberFormat();

        $("#labelMonthlySalary").html("Monthly salary (UGX)");
    }

    if ($("#inputAmount").length > 0) {
        $("#inputAmount").inputNumberFormat();
    }

    if ($(".IntOnlyNow").length > 0) {
        $(".IntOnlyNow").inputNumberFormat();
    }

    if ($("#DinputAmount").length > 0) {
        $("#DinputAmount").inputNumberFormat();
    }

    if ($("#BinputAmount").length > 0) {
        $("#BinputAmount").inputNumberFormat();
    }
});

document.addEventListener("adobe_dc_view_sdk.ready", function () {
    $(document).on("click", ".PdfViewer", function () {
        var path = $(this).data("source");
        var doc = $(this).data("doc");

        var adobeDCView = new AdobeDC.View({
            clientId: "2a136f8ba901415e847069372e0d2c2e",
            divId: "adobe-dc-view",
        });
        adobeDCView.previewFile({
            content: {
                location: {
                    url: path
                }
            },
            metaData: {
                fileName: doc
            },
        }, {});
    });
});


$(function () {



    $(document).on('click', '.TriggerNDA', function () {

        var DrugName = $("input[name='DrugName']");
        var GenericName = $("input[name='GenericName']");
        var DrugID = $("input[name='DID']");

        DrugName.val($(this).data('name'));
        GenericName.val($(this).data('generic'));
        DrugID.val($(this).data('did'));

        GenericName.attr('readonly', ' ')
        DrugName.attr("readonly", ' ');
    });





});
