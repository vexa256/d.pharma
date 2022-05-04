<!--begin::Card body-->
<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Manage next of keens attached to ' . $Name, $Msg = null) !!} </div>
<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'New Next Of Kin', $Icon = 'fa-plus') }}
    <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
        <thead>
            <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                <th>Name</th>
                <th>Patient</th>
                <th>Relationship</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody> @isset($NextOfKins) @foreach ($NextOfKins as $data)
                <tr>
                    <td>{{ $data->Name }}</td>
                    <td>{{ $data->PatientName }}</td>
                    <td>{{ $data->Relationship }}</td>
                    <td>{{ $data->Email }}</td>
                    <td>{{ $data->Phone }}</td>
                    <td>{{ $data->Address }}</td>


                    <td> <a data-bs-toggle="modal"
                            class="btn shadow-lg  me-1 btn-dark btn-sm admin TriggerNDA"
                            href="#Update{{ $data->id }}"> <i
                                class="fas fa-edit" aria-hidden="true"></i>




                            {!! ConfirmBtn(
    $data = [
        'msg' => 'You want to delete this record',
        'route' => route('DeleteData', ['id' => $data->id, 'TableName' => 'patient_next_of_kin']),
        'label' => '<i class="fas fa-trash"></i>',
        'class' => 'btn btn-danger btn-sm deleteConfirm admin',
    ],
) !!}



                        </a>
                    </td>
                </tr>
            @endforeach @endisset </tbody>
    </table>
</div>


@include('patients.NewNextOfKin')


@isset($NextOfKins)
    @foreach ($NextOfKins as $data)
        {{ UpdateModalHeader($Title = 'Update the selected next of kin', $ModalID = $data->id) }}
        <form novalidate action="{{ route('MassUpdate') }}" class=""
            method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="mt-3  mb-3 col-md-4  ">
                    <label id="label" for="" class=" required form-label">Patient's
                        name</label>
                    <select required name="PID" class="form-select  "
                        data-control="select2" data-placeholder="Select an option">
                        <option value="{{ $PID }}">
                            {{ $Name }}</option>

                    </select>

                </div>


                <input type="hidden" name="id" value="{{ $data->id }}">

                <input type="hidden" name="TableName" value="patient_next_of_kin">

                {{ RunUpdateModalFinal($ModalID = $data->id,$Extra = '',$csrf = null,$Title = null,$RecordID = $data->id,$col = '4',$te = '12',$TableName = 'patient_next_of_kin') }}
            </div>


            {{ UpdateModalFooter() }}

        </form>
    @endforeach
@endisset
