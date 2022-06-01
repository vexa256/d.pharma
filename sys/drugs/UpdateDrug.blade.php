<div class="modal fade show" id="New" aria-modal="true" role="dialog"
    style="display: block;">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title"> Update the selected drug record</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body ">

                <form action="{{ route('MassUpdate') }}"
                    class="row" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="row">


                        <div class="mt-3  mb-3 col-md-4  ">
                            <label id="label" for=""
                                class=" required form-label">Drug
                                Categories</label>
                            <select required name="DCID" class="form-select  "
                                data-control="select2"
                                data-placeholder="Select an option">
                                <option id="DCID" value=""> </option>
                                @isset($Categories)
                                    @foreach ($Categories as $datadd)
                                        <option value="{{ $datadd->DCID }}">
                                            {{ $datadd->CategoryName }}</option>
                                    @endforeach
                                @endisset

                            </select>

                        </div>


                        <div class="mt-3  mb-3 col-md-4  ">
                            <label id="label" for=""
                                class=" required form-label">Measurement
                                Units</label>
                            <select required name="MeasurementUnits"
                                class="form-select  " data-control="select2"
                                data-placeholder="Select an option">
                                <option id="MeasurementUnits" value=""> </option>
                                @isset($Units)
                                    @foreach ($Units as $datadd)
                                        <option value="{{ $datadd->UnitID }}">
                                            {{ $datadd->Unit }}</option>
                                    @endforeach
                                @endisset

                            </select>

                        </div>



                        <input type="hidden" name="created_at"
                            value="{{ date('Y-m-d') }}">

                        <input type="hidden" name="TableName" value="drugs">




                        <div class="col-md-4 mb-3 mt-3">
                            <div class="mb-3">
                                <label class="required form-label">Drug
                                    name</label>
                                <input id="DrugName" required="" type="text"
                                    name="DrugName" class="form-control "
                                    placeholder="">
                            </div>

                        </div>
                        <div class="col-md-4 mb-3 mt-3 ">
                            <div class="mb-3">
                                <label class="required form-label">Generic
                                    name</label>
                                <input id="GenericName" type="text"
                                    name="GenericName" class="form-control "
                                    placeholder="">
                            </div>
                        </div>




                        <div class="col-md-4 mb-3 mt-3 ">
                            <div class="mb-3">
                                <label class="required form-label">Minimum
                                    qty</label>
                                <input id="MinimumQty" required="" type="text" name="MinimumQty"
                                    class="form-control IntOnlyNow"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mt-3 x_UnitSellingPrice">
                            <div class="mb-3">
                                <label class="required form-label">Unit selling
                                    price</label>
                                <input required="" type="text" id="UnitSellingPrice"
                                    name="UnitSellingPrice"
                                    class="form-control IntOnlyNow"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mt-3 x_UnitBuyingPrice">
                            <div class="mb-3">
                                <label class="required form-label">Unit buying
                                    price</label>
                                <input required="" type="text"
                                id="UnitBuyingPrice"
                                    name="UnitBuyingPrice"
                                    class="form-control IntOnlyNow"
                                    placeholder="">
                            </div>
                        </div>








                    </div>

                    <div class="row">


                    </div>




                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info"
                    data-bs-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-dark">Save
                    Changes</button>


            </div>

        </div>
    </div>
</div>
