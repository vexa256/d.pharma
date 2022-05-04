window.addEventListener('DOMContentLoaded', () => {
    $(document).on("click", ".DeleteCartItem", function () {

        var id = $(this).data('id');

        axios.get(GLOBAL_API_PATH + 'RemoveDrugCartItem/' + id)
            .then(function (response) {

                if (response.data.status == "success") {

                    Swal.fire('Action Successful', response.data.Message, 'success');

                    FetchCartItems();
                }

            })
            .catch(function (error) {
                console.log(error);
                CatchAxiosError(error);
            });


    });
});
