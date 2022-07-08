 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Settings for the selected stock item', $Msg = null) !!}
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">

     <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Stock Item </th>
                 <th>Category</th>
                 <th>Buying Price</th>
                 <th>Selling Price</th>

             </tr>
         </thead>
         <tbody>
             @isset($PriceList)
                 @foreach ($PriceList as $data)
                     <tr>

                         <td>{{ $data->DrugName }}</td>
                         <td>{{ $data->CatName }}</td>
                         <td>{{ $data->Currency }}
                             {{ number_format($data->UnitBuyingPrice) }} per
                             {{ $data->Unit }}
                         </td>
                         <td>{{ $data->Currency }}
                             {{ number_format($data->UnitSellingPrice) }} per
                             {{ $data->Unit }}
                         </td>








                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>
