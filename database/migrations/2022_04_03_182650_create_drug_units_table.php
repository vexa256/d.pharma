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
        Schema::create('drug_units', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('Unit')->unique();
            $table->string('UnitID')->unique();

            $table->timestamps();
        });

        \DB::unprepared("INSERT INTO `drug_units` (`uuid`, `Unit`, `UnitID`, `created_at`, `updated_at`) VALUES
        ('@2y@10@QRXfhmY0Mdavtmhci/ue2O.jHH5IUUfKKmXGMEMx0qU6lXR.X4GQC', 'kilograms', '@2y@10@eLba8dDIa/HFpUK6Rsr/9eOO9gHPDqHIVuXTHkldKJoe.7kVLbcqi', '2022-04-21 02:35:19', NULL),
        ('@2y@10@DF6rW1nawrFessI95fHDkeLFZ59ZnALmJUafPQ0HwVYwQbgjqsQ0.', 'grams', '@2y@10@jsnt1vEND1xpWnXdWQnwCeD71xd69IY4umIX7qIvO3kf.58/pPXa.', '2022-04-21 02:40:05', NULL),
        ('@2y@10@uvgfVkqoZtoQhlI9zRXpNuGyFevZr3nYxHz3g4bR7CVn/70V3PMse', 'milligrams', '@2y@10@iTvwDF0l9Um9Z74grT8PXuRRFFVdpHPel0SleKQw1wU/Ol/xeuMUi', '2022-04-21 02:40:17', NULL),
        ('@2y@10@SquErck4V4MFJtbR.vRr8u07l3Ip/.guGS.vyH2G8pF8S4nD1SvDi', 'micrograms', '@2y@10@CNndi39Gxs65HKpvoVFYru6lnUWO0EzY.89.zYhZg9snMHEQJCCNG', '2022-04-21 02:40:26', NULL),
        ('@2y@10@0hP1VQ5/VLdQXnBqHCJHYeilYRyOkjSDWMZzbdv4x3ZqwPE8vwqpW', 'litres', '@2y@10@Wl9Y6Gn23iQ.uabGo56N1elQAkoflzydtrLNIZ9Ef428UBMSe2iNu', '2022-04-21 02:40:37', NULL),
        ('@2y@10@sbIKV3j6artvYzNJTq7xse./FF2X6QbAqMLYugYCsqsR02G8Xjpjq', 'millilitres', '@2y@10@45p47CGlFP4d.j0i5ooqI.RTjIj24SIA6Y0b5End.coSGjLGtuZBm', '2022-04-21 02:40:47', NULL),
        ('@2y@10@ydvtgW2dwaI0VW9owzUb3OFabZl1Uzpk/.U6IJETJiaIpFuiVnD3S', 'cubic centimetres', '@2y@10@WD3thp7CPxAnzlki65/F6ujsoaf1YT9Fnq.wSNK//ovD.zyBwMbUa', '2022-04-21 02:40:57', NULL),
        ('@2y@10@zfXJHYUkkULNxFkuHZ912OSSl16bG2gR7PdTiAZVW.J1bgPjVursm', 'moles', '@2y@10@FYFhPo.qOP/J2eM.FjNkcO8.90ush/Vd.jIAoyP6eqo2I6Oe8.Nmq', '2022-04-21 02:41:05', NULL),
        ('@2y@10@txXK42XTCNn.GRatgVdp0OFrfC0eJBEeWvhg5/FNCX/XLZydk/8l.', 'millimoles', '@2y@10@gGE9tleE4LSc9FPmD0bv5OJe/gBPNlPX06yyG1WNzzDtjdmdy0yc.', '2022-04-21 02:41:14', NULL),
        ('@2y@10@SEiVDZ5uHi/z6fAJpRzBVeJcGKa1v6MK3EOJUk5YKzMzDkfSsTn1O', 'packets', '@2y@10@JeU6zoe2WCgncEwMCBV02eFrxJ0IXL0sAnajetTD3IJY72a2OPw5K', '2022-04-21 02:41:22', NULL),
        ('@2y@10@Ge4PL23cz3b49kkNWUF4buXfMwQujQweMNMvKOrQarN1gZavwkiuq', 'cartons', '@2y@10@RhdYEAJtyG69DTrOOFIzOe.6qOFxXJD5EjRPRmjJLv2Rb1tTIc3q.', '2022-04-21 02:42:32', NULL),
        ('@2y@10@YPfXr2I6GnVV7tSfbXl97uc82PTouaC.ORV29zW//vI7Ykxsk0vVe', 'boxes', '@2y@10@GEKhXKMoaqVn3rIi0m7XZOQKgfSxDhAC0xfK.pyblWZ5jJrXSZcUu', '2022-04-21 02:42:50', NULL),
        ('@2y@10@yUkCZDft24BmsbUa4IYCqutLzBIdfVuPMDIhlIXo1T.adQnN3hEee', 'bottles', '@2y@10@nTGyCCQcCYb7bh1MX41Fy.MdxRtnEpuv7JFhelgc0QS55v4hTiIey', '2022-04-21 02:42:56', NULL),
        ('@2y@10@mbk9W6cn5d5AvmaKeuSROejonOF186ze7fphPf489..w4HB3Cv5bO', 'tins', '@2y@10@AhxqApr9HOctxdh8d6OzCuMsAhOMTrY3AV4qf9xVFvXw8veBDnBWy', '2022-04-21 02:43:02', NULL),
        ('@2y@10@agOT03liX6888tNSoh56RuxF/YX0Fsi6/oL5SUexo86YQ7rjY0k.i', 'bags', '@2y@10@oGC/3E7PGIzHRChx2MzDW.KkFgOjxopHIRP7euWacJjYRqE7CgZZy', '2022-04-21 02:43:26', NULL),
        ('@2y@10@KNYX.2rvku1JRrBwcuFTWeG0ru4jy4cx3I8BPsXqOrp4kpaz3qHs6', 'cylinders', '@2y@10@J5tmdglh4gzdj5wnUZ7q9.jHNitshZgvSVUlpxOyncbBXDLO5Dx5i', '2022-04-21 02:43:38', NULL);
        ");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drug_units');
    }
};