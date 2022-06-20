<div class="modal fade" id="New">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title SelectDrugSelect"> Select Stock To
                    Dispense


                </h5>

                <h5 class="modal-title SelectStockPileTable"> Select
                    Stockpile
                    to use

                    <a href="#" class="ms-2 GoToSelectDrug btn btn-dark shadow-lg">
                        Back to select Stock</a>

                </h5>


                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body ">
                <div class="SelectDrugSelect row">
                    <div class="mb-3 col-md-6   ">
                        <label id="label" for=""
                            class=" required form-label">Select Stock
                        </label>
                        <select required name="id"
                            class="form-select SelectedDrugId  " data-control="select2"
                            data-placeholder="Select an option">
                            <option></option>
                            @isset($Drugs)

                                @foreach ($Drugs as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->DrugName }}
                                        {{ $data->Currency }}
                                        {{ $data->UnitSellingPrice }} per
                                        {{ $data->Units }}</option>
                                @endforeach
                            @endisset

                        </select>

                    </div>

                    <div class="col-md-6 ">
                        <!--begin::Label-->
                        <label class="form-label">Select Quantity</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="text" class="form-control IntOnlyNow"
                            id="QtySelected" placeholder="" value="" />
                        <!--end::Input-->
                    </div>
                </div>


                <div class="mb-3 col-md-12  py-5  SelectStockPileTable  my-5">
                    <table class=" table table-rounded table-bordered  border gy-3 gs-3">
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
                <button type="button" class="btn btn-info GoToSelectDrug"
                    data-bs-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-dark SelectStockPile">Next</button>


            </div>

        </div>
    </div>
</div>
