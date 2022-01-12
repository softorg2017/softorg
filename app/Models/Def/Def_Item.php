<?php
namespace App\Models\Def;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Def_Item extends Model
{
    use SoftDeletes;
    //
    protected $connection = 'mysql_def';
    protected $table = "item";
    protected $fillable = [
        'active', 'status', 'item_active', 'item_status', 'item_category', 'item_type', 'category', 'type', 'sort',
        'owner_active',
        'owner_id', 'creator_id', 'updater_id', 'user_id', 'belong_id', 'source_id', 'object_id',
        'p_id', 'parent_id', 'quote_item_id',
        'rank', 'version',
        'org_id', 'admin_id',
        'item_id', 'menu_id',
        'name', 'title', 'subtitle', 'description', 'content', 'custom', 'custom2', 'custom3',
        'link_url', 'unique_path', 'cover_pic', 'attachment_name', 'attachment_src',
        'tag',
        'atom_category', 'major', 'nation', 'birth_time', 'death_time',
        'time_point', 'time_type', 'start_time', 'end_time', 'address',
        'visit_num', 'share_num', 'favor_num', 'collect_num', 'comment_num',
        'published_at'
    ];
    protected $dateFormat = 'U';

    protected $dates = ['created_at','updated_at','deleted_at'];
//    public function getDates()
//    {
////        return array(); // 原形返回；
//        return array('created_at','updated_at');
//    }


    public function __construct()
    {
        parent::__construct();

        if(explode('.',request()->route()->getAction()['domain'])[0] == 'test')
        {
            $this->connection = 'mysql_test';
        }
        else
        {
            $this->connection = 'mysql_def';
        }
    }




    // 拥有者
    function owner()
    {
        return $this->belongsTo('App\User','owner_id','id');
    }
    // 创作者
    function creator()
    {
        return $this->belongsTo('App\User','creator_id','id');
    }
    // 用户
    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }




    // 多对多 人关联的作品
    function pivot_people_product()
    {
        return $this->belongsToMany('App\Models\Def\Def_Item','pivot_item_relation','mine_item_id','relation_item_id')
            ->wherePivot('relation_type', 1);
//            ->withTimestamps();
    }
    // 多对多 作品关联的人
    function pivot_product_people()
    {
        return $this->belongsToMany('App\Models\Def\Def_Item','pivot_item_relation','relation_item_id','mine_item_id')
            ->wherePivot('relation_type', 1);
//            ->withTimestamps();
    }




    // 子节点
    function items()
    {
        return $this->hasMany('App\Models\Def\Def_Item','item_id','id');
    }

    // 父节点
    function belong_item()
    {
        return $this->belongsTo('App\Models\Def\Def_Item','item_id','id');
    }

    // 父节点
    function parent()
    {
        return $this->belongsTo('App\Models\Def\Def_Item','p_id','id');
    }

    // 子节点
    function children()
    {
        return $this->hasMany('App\Models\Def\Def_Item','p_id','id');
    }

    // 内容
    function contents()
    {
        return $this->hasMany('App\Models\Def\Def_Item','item_id','id');
    }

    // 评论
    function communications()
    {
        return $this->hasMany('App\Models\Def\Def_Communication','item_id','id');
    }

    // 评论
    function comments()
    {
        return $this->hasMany('App\Models\Def\Def_Communication','item_id','id');
    }

    // 收藏
    function collections()
    {
        return $this->hasMany('App\Models\Def\Def_Pivot_User_Collection','item_id','id');
    }

    // 转发内容
    function forward_item()
    {
        return $this->belongsTo('App\Models\Def\Def_Item','item_id','id');
    }




    // 其他人的
    function pivot_item_relation()
    {
        return $this->hasMany('App\Models\Def\Def_Pivot_User_Item','item_id','id');
    }

    // 其他人的
    function others()
    {
        return $this->hasMany('App\Models\Def\Def_Pivot_User_Item','item_id','id');
    }





    // 与我相关的话题
    function pivot_collection_course_users()
    {
        return $this->belongsToMany('App\User','pivot_user_collection','item_id','user_id');
    }

    // 与我相关的话题
    function pivot_collection_chapter_users()
    {
        return $this->belongsToMany('App\User','pivot_user_collection','item_id','user_id');
    }






    // 与我相关的话题
    function pivot_collection_item_users()
    {
        return $this->belongsToMany('App\User','pivot_user_item','item_id','user_id');
    }




    // 一对多 关联的目录
    function menu()
    {
        return $this->belongsTo('App\Models\Def\Def_Menu','menu_id','id');
    }

    // 多对多 关联的目录
    function menus()
    {
        return $this->belongsToMany('App\Models\Def\Def_Menu','pivot_menu_item','item_id','menu_id');
    }


    /**
     * 获得此文章的所有评论。
     */
    public function comment_s()
    {
        return $this->morphMany('App\Models\Comment', 'itemable');
    }

    /**
     * 获得此文章的所有标签。
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }
}
