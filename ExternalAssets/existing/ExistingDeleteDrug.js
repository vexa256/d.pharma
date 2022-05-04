window.addEventListener('DOMContentLoaded', () => {
    $(document).on("click", ".ExistingDeleteCartItem", function () {

        var id = $(this).data('id');

        axios.get(GLOBAL_API_PATH + 'RemoveDrugCartItem/' + id)
            .then(function (response) {

                if (response.data.status == "success") {

                    Swal.fire('Action Successful', response.data.Message, 'success');

                    FetchExistingCartItems();
                }

            })
            .catch(function (error) {
                console.log(error);
                CatchAxiosError(error);
            });


    });
});
