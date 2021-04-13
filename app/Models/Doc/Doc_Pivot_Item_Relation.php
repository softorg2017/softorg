<?php
namespace App\Models\Doc;
use Illuminate\Database\Eloquent\Model;

class Doc_Pivot_Item_Relation extends Model
{
    //
    protected $table = "doc_pivot_item_relation";
    protected $fillable = [
        'sort', 'type', 'relation', 'relation_type', 'mine_id', 'relation_id'
    ];
    protected $dateFormat = 'U';


    // mine
    function mine_item()
    {
        return $this->belongsTo('App\Models\Doc\Doc_Item','mine_id','id');
    }

    // relation
    function relation_item()
    {
        return $this->belongsTo('App\Models\Doc\Doc_Item','relation_id','id');
    }

    // relations
    function relations()
    {
        return $this->hasMany('App\Models\Doc\Doc_Item','relation_id','id');
    }


}
