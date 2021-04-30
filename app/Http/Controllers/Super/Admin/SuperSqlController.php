<?php
namespace App\Http\Controllers\Super\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Def\Def_User;
use App\Models\Def\Def_Item;

use App\Models\Doc\Doc_Item;

use App\Repositories\Super\Admin\SuperAdminRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class SuperSqlController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new SuperAdminRepository;
    }


    //  数据库
    public function sql_insert()
    {
        $user_init = request('user_init',null);
        if($user_init == 'truncate')
        {
            Def_User::truncate();
            echo "《User Init Truncate》"."<br>";
        }

        $user_times = request('user_times',0);
        $user_times = intval($user_times);

        echo "《User Insert》"."<br>";
        echo "【Per】 200条/次".'<br>';
        echo "【Times】 ".$user_times."次"."<br>";

        if($user_times > 0)
        {
            // 程序开始时间
            $user_insert_start_time = microtime(true);

            $user_start = Def_User::orderby('id','desc')->first();
            if($user_start) $user_start_id = $user_start->id;
            else $user_start_id = 0;

            $password = password_encode(1);

            for($j = 1; $j <= $user_times; $j++)
            {
                $user_0 = Def_User::orderby('id','desc')->first();
                if($user_0) $user_0_id = $user_0->id;
                else $user_0_id = 0;

                for($i = 1; $i <= 200; $i++)
                {
                    $user_insert[$i]['active'] = 0;
                    $user_insert[$i]['user_category'] = 1;
                    $user_insert[$i]['user_type'] = 1;
//                    $user_insert[$i]['mobile'] = $user_0_id+$i;
//                    $user_insert[$i]['password'] = $password;
//                    $user_insert[$i]['username'] = "用户_".($user_0_id+$i);

                }
//                DB::table('def_user')->insert($user_insert);
                $user = new Def_User;
//                $user::insert($user_insert);
            }

            $user_ended = Def_User::orderby('id','desc')->first();
            $user_ended_id = $user_ended->id;

            // 程序结束时间
            $user_insert_ended_time = microtime(true);

            echo "【User_id】 ".$user_start_id." --> ".$user_ended_id.'<br>';
            echo '【开始】 '.date('Y-n-j h:i:s',$user_insert_start_time).'<br>';
            echo '【结束】 '.date('Y-n-j h:i:s',$user_insert_ended_time).'<br>';
            echo '【用时】 '.($user_insert_ended_time - $user_insert_start_time).'秒'.'<br>';
            echo "<br>";

        }


        echo "<br>";
        echo "<br>";



        $item_init = request('item_init',null);
        if($item_init == 'truncate')
        {
            Def_Item::truncate();
            echo "《Item Init Truncate》"."<br>";
        }

        $item_times = request('item_times',0);
        $item_times = intval($item_times);

        echo "《Item Insert》"."<br>";
        echo "【Per】 200条/次".'<br>';
        echo "【Times】 ".$item_times."次"."<br>";

        if($item_times > 0)
        {
            // 程序开始时间
            $item_insert_start_time = microtime(true);

            $item_start = Def_Item::orderby('id','desc')->first();
            if($item_start) $item_start_id = $item_start->id;
            else $item_start_id = 0;


            for($j = 1; $j <= $item_times; $j++)
            {
                $item_0 = Def_Item::orderby('id','desc')->first();
                if($item_0) $item_0_id = $item_0->id;
                else $item_0_id = 0;

                for($i = 1; $i <= 200; $i++)
                {
                    $item_insert[$i]['active'] = 0;
                    $item_insert[$i]['item_category'] = 1;
                    $item_insert[$i]['item_type'] = 1;
                    $item_insert[$i]['owner_id'] = 1;
//                    $item_insert[$i]['title'] = 'Title_'.($item_0_id+$i);
                }
//                DB::table('def_item')->insert($item_insert);
                $user = new Def_Item;
//                $user::insert($item_insert);
            }

            $item_ended = Def_Item::orderby('id','desc')->first();
            $item_ended_id = $item_ended->id;

            // 程序结束时间
            $item_insert_ended_time = microtime(true);

            echo "【Item_id】 ".$item_start_id." --> ".$item_ended_id.'<br>';
            echo '【开始】 '.date('Y-n-j h:i:s',$item_insert_start_time).'<br>';
            echo '【结束】 '.date('Y-n-j h:i:s',$item_insert_ended_time).'<br>';
            echo '【用时】 '.($item_insert_ended_time - $item_insert_start_time).'秒'.'<br>';
            echo "<br>";

        }

        echo "<br>";
        echo "<br>";

    }


}
