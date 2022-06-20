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

        $this->UpdatePaymentMethods();

        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();

        if (\Schema::hasColumn('credit_payment_logs', 'PaymentMethod')) {

        } else {

            \Schema::table('credit_payment_logs', function ($table) {
                $table->string('PaymentMethod')->nullable();
                $table->string('Month')->nullable();
                $table->string('Year')->nullable();
            });

        }
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

    public function MgtUserRoles()
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

    public function UpdatePaymentMethods()
    {
        $PayUpdate = DB::table('payment_methods')->where('uuid', '@2y@10@E9Vjz0vEUeYv4c6QqkZ14uJNlcgSp4gQMCeBmZz6084.C5CkYTP4Ghsjshswiiw8383')
            ->count();

        if ($PayUpdate < 1) {
            DB::table('payment_methods')->where('uuid', '!=', '@2y@10@E9Vjz0vEUeYv4c6QqkZ14uJNlcgSp4gQMCeBmZz6084.C5CkYTP4Ghsjshswiiw8383')
                ->delete();

            \DB::unprepared("INSERT INTO `payment_methods` (`id`, `uuid`, `PaymentID`, `PaymentMethod`, `Description`, `status`, `created_at`, `updated_at`) VALUES
            (1, '@2y@10@E9Vjz0vEUeYv4c6QqkZ14uJNlcgSp4gQMCeBmZz6084.C5CkYTP4G', '@2y@10@Ar6hTbjme7iRT9y3dJo91uvQOZCZVF3wjFkci1RijfyM/ut35v7vi', 'Credit', 'Credit Purchases', 'true', '2022-04-21 00:20:47', '0000-00-00 00:00:00'),
            (2, '@2y@10@G3TUg5Y5YI0QzD53P.YgoO2CDEbgbP4xs87k18J0wLVFk2OdTYSae', '@2y@10@DBivxGPqgW.gUVL6L9jiZepN4O.gB7Gd6ULye8fXO9vdyvTEtZ0bG', 'Insurance', 'Insurance Purchase', 'true', '2022-04-21 00:21:15', '0000-00-00 00:00:00'),
            (3, '@2y@10@E5weCSu7C3bA8J787IGeZ.8XkgastHaGKbCn/x9/3jwHgL54jCOYe', '@2y@10@92SXoVKHDg49SeIu1XLMxOdNpVHH03DAcaFFns3EPk67z3B.t3EMy', 'MTN MoMo Pay', 'MTN MoMo Pay', 'true', '2022-04-21 00:24:36', '0000-00-00 00:00:00'),
            (4, '@2y@10@2ltAJwmOykeoEyXFl2rB0OCouTcCIfrJMo/xjgibP.YiBkDM0Mdoy', '@2y@10@fqv0tVm/fJEOEWJfBNK6heIiP9u9Z27idxlnsnnfMsLz5BSVyakhW', 'Airtel Money', 'Airtel Money', 'true', '2022-04-21 00:25:39', '0000-00-00 00:00:00'),
            (5, '@2y@10@38gZGUT4QzDtiCS6d6grl.Sr941X1Ct2jI8cMzqfKABIgm.rugs3G', '@2y@10@v/3Sv3gxccdV/SD9CvQgHOVjDW3NTg2puQAXbEUFy6wX.qWXNix2y', 'Airtel Pay', 'Airtel Pay', 'true', '2022-04-21 00:25:52', '0000-00-00 00:00:00'),
            (6, '@2y@10@AhqPnQh0RYFrTxva/NPE5u/chhTwdORKMmKS4trEDFeRXg3JK52dm', '@2y@10@NannX1qNA8tlqNn3EsBDbezRDNI7Eeua6EJRiECjjpeUATK0YKwui', 'MTN Mobile Money', 'MTN Mobile Money', 'true', '2022-04-21 00:26:03', '0000-00-00 00:00:00'),
            (7, '@2y@10@tam.a/KECsftOgquGRnqAOcoQMZxwieoh07t.oYpUGLfZgjYaZEuK', '@2y@10@e2g1Tm/6acBeD36YSHzL1eh1SJwvaggvEFdRmDq7C8yeqW150G/RO', 'Visa Card', 'Visa Card', 'true', '2022-04-21 00:26:16', '0000-00-00 00:00:00'),
            (8, '@2y@10@dNA/Uv60nmKtKNVhSS2LsOL2llJpRu1A0U.4kxv4kynCG3XWtN.ca', '@2y@10@C/XlrbQmKfnRZVV4lx6hye146nZIefP8H69VqaIXlY7AODq5591P.', 'Mastercard', 'Mastercard', 'true', '2022-04-21 00:26:33', '0000-00-00 00:00:00'),
            (9, '@2y@10@Dp9WFXdnDa.D3yg.NuZ.Iesu4RCEn.qlYG1IcS/n5vynFECwH1Ubm', '@2y@10@ELipnSKj/IbahCkGOcosvew3JPpPzoHiUwwwbCkEzW1HGhyocnNWC', 'Cash', 'Cash Purchase', 'true', '2022-04-21 00:27:05', '0000-00-00 00:00:00'),
            (10, '@2y@10@5FkWgQkUN/80rgj/0tsLdeBEMF0YLqA0dtYetzQ/hh7Twwx5siP7W', '@2y@10@TudPUuyJ3jgf5uoL0EOWlOZumXLDtDPjhxeHF9tYslcXml.iKV1AS', 'Bank Transfer', 'Bank Transfer', 'true', '2022-04-21 00:27:26', '0000-00-00 00:00:00'),
            (11, '@2y@10@E9Vjz0vEUeYv4c6QqkZ14uJNlcgSp4gQMCeBmZz6084.C5CkYTP4Ghsjshswiiw8383', '@2y@10@E9Vjz0vEUeYv4c6QqkZ14uJNlcgSp4gQMCeBmZz6084.C5CkYTP4Ghsjshswiiw29292', 'Hospital Billable', 'Hospital Billed Payements', 'true', '2022-06-20 16:14:05', '2022-06-20 16:14:05');
            ");
        }
    }

}
