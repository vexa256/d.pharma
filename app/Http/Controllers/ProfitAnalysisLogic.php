<?php

namespace App\Http\Controllers;

use DB;

class ProfitAnalysisLogic extends Controller
{

    public function ProjectedProfit()
    {
        $counter = DB::table('stock_piles  AS S')
            ->where('S.analyzed', 'false')
        //->join('profit_analyses AS P', 'P.StockID', 'S.StockID')
            ->count();

        //dd($counter);

        if ($counter > 0) {

            $StockPiles = DB::table('stock_piles  AS S')
                ->where('S.analyzed', 'false')
            //->join('profit_analyses AS P', 'P.StockID', 'S.StockID')
                ->join('drugs AS D', 'D.DID', 'S.DID')
                ->select('S.*', 'D.UnitSellingPrice', 'D.UnitBuyingPrice')
                ->get();

            foreach ($StockPiles as $data) {

                $uuid = \Hash::make(mt_rand(1, 999999999) . date('Y-m-d H:i:s.u') . $data->StockID);

                $BuyingPrice = $data->UnitBuyingPrice;
                $SellingPrice = $data->UnitSellingPrice;
                $Profit = $SellingPrice - $BuyingPrice;
                $ProjectedProfit = $Profit * $data->StockQty;

                DB::table('profit_analyses')->insert([

                    'uuid' => $uuid,
                    'StockID' => $data->StockID,
                    'DID' => $data->DID,
                    'Month' => date("m"),
                    'Year' => date("Y"),
                    'ProjectedProfit' => $ProjectedProfit,

                ]);

                $this->ResetAnalyzed($data->id);
            }

        }

    }

    public function ResetAnalyzed($id)
    {
        DB::table('stock_piles')->where('id', $id)->update([
            "analyzed" => 'true',
        ]);
    }

    public function CreditLoss()
    {
        $counter = DB::table('creditors_logs AS C')
            ->where('C.CreditStatus', 'true')
            ->join('dispense_logs AS D', 'D.CreditCard', 'C.CreditCard')
            ->join('profit_analyses AS P', 'P.StockID', 'D.StockID')
            ->select('C.*', 'D.StockID')
            ->count();

        if ($counter > 0) {

            $Credit = DB::table('creditors_logs AS C')
                ->where('C.CreditStatus', 'true')
                ->join('dispense_logs AS D', 'D.CreditCard', 'C.CreditCard')
                ->join('profit_analyses AS P', 'P.StockID', 'D.StockID')
                ->groupBy('D.StockID')
                ->selectRaw('sum(C.Balance) as CreditLoss,  D.StockID'
                )->get();

            foreach ($Credit as $data) {

                DB::table('profit_analyses')->where('StockID', $data->StockID)
                    ->update([

                        "CreditLoss" => $data->CreditLoss,
                    ]);
            }

        }

    }

    public function RunAnalysis()
    {
        $this->ProjectedProfit();
        $this->CreditLoss();

    }
}