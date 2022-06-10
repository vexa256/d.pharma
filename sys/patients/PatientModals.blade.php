@isset($PatientsDetails)
    @include('viewer.viewer', [
        'PassedData' => $PatientsDetails,
        'Title' => 'The Relevant Medical History of the selected patient',
        'DescriptionTableColumn' => 'RelevantMedicalNotes',
    ])
@endisset


@isset($PatientsDetails)
    @foreach ($PatientsDetails as $dataw)
        <div class="modal fade" id="Allergies{{ $dataw->id }}">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header bg-gray">
                        <h5 class="modal-title">Recorded allergies in relation
                            to the selected patient

                        </h5>

                        <!--begin::Close-->
                        <a href="#MgtTaxes" data-bs-toggle="modal" type="button"
                            class="btn btn-info" data-bs-dismiss="modal"
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                        </a>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body ">

                        <textarea class="editorme">
                     {{ $dataw->KnownAllergies }}
                 </textarea>

                    </div>

                    <div class="modal-footer">
                        <a data-bs-toggle="modal" href="#" type="button"
                            class="btn btn-info" data-bs-dismiss="modal">Close</a>


                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endisset




@isset($PatientsDetails)
    @foreach ($PatientsDetails as $data)
        {{ UpdateModalHeader($Title = 'Update the selected  patient\'s record', $ModalID = $data->id) }}
        <form novalidate action="{{ route('MassUpdate') }}" class=""
            method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="mt-3  mb-3 col-md-6  ">
                    <label id="label" for="" class=" required form-label">Package</label>
                    <select required name="PackageID" class="form-select  "
                        data-control="select2" data-placeholder="Select an option">
                        <option value="{{ $data->PackageID }}">

                            {{ $data->PackageName }}

                        </option>

                        @isset($Packages)
                            @foreach ($Packages as $dataddd)
                                <option value="{{ $dataddd->PackageID }}">
                                    {{ $dataddd->PackageName }}</option>
                            @endforeach
                        @endisset

                    </select>

                </div>


                <div class="mt-3  mb-3 col-md-6 ">
                    <label id="label" for="" class=" required form-label">Gender</label>
                    <select required name="Gender" class="form-select  "
                        data-control="select2" data-placeholder="Select an option">
                        <option value="{{ $data->Gender }}">

                            {{ $data->Gender }}

                        </option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>


                    </select>

                </div>



                <input type="hidden" name="id" value="{{ $data->id }}">

                <input type="hidden" name="TableName" value="patients">

                {{ RunUpdateModalFinal($ModalID = $data->id, $Extra = '', $csrf = null, $Title = null, $RecordID = $data->id, $col = '4', $te = '12', $TableName = 'patients') }}
            </div>


            {{ UpdateModalFooter() }}

        </form>
    @endforeach
@endisset


<div class="modal fade" id="DispenseNotes">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title">Record pharmacy notes for the selected patient

                </h5>

                <!--begin::Close-->
                <a href="#MgtTaxes" data-bs-toggle="modal" type="button"
                    class="btn btn-info" data-bs-dismiss="modal"
                    class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </a>
                <!--end::Close-->
            </div>

            <div class="modal-body ">

                <form action="{{ route('MassInsert') }}" method="post">
                    @csrf
                    <input type="hidden" name="created_at" value="{{ date('Y-m-d') }}">

                    <input type="hidden" name="TableName" value="dispensary_notes">

                    <input type="hidden" name="uuid"
                        value="{{ md5($PID . uniqid() . date('Y-m-d')) }}">

                    <input type="hidden" name="PID" value="{{ $PID }}">

                    <textarea class="editorme" name="DispensaryNotes">
            
         </textarea>

            </div>

            <div class="modal-footer">
                <a data-bs-toggle="modal" href="#" type="button" class="btn btn-info"
                    data-bs-dismiss="modal">Close</a>


                <button type="submit" class="btn btn-danger">Save Changes
                </button>
                </form>

            </div>

        </div>
    </div>
</div>
