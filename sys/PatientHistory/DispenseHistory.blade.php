 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Patient Pharmacy Dispense History', $Msg = null) !!} </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'Dispense Notes', $Icon = 'fa-binoculars') }}
     <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Drug Name</th>
                 <th>Batch No.</th>
                 <th>Date of Sale</th>
                 <th>Dispensed QTY</th>
                 <th>Selling Price</th>
                 <th>Amount Paid</th>
                 <th>Dispensed By</th>

                 {{-- <th class="bg-dark text-light">Add to Drug List </th> --}}
             </tr>
         </thead>
         <tbody class="DisplayNdaDrugListHere">
             @isset($Report)
                 @foreach ($Report as $data)
                     <tr>
                         <td>{{ $data->DrugName }}</td>
                         <td>{{ $data->BatchNumber }}</td>
                         <td>{!! date('F j, Y', strtotime($data->created_at)) !!}
                         </td>
                         <td>{{ $data->Qty }} {{ $data->Units }}</td>
                         <td>{{ $data->SellingPrice }}</td>
                         <td>{{ $data->SubTotal }}</td>
                         <td>{{ $data->DispensedBy }}</td>
                     </tr>
                 @endforeach @endisset
             </tbody>
         </table>
     </div>

     @include('PatientHistory.DispenseNotes')
     {{-- @include('drugs.EnableNDA') --}}
