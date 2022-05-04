 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert(
    $icon = 'fa-info',
    $class = 'alert-primary',
    $Title = 'Manage
     patients records',
    $Msg = null,
) !!} </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'New Patient', $Icon = 'fa-plus') }}
     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Name</th>
                 <th>Gender</th>
                 <th>Package</th>
                 <th class="bg-dark text-light">Package</th>
                 <th>Email</th>
                 <th>Phone</th>
                 <th>Address</th>
                 <th>Age</th>
                 <th>Medical History</th>
                 <th>Known Allergies</th>
                 <th class="bg-dark fw-bolder text-light">Next of Keen</th>
                 <th>Actions</th>
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




                             {!! ConfirmBtn(
    $data = [
        'msg' => 'You want to delete this record',
        'route' => route('DeleteData', ['id' => $data->id, 'TableName' => 'patient_packages']),
        'label' => '<i class="fas fa-trash"></i>',
        'class' => 'btn btn-danger btn-sm deleteConfirm admin',
    ],
) !!}



                         </a>
                     </td>
                 </tr>
             @endforeach @endisset </tbody>
     </table>
 </div>
 @include('patients.PatientModals')




 @isset($PatientsDetails)
     @foreach ($PatientsDetails as $data)
         <div class="modal fade" id="Keen{{ $data->id }}"
             data-backdrop="static" data-keyboard="false" tabindex="-1"
             aria-labelledby="staticBackdrop" aria-hidden="true">
             <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h5 class="modal-title" id="staticBackdropLabel">Next of
                             keen record for the selected patient
                             <span class="text-danger fw-bolder">
                                 {{ $data->Name }}
                             </span>
                         </h5>
                         <button type="button" class="close"
                             data-bs-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <div class="modal-body">

                         <table
                             class=" table table-rounded table-bordered  border gy-3 gs-3">
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
