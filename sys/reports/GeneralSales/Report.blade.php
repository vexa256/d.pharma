<!--begin::Card body-->
<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'General Sales Report for the Months ' . $FromMonth . ' to  ' . $ToMonth . ' ', $Msg = null) !!}
    {{-- {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'Credit Payment Report', $Icon = 'fa-binoculars') }} --}}
</div>
@include('reports.GeneralSales.stats')



<div class="card-body pt-3 bg-light shadow-lg table-responsive">

    <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
        <thead>
            <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                <th>Total Sales</th>
                <th>Payment Method</th>
                <th>Month of Sales</th>
                <th>Report Year</th>


            </tr>
        </thead>
        <tbody>
            @isset($Reports)
                @foreach ($Reports as $data)
                    <tr>

                        <td>UGX {{ number_format($data->TotalSales) }}</td>
                        <td>{{ $data->PaymentMode }}</td>
                        <td><?php
                        
                        $monthNum = $data->Month;
                        $dateObj = DateTime::createFromFormat('!m', $monthNum);
                        echo $dateObj->format('F');
                        
                        ?></td>
                        <td>{{ $data->Year }}</td>

                    </tr>
                @endforeach
            @endisset



        </tbody>
    </table>
</div>
