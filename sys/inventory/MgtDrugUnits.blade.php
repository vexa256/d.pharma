 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Set the units used to quantify stock', $Msg = null) !!}
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'New Measurement Unit', $Icon = 'fa-plus') }}
     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Unit Name</th>
                 <th>Date Created</th>
                 <th class="bg-dark text-light"> Update </th>
                 <th class="bg-danger fw-bolder text-light"> Delete </th>



             </tr>
         </thead>
         <tbody>
             @isset($Units)
                 @foreach ($Units as $data)
                     <tr>

                         <td>{{ $data->Unit }}</td>
                         <td>{!! date('F j, Y', strtotime($data->created_at)) !!}</td>

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
        'route' => route('DeleteData', ['id' => $data->id, 'TableName' => 'drug_units']),
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
 @include('inventory.NewDrugUnit')




 @isset($Units)
     @foreach ($Units as $data)
         <form novalidate action="{{ route('MassUpdate') }}" class=""
             method="POST" enctype="multipart/form-data">
             @csrf

             <div class="row">
                 <input type="hidden" name="id" value="{{ $data->id }}">

                 <input type="hidden" name="TableName" value="drug_units">


                 {{ RunUpdateModal($ModalID = $data->id,$Extra = '',$csrf = null,$Title = 'Update the selected  record',$RecordID = $data->id,$col = '12',$te = '12',$TableName = 'drug_units') }}
             </div>
         </form>
     @endforeach
 @endisset
