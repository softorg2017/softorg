<?php
namespace App\Models\Admin\Company;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    //
    protected $table = "website";
    protected $fillable = [
        'sort', 'type', 'name', 'title', 'description', 'content'
    ];
    protected $dateFormat = 'U';

    function company()
    {
        return $this->belongsTo('App\Models\Admin\Company\Company','company_id','id');
    }



}
