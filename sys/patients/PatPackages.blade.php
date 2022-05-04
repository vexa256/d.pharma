 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Manage supported packages', $Msg = null) !!} </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'New Package', $Icon = 'fa-plus') }}
     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Package Name</th>
                 <th>Package value in UGX </th>
                 <th>Billing Status</th>
                 <th>Package Description</th>
                 <th>Actions</th>
             </tr>
         </thead>
         <tbody> @isset($Packages) @foreach ($Packages as $data)
                 <tr>
                     <td>{{ $data->PackageName }}</td>
                     <td>{{ number_format($data->PackageAccountValueInLocalCurrency, 2) }}
                     </td>
                     <td>{{ $data->BillingStatus }}</td>

                     <td> <a data-bs-toggle="modal"
                             class="btn shadow-lg btn-primary btn-sm admin TriggerNDA"
                             href="#Desc{{ $data->id }}"> <i
                                 class="fas fa-binoculars"
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


 @include('patients.NewPackage')

 @isset($Packages)
     @include('viewer.viewer', [
         'PassedData' => $Packages,
         'Title' => 'View the Description of the patient package',
         'DescriptionTableColumn' => 'PackageDescription',
     ])
 @endisset
 @isset($Packages)
     @foreach ($Packages as $data)
         {{ UpdateModalHeader($Title = 'Update the selected  record', $ModalID = $data->id) }}
         <form novalidate action="{{ route('MassUpdate') }}" class=""
             method="POST" enctype="multipart/form-data">
             @csrf

             <div class="row">

                 <div class="mt-3  mb-3 col-md-12  ">
                     <label id="label" for="" class=" required form-label">Billing
                         Status</label>
                     <select required name="BillingStatus" class="form-select  "
                         data-control="select2" data-placeholder="Select an option">
                         <option value="{{ $data->BillingStatus }}">
                             {{ $data->BillingStatus }}
                         </option>
                         <option value="Patient Billable"> Patient
                             Billable
                         </option>
                         <option value="Hospital Billable"> Hospital
                             Billable
                         </option>



                     </select>


                 </div>

                 <input type="hidden" name="id" value="{{ $data->id }}">

                 <input type="hidden" name="TableName" value="patient_packages">

                 {{ RunUpdateModalFinal($ModalID = $data->id,$Extra = '',$csrf = null,$Title = null,$RecordID = $data->id,$col = '6',$te = '12',$TableName = 'patient_packages') }}
             </div>


             {{ UpdateModalFooter() }}

         </form>
     @endforeach
 @endisset
