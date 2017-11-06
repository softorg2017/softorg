<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $table = "records";
    protected $fillable = [
        'sort', 'type', 'form', 'org_id', 'page_id', 'user_id', 'from', 'ip'
    ];
    protected $dateFormat = 'U';

    function org()
    {
        return $this->belongsTo('App\Models\Softorg','org_id','id');
    }


}
