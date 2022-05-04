<!--begin::Card body-->
<div class="card-body pt-3 bg-light table-responsive">
</div>


<div class="card-body shadow-lg pt-3 bg-light table-responsive">
    <div class="">
        <form action="{{ route('DisposalReportAccept') }}" method="POST">
            <div class="row">

                @csrf
                <div class="mb-3 col  py-5   my-5">
                    <label id="label" for=""
                        class="px-5   my-5 required form-label">From
                        Month</label>
                    <select required name="FromMonth"
                        class="form-select  py-5   my-5 form-select-solid"
                        data-control="select2"
                        data-placeholder="Select an option">
                        <option></option>
                        @isset($Reports)

                            @foreach ($Reports->unique('DisposedMonth') as $data)
                                <option value="{{ $data->DisposedMonth }}">
                                    <?php

                                    $monthNum = $data->DisposedMonth;
                                    $dateObj = DateTime::createFromFormat('!m', $monthNum);
                                    echo $dateObj->format('F');

                                    ?>
                                </option>
                            @endforeach
                        @endisset

                    </select>

                </div>

                <div class="mb-3 col  py-5   my-5">
                    <label id="label" for=""
                        class="px-5   my-5 required form-label">To
                        Month</label>
                    <select required name="ToMonth"
                        class="form-select  py-5   my-5 form-select-solid"
                        data-control="select2"
                        data-placeholder="Select an option">
                        <option></option>
                        @isset($Reports)

                            @foreach ($Reports->unique('DisposedMonth') as $data2)
                                <option value="{{ $data2->DisposedMonth }}">
                                    <?php

                                    $monthNum = $data2->DisposedMonth;
                                    $dateObj = DateTime::createFromFormat('!m', $monthNum);
                                    echo $dateObj->format('F');

                                    ?>
                                </option>
                            @endforeach
                        @endisset
                    </select>

                </div>

                <div class="mb-3 col  py-5   my-5">
                    <label id="label" for=""
                        class="px-5   my-5 required form-label">Select
                        Year</label>
                    <select required name="Year"
                        class="form-select  py-5   my-5 form-select-solid"
                        data-control="select2"
                        data-placeholder="Select an option">
                        <option></option>
                        @isset($Reports)

                            @foreach ($Reports->unique('DisposedYear') as $data3)
                                <option value="{{ $data->DisposedYear }}">
                                    {{ $data3->DisposedYear }}</option>
                            @endforeach
                        @endisset

                    </select>

                </div>
            </div>
            <div class="float-end my-3">
                <button class="btn btn-danger shadow-lg" type="submit">
                    Next
                </button>

            </div>

        </form>

    </div>


</div>
