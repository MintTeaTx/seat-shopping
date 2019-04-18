<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/5/2019
 * Time: 10:15 PM
 */

namespace Fordav3\Seat\Shopping\Http\Controllers;

use Fordav3\Seat\Shopping\Models\CorpOrder;

class OrderController extends \Seat\Web\Http\Controllers\Controller
{

    private function createOrder(OrderRequest $request)
    {
        
        if(is_null($request->input('details')) || $request->input('details') != [])
            return redirect()->back()->with('failure', "Please input your order.");
        $details = $this->parseDetails($request->details);
        CorpOrder::create(
            [
                'user_id'           =>    auth()->user()->id(),
                'details'           =>    $details,
                'status'            =>    "new",
            ]
        );

        if(is_null($request->input('details')) || $request->input('details') != [])
            return redirect()->back()->with('failure', "Please input your order.");
        return redirect()->back()->with('success', "Order placed Successfully.");
    }
    public function settleOrder($order_id, $action)
    {
        $order = CorpOrder::find($order_id);
        switch ($action)
        {
            //'Reject|Pending|Progress|Complete'
            case 'Reject':
                $order->status = '-1';
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

    public function parseDetails($order)
    {
        $orderarray = explode("\n", $order);
        $itemarray = [];
        foreach ($orderarray as $item)
        {
            $tempArray = explode("\t",$item);
            $itemarray[$tempArray[0]] = $tempArray[1];
        }

        return $itemarray;
    }

}