<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('PaymentID');
            $table->string('PaymentMethod');
            $table->string('Description');
            $table->string('status')->default('true');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        \DB::unprepared("INSERT INTO `payment_methods` ( `uuid`, `PaymentID`, `PaymentMethod`, `Description`, `status`, `created_at`, `updated_at`) VALUES
        ('@2y@10@E9Vjz0vEUeYv4c6QqkZ14uJNlcgSp4gQMCeBmZz6084.C5CkYTP4G', '@2y@10@Ar6hTbjme7iRT9y3dJo91uvQOZCZVF3wjFkci1RijfyM/ut35v7vi', 'Credit', 'Credit Purchases', 'true', '2022-04-21 03:20:47', NULL),
        ('@2y@10@G3TUg5Y5YI0QzD53P.YgoO2CDEbgbP4xs87k18J0wLVFk2OdTYSae', '@2y@10@DBivxGPqgW.gUVL6L9jiZepN4O.gB7Gd6ULye8fXO9vdyvTEtZ0bG', 'Insurance', 'Insurance Purchase', 'true', '2022-04-21 03:21:15', NULL),
        ('@2y@10@E5weCSu7C3bA8J787IGeZ.8XkgastHaGKbCn/x9/3jwHgL54jCOYe', '@2y@10@92SXoVKHDg49SeIu1XLMxOdNpVHH03DAcaFFns3EPk67z3B.t3EMy', 'MTN MoMo Pay', 'MTN MoMo Pay', 'true', '2022-04-21 03:24:36', NULL),
        ('@2y@10@2ltAJwmOykeoEyXFl2rB0OCouTcCIfrJMo/xjgibP.YiBkDM0Mdoy', '@2y@10@fqv0tVm/fJEOEWJfBNK6heIiP9u9Z27idxlnsnnfMsLz5BSVyakhW', 'Airtel Money', 'Airtel Money', 'true', '2022-04-21 03:25:39', NULL),
        ('@2y@10@38gZGUT4QzDtiCS6d6grl.Sr941X1Ct2jI8cMzqfKABIgm.rugs3G', '@2y@10@v/3Sv3gxccdV/SD9CvQgHOVjDW3NTg2puQAXbEUFy6wX.qWXNix2y', 'Airtel Pay', 'Airtel Pay', 'true', '2022-04-21 03:25:52', NULL),
        ('@2y@10@AhqPnQh0RYFrTxva/NPE5u/chhTwdORKMmKS4trEDFeRXg3JK52dm', '@2y@10@NannX1qNA8tlqNn3EsBDbezRDNI7Eeua6EJRiECjjpeUATK0YKwui', 'MTN Mobile Money', 'MTN Mobile Money', 'true', '2022-04-21 03:26:03', NULL),
        ('@2y@10@tam.a/KECsftOgquGRnqAOcoQMZxwieoh07t.oYpUGLfZgjYaZEuK', '@2y@10@e2g1Tm/6acBeD36YSHzL1eh1SJwvaggvEFdRmDq7C8yeqW150G/RO', 'Visa Card', 'Visa Card', 'true', '2022-04-21 03:26:16', NULL),
        ('@2y@10@dNA/Uv60nmKtKNVhSS2LsOL2llJpRu1A0U.4kxv4kynCG3XWtN.ca', '@2y@10@C/XlrbQmKfnRZVV4lx6hye146nZIefP8H69VqaIXlY7AODq5591P.', 'Mastercard', 'Mastercard', 'true', '2022-04-21 03:26:33', NULL),
        ('@2y@10@Dp9WFXdnDa.D3yg.NuZ.Iesu4RCEn.qlYG1IcS/n5vynFECwH1Ubm', '@2y@10@ELipnSKj/IbahCkGOcosvew3JPpPzoHiUwwwbCkEzW1HGhyocnNWC', 'Cash', 'Cash Purchase', 'true', '2022-04-21 03:27:05', NULL),
        ('@2y@10@5FkWgQkUN/80rgj/0tsLdeBEMF0YLqA0dtYetzQ/hh7Twwx5siP7W', '@2y@10@TudPUuyJ3jgf5uoL0EOWlOZumXLDtDPjhxeHF9tYslcXml.iKV1AS', 'Bank Transfer', 'Bank Transfer', 'true', '2022-04-21 03:27:26', NULL);");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};