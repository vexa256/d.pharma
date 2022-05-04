 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Drug Validity Report', $Msg = null) !!}
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">

     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Name</th>
                 <th>Category</th>
                 <th>Vendor</th>
                 <th>Expiry</th>
                 <th>Expiry Status</th>
                 <th>Batch No.</th>

                 <th class="fw-bolder text-light bg-dark">Qty in stock</th>
                 <th>Months To Expiry</th>




             </tr>
         </thead>
         <tbody>
             @isset($Drugs)
                 @foreach ($Drugs as $data)
                     <tr>

                         <td>{{ $data->DrugName }}</td>
                         <td>{{ $data->CatName }}</td>
                         <td>{{ $data->VendorName }}</td>

                         <td>{!! date('F j, Y', strtotime($data->ExpiryDate)) !!}</td>
                         <td>
                             {!! $data->DrugExpiryStatus !!}</td>
                         <td>{{ $data->BatchNumber }}</td>

                         <td class="fw-bolder text-light bg-dark">
                             {{ $data->QtyAvailable }} {{ $data->Units }}</td>

                         <td class="fw-bolder text-light bg-danger shadow-lg">
                             {{ $data->MonthsToExpiry }} Months</td>






                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>
 <!--end::Card body-->

 @include('drugs.Refund')


 @isset($Drugs)
     @include('viewer.viewer', [
         'PassedData' => $Drugs,
         'Title' => 'View the Description of the selected drug',
         'DescriptionTableColumn' => 'DrugDescription',
     ])
 @endisset

 @isset($Drugs)
     @foreach ($Drugs as $data)
         {{ UpdateModalHeader($Title = 'Update the selected  record', $ModalID = $data->id) }}
         <form novalidate action="{{ route('RestockDrugs') }}"
             class="" method="POST" enctype="multipart/form-data">
             @csrf

             <div class="row">
                 <input type="hidden" name="id" value="{{ $data->id }}">




                 <div class="mb-3 col-md-12">
                     <label class="required form-label">Measurement Units</label>
                     <input disabled type="text" class="form-control "
                         value="{{ $data->Units }}">
                 </div>

                 <div class="mb-3 mt-3 col-md-12">
                     <label class="required form-label">Quantity Restocked</label>
                     <input required="" type="text" name="RefilledQty"
                         class="form-control IntOnlyNow" value="">
                 </div>




                 {{ RunUpdateModalFinal($ModalID = $data->id,$Extra = '',$csrf = null,$Title = null,$RecordID = $data->id,$col = '12',$te = '12',$TableName = 'drugs') }}
             </div>


             {{ UpdateModalFooter() }}

         </form>
     @endforeach
 @endisset
