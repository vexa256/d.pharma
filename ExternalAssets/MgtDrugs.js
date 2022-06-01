global.axios = require("./sale/axios");

global.DisplayTextHere = $('.DisplayTextHere');

window.addEventListener('DOMContentLoaded', (event) => {


    $(document).on("click", ".ViewDesc", function () {



        var Desc = $(this).data("desc");


        DisplayTextHere.html(Desc);

        $('.editorme').trumbowyg();
        // $('.editorme').trumbowyg();
    });
});

