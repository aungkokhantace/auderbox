<?php
/**
 * Created by PhpStorm.
 * Author: Soe Thandar Aung
 * Date: 10/21/2016
 * Time: 10:11 AM
 */

namespace App\Setup\Backend;

use Illuminate\Database\Eloquent\Model;

class Backend extends Model
{
    protected $table = 'backend_server';

    protected $fillable = [
        'website_url','client_count','description',
        'backend_activationkey','status','created_at','updated_at','deleted_at','updated_by','created_by','deleted_by'
    ];

    public function frontend(){
    	return $this->hasMany('App\Setup\FrontEnd\FrontEnd');
    }
}
