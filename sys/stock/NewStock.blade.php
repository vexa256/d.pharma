<div class="modal fade" id="New">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title"> Let's add a new drug Stockpile

                </h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body ">

                <form action="{{ route('MassInsert') }}" class="row"
                    method="POST" enctype="multipart/form-data"> @csrf
                    <div class="row">


                        <div class="mt-3  mb-3  col-md-12 ">
                            <label id="label" for=""
                                class=" required form-label">Drug
                                Supplier</label>
                            <select required name="VID"
                                class="form-select  form-select-solid"
                                data-control="select2"
                                data-placeholder="Select an option">
                                <option value="">
                                </option>
                                @isset($Vendors)
                                    @foreach ($Vendors as $dataxd)
                                        <option value="{{ $dataxd->VID }}">
                                            {{ $dataxd->Name }}</option>
                                    @endforeach
                                @endisset

                            </select>

                        </div>

                        <div class="mt-3  mb-3 col-md-4 ">
                            <label id="label" for=""
                                class=" required form-label">Drug
                                Label</label>
                            <select required name="DID" class="form-select  "
                                data-control="select2"
                                data-placeholder="Select an option">
                                <option value="{{ $Drugs->DID }}">
                                    {{ $Drugs->DrugName }}</option>



                            </select>

                        </div>





                        <input type="hidden" name="created_at"
                            value="{{ date('Y-m-d h:i:s') }}">

                        <input type="hidden" name="TableName"
                            value="stock_piles">

                        @foreach ($Form as $data)
                            @if ($data['type'] == 'string')
                                {{ CreateInputText($data, $placeholder = null, $col = '4') }}
                            @elseif ('smallint' == $data['type'] || 'bigint' === $data['type'] || 'integer' == $data['type'] || 'bigint' == $data['type'])
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



                    <input type="hidden" name="StockTag"
                        value="{{ $StockTag }}">

                    {!! Form::hidden($name = 'StockID', $value = \Hash::make(uniqid() . 'AFC' . date('Y-m-d H:I:S')), [($options = null)]) !!}


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
