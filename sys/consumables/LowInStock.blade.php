 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info ', $class = 'alert-danger ', $Title = 'To restock a consumable item, Click create stock pile', $Msg = null) !!}
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">

     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Consumable Item</th>
                 <th>Category</th>
                 <th>Vendor</th>
                 <th>Expiry</th>
                 <th>Expiry Status</th>


                 <th class="fw-bolder text-light bg-dark">Qty Now</th>
                 <th>Date Added</th>

                 <th class="bg-dark text-light"> Restock </th>




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
                             {!! $data->ExpiryStatus !!}</td>


                         <td class="fw-bolder text-light bg-dark">
                             {{ $data->QtyAvailable }} {{ $data->Units }}</td>

                         <td>{!! date('F j, Y', strtotime($data->created_at)) !!}</td>




                         <td>

                             <a class="btn shadow-lg btn-danger btn-sm admin"
                                 href="{{ url('SelectConsStockPile') }}">

                                 <i class="fas fa-clock" aria-hidden="true"></i>
                             </a>

                         </td>








                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>
 <!--end::Card body-->

 @isset($Drugs)
     @include('viewer.viewer', [
         'PassedData' => $Drugs,
         'Title' => 'View the Description of the selected consumable',
         'DescriptionTableColumn' => 'DrugDescription',
     ])
 @endisset
