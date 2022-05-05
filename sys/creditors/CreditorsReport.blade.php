 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Patient/Creditors report ', $Msg = null) !!}
 </div>
 <div class="row container pt-3">
     @include('creditors.Stat')
 </div>

 <div class="card-body pt-3 bg-light shadow-lg table-responsive">

     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th> Name</th>
                 <th> Email</th>
                 <th> Phone</th>
                 <th> Address</th>
                 <th>Initial Credit Amount</th>
                 <th>Amount Paid</th>
                 <th>Amount Unpaid</th>

                 <th class="bg-danger fw-bolder text-light"> Record Payment
                 </th>



             </tr>
         </thead>
         <tbody>
             @isset($Creditors)
                 @foreach ($Creditors as $data)
                     <tr>
                         <td>{{ $data->Name }}</td>
                         <td>{{ $data->Email }}</td>
                         <td>{{ $data->Phone }} </td>
                         <td>{{ $data->Address }} </td>
                         <td>UGX {{ number_format($data->Total, 2) }} </td>
                         <td>UGX {{ number_format($data->TotalPaid, 2) }} </td>
                         <td>UGX {{ number_format($data->BalanceUnpaid, 2) }}
                         </td>



                         <td>
                             <a class="btn btn-dark viewer_only shadow-lg btn-sm"
                                 href="{{ route('RecordPay', ['id' => $data->id]) }}">

                                 <i class="fas fa-check" aria-hidden="true"></i>
                             </a>

                         </td>


                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>
