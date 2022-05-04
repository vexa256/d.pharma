 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info ', $class = 'alert-danger ', $Title = 'Drug Inventory restocking history filtered by year', $Msg = null) !!}
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">

     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th class="bg-danger text-light fw-bolder">Drug</th>
                 <th>Drug Category</th>
                 <th>Restock Date</th>
                 <th>Restocked By</th>
                 <th class="bg-dark text-light fw-bolder">Qty Restocked</th>
                 <th>Selling Price</th>
                 <th>Buying Price</th>
                 <th>Projected Profit</th>



             </tr>
         </thead>
         <tbody>
             @isset($Drugs)
                 @foreach ($Drugs as $data)
                     <tr>

                         <td class="bg-danger text-light fw-bolder">
                             {{ $data->DrugName }}</td>
                         <td>{{ $data->DrugCategory }}</td>

                         <td>{!! date('F j, Y', strtotime($data->created_at)) !!}</td>
                         <td>{{ $data->RestockedBy }} </td>
                         <td class="bg-dark text-light fw-bolder">
                             {{ number_format($data->QtyRestocked) }}
                             {{ $data->Units }}
                         </td>
                         <td>{{ number_format($data->UnitSellingPrice, 2) }}
                             {{ $data->Currency }}
                         </td>
                         <td>{{ number_format($data->UnitBuyingPrice, 2) }}
                             {{ $data->Currency }}
                         </td>
                         <td>{{ number_format($data->ProjectedProfit, 2) }}
                             {{ $data->Currency }}
                         </td>













                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>
 <!--end::Card body-->
