<input type="text" name="UpdateStockJs" class="UpdateStockJs d-none">

<div class="modal fade" id="UpdateStockItem">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title"> Select Stock Item To Update</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body ">

                <div class="row"> @csrf
                    <div class="row">
                        <div class="mt-3  mb-3 col-md-12 HtmlToPick HtmlYo ">
                            <label id="label" for="" class=" required form-label">Stock
                                Item</label>
                            <select required id="SelectedStockId" class="form-select  "
                                data-control="select2"
                                data-placeholder="Select an option">
                                <option>Select Stock Item To Update </option>
                                @isset($Stock)
                                    @foreach ($Stock as $data)
                                        <option value="{{ $data->id }}">
                                            {{ $data->DrugName }}</option>
                                    @endforeach
                                @endisset

                            </select>

                        </div>



                    </div>



                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info"
                        data-bs-dismiss="modal">Close</button>

                    <a href="#SelectedDrugModal" data-bs-toggle="modal"
                        class="btn btn-dark LoadUpdateStockView">Next Step</a>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="SelectedDrugModal">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title"> Select Stock Item To Update</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body " id="SelectedDrugScreen">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info"
                    data-bs-dismiss="modal">Close</button>



            </div>
        </div>

    </div>
</div>
</div>
