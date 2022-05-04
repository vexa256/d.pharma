 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Credit breakdown for the selected patient', $Msg = null) !!}
 </div>
 <div class="container">
     @include('creditors.PayStat')
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">

     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Item</th>
                 <th>Qty</th>
                 <th>Unit Cost</th>
                 <th>Initial Credit Amount</th>

                 <th>Amount Paid</th>
                 <th>Amount Unpaid</th>
                 <th>Credit Date</th>
                 <th class="bg-danger fw-bolder text-light"> Record Payment
                 </th>



             </tr>
         </thead>
         <tbody>
             @isset($Creditors)
                 @foreach ($Creditors as $data)
                     <tr>
                         <td>{{ $data->DrugName }}</td>
                         <td>{{ number_format($data->Qty, 2) }}</td>
                         <td>UGX {{ number_format($data->SellingPrice, 2) }} </td>
                         <td>UGX {{ number_format($data->CreditAmount, 2) }} </td>

                         <td>UGX {{ number_format($data->PaidAmount, 2) }} </td>
                         <td>UGX {{ number_format($data->Balance, 2) }}
                         </td>
                         <td>{!! date('F j, Y', strtotime($data->created_at)) !!}</td>
                         <td>
                             <a data-bs-toggle="modal"
                                 class="btn btn-dark shadow-lg btn-sm"
                                 href="#Update{{ $data->id }}">

                                 <i class="fas fa-check" aria-hidden="true"></i>
                             </a>

                         </td>


                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>


 @include('creditors.Pay')
