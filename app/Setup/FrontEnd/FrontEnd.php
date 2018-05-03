<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 8/5/2016
 * Time: 11:17 AM
 */

namespace App\Setup\FrontEnd;

use Illuminate\Database\Eloquent\Model;

class FrontEnd extends Model
{
    protected $table = 'front_end';

    protected $fillable = [
    	'backend_id',
        'activation_key',
        'description',
        'status',
        'updated_at','created_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function backend(){
        return $this->belongsTo('App\Setup\Backend\Backend','backend_id','id');
    }

}
