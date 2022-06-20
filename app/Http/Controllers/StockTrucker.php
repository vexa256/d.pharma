<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProcessFixesController;
use DB;

class StockTrucker extends Controller
{

    public function __construct()
    {
        $ProcessFixesController = new ProcessFixesController;
        $ProcessFixesController->FixTimestampLossOnDispenseLogs();

        $this->SetDrugMonthsToExpiry();

        $count = DB::table('stock_piles AS S')
            ->where('S.ActiveStatus', 'true')
            ->join('drugs AS D', 'D.DID', '=', 'S.DID')
            ->groupBy('S.DID')
            ->selectRaw('sum(S.StockQty) as QtyAvailable')
            ->count();

        if ($count > 0) {
            $Up = DB::table('stock_piles AS S')
                ->where('S.ActiveStatus', 'true')
                ->join('drugs AS D', 'D.DID', '=', 'S.DID')
                ->groupBy('S.DID')
                ->select('D.id')
                ->selectRaw('sum(S.StockQty) as QtyAvailable')
                ->get();

            foreach ($Up as $data) {
                DB::table('drugs')->where('id', $data->id)->update([
                    'QtyAvailable' => $data->QtyAvailable,
                ]);
            }

        }

    }

    public function CheckLowQtyStock()
    {
        $count = DB::table('drugs')
            ->whereColumn('QtyAvailable', '<=', 'MinimumQty')
            ->count();

        if ($count > 0) {

            $Up = DB::table('drugs')
                ->whereColumn('QtyAvailable', '<=', 'MinimumQty')
                ->get();

            foreach ($Up as $data) {

                DB::table('drugs')->where('id', $data->id)->update([

                    'WarningQtyStatus' => 'true',
                ]);

            }

        }

        return true;
    }

    public function LowQtyReversal()
    {
        $count = DB::table('drugs')
            ->whereColumn('QtyAvailable', '>', 'MinimumQty')
            ->where('WarningQtyStatus', 'true')
            ->count();

        if ($count > 0) {

            $Up = DB::table('drugs')
                ->whereColumn('QtyAvailable', '>', 'MinimumQty')
                ->where('WarningQtyStatus', 'true')
                ->get();

            foreach ($Up as $data) {

                DB::table('drugs')->where('id', $data->id)->update([

                    'WarningQtyStatus' => 'false',
                ]);

            }

        }
        return true;
    }

    private function SetMonths($ExpiryDate, $uuid)
    {
        $DrugExpiryStatus = "Valid";

        $DifferenceInMonths = null;

        $Now = \Carbon\Carbon::now()->format('Y-m-d');

        $Today = \Carbon\Carbon::parse($Now);

        $Expiry = \Carbon\Carbon::parse($ExpiryDate);

        if ($Expiry->gt($Today)) {

            $diff_in_months = $Today->diffInMonths($Expiry);

            if ($diff_in_months <= 3) {

                $DrugExpiryStatus = 'Soon Expiring';
            }

            $Update = DB::table('stock_piles')->where('uuid', $uuid)->update([

                'MonthsToExpiry' => $diff_in_months,
                'ExpiryStatus'   => $DrugExpiryStatus,
            ]);

        } else {

            $Update = DB::table('stock_piles')->where('uuid', $uuid)->update([

                'MonthsToExpiry' => 0,
                'ExpiryStatus'   => 'Invalid',
            ]);
        }
    }

    private function SetDrugMonthsToExpiry()
    {
        $count = DB::table('stock_piles')->where('ActiveStatus', '!=', "false")->count();
        if ($count >= 1) {

            $Vendors = DB::table('stock_piles')->where('ActiveStatus', '!=', "false")->get();

            foreach ($Vendors as $data) {

                $this->SetMonths($data->ExpiryDate, $data->uuid);
            }
        }
    }

    public function CreateDrugRestockLog()
    {

        $StockPiles = DB::table('stock_piles')->where('ActiveStatus', 'true')->get();

        foreach ($StockPiles as $data) {

            $RestockLogsCounter = DB::table('drug_restock_logs')->where('StockID', $data->StockID)->count();

            if ($RestockLogsCounter < 1) {

                $LogData = DB::table('stock_piles AS S')
                    ->where('S.StockID', $data->StockID)
                    ->join('drugs AS D', 'D.DID', 'S.DID')
                    ->join('drug_units AS U', 'U.UnitID', 'D.MeasurementUnits')
                    ->join('drug_categories AS C', 'C.DCID', 'D.DCID')
                    ->select('S.*', 'D.*', 'C.*', 'U.Unit')
                    ->first();

                $Profit          = $LogData->UnitSellingPrice - $LogData->UnitBuyingPrice;
                $ProjectedProfit = $Profit * $LogData->StockQty;

                DB::table('drug_restock_logs')->insert([
                    'uuid'             => $data->uuid,
                    'DID'              => $data->DID,
                    'QtyRestocked'     => $data->StockQty,
                    'ProjectedProfit'  => $ProjectedProfit,
                    'StockID'          => $data->StockID,
                    'RestockedBy'      => \Auth::user()->name,
                    'RestockMonth'     => date('M'),
                    'RestockYear'      => date('Y'),
                    'DrugName'         => $LogData->DrugName,
                    'GenericName'      => $LogData->GenericName,
                    'Units'            => $LogData->Unit,
                    'DrugCategory'     => $LogData->CategoryName,
                    'Currency'         => $LogData->Currency,
                    'UnitSellingPrice' => $LogData->UnitSellingPrice,
                    'UnitBuyingPrice'  => $LogData->UnitBuyingPrice,
                    'created_at'       => date('Y-m-d'),
                ]);
            }

        }

    }
} /**class closure */
