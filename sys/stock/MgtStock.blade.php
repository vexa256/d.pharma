 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info ', $class = 'alert-danger ', $Title = '' . $Drugs->DrugName . ' Stockpiles in the inventory | Total Stockpile Quantity :: ' . $Total . ' Units', $Msg = null) !!}
 </div>
 <div class="col-md-12">
     <div class="card-body">
         {!! $chart->container() !!}

     </div>
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'New Stockpile', $Icon = 'fa-plus') }}
     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">

                 <th>Stock</th>
                 <th>Batch</th>
                 <th>Drug</th>
                 <th>Category</th>
                 <th>Vendor</th>
                 <th>Min QTY</th>
                 <th>QTY</th>
                 <th> Selling Price</th>
                 <th> Buying Price</th>
                 <th> Validity</th>
                 <th>Expiry</th>

                 <th>Date Addded</th>
                 <th>Actions</th>


             </tr>
         </thead>
         <tbody>
             @isset($Stock)
                 @foreach ($Stock as $data)
                     <tr>


                         <td>{{ $data->StockTag }}</td>
                         <td>{{ $data->BatchNumber }}</td>
                         <td>{{ $data->DrugName }}</td>
                         <td>{{ $data->CatName }}</td>
                         <td>{{ $data->VendorName }}</td>
                         <td>{{ $data->MinimumQty }}
                             {{ $data->Dunit }}
                         </td>
                         <td>{{ $data->StockQty }}
                             {{ $data->Dunit }}</td>
                         <td> {{ $data->Currency }}
                             {{ $data->UnitSellingPrice }}</td>
                         <td> {{ $data->Currency }}
                             {{ $data->UnitBuyingPrice }}

                         </td>
                         <td>{{ $data->MonthsToExpiry }} Months</td>
                         <td>{!! date('F j, Y', strtotime($data->ExpiryDate)) !!}</td>
                         <td>{!! date('F j, Y', strtotime($data->created_at)) !!}</td>

                         <td>

                             <a data-bs-toggle="modal"
                                 class="btn d-none shadow-lg btn-info btn-sm admin"
                                 href="#Update{{ $data->BautoID }}">

                                 <i class="fas fa-edit" aria-hidden="true"></i>
                             </a>



                             {!! ConfirmBtn(
    $data = [
        'msg' => 'You want to delete this record',
        'route' => route('DeleteData', ['id' => $data->BautoID, 'TableName' => 'stock_piles']),
        'label' => '<i class="fas fa-trash"></i>',
        'class' => 'btn btn-danger btn-sm deleteConfirm admin',
    ],
) !!}

                         </td>






                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>
 <!--end::Card body-->

 @include('stock.NewStock')



 @isset($Stock)
     @foreach ($Stock as $data)
         {{ UpdateModalHeader($Title = 'Update the selected  drug Stock record', $ModalID = $data->BautoID) }}
         <form novalidate action="{{ route('MassUpdate') }}"
             class="" method="POST" enctype="multipart/form-data">
             @csrf

             <div class="row">
                 <input type="hidden" name="id" value="{{ $data->BautoID }}">

                 <input type="hidden" name="TableName" value="stock_piles">







                 <div class="mt-3  mb-3  col-md-12 ">
                     <label id="label" for="" class=" required form-label">Drug
                         Supplier</label>
                     <select required name="VID"
                         class="form-select  form-select-solid"
                         data-control="select2" data-placeholder="Select an option">
                         <option value="{{ $data->VID }}">
                             {{ $data->VendorName }}</option>
                         @isset($Vendors)
                             @foreach ($Vendors as $dataxd)
                                 <option value="{{ $dataxd->VID }}">
                                     {{ $dataxd->Name }}</option>
                             @endforeach
                         @endisset

                     </select>

                 </div>





                 {{ RunUpdateModalFinal($ModalID = $data->id,$Extra = '',$csrf = null,$Title = null,$RecordID = $data->BautoID,$col = '4',$te = '12',$TableName = 'stock_piles') }}
             </div>


             {{ UpdateModalFooter() }}

         </form>
     @endforeach
 @endisset
