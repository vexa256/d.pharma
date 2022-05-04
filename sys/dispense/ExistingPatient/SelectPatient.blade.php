<!--begin::Card body-->
<div class="card-body pt-3 bg-light table-responsive">
</div>
<div class="card-body shadow-lg pt-3 bg-light table-responsive">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('AcceptPatientSelection') }}"
                method="POST">
                @csrf
                <div class="mb-3 col-md-12  py-5   my-5">
                    <label id="label" for=""
                        class="px-5   my-5 required form-label">Select a
                        Patient to sell to</label>
                    <select required name="id" class="form-select  py-5   my-5 "
                        data-control="select2"
                        data-placeholder="Select an option">
                        <option></option>
                        @isset($Patients)

                            @foreach ($Patients as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->Name }}</option>
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
            </form>


        </div>



    </div>


</div>
