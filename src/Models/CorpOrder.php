<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/5/2019
 * Time: 6:48 PM
 */

namespace Fordav3\Seat\Shopping\Models;

class CorpOrder extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'shopping_orders';
    public $incrementing = true;
    protected $primaryKey = 'order_id';
    protected $fillable = ['user_id', 'details', 'raw_details', 'status', 'handler', 'completed_date','reason', 'total_cost','volume','sub_total', 'fuel_cost','fee','is_paid'];
    protected $attributes =['status'=> 0, 'handler'=>0, 'completed_date'=> '', 'total_cost'=>0, 'reason' =>"", 'fuel_cost'=>0, 'fee'=>0, 'is_paid' => false];
    protected $casts = ['details' => 'array'] ;

}