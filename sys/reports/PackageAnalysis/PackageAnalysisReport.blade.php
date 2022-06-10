 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Patient Package Analysis Report | Used Amount | Assigned Amount | Budget Overshoot ', $Msg = null) !!} </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Patient </th>
                 <th>Package Name</th>
                 <th class="bg-dark text-light fw-bolder">Package Assigned Budget</th>
                 <th>Amount Used By Patient</th>
                 <th class="bg-danger text-light fw-bolder">Package Budget Variance
                     (ASSIGNED - USED)</th>


             </tr>
         </thead>
         <tbody class="DisplayNdaDrugListHere">
             @isset($Analysis)
                 @foreach ($Analysis as $data)
                     <tr>
                         <td>{{ $data->Name }}</td>
                         <td>{{ $data->PackageName }}</td>
                         <td>UGX
                             {{ number_format($data->PackageAccountValueInLocalCurrency) }}
                         </td>

                         <td>UGX
                             {{ number_format($data->Total) }}
                         </td>

                         <td>UGX
                             {{ number_format($data->PackageAccountValueInLocalCurrency - $data->Total) }}
                         </td>


                     </tr>
                 @endforeach @endisset
             </tbody>
         </table>
     </div>


     @include('drugs.EnableNDA')
