<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/5/2019
 * Time: 10:15 PM
 */

namespace Fordav3\Seat\Shopping\Http\Controllers;

use Composer\Package\Package;
use Fordav3\Seat\Shopping\Models\CorpOrder;
use Fordav3\Seat\Shopping\Validation\OrderConfirmRequest;
use Fordav3\Seat\Shopping\Validation\OrderRequest;
use Fordav3\Seat\Shopping\Models\RejectionReason;
use Fordav3\Seat\Shopping\Validation\OrderViewRequest;

class OrderController extends \Seat\Web\Http\Controllers\Controller
{

    public function createOrder(OrderRequest $request)
    {
        logger()->debug('parsing details');
        $details = $this->parseDetails($request->details);
        logger()->debug('making order');
        $order = CorpOrder::create([
            'user_id' => auth()->user()->id,
            'details' => $details,
            'raw_details' => $request->details
        ]);
        return view('shopping::confirmOrder', compact('order'));
    }
    public function confirmOrder(OrderConfirmRequest $request){

        $action = $request->input('action');
        $order_id = $request->order_id;

        switch ($action)
        {
            case 'Confirm':
                return view('shopping::myorders');
            case 'Cancel':
                CorpOrder::destroy($order_id);
                return view('shopping::myorders');
        }
        return redirect()->route('shopping.myorders');
    }
    public function rejectOrder(CorpOrder $order, $reason)
    {
        $rejection = RejectionReason::updateOrCreate(
                ['order_id' => $order->order_id],
                [ 'reason' => $reason]);
        $order->reason()->save($rejection);
        $rejection->order()->associate($order);
        $rejection->save();

    }

    public function settleOrder($order_id, $action, $extra = "")
    {
        $order = CorpOrder::find($order_id);
        switch ($action)
        {
            //'Reject|Pending|Progress|Complete'
            case 'Reject':
                $order->status = '-1';
                $this->rejectOrder($order,$extra);
                break;
            case 'Pending':
                $order->status = '0';
                break;
            case 'Progress':
                $order->status = '1';
                break;
            case 'Approve':
                $order->status = '2';
                break;
        }

        $order->handler = auth()->user()->name;
        $order->save();

        return json_encode(['name' => $action, 'orderID' => $order_id, 'handler' => auth()->user()->name]);
    }

    public function getMyOrderView()
    {
        $orders = CorpOrder::where('user_id', auth()->user()->id)->get();
        $pending = $orders->where('status', 0);
        $complete = $orders->where('status', 2);
        $progress = $orders->where('status', 1);
        $rejected = $orders->where('status', -1);

     //   $orders = CorpOrder::where('user_id' , auth()->user()->id());
            return view('shopping::myorders', compact('pending', 'complete','progress', 'rejected'));
    }

    public function parseDetails($order)
    {
        $orderarray = explode("\n", $order);
        $itemarray = [];
        foreach ($orderarray as $item)
        {
            $tempArray = explode("\t",$item);
            if($tempArray[0] === "Total:"): continue; endif;

            $tempArray2TheElectricBoogaloo = [];
            $tempArray2TheElectricBoogaloo['item'] = $tempArray[0];
            $tempArray2TheElectricBoogaloo['quantity'] = $tempArray[1];
            $tempArray2TheElectricBoogaloo['cost'] = $this->getCost($tempArray[0]);
            $itemarray[] = $tempArray2TheElectricBoogaloo;
        }

        return $itemarray;
    }
    public function getCost(String $item)
    {
        return 56;
    }
    public function getOrderView(OrderViewRequest $request)
    {
        $order = CorpOrder::find($request->input('order_id'));
        return view('shopping::orderdetails', compact('order'));
    }


}