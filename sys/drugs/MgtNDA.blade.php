 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Select drugs from the National Drug Authority Database to add to your supported drugs', $Msg = null) !!} </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Drug Name</th>
                 <th>Generic Name</th>

                 <th class="bg-dark text-light">Add to Drug List </th>
             </tr>
         </thead>
         <tbody class="DisplayNdaDrugListHere">
             @isset($NDA)
                 @foreach ($NDA as $data)
                     <tr>
                         <td>{{ $data->DrugName }}</td>
                         <td>{{ $data->GenericName }}</td>

                         <td> <a data-generic="{{ $data->GenericName }}"
                                 data-name="{{ $data->DrugName }}"
                                 data-did="{{ $data->DID }}"
                                 data-bs-toggle="modal"
                                 class="btn shadow-lg btn-danger btn-sm admin TriggerNDA"
                                 href="#EnableNDA"> <i class="fas fa-check"
                                     aria-hidden="true"></i>


                             </a> </td>
                     </tr>
                 @endforeach @endisset
             </tbody>
         </table>
     </div>


     @include('drugs.EnableNDA')
