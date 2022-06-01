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
                 {{-- <th class="bg-dark text-light">Balance</th> --}}

                 <th>Package</th>
                 <th class="bg-dark text-light">Billing</th>

                 <th>Settings and More</th>

             </tr>
         </thead>
         <tbody> @isset($PatientsDetails) @foreach ($PatientsDetails as $data)
                 <tr>
                     <td>{{ $data->Name }}</td>
                     {{-- <td class="bg-dark text-light">{{ number_format($data->Balance )}} UGX</td> --}}

                     <td>{{ $data->PackageName }}</td>
                     <td class="bg-dark text-light fw-bolder">
                         {{ $data->BillingStatus }}</td>


                     <td>
                         <a href="{{ route('PatientSettings', ['id' => $data->id]) }}" class="bg-danger btn btn-sm shadow-lg">

                            <i class="fa text-light fa-cogs" aria-hidden="true"></i>


                         </a>
                     </td>









                 </tr>
             @endforeach @endisset </tbody>
     </table>
 </div>





 @include('patients.NewPatient')
