<div class="modal fade" id="EnableNDA">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title"> Add drug to supported drug list from
                    the NDA Register/Database


                </h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body ">

                <form action="{{ route('AddToDrugList') }}"
                    class="row" method="POST"
                    enctype="multipart/form-data"> @csrf
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
                            value="{{ date('Y-m-d h:i:s') }}">

                        <input type="hidden" name="TableName" value="drugs">

                        @foreach ($Form as $data)
                            @if ($data['type'] == 'string')
                                {{ CreateInputText($data, $placeholder = null, $col = '4') }}
                            @elseif ($data['type'] == 'integer' || $data['type'] == 'smallint' || $data['type'] == 'bigint')
                                {{ CreateInputInteger($data, $placeholder = null, $col = '4') }}
                            @elseif ($data['type'] == 'date' || $data['type'] == 'datetime')
                                {{ CreateInputDate($data, $placeholder = null, $col = '4') }}
                            @endif
                        @endforeach

                    </div>

                    <div class="row">
                        @foreach ($Form as $data)
                            @if ($data['type'] == 'text')
                                {{ CreateInputEditor($data, $placeholder = null, $col = '12') }}
                            @endif
                        @endforeach

                    </div>



                    <input type="text" class="d-none" name="DID"
                        id="DID">

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
