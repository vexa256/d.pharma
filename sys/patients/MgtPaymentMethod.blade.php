 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Manage payment methods', $Msg = null) !!} </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'New Payment Method', $Icon = 'fa-plus') }}
     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Payment Method</th>
                 <th>Payment Description</th>
                 <th>Actions</th>
             </tr>
         </thead>
         <tbody> @isset($PaymentMethods) @foreach ($PaymentMethods as $data)
                 <tr>
                     <td>{{ $data->PaymentMethod }}</td>

                     <td> <a data-bs-toggle="modal"
                             class="btn shadow-lg btn-primary btn-sm admin TriggerNDA"
                             href="#Desc{{ $data->id }}"> <i
                                 class="fas fa-binoculars"
                                 aria-hidden="true"></i>


                         </a>
                     </td>


                     <td>

                         @if ($data->PaymentMethod != 'Credit')
                             <a data-bs-toggle="modal"
                                 class="btn shadow-lg  me-1 btn-dark btn-sm admin TriggerNDA"
                                 href="#Update{{ $data->id }}"> <i
                                     class="fas fa-edit"
                                     aria-hidden="true"></i>

                             </a>
                             {!! ConfirmBtn(
    $data = [
        'msg' => 'You want to delete this record',
        'route' => route('DeleteData', ['id' => $data->id, 'TableName' => 'patient_packages']),
        'label' => '<i class="fas fa-trash"></i>',
        'class' => 'btn btn-danger btn-sm deleteConfirm admin',
    ],
) !!}
                         @endif





                     </td>
                 </tr>
             @endforeach @endisset </tbody>
     </table>
 </div>


 @include('patients.NewPayMethods')

 @isset($PaymentMethods)
     @include('viewer.viewer', [
         'PassedData' => $PaymentMethods,
         'Title' => 'View the Description for the selected payment method',
         'DescriptionTableColumn' => 'Description',
     ])
 @endisset
 @isset($PaymentMethods)
     @foreach ($PaymentMethods as $data)
         {{ UpdateModalHeader($Title = 'Update the selected  payment method', $ModalID = $data->id) }}
         <form novalidate action="{{ route('MassUpdate') }}" class=""
             method="POST" enctype="multipart/form-data">
             @csrf

             <div class="row">



                 <input type="hidden" name="id" value="{{ $data->id }}">

                 <input type="hidden" name="TableName" value="payment_methods">

                 {{ RunUpdateModalFinal($ModalID = $data->id,$Extra = '',$csrf = null,$Title = null,$RecordID = $data->id,$col = '12',$te = '12',$TableName = 'payment_methods') }}
             </div>


             {{ UpdateModalFooter() }}

         </form>
     @endforeach
 @endisset
