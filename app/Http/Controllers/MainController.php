<?php
namespace App\Http\Controllers;

use App\Http\Controllers\FormEngine;
use App\Http\Controllers\ProcessFixesController;
use DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function __construct()
    {
        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();

        if (\Schema::hasColumn('dispense_logs', 'PatientName')) {

        } else {
            \Schema::table('dispense_logs', function ($table) {
                $table->string('PatientName')->nullable();
            });
        }

        if (\Schema::hasColumn('patients', 'IsStaffMember')) {

        } else {

            \Schema::table('patients', function ($table) {
                $table->string('IsStaffMember')->default('false');
                $table->string('StaffRole')->default('false');
            });

        }

        if (\Schema::hasTable('dispensary_notes')) {

        } else {

            \Schema::create('dispensary_notes', function (Blueprint $table) {
                $table->id();
                $table->string('uuid');
                $table->string('PID');
                $table->longText('DispensaryNotes');
                $table->timestamps();
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
            '*'        => 'required',
            'files'    => 'nullable',
            'password' => 'confirmed',
        ]);

        \DB::table('users')->where('id', '=', $request->id)->update([

            "name"     => $request->name,
            "email"    => $request->email,
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

            "Page"  => "users.MgtUsers",
            "Title" => "Manage All Authorized User Accounts",
            "Desc"  => "User Settings",
            "Users" => $Users,
            "rem"   => $rem,
            "Form"  => $FormEngine->Form('users'),
            // "Units" => $Units,

        ];

        return view('scrn', $data);
    }

}
