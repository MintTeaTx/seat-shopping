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

    protected $table = 'seat_shopping_orders';
    public $incrementing = true;
    protected $primaryKey = 'order_id';
    protected $fillable = ['character_name', 'details', 'status', 'handler', 'completed_date'];
    protected $casts = ['details' => 'array'] ;

}