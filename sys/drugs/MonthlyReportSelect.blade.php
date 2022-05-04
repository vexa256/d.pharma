<!--begin::Card body-->
<div class="card-body pt-3 bg-light table-responsive">
</div>
<div class="card-body shadow-lg pt-3 bg-light table-responsive">
    <form action="{{ route('GenerateMonthlyRestock') }}" method="POST">
        <div class="row">

            @csrf
            <div class="col-md-6">


                <div class="mb-3 col-md-12  py-5   my-5">
                    <label id="label" for=""
                        class="px-5   my-5 required form-label">Select
                        Month</label>
                    <select required name="Month"
                        class="form-select  py-5   my-5 form-select-solid"
                        data-control="select2"
                        data-placeholder="Select an option">
                        <option></option>
                        @isset($Drugs)

                            @foreach ($Drugs as $data)
                                <option value="{{ $data->Month }}">
                                    {{ $data->Month }}</option>
                            @endforeach
                        @endisset

                    </select>

                </div>



            </div>

            <div class="col-md-6">


                <div class="mb-3 col-md-12  py-5   my-5">
                    <label id="label" for=""
                        class="px-5   my-5 required form-label">Select
                        Year</label>
                    <select required name="Year"
                        class="form-select  py-5   my-5 form-select-solid"
                        data-control="select2"
                        data-placeholder="Select an option">
                        <option></option>
                        @isset($Drugs)

                            @foreach ($Drugs as $data2)
                                <option value="{{ $data2->Year }}">
                                    {{ $data2->Year }}</option>
                            @endforeach
                        @endisset

                    </select>

                </div>
                <div class="float-end my-3">
                    <button class="btn btn-danger btn-sm shadow-lg"
                        type="submit">
                        Next
                    </button>
                </div>



            </div>



        </div>
    </form>

</div>
