window.addEventListener('DOMContentLoaded', () => {


    global.HideModal = (ModalId) => {

        $('#' + ModalId).hide();

        $('.modal-backdrop').remove();




    }

    global.ShowModal = (ModalId) => {

        $('#' + ModalId).show();

        $('body').append(`<div class="modal-backdrop show"></div>`);


    }


    $(document).on('click', '[data-bs-dismiss="modal"]', function () {

        $('.modal-backdrop').remove();

    });



});
