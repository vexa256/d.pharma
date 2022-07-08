<div class="modal fade" id="New" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">View Patient Dispense Notes for the Patient

                    <span class="text-danger fw-bolder">
                        {{ $PatientName }}
                    </span>

                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @isset($Notes)
                    @foreach ($Notes as $data)
                        <textarea class="editorme">
                        {{ $data->DispensaryNotes }}
                    </textarea>
                    @endforeach
                @endisset



            </div>

        </div>
    </div>
</div>
