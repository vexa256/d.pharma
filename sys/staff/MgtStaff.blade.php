 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Manage staff members', $Msg = null) !!} </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     <a href="#New" data-bs-toggle="modal"
         class="btn mx-1 float-end   mb-2 btn-sm btn-danger">
         <i class="fa fa-plus me-1" aria-hidden="true"></i>
         New Staff Member</a>
     <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Name</th>
                 <th>Role</th>
                 <th>Package</th>
                 <th class="bg-dark text-light">Billing</th>
                 <th>Actions</th>
             </tr>
         </thead>
         <tbody> @isset($PatientsDetails) @foreach ($PatientsDetails as $data)
                 <tr>
                     <td>{{ $data->Name }}</td>
                     <td>{{ $data->StaffRole }}</td>
                     <td>{{ $data->PackageName }}</td>
                     <td class="bg-dark text-light fw-bolder">
                         {{ $data->BillingStatus }}</td>




                     <td> <a data-bs-toggle="modal"
                             class="btn shadow-lg  me-1 btn-dark btn-sm admin TriggerNDA"
                             href="#Update{{ $data->id }}"> <i class="fas fa-edit"
                                 aria-hidden="true"></i>




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
 @include('patients.NewPatient')
