<div class="modal" id="ModalSelectDrug">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white fw-bolder" id="staticBackdropLabel">
                    Select item
                    to add to cart
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label id="label" for="" class=" required form-label">Select
                            Item to
                            Dispense</label>
                        <select required name="id"
                            class="form-select  ExistingDrugSelected"
                            data-control="select2" data-placeholder="Select an option">
                            <option></option>
                            @isset($Drugs)

                                @foreach ($Drugs as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->DrugName }}</option>
                                @endforeach
                            @endisset

                        </select>
                    </div>

                    <div class="col-md-6">
                        <!--begin::Label-->
                        <label class="form-label">Select Item Qty</label>
                        <!--end::Label-->

                        <!--begin::Input-->
                        <input type="text" class="form-control IntOnlyNow QtySelected"
                            placeholder="" value="" />
                        <!--end::Input-->
                    </div>



                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger"
                    data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-dark SelectExistingDrugButton">Save
                    Changes</button>
            </div>
        </div>
    </div>
</div>
