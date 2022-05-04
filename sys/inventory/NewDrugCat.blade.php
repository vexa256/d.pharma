<div class="modal fade" id="New">
    <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-gray">
                <h5 class="modal-title">Let's create a new stock category

                </h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body ">

                <form action="{{ route('MassInsert') }}" class="row"
                    method="POST" enctype="multipart/form-data"> @csrf
                    <div class="row">



                        <input type="hidden" name="created_at"
                            value="{{ date('Y-m-d h:i:s') }}">

                        <input type="hidden" name="TableName"
                            value="drug_categories">

                        @foreach ($Form as $data)
                            @if ($data['type'] == 'string')
                                {{ CreateInputText($data, $placeholder = null, $col = '12') }}
                            @elseif ('smallint' == $data['type'] || 'bigint' === $data['type'] || 'integer' == $data['type'] || 'bigint' == $data['type'])
                                {{ CreateInputInteger($data, $placeholder = null, $col = '6') }}
                            @elseif ($data['type'] == 'date' || $data['type'] == 'datetime')
                                {{ CreateInputDate($data, $placeholder = null, $col = '6') }}
                            @endif
                        @endforeach

                    </div>

                    <div class="row">
                        @foreach ($Form as $data)
                            @if ($data['type'] == 'text')
                                {{ CreateInputEditor($data, $placeholder = null, $col = '12') }}
                            @endif
                        @endforeach

                    </div>



                    {!! Form::hidden($name = 'DCID', $value = \Hash::make(uniqid() . 'AFC' . date('Y-m-d H:I:S')), [($options = null)]) !!}

                    {!! Form::hidden($name = 'uuid', $value = \Hash::make(uniqid() . 'AFC' . date('Y-m-d H:I:S')), [($options = null)]) !!}



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info"
                    data-bs-dismiss="modal">Close</button>

                <button type="submit" class="btn btn-dark">Save
                    Changes</button>

                </form>
            </div>

        </div>
    </div>
</div>
