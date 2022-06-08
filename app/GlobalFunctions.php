<?php
use App\Http\Controllers\FormEngine;

function UpdateModalHeader($Title, $ModalID)
{

    echo ' <div class="modal bg-white fade"  id="Update' . $ModalID . '">
    <div class="modal-dialog modal-fullscreen modal-dialog-scrollable">
        <div class="modal-content shadow-none">
            <div class="modal-header">
                <h5 class="modal-title">' . $Title . '</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span class=" text-dark svg-icon svg-icon-2x">
                        <i class="fas fa-times fa-2x"></i>
                    </span>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">';

}

function UpdateModalFooter()
{
    echo ' </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger shadow-lg"
            data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-dark shadow-lg">Update
            Record</button>


    </div>
    </div>
    </div>
    </div>';
}

function MenuItem($link, $label, $class = "null")
{
    echo ' <div class="menu-item ' . $class . '.">
    <a class="menu-link" href="' . $link . '">
        <span class="menu-bullet">
        <i class="me-2 fas fa-circle-notch text-danger "></i>
        </span>
        <span class="menu-title fs-6">

        ' . $label . '</span>
    </a>
</div>';
}

function HeaderBtn($Toggle, $Class, $Label, $Icon, $BtnClass = "btn-sm")
{
    echo '  <button type="button" class="btn mx-1 float-end   mb-2 ' . $BtnClass . ' ' . $Class . '" data-bs-toggle="modal" data-bs-target="#' . $Toggle . '">
    <i class="fas me-1 ' . $Icon . ' " aria-hidden="true"></i>' . $Label . '</button>';
}

function HeaderBtn2($Toggle, $Class, $Label, $Icon)
{
    echo '  <button type="button" class="btn mx-1 float-end btn-sm  mb-2 ' . $Class . '" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#' . $Toggle . '">
    <i class="fas me-1 ' . $Icon . ' " aria-hidden="true"></i>' . $Label . '</button>';
}

function FromCamelCase($input)
{
    $pattern = '!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!';
    preg_match_all($pattern, $input, $matches);
    $ret = $matches[0];
    foreach ($ret as &$match) {
        $match = strtoupper($match) == $match ?
        strtolower($match) :
        lcfirst($match);
    }

    return implode(' ', $ret);
}

function CreateInputText($data = [], $placeholder = null, $col = '4')
{
    echo ' <div class="col-md-' . $col . ' mb-3 mt-3 x_' . $data['name'] . '">
        <div class="mb-3">
            <label class="required form-label">' . ucfirst(FromCamelCase($data['name'])) . '</label>
            <input required type="text" name="' . $data['name'] . '" class="form-control " placeholder="' . $placeholder . '" />
        </div>
    </div>';
}

function CreateInputInteger($data = [], $placeholder = null, $col = '4')
{
    echo ' <div class="col-md-' . $col . ' mb-3 mt-3 x_' . $data['name'] . '">
        <div class="mb-3">
            <label class="required form-label">' . ucfirst(FromCamelCase($data['name'])) . '</label>
            <input required type="text" name="' . $data['name'] . '" class="form-control IntOnlyNow" placeholder="' . $placeholder . '" />
        </div>
    </div>';
}

function CreateInputDate($data = [], $placeholder = null, $col = '4')
{
    echo ' <div class="col-md-' . $col . ' mb-3 mt-3 x_' . $data['name'] . '">
        <div class="mb-3">
            <label class="required form-label">' . ucfirst(FromCamelCase($data['name'])) . '</label>
            <input required type="text" name="' . $data['name'] . '" class="form-control DateArea" placeholder="' . $placeholder . '" />
        </div>
    </div>';
}

function CreateInputEditor($data = [], $placeholder = null, $col = '12')
{
    echo ' <div class="col-md-' . $col . ' mb-3 mt-3 x_' . $data['name'] . '">
        <div class="mb-3">
            <label class="required form-label">' . ucfirst(FromCamelCase($data['name'])) . '</label>
            <textarea name="' . $data['name'] . '" class="form-control editorme"></textarea>
        </div>
    </div>';
}

