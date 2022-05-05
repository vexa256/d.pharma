<div class="modal fade" id="Explain">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title">Hey there, here is your tabular
                    interpritation of the graph

                </h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body ">
                <table
                    class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
                    <thead>
                        <tr
                            class="fw-bold  text-gray-800 border-bottom border-gray-200">
                            <th>Vendor Name</th>

                            <th class="bg-danger text-light fw-bolder">Contract
                                Validity
                            </th>
                            <th class="bg-danger text-light fw-bolder">Contract
                                Expiry Date
                            </th>
                            <th class="bg-danger text-light fw-bolder">Months to
                                Expiry
                            </th>

                            <th class="bg-dark text-light"> Extend Validity
                            </th>



                        </tr>
                    </thead>
                    <tbody>
                        @isset($Vendors)
                            @foreach ($Vendors as $data)
                                <tr>

                                    <td>{{ $data->Name }}</td>
                                    <td class="bg-dark text-light fw-bolder">
                                        {{ $data->ContractValidity }}</td>
                                    <td class="bg-primary text-light fw-bolder">
                                        {!! date('F j, Y', strtotime($data->ContractExpiry)) !!}

                                    </td>

                                    <td class="bg-primary text-light fw-bolder">
                                        {{ $data->MonthsToContractExpiry }}
                                        Month(s)</td>



                                    <td>

                                        <a data-bs-toggle="modal"
                                            class="btn viewer_only shadow-lg btn-dark btn-sm admin"
                                            href="#Update{{ $data->id }}">

                                            <i class="fas fa-edit"
                                                aria-hidden="true"></i> Edit
                                            Contract Expiry
                                        </a>

                                    </td>








                                </tr>
                            @endforeach
                        @endisset



                    </tbody>
                </table>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info"
                    data-bs-dismiss="modal">Close</button>



            </div>

        </div>
    </div>
</div>
