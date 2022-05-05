 <!--begin::Card body-->
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {!! Alert($icon = 'fa-info', $class = 'alert-primary', $Title = 'Manage User Accounts', $Msg = null) !!}
 </div>
 <div class="card-body pt-3 bg-light shadow-lg table-responsive">
     {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'New User Account', $Icon = 'fa-plus') }}
     <table
         class=" mytable table table-rounded table-bordered  border gy-3 gs-3">
         <thead>
             <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                 <th>Name</th>
                 <th>Username</th>
                 <th>Date Created</th>
                 <th>Role</th>
                 <th class="bg-danger fw-bolder text-light"> Delete </th>



             </tr>
         </thead>
         <tbody>
             @isset($Users)
                 @foreach ($Users as $data)
                     <tr>

                         <td>{{ $data->name }}</td>
                         <td>{{ $data->email }}</td>

                         <td>{!! date('F j, Y', strtotime($data->created_at)) !!}

                         <td>{{ $data->role }}</td>
                         <td>

                             {!! ConfirmBtn(
    $data = [
        'msg' => 'You want to delete this users account',
        'route' => route('DeleteData', ['id' => $data->id, 'TableName' => 'users']),
        'label' => '<i class="fas fa-trash"></i>',
        'class' => 'btn btn-danger btn-sm deleteConfirm admin',
    ],
) !!}

                         </td>





                     </tr>
                 @endforeach
             @endisset



         </tbody>
     </table>
 </div>
 <!--end::Card body-->

 @include('users.NewUser')
