 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-danger fw-bolder', $Title = 'The selectred patient is ' . $Name, $Msg = null) !!}
 </div>

 <input type="text" class="d-none" id="PaymentSessionID"
     value="{{ $PaymentSessionID }}">

 <input type="text" class="d-none" id="DispensedBy"
     value="{{ Auth::user()->name }}">


 <input type="text" class="d-none" id="BillingStatus"
     value="{{ $BillingStatus }}">

 <div class="card-body pt-3 bg-light table-responsive">
     {{ HeaderBtn($Toggle = 'ModalSelectDrug',$Class = 'btn-danger',$Label = 'Add  Item to Cart',$Icon = 'fa-plus',$BtnClass = 's') }}

     <a href="{{ route('ExistingSelectPaymentMethod') }}"
         class="btn mx-1 float-end mb-2 btn-dark GoToPay">
         <i class="fas me-1 fa-check " aria-hidden="true"></i>Next Step</a>



 </div>
 <div class="card-header">
     <span class="text-danger fw-bolder">
         Selected Patient's Billing Status :: {{ $BillingStatus }}

     </span>
 </div>
 @include(
     'dispense.ExistingPatient.TotalCart'
 )
 <table
     class="table table-rounded table-bordered table-striped border gy-3 gs-3">

     <thead>
         <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
             <th>Patient</th>
             <th>Phone</th>
             <th>Email</th>
             <th>Stock Item</th>
             <th>Generic Name</th>
             <th>Units </th>
             <th>Unit Price </th>
             <th>Qty </th>
             <th>Sub Total</th>
             <th class="bg-danger fw-bolder text-light"> Remove Item
             </th>
         </tr>
     </thead>
     <tbody class="ExistingDisplayCartItemsHere">

     </tbody>
 </table>

 </div>
 </div>

 @include(
     'dispense.ExistingPatient.SelectDrugModal'
 )

 @include(
     'dispense.ExistingPatient.SelectStockPileModal'
 )
