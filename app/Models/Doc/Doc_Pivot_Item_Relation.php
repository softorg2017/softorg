<?php
namespace App\Models\Doc;
use Illuminate\Database\Eloquent\Model;

class Doc_Pivot_Item_Relation extends Model
{
    //
    protected $table = "doc_pivot_item_relation";
    protected $fillable = [
        'active', 'category', 'type', 'relation', 'relation_active', 'relation_category', 'relation_type', 'mine_item_id', 'relation_item_id'
    ];
    protected $dateFormat = 'U';


    // mine
    function mine_item()
    {
        return $this->belongsTo('App\Models\Doc\Doc_Item','mine_item_id','id');
    }

    // relation
    function relation_item()
    {
        return $this->belongsTo('App\Models\Doc\Doc_Item','relation_item_id','id');
    }

    // relations
    function relation_items()
    {
        return $this->hasMany('App\Models\Doc\Doc_Item','relation_item_id','id');
    }


}
