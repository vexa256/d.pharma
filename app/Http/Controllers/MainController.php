<?php
namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\FormEngine;

class MainController extends Controller
{


    public function __construct()
    {
        if (\Schema::hasColumn('dispense_logs', 'PatientName')) {

        }else{
            \Schema::table('dispense_logs', function ($table) {
                $table->string('PatientName')->nullable();
            });
        }
    }


    public function VirtualOffice()
    {

        return redirect()->route('DispenseDrugs');

    }

    public function UpdateAccount(Request $request)
    {
        $validated = $request->validate([
            '*' => 'required',
            'files' => 'nullable',
            'password' => 'confirmed',
        ]);

        \DB::table('users')->where('id', '=', $request->id)->update([

            "name" => $request->name,
            "email" => $request->email,
            "password" => \Hash::make($request->password),

        ]);

        return redirect()->route('NotiFicationsCloud')->with('status', 'Account information updated successfully');
    }

    public function MgtUserRoles(Type $var = null)
    {
        $Users = DB::table('users')
            ->where('email', '!=', 'vexa256@gmail.com')
            ->get();

        $rem = [

            "id",
            "created_at",
            "updated_at",
            "EmpID",
            "Title",
            "remember_token",
            "email_verified_at",
            "role",

        ];
        $FormEngine = new FormEngine;

        $data = [

            "Page" => "users.MgtUsers",
            "Title" => "Manage All Authorized User Accounts",
            "Desc" => "User Settings",
            "Users" => $Users,
            "rem" => $rem,
            "Form" => $FormEngine->Form('users'),
            // "Units" => $Units,

        ];

        return view('scrn', $data);
    }

}