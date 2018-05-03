<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 11/2/2016
 * Time: 5:12 PM
 */

namespace App\Setup\BackendLog;

use Illuminate\Database\Eloquent\Model;

class BackendLog extends Model
{
    protected $table = 'backend_server_log';

    protected $fillable = [
        'backend_id','description',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];

    
}
