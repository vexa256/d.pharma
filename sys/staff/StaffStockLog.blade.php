 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Staff Stock Utilization Log For the Month ' . $FromMonth . ' To the Month ' . $ToMonth . ' in  the year ' . $Year, $Msg = null) !!} </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">

     <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Stock Item</th>
                 <th>Qty Utilized</th>
                 <th>Selling Price</th>

                 <th>Sub Total</th>
                 <th>Record Date</th>
                 <th>Dispensed By</th>

             </tr>
         </thead>
         <tbody> @isset($Details) @foreach ($Details as $data)
                 <tr>
                     <td>{{ $data->DrugName }}</td>
                     <td>{{ $data->Qty }} {{ $data->Unit }}</td>
                     <td>UGX {{ number_format($data->SellingPrice) }}</td>
                     <td>UGX {{ number_format($data->SubTotal) }}</td>
                     <td>{!! date('F j, Y', strtotime($data->created_at)) !!}
                     </td>
                     <td>{{ $data->DispensedBy }}</td>




                 </tr>
             @endforeach @endisset </tbody>
     </table>
 </div>
