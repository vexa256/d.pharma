<!--begin::Card body-->
<div class="card-body pt-3 bg-light shadow-lg table-responsive">
    {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Stock Refund/Exchange Report for the months ' . $FromMonth . ' to ' . $ToMonth, $Msg = null) !!}
</div>
@include('reports.RefundReport.Stats')

<div class="card-body pt-3 bg-light shadow-lg table-responsive">

    <table class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
        <thead>
            <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                <th>Stock Item</th>
                <th>Batch No.</th>
                <th>Vendor</th>
                <th>Recovered Amount (UGX)</th>
                <th>Exchanged/Refunded Qty</th>
                <th>Stock Buying Price</th>
                <th>Stock Selling Price</th>
                <th>Refund Month</th>
                <th>Refund Year</th>
                <th>Refund Notes</th>
                <th>Registered By</th>

            </tr>
        </thead>
        <tbody>
            @isset($Reports)
                @foreach ($Reports as $data)
                    <tr>
                        <td>{{ $data->DrugName }}</td>
                        <td>{{ $data->BatchNumber }}</td>
                        <td>{{ $data->Name }}</td>
                        <td>UGX {{ number_format($data->RecoveredAmount) }}</td>
                        <td> {{ number_format($data->RefundedQty) }}
                            {{ $data->UnitName }}</td>
                        <td>UGX {{ number_format($data->BuyingPrice) }}</td>
                        <td>UGX {{ number_format($data->SellingPrice) }}</td>
                        <td>
                            <?php

                            $monthNum = $data->RefundMonth;
                            $dateObj = DateTime::createFromFormat('!m', $monthNum);
                            echo $dateObj->format('F');

                            ?>
                        </td>

                        <td>
                            {{ $data->RefundYear }}
                        </td>


                        <td>
                            {!! $data->RefundDetails !!}
                        </td>

                        <td>
                            {{ $data->RefundRegisteredBy }}
                        </td>






                    </tr>
                @endforeach
            @endisset



        </tbody>
    </table>
</div>
