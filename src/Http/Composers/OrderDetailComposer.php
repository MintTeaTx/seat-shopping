<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/28/2019
 * Time: 1:53 PM
 */

namespace Fordav3\Seat\Shopping\Http\Composers;


use Fordav3\Seat\Shopping\Models\CorpOrder;
use Illuminate\View\View;

class OrderDetailComposer
{

    protected $order;

    public function __construct(CorpOrder $order)
    {
        $this->order = $order;
    }


    public function compose(View $view)
    {
        $view->with('selected_order', $this->order);
    }

}