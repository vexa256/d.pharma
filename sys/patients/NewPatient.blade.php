<div class="modal fade" id="New">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title"> Let's create a new patients record

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

                        <input type="hidden" name="created_at"
                            value="{{ date('Y-m-d h:i:s') }}">
                        <input type="hidden" name="TableName" value="patients">

                        <div class="mt-3  mb-3 col-md-4  ">
                            <label id="label" for=""
                                class=" required form-label">Package</label>
                            <select required name="PackageID"
                                class="form-select  " data-control="select2"
                                data-placeholder="Select an option">
                                <option> </option>
                                @isset($Packages)
                                    @foreach ($Packages as $datadd)
                                        <option value="{{ $datadd->PackageID }}">
                                            {{ $datadd->PackageName }}</option>
                                    @endforeach
                                @endisset

                            </select>

                        </div>
                        <div class="mt-3  mb-3 col-md-4  ">
                            <label id="label" for=""
                                class=" required form-label">Gender</label>
                            <select required name="Gender"
                                class="form-select  " data-control="select2"
                                data-placeholder="Select an option">
                                <option> </option>

                                <option value="Male">Male</option>
                                <option value="Female">Female</option>


                            </select>

                        </div>

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

                    <input type="hidden" name="PID"
                        value="{{ \Hash::make(uniqid() . 'AFC' . date('Y-m-d H:I:S')) }}">

                    <input type="hidden" name="uuid"
                        value="{{ \Hash::make(uniqid() . 'AFC' . date('Y-m-d H:I:S')) }}">







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
