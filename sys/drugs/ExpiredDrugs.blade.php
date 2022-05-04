 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Track expired drugs in stock', $Msg = null) !!}
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">

     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Name</th>
                 <th class="bg-danger fw-bolder text-light">Drug Stock</th>
                 <th>Category</th>
                 <th>Vendor</th>

                 <th>Expiry</th>
                 <th class="fw-bolder text-light bg-dark">Expiry Status</th>


                 <th>Qty Now</th>
                 <th>Date Added</th>

                 <th class="bg-info text-light"> Extend Validity </th>
                 <th class="bg-danger fw-bolder text-light"> Dispose Off </th>
                 <th class="bg-primary fw-bolder text-light"> Get Refund
                 </th>



             </tr>
         </thead>
         <tbody>
             @isset($Drugs)
                 @foreach ($Drugs as $data)
                     <tr>

                         <td>{{ $data->DrugName }}</td>
                         <td class="bg-danger fw-bolder text-light">
                             {{ $data->StockTag }}</td>
                         <td>{{ $data->CatName }}</td>
                         <td>{{ $data->VendorName }}</td>

                         <td>{!! date('F j, Y', strtotime($data->ExpiryDate)) !!}</td>
                         <td class="fw-bolder text-light bg-dark">
                             {!! $data->ExpiryStatus !!}</td>


                         <td>{{ $data->QtyAvailable }} {{ $data->Units }}</td>

                         <td>{!! date('F j, Y', strtotime($data->created_at)) !!}</td>




                         <td>

                             <a data-bs-toggle="modal"
                                 class="btn shadow-lg btn-info btn-sm admin"
                                 href="#Update{{ $data->StID }}">

                                 <i class="fas fa-clock" aria-hidden="true"></i>
                             </a>

                         </td>



                         <td>

                             <a data-route="{{ route('DisposeOffDrug', ['id' => $data->StID]) }}"
                                 data-msg="You sure you want to dispose off the selected drug and record a loss? This action is not reversible"
                                 class="btn shadow-lg btn-danger btn-sm admin deleteConfirm"
                                 href="#">

                                 <i class="fas fa-times" aria-hidden="true"></i>
                             </a>

                         </td>

                         <td>

                             <a data-bs-toggle="modal"
                                 class="btn shadow-lg btn-primary btn-sm admin"
                                 href="#Refund{{ $data->StID }}">

                                 <i class="fas fa-coins" aria-hidden="true"></i>
                             </a>

                         </td>




                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>
 <!--end::Card body-->

 @include('drugs.Refund')


 @isset($Drugs)
     @include('viewer.viewer', [
         'PassedData' => $Drugs,
         'Title' => 'View the Description of the selected drug',
         'DescriptionTableColumn' => 'DrugDescription',
     ])
 @endisset

 @isset($Drugs)
     @foreach ($Drugs as $data)
         {{ UpdateModalHeader($Title = 'Extend  validity of the selected drug stockpile', $ModalID = $data->StID) }}
         <form action="{{ route('MassUpdate') }}" class=""
             method="POST" enctype="multipart/form-data">
             @csrf

             <div class="row">
                 <input type="hidden" name="id" value="{{ $data->StID }}">

                 <input type="hidden" name="TableName" value="stock_piles">




                 {{ RunUpdateModalFinal($ModalID = $data->id,$Extra = '',$csrf = null,$Title = null,$RecordID = $data->StID,$col = '12',$te = '12',$TableName = 'stock_piles') }}
             </div>


             {{ UpdateModalFooter() }}

         </form>
     @endforeach
 @endisset
