<script>
      window.addEventListener('DOMContentLoaded', (event) => {
    const container = document.querySelector('#MgtGrantsSheet');

    const hot = new Handsontable(container, {
      data: [
        @isset($Grants)
                @foreach ($Grants as $data)
                    ['{{ $data->GrantName }}', ' {{ $data->status }}', `{{ date('j F, Y', strtotime($data->GrantExpiry)) }}`,`{{ date('j F, Y', strtotime($data->GrantExpiry)) }}`,
                    '{{ $data->Donor }}','$data->GrantCategory',
                    '{{ number_format($data->OriginalAmount, 2) }}','{{ $data->OriginalCurrency }}',
                    '{{ number_format($data->OriginalExchangeRate, 2) }} UGX','{{ number_format($data->AmountInUgx, 2) }} UGX ',
                    '{{ number_format($data->AvailableGrantAmountInUgx, 2) }} UGX',

                    '{{ number_format($data->GrantAmountAlreadySpentInUgx, 2) }} UGX','{{ $data->GrantNumber }}'],



                @endforeach
            @endisset
      ],
      colHeaders: ['Grant', 'Status', 'Start Date', 'End Date', 'Donor', 'Grant Category', 'Original Amount',
                'Original Currency',
                'Original Exchange Rate',
                'Amount (UGX)',
                'Available Grant Amount (UGX)',
                'Grant Amount Spent  (UGX)',
                'Grant Number',
                'Actions',],

  height: '500px',
  rowHeights: 23,
  colWidths: 100,
      licenseKey: 'non-commercial-and-evaluation'
    });
    });
    </script>
