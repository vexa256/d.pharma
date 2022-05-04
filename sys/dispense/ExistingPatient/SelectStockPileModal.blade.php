<div class="modal" tabindex="-1" id="ModalSelectDrugStockPile">
    <iv class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white fw-bolder"
                    id="staticBackdropLabel">Select drug stock to dispense
                    from
                </h5>
                <button type="button" class="btn-close"
                    data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 col-md-12  py-5  SelectStockPileTable  my-5">
                    <table
                        class=" table table-rounded table-bordered  border gy-3 gs-3">
                        <thead>
                            <tr
                                class="fw-bold  text-gray-800 border-bottom border-gray-200">


                                <th>Stock Item</th>
                                <th>Generic Name</th>
                                <th>Stock Tag</th>
                                <th>Batch</th>

                                <th>QTY Available</th>
                                <th>Selling Price</th>
                                <th>Expiry</th>
                                <th>Use This Stockpile</th>


                            </tr>
                        </thead>
                        <tbody class="DisplayStockHere">

                        </tbody>
                    </table>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger BackToDrugSelection"
                    data-bs-dismiss="modal">Back to drug selection</button>

            </div>
        </div>
    </iv>
</div>
