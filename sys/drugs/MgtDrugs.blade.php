 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Let\'s manage our pharmacy inventory.', $Msg = null) !!}
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'New Drug', $Icon = 'fa-plus') }}
     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Drug Name </th>
                 <th>Category</th>
                 <th>Buying Price</th>
                 <th>Selling Price</th>
                 <th>MIN QTY</th>

                 <th>Description</th>
                 <th>Date Added</th>
                 <th class="bg-dark text-light"> Update </th>
                 <th class="bg-danger fw-bolder text-light"> Delete </th>



             </tr>
         </thead>
         <tbody>
             @isset($Drugs)
                 @foreach ($Drugs as $data)
                     <tr>

                         <td>{{ $data->DrugName }}</td>
                         <td>{{ $data->CatName }}</td>
                         <td>{{ $data->Currency }} {{ $data->UnitBuyingPrice }}
                         </td>
                         <td>{{ $data->Currency }} {{ $data->UnitSellingPrice }}
                         </td>
                         <td>{{ $data->MinimumQty }} {{ $data->Unit }}</td>


                         <td>
                             <a data-bs-toggle="modal"
                                 class="btn btn-dark shadow-lg btn-sm"
                                 href="#Desc{{ $data->id }}">

                                 <i class="fas fa-binoculars" aria-hidden="true"></i>
                             </a>

                         </td>

                         <td>{!! date('F j, Y', strtotime($data->created_at)) !!}</td>

                         <td>

                             <a data-bs-toggle="modal"
                                 class="btn shadow-lg btn-danger btn-sm admin"
                                 href="#Update{{ $data->id }}">

                                 <i class="fas fa-edit" aria-hidden="true"></i>
                             </a>

                         </td>


                         <td>

                             {!! ConfirmBtn(
    $data = [
        'msg' => 'You want to delete this record',
        'route' => route('DeleteData', ['id' => $data->id, 'TableName' => 'drugs']),
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
 @include('drugs.NewDrug')


 @isset($Drugs)
     @include('viewer.viewer', [
         'PassedData' => $Drugs,
         'Title' => 'View the Description of the selected drug',
         'DescriptionTableColumn' => 'DrugDescription',
     ])
 @endisset

 @isset($Drugs)
     @foreach ($Drugs as $data)
         {{ UpdateModalHeader($Title = 'Update the selected  record', $ModalID = $data->id) }}
         <form novalidate action="{{ route('MassUpdate') }}"
             class="" method="POST" enctype="multipart/form-data">
             @csrf

             <div class="row">


                 <div class="mt-3  mb-3 col-md-6  ">
                     <label id="label" for="" class=" required form-label">Drug
                         Categories</label>
                     <select required name="DCID" class="form-select  "
                         data-control="select2" data-placeholder="Select an option">
                         <option value="{{ $data->DCID }}">
                             {{ $data->CatName }}</option>
                         @isset($Categories)
                             @foreach ($Categories as $datadd)
                                 <option value="{{ $datadd->DCID }}">
                                     {{ $datadd->CategoryName }}</option>
                             @endforeach
                         @endisset

                     </select>

                 </div>


                 <div class="mt-3  mb-3 col-md-6  ">
                     <label id="label" for=""
                         class=" required form-label">Measurement
                         Units</label>
                     <select required name="MeasurementUnits" class="form-select  "
                         data-control="select2" data-placeholder="Select an option">
                         <option value="{{ $data->MeasurementUnits }}">
                             {{ $data->Unit }}</option>
                         @isset($Units)
                             @foreach ($Units as $datadd)
                                 <option value="{{ $datadd->UnitID }}">
                                     {{ $datadd->Unit }}</option>
                             @endforeach
                         @endisset

                     </select>

                 </div>

















                 <input type="hidden" name="id" value="{{ $data->id }}">

                 <input type="hidden" name="TableName" value="drugs">

                 {{ RunUpdateModalFinal($ModalID = $data->id,$Extra = '',$csrf = null,$Title = null,$RecordID = $data->id,$col = '6',$te = '12',$TableName = 'drugs') }}
             </div>


             {{ UpdateModalFooter() }}

         </form>
     @endforeach
 @endisset
