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
use Fordav3\Seat\Shopping\Validation\OrderRejectRequest;
use Fordav3\Seat\Shopping\Validation\OrderRequest;
use Fordav3\Seat\Shopping\Models\RejectionReason;
use Fordav3\Seat\Shopping\Validation\OrderViewRequest;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Seat\Eveapi\Models\Sde\InvType;

class OrderController extends \Seat\Web\Http\Controllers\Controller
{

    public function createOrder(OrderRequest $request)
    {
        logger()->debug('parsing details');
        $details = $this->parseDetails($request->details);
        logger()->debug('making order');
        $fuel_cost = $this->getFuelCost($details['volume']);
        $fee =  $this->getFee($details['Total']);
        $total = $details['Total'] + $fuel_cost + $fee;
        $order = CorpOrder::create([
            'user_id' => auth()->user()->id,
            'details' => $details,
            'raw_details' => $request->details,
            'sub_total' => $details['Total'],
            'total_cost' => $total,
            'volume' => $details['volume'],
            'fuel_cost' => $fuel_cost,
            'fee' => $fee
        ]);

        return view('shopping::confirmOrder', compact('order'));
    }
    public function confirmOrder(OrderConfirmRequest $request){

        $order_id = $request->order_id;
        return redirect()->route('shopping.myorders');
        //return view('shopping::confirmed', compact('order_id'));
    }
    public function cancelOrder(OrderConfirmRequest $request)
    {
        CorpOrder::destroy($request->order_id);
        return view('shopping::cancelled');
    }
    public function rejectOrder(OrderRejectRequest $request)
    {
        $order = CorpOrder::find(['order_id'=>$request->order_id])->first();
        $order->handler = auth()->user()->id;
        $reason = $request->reason;
        $order->reason = $reason;
        $order->status = '-1';

        $order->save();

        return redirect()->route('shopping.handler.list');
    }

    public function settleOrder($order_id, $action, $extra = "")
    {
        $order = CorpOrder::find($order_id);
        switch ($action)
        {
            //'Reject|Pending|Progress|Complete'
            case 'Reject':
                $this->rejectOrder($order,$extra);
                break;
            case 'Pending':
                $order->status = '0';
                break;
            case 'Progress':
                $order->status = '1';
                break;
            case 'Complete':
                $order->status = '2';
                $order->completed_date = Carbon::now()->toDateTimeString();
                break;
        }

        $order->handler = auth()->user()->id;
        $order->save();
        return redirect()->back();
        //return json_encode(['name' => $action, 'orderID' => $order_id, 'handler' => auth()->user()->name]);
    }

    public function getMyOrderView()
    {
        $orders = CorpOrder::where('user_id', auth()->user()->id)->get();
        $pending = $orders->where('status', 0);
        $complete = $orders->where('status', 2);
        $progress = $orders->where('status', 1);
        $rejected = $orders->where('status', -1);

       // $orders = compact('orders')compact('pending', 'complete', 'progress', 'rejected');

     //   $orders = CorpOrder::where('user_id' , auth()->user()->id());
            return view('shopping::myorders', compact('pending', 'complete', 'progress', 'rejected'));
    }

    public function parseDetails($order)
    {
        $orderarray = explode("\n", $order);
        $itemarray = [];
        $total_isk = 0;
        $itemstring = '';
        $volume = 0;
        $itemvolume=0;
        $client = new Client(['headers' => [
            'User-Agent' => 'The Aether Syndicate Ordering Tool',
            'Content-Type: application/x-www-form-urlencoded'
        ]]);

        $res = $client->post('https://evepraisal.com/appraisal.json?market=jita&persist=no', [
            'form_params' => [
                'raw_textarea' =>$order
            ]]);
        $data2 = $res->getBody();
        $data = [];
        $data = json_decode($data2, true);
        $resItemArray = [];
        $resItemArray = $data['appraisal']['items'];

        foreach ($resItemArray as $item)
        {
            $tempArray = [];
            $tempArray['itemID'] = $item['typeID'];
            $tempArray['item'] = $item['typeName'];
            $tempArray['quantity'] = $item['quantity'];
            $tempArray['cost'] = $item['prices']['sell']['min']*$item['quantity'];
            $tempArray['volume'] = $item['typeVolume'];
            $itemarray['items'][] = $tempArray;
        }


        $itemarray['Total'] = $data['appraisal']['totals']['sell'];
        $itemarray['volume'] = $data['appraisal']['totals']['volume'];

        return $itemarray;
    }

    public function getOrderView(OrderViewRequest $request)
    {
        $order = CorpOrder::find($request->input('order_id'));
        return view('shopping::includes.orderdetails', compact('order'));
    }
    public function getOrderList()
    {
        $orders = CorpOrder::all();
        $pending = $orders->where('status', 0);
        $complete = $orders->where('status', 2);
        $progress = $orders->where('status', 1);
        $rejected = $orders->where('status', -1);
        $handler = null;

        // $orders = compact('orders')compact('pending', 'complete', 'progress', 'rejected');

        //   $orders = CorpOrder::where('user_id' , auth()->user()->id());
        return view('shopping::orderlist.list', compact('pending', 'complete', 'progress', 'rejected', 'handler'));
    }
    public function getMyAssignedOrders()
    {
        $handler = auth()->user()->id;
        $orders = CorpOrder::where('handler', $handler)->get();
        $pending = $orders->where('status', 0);
        $complete = $orders->where('status', 2);
        $progress = $orders->where('status', 1);
        $rejected = $orders->where('status', -1);

        return view('shopping::orderlist.list', compact('pending', 'complete', 'progress', 'rejected','handler'));
    }
    public function getAssignedOrders($handler)
    {
        $orders = CorpOrder::where('handler', $handler)->get();
        $pending = $orders->where('status', 0);
        $complete = $orders->where('status', 2);
        $progress = $orders->where('status', 1);
        $rejected = $orders->where('status', -1);
        return view('shopping::orderlist.list', compact('handler','pending', 'complete', 'progress', 'rejected'));

    }

    public function rejectionView($order_id)
    {
        $order = CorpOrder::find($order_id);

        return view('shopping::reject', compact('order'));
    }

    public function getFee($total)
    {
        return 0.03*$total;
    }
    public function getFuelCost($volume)
    {
        $max_volume = 370000;
        $fuel_cost = 20236944;

        $perc = $volume/$max_volume;
        return $fuel_cost * $perc;
    }


}
