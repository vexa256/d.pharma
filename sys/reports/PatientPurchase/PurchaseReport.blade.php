<!--begin::Card body-->
<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Patient Purchasing Power Analysis', $Msg = null) !!}
</div>
@include('reports.PatientPurchase.Stats')

<div class="card-body pt-3 bg-light shadow-lg table-responsive">

    <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
        <thead>
            <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                <th>Total Purchases</th>
                <th>Patient Name</th>

            </tr>
        </thead>
        <tbody>
            @isset($Reports)
                @foreach ($Reports as $data)
                    <tr>

                        <td>UGX {{ number_format($data->TotalSales) }}</td>
                        <td>{{ $data->PatientName }}</td>



                    </tr>
                @endforeach
            @endisset



        </tbody>
    </table>
</div>
