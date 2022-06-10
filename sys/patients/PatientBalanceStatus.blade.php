<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    <div class="card-body pt-3 bg-light shadow-lg table-responsive">
        {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'A patient balance indicates that the pharmacy owes the patient', $Msg = null) !!} </div>
    <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
        <thead>
            <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Balance</th>
                <th>Deplete Balance</th>

            </tr>
        </thead>
        <tbody> @isset($Credit)
                @foreach ($Credit as $data)
                    <tr>
                        <td>{{ $data->PatientName }}</td>
                        <td>{{ $data->PatientEmail }}</td>
                        <td>{{ $data->PatientPhone }}</td>
                        <td class="bg-dark text-light">
                            {{ number_format($data->Balance) }} UGX</td>
                        <td>
                            <a href="{{ route('DepleteClientBalance', ['unique' => $data->_unique]) }}"
                                class="bg-danger btn btn-sm shadow-lg">

                                <i class="fa text-light fa-arrow-right" aria-hidden="true"></i>

                            </a>
                        </td>


                    </tr>
                @endforeach @endisset
            </tbody>
        </table>
    </div>
