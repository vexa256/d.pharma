<div class="modal fade" id="New" data-backdrop="static" data-keyboard="false"
    aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"> Let's add a new consumable to
                    our pharmacy stock
                </h5>
                <button type="button" class="close"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <form action="{{ route('MassInsert') }}" class="row"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mt-3  mb-3 col-md-4  ">
                            <label id="label" for=""
                                class=" required form-label">Drug
                                Categories</label>
                            <select required name="DCID" class="form-select  "
                                data-control="select2"
                                data-placeholder="Select an option">
                                <option> </option>
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
                                <option> </option>
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

                        <div class="col-md-4 mb-3 mt-3 x_DrugName">
                            <div class="mb-3">
                                <label class="required form-label">Consumable
                                </label>
                                <input required="" type="text" name="DrugName"
                                    class="form-control " placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mt-3 ">
                            <div class="mb-3">
                                <label class="required form-label">Generic
                                    name</label>
                                <input required="" type="text"
                                    name="GenericName" class="form-control "
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mt-3 ">
                            <div class="mb-3">
                                <label class="required form-label">Minimum
                                    qty</label>
                                <input required="" type="text" name="MinimumQty"
                                    class="form-control " placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mt-3 ">
                            <div class="mb-3">
                                <label class="required form-label">Unit selling
                                    price</label>
                                <input required="" type="text"
                                    name="UnitSellingPrice"
                                    class="form-control IntOnlyNow"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mt-3 ">
                            <div class="mb-3">
                                <label class="required form-label">Unit buying
                                    price</label>
                                <input required="" type="text"
                                    name="UnitBuyingPrice"
                                    class="form-control IntOnlyNow"
                                    placeholder="">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3 mt-3 ">
                            <textarea class="editorme" name="DrugDescription"></textarea>
                        </div>
                    </div>


                    {!! Form::hidden($name = 'DID', $value = \Hash::make(uniqid() . 'AFC' . date('Y-m-d H:I:S')), [($options = null)]) !!}

                    {!! Form::hidden($name = 'StockType', $value = 'Consumable', [($options = null)]) !!}

                    {!! Form::hidden($name = 'uuid', $value = \Hash::make(uniqid() . 'AFC' . date('Y-m-d H:I:S')), [($options = null)]) !!}



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info"
                    data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-dark">Save
                    Changes</button>

                </form>
            </div>

        </div>
    </div>
</div>
