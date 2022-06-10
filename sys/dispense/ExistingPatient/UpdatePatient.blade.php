<input type="hidden" id="CurrentPatientID" value="{{ $PatientID }}">

<div class="modal fade" id="ModalUpdatePatient" data-backdrop="static"
    data-keyboard="false" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Manage the Selected
                    Patient</h5>

                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table
                    class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
                    <thead>
                        <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Package</th>
                            <th class="bg-dark text-light">Billing</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Age</th>
                            <th>Medical History</th>
                            <th>Known Allergies</th>
                            <th class="bg-dark fw-bolder text-light">Next of Keen</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody> @isset($PatientsDetails) @foreach ($PatientsDetails as $data)
                            <tr>
                                <td>{{ $data->Name }}</td>
                                <td>{{ $data->Gender }}</td>
                                <td>{{ $data->PackageName }}</td>
                                <td class="bg-dark text-light fw-bolder">
                                    {{ $data->BillingStatus }}</td>
                                <td>{{ $data->Email }}</td>
                                <td>{{ $data->Phone }}</td>
                                <td>{{ $data->Address }}</td>
                                <td>{{ $data->PatientsAge }}</td>

                                <td> <a data-bs-toggle="modal"
                                        class="btn shadow-lg btn-primary btn-sm admin TriggerNDA"
                                        href="#Desc{{ $data->id }}"> <i
                                            class="fas fa-binoculars"
                                            aria-hidden="true"></i>


                                    </a>
                                </td>

                                <td> <a data-bs-toggle="modal"
                                        class="btn shadow-lg btn-danger btn-sm admin TriggerNDA"
                                        href="#Allergies{{ $data->id }}"> <i
                                            class="   fas fa-binoculars"
                                            aria-hidden="true"></i>


                                    </a>
                                </td>
                                <td> <a data-bs-toggle="modal"
                                        class="btn shadow-lg btn-dark btn-sm admin TriggerNDA"
                                        href="#Keen{{ $data->id }}"> <i
                                            class="   fas fa-people-carry"
                                            aria-hidden="true"></i>


                                    </a>
                                </td>


                                <td> <a data-bs-toggle="modal"
                                        class="btn shadow-lg  me-1 btn-dark btn-sm admin TriggerNDA"
                                        href="#Update{{ $data->id }}"> <i
                                            class="fas fa-edit" aria-hidden="true"></i>





                                    </a>
                                </td>
                            </tr>
                        @endforeach @endisset </tbody>
                </table>

            </div>

        </div>
    </div>
</div>



<div class="modal fade" id="DispensaryNotes" data-backdrop="static"
    data-keyboard="false" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Dispensary Notes For
                    the Selected Patient</h5>

                </h5>
                <button type="button" class="close" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table
                    class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
                    <thead>
                        <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                            <th>Date</th>
                            <th>View Notes</th>

                        </tr>
                    </thead>
                    <tbody> @isset($DispensaryNotes) @foreach ($DispensaryNotes as $notes)
                            <tr>

                                <td>{{ date('F j, Y', strtotime($notes->created_at)) }}
                                </td>
                                </td>
                                <td> <a data-bs-toggle="modal"
                                        class="btn shadow-lg btn-primary btn-sm admin TriggerNDA"
                                        href="#notes{{ $notes->id }}"> <i
                                            class="fas fa-binoculars"
                                            aria-hidden="true"></i>


                                    </a>
                                </td>



                            </tr>
                        @endforeach @endisset
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>
@isset($DispensaryNotes) @foreach ($DispensaryNotes as $dat)
    <div class="modal fade" id="notes{{ $dat->id }}" data-backdrop="static"
        data-keyboard="false" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Dispensary Notes
                        For
                        the Selected Patient</h5>

                    </h5>
                    <button type="button" class="close btn-dark btn text-light"
                        data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <textarea class="editorme" name="DispensaryNotes">
                        {{ $dat->DispensaryNotes }}
                </textarea>


                </div>

            </div>
        </div>
    </div>
@endforeach @endisset
@include('patients.PatientModals')




@isset($PatientsDetails)
    @foreach ($PatientsDetails as $data)
        <div class="modal fade" id="Keen{{ $data->id }}" data-backdrop="static"
            data-keyboard="false" aria-labelledby="staticBackdrop" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Next of
                            keen record for the selected patient
                            <span class="text-danger fw-bolder">
                                {{ $data->Name }}
                            </span>
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <table class=" table table-rounded table-bordered  border gy-3 gs-3">
                            <thead>
                                <tr
                                    class="fw-bold  text-gray-800 border-bottom border-gray-200">
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Address</th>
                                    <th class="bg-dark text-light">Phone</th>
                                    <th>Email</th>
                                    <th>Reletionship</th>


                                </tr>
                            </thead>
                            <tbody> @isset($PatientsDetails)
                                    @foreach ($PatientsDetails as $data)
                                        <tr>
                                            <td>{{ $data->NextOfKeenName }}</td>
                                            <td>{{ $data->NextOfKeenGender }}</td>
                                            <td>{{ $data->NextOfKeenAddress }}</td>
                                            <td>{{ $data->NextOfKeenPhone }}</td>
                                            <td>{{ $data->NextOfKeenEmail }}</td>
                                            <td>{{ $data->NextOfKeenRelationship }}
                                            </td>


                                        </tr>
                                    @endforeach
                                @endisset
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endisset