function DescModal($ArrayData, $Title, $ModalID)
{
    foreach ($ArrayData as $data) {
        echo '<div class="modal fade"  id="' . $ModalID . $data->id . '">
        <div class="modal-dialog modal-dialog-scrollable modal-fullscreen ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                       ' . $Title . '
                    </h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                        <i class="fas fa-3x text-dark fa-times" aria-hidden="true"></i>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">


                        <div class="mb-10 col-md-12">
                            <label for="exampleFormControlInput1" class="required form-label">Description/Details</label>
                            <textarea name="Desc">
                             ' . $data->Description . '
                            </textarea>
                        </div>


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-dark shadow-lg" data-bs-dismiss="modal">Close</button>


                </div>

            </div>
        </div>
    </div>';
    }
}

function ConfirmBtn($data = [
    'msg'   => '',
    'route' => '',
    'label' => 'delete',
    'class' => 'dropdown-item deleteConfirm',
]) {
    echo '
    <a data-msg="' . $data['msg'] . '
    " data-route="' . $data['route'] . '
    " class="' . $data['class'] . '
    " href="#">' . $data['label'] .
        '</a>';
}

function Alert($icon = 'fa-info', $class = 'alert-primary', $Title = '', $Msg = '')
{
    echo '<div class="alert ' . $class . ' shadow-lg">
   <!--begin::Icon-->
   <span class=" float-end svg-icon svg-icon-2hx svg-icon-primary me-3">

      <i class="fas ' . $icon . ' fa-2x" aria-hidden="true"></i>

   </span>
   <!--end::Icon-->

   <!--begin::Wrapper-->
   <div class="d-flex flex-column">
       <!--begin::Title-->
       <h4 class="mb-1 text-dark">' . $Title . '</h4>
       <!--end::Title-->
       <!--begin::Content-->
       <span>' . $Msg . '</span>
       <!--end::Content-->
   </div>
   <!--end::Wrapper-->
</div>
<!--end::Alert-->
';
}

function UpdateString($name = null, $label = null, $value = null)
{
    echo ' <div class="col-md-4 mb-3 mt-3 ">
    <div class="mb-3">
        <label class="required form-label">' . $label . '</label>
        <input required type="text" name="' . $name . '" class="form-control " placeholder="" value="' . $value . '"/>
    </div>
</div>';
}

function UpdateInteger($name = null, $label = null, $value = null)
{
    echo ' <div class="col-md-4 mb-3 mt-3">
     <div class="mb-3">
     <label class="required form-label">' . $label . '</label>
     <input required type="text" name="' . $name . '" class="form-control IntOnlyNow" placeholder="" value="' . $value . '"/>

     </div>
 </div>';
}

function UpdateDate($name = null, $label = null, $value = null)
{
    echo '  <div class="col-md-4 mb-3 mt-3">
      <div class="mb-3">
      <label class="required form-label">' . $label . '</label>
      <input required type="text" name="' . $name . '" class="form-control DateArea" placeholder="" value="' . $value . '"/>

      </div>
  </div>';
}

function UpdateDate2($name = null, $label = null, $value = null)
{
    echo '  <div class="col-md-12 mb-3 mt-3">
      <div class="mb-3">
      <label class="required form-label">' . $label . '</label>
      <input required type="text" name="' . $name . '" class="form-control DateArea" placeholder="" value="' . $value . '"/>

      </div>
  </div>';
}

function UpdateText($name = null, $label = null, $value = null)
{
    echo '<div class="col-md-12 mb-3 mt-3">
      <div class="mb-3">
      <label class="required form-label">' . $label . '</label>
          <textarea name="' . $name . '" class="form-control">
            ' . $value . '
          </textarea>
      </div>
  </div>
';

}

function RunUpdateModal($ModalID,
    $Extra, $csrf, $Title, $RecordID, $col, $te, $TableName) {

    $FormEngine = new FormEngine;

    return $FormEngine->UpdateModal($ModalID,
        $Extra, $csrf, $Title, $RecordID, $col, $te, $TableName);

}

function RunUpdateModalFinal($ModalID,
    $Extra, $csrf, $Title, $RecordID, $col, $te, $TableName) {

    $FormEngine = new FormEngine;

    return $FormEngine->UpdateModalFinal($ModalID,
        $Extra, $csrf, $Title, $RecordID, $col, $te, $TableName);

}
