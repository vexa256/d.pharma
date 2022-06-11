 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Staff Stock Utilization Report For the Month ' . $FromMonth . ' To the Month ' . $ToMonth . ' in the year ' . $Year, $Msg = null) !!} </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Staff Member </th>

                 <th class="bg-danger text-light fw-bolder">Stock Value Utilized
                 </th>

                 <th>See Detailed Log </th>


             </tr>
         </thead>
         <tbody class="DisplayNdaDrugListHere">
             @isset($Analysis)
                 @foreach ($Analysis as $data)
                     <tr>
                         <td>{{ $data->Name }}</td>


                         <td>UGX
                             {{ number_format($data->Total) }}
                         </td>


                         <td>
                             <a href="{{ route('StaffStockLog', [
                                 'PID' => $data->PID,
                                 'FromMonth' => $FromMonth,
                                 'ToMonth' => $ToMonth,
                                 'Year' => $Year,
                             ]) }}"
                                 class="btn btn-danger btn-sm">

                                 <i class="fas fa-binoculars me-1" aria-hidden="true"></i>
                                 View Details
                             </a>
                         </td>



                     </tr>
                 @endforeach @endisset
             </tbody>
         </table>
     </div>

     {{-- @include('drugs.EnableNDA') --}}
