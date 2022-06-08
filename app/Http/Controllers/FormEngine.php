<?php

namespace App\Http\Controllers;

use DB;

class FormEngine extends Controller
{
    public function Form($TableName)
    {
        $Form = [];

        $schema = DB::getDoctrineSchemaManager();

        //dd($schema->listTableColumns('patients')['id']->getType()->getName());

        $table = $schema->listTableColumns($TableName);

        foreach ($table as $column) {

            $Form[] = [
                'name' => $column->getName(),
                'type' => $column->getType()->getName(),
            ];
        }

        return $Form;
    }

    private function CreateInputText($data, $value, $col)
    {
        return $data = ' <div class="col-md-' . $col . ' mb-3 mt-3 x_' . $data['name'] . '">
        <div class="mb-3">
            <label class="required form-label">' . ucfirst(FromCamelCase($data['name'])) . '</label>
            <input required type="text" name="' . $data['name'] . '" class="form-control " value="' . $value . '" />
        </div>
    </div>';
    }

    private function CreateInputInteger($data, $value, $col)
    {
        return $data = '<div class="col-md-' . $col . ' mb-3 mt-3 x_' . $data['name'] . '">
        <div class="mb-3">
            <label class="required form-label">' . ucfirst(FromCamelCase($data['name'])) . '</label>
            <input required type="text" name="' . $data['name'] . '" class="form-control IntOnlyNow" value="' . $value . '" />
        </div>
    </div>';
    }

    private function CreateInputDate($data, $value, $col)
    {
        return $data = ' <div class="col-md-' . $col . ' mb-3 mt-3 x_' . $data['name'] . '">
        <div class="mb-3">
            <label class="required form-label">' . ucfirst(FromCamelCase($data['name'])) . '</label>
            <input required type="text" name="' . $data['name'] . '" class="form-control DateArea" value="' . $value . '" />
        </div>
    </div>';
    }

    private function CreateInputEditor($data, $value, $col)
    {
        return $data = ' <div class="col-md-' . $col . ' mb-3 mt-3 x_' . $data['name'] . '">
        <div class="mb-3">
            <label class="required form-label">' . ucfirst(FromCamelCase($data['name'])) . '</label>
            <textarea name="' . $data['name'] . '" class="form-control editorme">
                ' . $value . '
            </textarea>
        </div>
    </div>';
    }

    public function UpdateTable($TableName = null, $id = null, $col = "4", $te = '12')
    {
        $UpdateForm = [];

        $Up = DB::table($TableName)->where('id', $id)->first();

        $Fields = $this->Form($TableName);

        $UpdateForm[] = [

            //  'Field' => '<input type="hidden" name="TableName" value="' . $TableName . '">',

        ];

        $UpdateForm[] = [

            'Field' => '<input type="hidden" name="id" value="' . $id . '">',

        ];

        foreach ($Fields as $data) {

            if ('string' == $data['type']) {

                $output = $this->CreateInputText($data, $Up->{$data['name']}, $col);

                $UpdateForm[] = ['Field' => $output];

            } elseif ('smallint' == $data['type'] || 'bigint' === $data['type'] || 'integer' == $data['type'] || 'bigint' == $data['type']) {

                $output = $this->CreateInputInteger($data, $Up->{$data['name']}, $col);

                $UpdateForm[] = ['Field' => $output];

            } elseif ('date' == $data['type'] || 'datetime' == $data['type']) {

                $output = $this->CreateInputDate($data, $Up->{$data['name']}, $col);

                $UpdateForm[] = ['Field' => $output];

            } elseif ('text' == $data['type']) {

                $output = $this->CreateInputEditor($data, $Up->{$data['name']}, $te);

                $UpdateForm[] = ['Field' => $output];

            }

        }

        foreach ($UpdateForm as $data) {

            echo $data['Field'];

        }

    }

    public function UpdateTable2($TableName = null, $id = null, $col = "4", $te = '12')
    {
        $UpdateForm = [];

        $Up = DB::table($TableName)->where('id', $id)->first();

        $Fields = $this->Form($TableName);

        $UpdateForm[] = [

            'Field' => '<input type="hidden" name="TableName" value="' . $TableName . '">',

            'Field' => '<input type="hidden" name="id" value="' . $id . '">',

        ];

        foreach ($Fields as $data) {

            if ('string' == $data['type']) {

                $output = $this->CreateInputText($data, $Up->{$data['name']}, $col);

                $UpdateForm[] = ['Field' => $output];

            } elseif ('smallint' == $data['type'] || 'bigint' === $data['type'] || 'integer' == $data['type'] || 'bigint' == $data['type']) {

                $output = $this->CreateInputInteger($data, $Up->{$data['name']}, $col);

                $UpdateForm[] = ['Field' => $output];

            } elseif ('date' == $data['type'] || 'datetime' == $data['type']) {

                $output = $this->CreateInputDate($data, $Up->{$data['name']}, $col);

                $UpdateForm[] = ['Field' => $output];

            }

        }

        foreach ($Fields as $data) {

            if ('text' == $data['type']) {

                $output = $this->CreateInputEditor($data, $Up->{$data['name']}, $te);

                $UpdateForm[] = ['Field' => $output];

            }
        }

        return $UpdateForm;

    }

    public function UpdateModal($ModalID,
        $Extra, $csrf, $Title, $RecordID, $col, $te, $TableName) {

        $ExtraFields = $Extra;

        $GeneralForm = '';

        $up = $this->UpdateTable2(

            $TableName = $TableName,
            $id = $RecordID,
            $col = $col,
            $te = $te
        );

        foreach ($up as $da) {

            $GeneralForm .= $da['Field'];
        }

        echo '<div class="modal bg-white fade"  id="Update' . $ModalID . '">
        <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
            <div class="modal-content shadow-none">
                <div class="modal-header">
                    <h5 class="modal-title">' . $Title . '</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class=" text-dark svg-icon svg-icon-2x">
                            <i class="fas fa-times fa-2x"></i>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">

                <div class="row">

                        ' . $ExtraFields . '

                        ' . $GeneralForm . '

                </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger shadow-lg" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-dark shadow-lg">Update Record</button>

                </div>
            </div>
        </div>
    </div>';

    }

    public function UpdateModalFinal($ModalID,
        $Extra, $csrf, $Title, $RecordID, $col, $te, $TableName) {

        $ExtraFields = $Extra;

        $GeneralForm = '';

        $up = $this->UpdateTable2(

            $TableName = $TableName,
            $id = $RecordID,
            $col = $col,
            $te = $te
        );

        foreach ($up as $da) {

            $GeneralForm .= $da['Field'];
        }

        echo '
                <div class="row">

                        ' . $ExtraFields . '

                        ' . $GeneralForm . '

                </div>
                ';

    }

}
