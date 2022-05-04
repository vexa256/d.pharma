@isset($PassedData)
    @foreach ($PassedData as $data)
        <div class="modal fade" id="Desc{{ $data->id }}">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header bg-gray">
                        <h5 class="modal-title">{{ $Title }}

                        </h5>

                        <!--begin::Close-->
                        <a href="#MgtTaxes" data-bs-toggle="modal" type="button"
                            class="btn btn-info" data-bs-dismiss="modal"
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                        </a>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body ">

                        <textarea class="editorme">
                        {{ $data->$DescriptionTableColumn }}
                    </textarea>

                    </div>

                    <div class="modal-footer">
                        <a data-bs-toggle="modal" href="#" type="button"
                            class="btn btn-info" data-bs-dismiss="modal">Close</a>


                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endisset





@isset($Employees)
    @foreach ($Employees as $data)
        <div class="modal fade" id="ViewLeaveDesc{{ $data->id }}">
            <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header bg-gray">
                        <h5 class="modal-title">View description for the leave
                            category labeled
                            <span class="text-danger font-weight-bold">
                                {{ $data->LeaveType }}
                            </span>
                        </h5>

                        <!--begin::Close-->
                        <a href="#MgtTaxes" data-bs-toggle="modal" type="button"
                            class="btn btn-info" data-bs-dismiss="modal"
                            class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                        </a>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body ">

                        <textarea>
                        {{ $data->Description }}
                    </textarea>

                    </div>

                    <div class="modal-footer">
                        <a data-bs-toggle="modal" href="#MgtTaxes" type="button"
                            class="btn btn-info" data-bs-dismiss="modal">Close</a>


                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endisset
