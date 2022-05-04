 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert(
    $icon = 'fa-info',
    $class = 'alert-primary',
    $Title = 'Let\'s add
     our stock suppliers',
    $Msg = null,
) !!}
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'New Stock Vendor', $Icon = 'fa-plus') }}
     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Vendor Name</th>
                 <th>Email</th>
                 <th>Phone</th>
                 <th>Address</th>
                 <th>Contact Person</th>
                 <th class="bg-danger text-light fw-bolder">Contract Validity
                 </th>
                 <th class="bg-danger text-light fw-bolder">Months to Expiry
                 </th>
                 <th>Remarks</th>
                 <th>Date Created</th>
                 <th class="bg-dark text-light"> Update </th>
                 <th class="bg-danger fw-bolder text-light"> Delete </th>



             </tr>
         </thead>
         <tbody>
             @isset($Vendors)
                 @foreach ($Vendors as $data)
                     <tr>

                         <td>{{ $data->Name }}</td>
                         <td>{{ $data->Email }}</td>
                         <td>{{ $data->Phone }}</td>
                         <td>{{ $data->Address }}</td>
                         <td>{{ $data->ContactPerson }}</td>
                         <td class="bg-dark text-light fw-bolder">
                             {{ $data->ContractValidity }}</td>
                         <td class="bg-dark text-light fw-bolder">
                             {{ $data->MonthsToContractExpiry }} Month(s)</td>
                         <td>

                             <a data-bs-toggle="modal"
                                 class="btn btn-dark shadow-lg btn-sm"
                                 href="#Desc{{ $data->id }}">

                                 <i class="fas fa-binoculars"
                                     aria-hidden="true"></i>
                             </a>

                         </td>
                         <td>{!! date('F j, Y', strtotime($data->created_at)) !!}
                         </td>


                         <td>

                             <a data-bs-toggle="modal"
                                 class="btn shadow-lg btn-danger btn-sm admin"
                                 href="#Update{{ $data->id }}">

                                 <i class="fas fa-edit" aria-hidden="true"></i>
                             </a>

                         </td>


                         <td>

                             {!! ConfirmBtn(
    $data = [
        'msg' => 'You want to delete this record',
        'route' => route('DeleteData', ['id' => $data->id, 'TableName' => 'drugs_vendors']),
        'label' => '<i class="fas fa-trash"></i>',
        'class' => 'btn btn-danger btn-sm deleteConfirm admin',
    ],
) !!}

                         </td>





                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>
 <!--end::Card body-->
 @include('inventory.NewDrugVendor')


 @isset($Vendors)
     @include('viewer.viewer', [
         'PassedData' => $Vendors,
         'Title' => 'View pharmacy remarks about the selected stock vendor',
         'DescriptionTableColumn' => 'Remarks',
     ])
 @endisset

 @isset($Vendors)
     @foreach ($Vendors as $data)
         <form novalidate action="{{ route('MassUpdate') }}"
             class="" method="POST" enctype="multipart/form-data">
             @csrf

             <div class="row">
                 <input type="hidden" name="id" value="{{ $data->id }}">

                 <input type="hidden" name="TableName" value="drugs_vendors">


                 {{ RunUpdateModal($ModalID = $data->id,$Extra = '',$csrf = null,$Title = 'Update the selected  record',$RecordID = $data->id,$col = '6',$te = '12',$TableName = 'drugs_vendors') }}
             </div>
         </form>
     @endforeach
 @endisset
