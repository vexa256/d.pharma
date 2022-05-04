 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info ', $class = 'alert-danger ', $Title = 'Drug inventory report', $Msg = null) !!}
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">

     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">


                 <th>Drug Name</th>
                 <th>Drug Category</th>
                 <th class="bg-dark text-light fw-bolder">Qty Instock</th>



             </tr>
         </thead>
         <tbody>
             @isset($Drugs)
                 @foreach ($Drugs as $data)
                     <tr>



                         <td>{{ $data->DrugName }}</td>
                         <td>{{ $data->CatName }}</td>
                         <td class="bg-dark text-light fw-bolder">
                             {{ $data->QtyAvailable }}
                             {{ $data->Dunit }}</td>









                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>
 <!--end::Card body-->
