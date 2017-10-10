<?php
namespace App\Models\Admin\Article;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $table = "article";
    protected $fillable = [
        'sort', 'type', 'company_id', 'admin_id', 'name', 'title', 'description', 'content'
    ];
    protected $dateFormat = 'U';

    function company()
    {
        return $this->belongsTo('App\Models\Admin\Company\Company','company_id','id');
    }

    function admin()
    {
        return $this->belongsTo('App\Administrator','admin_id','id');
    }


}
