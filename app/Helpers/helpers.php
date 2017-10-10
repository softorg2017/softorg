<?php
/*
 * 全局公共方法
 */


// 密码加密
if(!function_exists('password_encode'))
{
	function password_encode($str)
	{
		return password_hash(md5($str),PASSWORD_BCRYPT);
	}
}
// 核对密码
if(!function_exists('password_check'))
{
	function password_check($str,$password)
	{
		return password_verify(md5($str),$password);
	}
}


// 初始化时间戳 global $time_stamp
if(!function_exists('time_init')) {
	function time_init()
	{
		global $today_start_unix;    //今天开始；
		global $today_ended_unix;    //今天结束；
		global $yesterday_start_unix;    //昨天开始；
		global $yesterday_ended_unix;    //昨天结束；
		global $beforeday_start_unix;    //前天开始；
		global $beforeday_ended_unix;    //前天结束；
		global $tomorrow_start_unix;    //明天开始；
		global $tomorrow_ended_unix;    //明天结束；
		global $afterday_start_unix;    //后天开始；
		global $afterday_ended_unix;    //后天结束；
		global $this_year_start_unix;    //今年开始；
		global $this_year_ended_unix;    //今年结束；


		$today_start_unix = strtotime(date("Y-m-d",time()));
		$today_ended_unix = $today_start_unix + (3600 * 24 - 1);
		$yesterday_start_unix = $today_start_unix - 3600 * 24;
		$yesterday_ended_unix = $today_ended_unix - 3600 * 24;
		$beforeday_start_unix = $yesterday_start_unix - 3600 * 24;
		$beforeday_ended_unix = $yesterday_ended_unix - 3600 * 24;
		$tomorrow_start_unix = $today_start_unix + 3600 * 24;
		$tomorrow_ended_unix = $today_ended_unix + 3600 * 24;
		$afterday_start_unix = $tomorrow_start_unix + 3600 * 24;
		$afterday_ended_unix = $tomorrow_ended_unix + 3600 * 24;
		$this_year_start_unix = strtotime(date("Y",time())."-1-1");
		$this_year_ended_unix = strtotime(date("Y",time())."-12-31 23:59:59");
	}
}

// 处理数据 返回 Data Show
if(!function_exists('time_show'))
{
	function time_show($stamp)
	{
		global $today_start_unix;	//今天开始；
		global $today_ended_unix;	//今天结束；

		global $yesterday_start_unix;	//昨天开始；
		global $yesterday_ended_unix;	//昨天结束；

		global $beforeday_start_unix;	//前天开始；
		global $beforeday_ended_unix;	//前天结束；

		global $tomorrow_start_unix;	//明天开始；
		global $tomorrow_ended_unix;	//明天结束；

		global $afterday_start_unix;	//后天开始；
		global $afterday_ended_unix;	//后天结束；

		global $this_year_start_unix;	//今年开始；
		global $this_year_ended_unix;	//今年结束；

		time_init();

		if( ($stamp >= $beforeday_start_unix) && ($stamp < $yesterday_start_unix) ) {
			return "前天".date(" H:i",$stamp);
		}
		elseif( ($stamp >= $yesterday_start_unix) && ($stamp < $today_start_unix) ) {
			return "昨天".date(" H:i",$stamp);
		}
		elseif( ($stamp >= $today_start_unix) && ($stamp <= $today_ended_unix) ) {
			return "今天".date(" H:i",$stamp);
		}
		elseif( ($stamp >= $today_ended_unix) && ($stamp < $tomorrow_ended_unix) ) {
			return "明天".date(" H:i",$stamp);
		}
		elseif( ($stamp >= $tomorrow_ended_unix) && ($stamp < $afterday_ended_unix) ) {
			return "后天".date(" H:i",$stamp);
		}
		else {
			if( ($this_year_start_unix <= $stamp) && ($stamp <= $this_year_ended_unix) ) {
				return date("n月j日 H:i",$stamp);
			} else {
				return date("Y-n-j H:i",$stamp);
			}
		}
	}
}
// 处理数据 返回 Data Show
if(!function_exists('date_show'))
{
    function date_show($stamp)
    {
        return date("Y-m-j",$stamp);
    }
}

if(!function_exists('return_interval_unix'))
{
    function return_interval_unix($sort,$value)
    {
        if($sort == config('display.geter.schedule.type.month'))
        {
            $stamp = strtotime($value."-1");
            $return["start_unix"] = get_month_start_unix($stamp);
            $return["end_unix"] = get_month_ended_unix($stamp);
        }
        else if($sort == config('display.geter.schedule.type.day'))
        {
            $stamp = strtotime($value);
            $return["start_unix"] = get_day_start_unix($stamp);
            $return["end_unix"] = get_day_ended_unix($stamp);
        }
        else
        {
            $return["start_unix"] = 0;
            $return["end_unix"] = 0;
        }
        return $return;
    }
}


if(!function_exists('replace_blank')) {
	function replace_blank($text)
	{
		$patterns = array();
		$patterns[0] = "/ /";
		$patterns[1] = "/\\n/";
		$replacements = array();
		$replacements[0] = "&nbsp;";
		$replacements[1] = "<br>";
		$text = preg_replace($patterns, $replacements, $text);
		return $text;
	}
}
if(!function_exists('replace_content')) {
	function replace_content($text)
	{
		$patterns = array();
		$patterns[0] = "/ /";
		$patterns[2] = "/&amp;/";
		$patterns[3] = "/&quot;/";
		$patterns[4] = "/\</";
		$patterns[5] = "/\>/";
		$patterns[6] = "/\\n/";
		$replacements = array();
		$replacements[0] = "&nbsp;";
		$replacements[2] = "&";
		$replacements[3] = '"';
		$replacements[4] = "&lt;";
		$replacements[5] = "&gt;";
		$replacements[6] = "<br/>";
		$text = preg_replace($patterns, $replacements, $text);

		$pattern = "/((?:https?|http?|ftp?):\/\/(?:\w|\?|\.|\/|\=|\+|\-|\&|\%|\#|\@|\:|\[|\])+)\b/i";
		$text = preg_replace($pattern,'<a class=content_link href=\1 target=_blank title=\1 ><em class="link-icon"></em> 网址链接</a>',$text);
		return $text;
	}
}

if(!function_exists('Get_IP'))
{
	function Get_IP()
	{
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			$ip = getenv("REMOTE_ADDR");
		else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			$ip = $_SERVER['REMOTE_ADDR'];
		else
			$ip = "unknown";
		return($ip);
	}
}




if(!function_exists('encode')) {
    function encode($str, $key = '')
    {
        $str = strval($str);
//        $key = empty($key) ? env('APP_KEY', 'key.by.heroest') : $key;
        $key = empty($key) ? config('env.APP_KEY') : $key;
        $charset = hash_hmac('sha256', $key, 'abcdefgopqrsthigklmnuvwxyz');
        $mac = hash_hmac('sha256', $str, $key);

        $len_str = mb_strlen($str);
        while(mb_strlen($charset) < $len_str)
        {
            $charset .= $charset;
        }

        $encoded = bin2hex($str ^ ($charset . $charset . $charset));
        $head = substr($mac, 0, 2);
        $tail = substr($mac, -2);
        return $head . $encoded . $tail;
    }
}
if(!function_exists('decode')) {
    function decode($input, $key = '')
    {
//        $key = empty($key) ? env('APP_KEY', 'key.by.heroest') : $key;
        $key = empty($key) ? config('env.APP_KEY') : $key;
        $charset = hash_hmac('sha256', $key, 'abcdefgopqrsthigklmnuvwxyz');

        $head = substr($input, 0, 2);
        $tail = substr($input, -2);
        $encoded = substr($input, 2, -2);
        if(strlen($encoded) % 2 !== 0) return false;
        $encoded = hex2bin($encoded);

        $len_str = mb_strlen($encoded);
        while(mb_strlen($charset) < $len_str)
        {
            $charset .= $charset;
        }
        $origin = $encoded ^ $charset;

        $mac = hash_hmac('sha256', $origin, $key);
        if($head == substr($mac, 0, 2) and $tail == substr($mac, -2))
        {
            return $origin;
        }
        else
        {
            return false;
        }
    }
}

if(!function_exists('medsci_encode')){
	function medsci_encode($id,$key){
		$id = trim($id);
//		if(!is_numeric($id)){
//			return FALSE;
//		}
		$iii=5;//左侧位数，必需是数字，避免与其它定义重复，故用此定义
		$kkk=2;//右侧位数，必需是数字
		$mmm=$key;//加的一个常量，必需是数字,这样容纳10亿个数字，加密后的位数依然不变，为16位，与MD5加密一致，会被误认为是md5
		$nnn="7";//只能填0-9之间的数字，将数字替换为下面的o代表的字符,只替换一次。
		$ooo="e";//最好是a-f之间的字符,改变上述这五个常量,黑客就无从猜解了.
		$ppp="0";//只能填0-9之间的数字，将数字替换为下面的o代表的字符,只替换一次。
		$qqq="c";//最好是a-f之间的字符,改变上述这五个常量,黑客就无从猜解了.
		$rrr="4";//只能填0-9之间的数字，将数字替换为下面的o代表的字符,只替换一次。
		$sss="a";//最好是a-f之间的字符,改变上述这五个常量,黑客就无从猜解了.
		$id_plus=$id1=$id2=$id3=$id_str = '';


		$id_plus=$id+$mmm;//加上一个常数进行运算，这是能否解密的关键，同时也可以防止黑客用非数字攻击。
		$id1 = substr(md5($id_plus),8,16);
		$id2 = substr($id1,0,$iii);//只取前5位
		$id3 = substr($id1,-$kkk);//取后2位
		$replace_count = 1;
		$id_str = substr($id_plus, 0, 1).preg_replace("/{$nnn}/", $ooo, substr($id_plus, 1), $replace_count);//替换第一个出现的数字为字符
		$id_str = substr($id_str, 0, 1).preg_replace("/{$ppp}/", $qqq, substr($id_str, 1), $replace_count);//替换第一个出现的数字为字符
		$id_str = substr($id_str, 0, 1).preg_replace("/$rrr/", $sss, substr($id_str, 1), $replace_count);//替换第一个出现的数字为字符

		return $id2.$id_str.$id3;
	}
}
if(!function_exists('medsci_decode')){
	function medsci_decode($key,$module){
		$key = trim($key);
//		if(!ctype_alnum($key) or strlen($key) != 16 ){
//			return $key;
//		}
		$iii=5;//左侧位数，必需是数字，避免与其它定义重复，故用此定义
		$kkk=2;//右侧位数，必需是数字
		$mmm=$module;//加的一个常量，必需是数字,这样容纳10亿个数字，加密后的位数依然不变，为16位，与MD5加密一致，会被误认为是md5
		$nnn="7";//只能填0-9之间的数字，将数字替换为下面的o代表的字符,只替换一次。
		$ooo="e";//最好是a-f之间的字符,改变上述这五个常量,黑客就无从猜解了.
		$ppp="0";//只能填0-9之间的数字，将数字替换为下面的o代表的字符,只替换一次。
		$qqq="c";//最好是a-f之间的字符,改变上述这五个常量,黑客就无从猜解了.
		$rrr="4";//只能填0-9之间的数字，将数字替换为下面的o代表的字符,只替换一次。
		$sss="a";//最好是a-f之间的字符,改变上述这五个常量,黑客就无从猜解了.
		$id1=$id2=$id3=$id_left=$id_right=$id_left_1=$id_right_1=$x=$x1=$id3_md5=$id1_str=$id_plus='';
		$id_left_1=substr($key,0,5);//取MD5加密的前5位
		$id_right_1=substr($key,-$kkk);//取加密后2位
		$x=strlen($key);//计算长度
		$x1=$x-$iii-$kkk;//实际ID值的长度
		$replace_count =1;
		$id_plus =substr($key,$iii,$x1);
		$id_plus = substr($id_plus, 0, 1).preg_replace("/{$ooo}/", $nnn, substr($id_plus, 1), $replace_count);//替换第一个出现的数字为字符
		$id_plus = substr($id_plus, 0, 1).preg_replace("/{$qqq}/", $ppp, substr($id_plus, 1), $replace_count);//替换第一个出现的数字为字符
		$id_plus = substr($id_plus, 0, 1).preg_replace("/{$sss}/", $rrr, substr($id_plus, 1), $replace_count);//替换第一个出现的数字为字符
		if(!is_numeric($id_plus)){
			$medsci_Decryption_id=0;
		}
		$id_plus_md5=substr(md5($id_plus),8,16);
		$id_left = substr($id_plus_md5, 0, $iii);
		$id_right=substr($id_plus_md5,-$kkk);

		if($id_left==$id_left_1 and $id_right==$id_right_1){
			$medsci_Decryption_id=$id_plus-$mmm;
		}else{
			$medsci_Decryption_id=0;
		}
		return $medsci_Decryption_id;
	}
}

/**
 * 上传文件
 */
if (!function_exists('upload')) {
	function upload($file, $saveFolder, $patch = 'research')
	{
		$allowedExtensions = [
			'jpg', 'jpeg', 'png', 'csv',
		];
		$extension = $file->getClientOriginalExtension();

		/*判断后缀是否合法*/
		if (in_array($extension, $allowedExtensions)) {
			$image = Image::make($file);
			/*保存图片*/
			$date = date('Y-m-d');
			$upload_path = <<<EOF
resource/$patch/$saveFolder/$date/
EOF;

			$mysql_save_path = <<<EOF
$patch/$saveFolder/$date/
EOF;
			$path = public_path($upload_path);
			if (!is_dir($path)) {
				mkdir($path, 0766, true);
			}
			$filename = uniqid() . time() . '.' . $extension;
			$image->save($path . $filename);
			$returnData = [
				'result' => true,
				'msg' => '上传成功',
				'local' => $mysql_save_path . $filename,
				'extension' => $extension,
			];
		} else {
			$returnData = [
				'result' => false,
				'msg' => '上传图片格式不正确',
			];
		}
		return $returnData;
	}
}
/**
 * 上传文件
 */
if (!function_exists('upload_s')) {
    function upload_s($file, $saveFolder, $patch = 'research')
    {
        $allowedExtensions = [
            'jpg', 'jpeg', 'png', 'csv',
        ];
        $extension = $file->getClientOriginalExtension();

        /*判断后缀是否合法*/
        if (in_array(strtolower($extension), $allowedExtensions)) {
            $image = Image::make($file);
            /*保存图片*/
            $date = date('Y-m-d');
            $upload_path = <<<EOF
resource/$patch/$saveFolder/$date/
EOF;

            $mysql_save_path = <<<EOF
$patch/$saveFolder/$date/
EOF;
            $path = storage_path($upload_path);
            if (!is_dir($path)) {
                mkdir($path, 0766, true);
            }
            $filename = uniqid() . time() . '.' . $extension;
            $image->save($path . $filename);
            $returnData = [
                'result' => true,
                'msg' => '上传成功',
                'local' => $mysql_save_path . $filename,
                'extension' => $extension,
            ];
        } else {
            $returnData = [
                'result' => false,
                'msg' => '上传图片格式不正确',
            ];
        }
        return $returnData;
    }
}

if (!function_exists('commonUpload'))
{
    function commonUpload($file, $saveFolder)
    {
        $allowedExtensions = [
            'jpg', 'jpeg', 'png', 'csv', 'xls', 'pdf', 'gif'
        ];
        $extension = $file->getClientOriginalExtension();

        /*判断后缀是否合法*/
        if (in_array($extension, $allowedExtensions)) {

            /*保存图片*/
            $upload_path = 'resource/research/' . $saveFolder . '/' . date('Y-m-d') . '/';
            $mysql_save_path = 'research/' . $saveFolder . '/' . date('Y-m-d') . '/';
            $path = public_path($upload_path);
            if (!is_dir($path)) {
                mkdir($path, 0766, true);
            }
            $filename = uniqid() . time() . '.' . $extension;

            $file->move($path, $filename);

            $returnData = [
                'result' => true,
                'msg' => '上传成功',
                'local' => $mysql_save_path . $filename,
                'extension' => $extension,
            ];
        } else {
            $returnData = [
                'result' => false,
                'msg' => '上传图片格式不正确',
            ];
        }
        return $returnData;
    }
}

if (! function_exists('storage_path')) {

    function storage_path($path = '')
    {
        return app('path.storage').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

/*检查是否是手机号码*/
if(! function_exists('isMobile'))
{
	function isMobile($mobile)
    {
		if (!is_numeric($mobile)) return false;
//        return preg_match('#^13[\d]{9}$|^14[\d]{9}}$|^15[\d]{9}$|^17[\d]{9}$|^18[\d]{9}$#', $mobile) ? true : false;
		$rule = '#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#';
		return preg_match($rule, $mobile) ? true : false;
	}
}


/*检查是否是移动设备*/
if(!function_exists('isMobileEquipment')){
	function isMobileEquipment()
	{
		// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
		if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
		{
			return true;
		}

		// 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
		if (isset ($_SERVER['HTTP_VIA']))
		{
			// 找不到为flase,否则为true
			return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
		}

		// 脑残法，判断手机发送的客户端标志,兼容性有待提高
		if (isset ($_SERVER['HTTP_USER_AGENT']))
		{
			$clientkeywords = array ('nokia',
				'sony',
				'ericsson',
				'mot',
				'samsung',
				'htc',
				'sgh',
				'lg',
				'sharp',
				'sie-',
				'philips',
				'panasonic',
				'alcatel',
				'lenovo',
				'iphone',
				'ipod',
				'blackberry',
				'meizu',
				'android',
				'netfront',
				'symbian',
				'ucweb',
				'windowsce',
				'palm',
				'operamini',
				'operamobi',
				'openwave',
				'nexusone',
				'cldc',
				'midp',
				'wap',
				'mobile'
			);

			// 从HTTP_USER_AGENT中查找手机浏览器的关键字
			if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
			{
				return true;
			}
		}

		// 协议法，因为有可能不准确，放到最后判断
		if (isset ($_SERVER['HTTP_ACCEPT']))
		{
			// 如果只支持wml并且不支持html那一定是移动设备
			// 如果支持wml和html但是wml在html之前则是移动设备
			if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
			{
				return true;
			}
		}

		return false;
	}
}



// 获得 今天（开始）时间戳
if(!function_exists('get_today_start_unix'))
{
    function get_today_start_unix() {
        return strtotime(date("Y-m-d",time()));
    }
}
// 获得 今天（结束）时间戳
if(!function_exists('get_today_ended_unix'))
{
    function get_today_ended_unix() {
        return strtotime(date("Y-m-d",time())) + (3600*24-1);
    }
}
// 获得 本周（开始）时间戳
if(!function_exists('get_this_week_start_unix'))
{
    function get_this_week_start_unix() {
    return (get_today_start_unix() - ((date("N")-1)*3600*24));
}
}
// 获得 本周（结束）时间戳
if(!function_exists('get_this_week_ended_unix'))
{
    function get_this_week_ended_unix() {
        return get_this_week_start_unix() + (7*3600*24-1);
    }
}
// 获得 本月（开始）时间戳
if(!function_exists('get_this_month_start_unix'))
{
    function get_this_month_start_unix() {
        return strtotime(date("Y-m",time())."-1");
    }
}
// 获得 本月（结束）时间戳
if(!function_exists('get_this_month_ended_unix'))
{
    function get_this_month_ended_unix() {
        return (strtotime(date("Y",time())."-".(date("m",time()) + 1)."-1") - 1);
    }
}
// 获得 本年（开始）时间戳
if(!function_exists('get_this_year_start_unix'))
{
    function get_this_year_start_unix() {
        return strtotime(date("Y",time())."-1-1");
    }
}
// 获得 本年（结束）时间戳
if(!function_exists('get_this_year_ended_unix'))
{
    function get_this_year_ended_unix() {
        return strtotime(date("Y",time())."-12-31 23:59:59");
    }
}



// 获取 某一天（开始）时间戳
if(!function_exists('get_day_start_unix'))
{
    function get_day_start_unix($stamp) {
        return strtotime(date("Y-m-d",$stamp));
    }
}
// 获取 某一天（结束）时间戳
if(!function_exists('get_day_ended_unix'))
{
    function get_day_ended_unix($stamp) {
        return strtotime(date("Y-m-d",$stamp)) + (3600*24-1);
    }
}
// 获取 某一周（开始）时间戳
if(!function_exists('get_week_start_unix'))
{
    function get_week_start_unix($stamp) {
        return ( get_day_start_unix($stamp) - ((date("N",$stamp)-1)*3600*24) );
    }
}
// 获取 某一周（结束）时间戳
if(!function_exists('get_week_ended_unix'))
{
    function get_week_ended_unix($stamp) {
        return get_week_start_unix($stamp) + (7*3600*24-1);
    }
}
// 获取 某一月（开始）时间戳
if(!function_exists('get_month_start_unix'))
{
    function get_month_start_unix($stamp) {
        return strtotime(date("Y-m",$stamp)."-1");
    }
}
// 获取 某一月（结束）时间戳
if(!function_exists('get_month_ended_unix'))
{
    function get_month_ended_unix($stamp) {
        $yearN = date("Y",$stamp);
        $monthN = date("m",$stamp);
        if($monthN == 12) {
            $yearN = $yearN +1;
            $monthN = 1;
        } else {
            $monthN = $monthN + 1;
        }
        $timestr = $yearN."-".$monthN."-1";
        //return (strtotime(date("Y",$stamp)."-".(date("m",$stamp) + 1)."-1") - 1);
        return strtotime($timestr) - 1;
    }
}
// 获取 某一年（开始）时间戳
if(!function_exists('get_year_start_unix'))
{
    function get_year_start_unix($stamp) {
        return strtotime(date("Y",$stamp)."-1-1");
    }
}
// 获取 某一年（结束）时间戳
if(!function_exists('get_year_ended_unix'))
{
    function get_year_ended_unix($stamp) {
        return strtotime(date("Y",$stamp)."-12-31 23:59:59");
    }
}



// 是否同一天 return 0 || 1
if(!function_exists('is_same_day'))
{
    function is_same_day($stamp_1,$stamp_2) {
        if( get_day_start_unix($stamp_1) == get_day_start_unix($stamp_2) ) return 1;
        else return 0;
    }
}
// 是否同一周 return 0 || 1
if(!function_exists('is_same_week'))
{
    function is_same_week($stamp_1,$stamp_2) {
        if( get_week_start_unix($stamp_1) == get_week_start_unix($stamp_2) ) return 1;
        else return 0;
    }
}
// 是否同一月 return 0 || 1
if(!function_exists('is_same_month'))
{
    function is_same_month($stamp_1,$stamp_2) {
        if( get_month_start_unix($stamp_1) == get_month_start_unix($stamp_2) ) return 1;
        else return 0;
    }
}
// 是否同一年 return 0 || 1
if(!function_exists('is_same_year'))
{
    function is_same_year($stamp_1,$stamp_2) {
        if( get_year_start_unix($stamp_1) == get_year_start_unix($stamp_2) ) return 1;
        else return 0;
    }
}


if(!function_exists('response_success'))
{
    function response_success($data = "",$msg = "操作成功！") {
        return json_encode([
                'success' => true,
                'status' => 200,
                'code' => 200,
                'msg' => $msg,
                'data' => $data,
            ]);
    }
}
if(!function_exists('response_fail'))
{
    function response_fail($data = "",$msg = "程序出错，请重试！") {
        return json_encode([
                'success' => false,
                'status' => 500,
                'code' => 500,
                'msg' => $msg,
                'data' => $data,
            ]);
    }
}
if(!function_exists('response_error'))
{
    function response_error($data = "",$msg = "参数有误！") {
        return json_encode([
                'success' => false,
                'status' => 422,
                'code' => 422,
                'msg' => $msg,
                'data' => $data,
            ]);
    }
}

if(!function_exists('datatable_response'))
{
    function datatable_response($data = array(), $draw = 0, $total = 100, $message = 'success', $status_code = '200')
    {
        if($status_code == 304) exit(header('server-response-code: 304'));

        if(!empty($data)) {
            $result = array(
                'message'			=> $message,
                'data' 				=> $data,
                'draw' 				=> $draw + 1,
                'recordsTotal'		=> $total,
                'recordsFiltered'	=> $total,
            );
        } else {
            $result = array(
                'message'			=> $message,
                'data'				=> $data,
                'draw'				=> 0,
                'recordsTotal'		=> 0,
                'recordsFiltered'	=> 0,
            );
        }
        return Response::json($result);
    }
}









//if(!function_exists('getClientIps'))
//{
//    function getClientIps()
//    {
//        $clientIps = array();
//        $ip = $this->server->get('REMOTE_ADDR');
//
//        if (!$this->isFromTrustedProxy()) {
//            return array($ip);
//        }
//
//        $hasTrustedForwardedHeader = self::$trustedHeaders[self::HEADER_FORWARDED] && $this->headers->has(self::$trustedHeaders[self::HEADER_FORWARDED]);
//        $hasTrustedClientIpHeader = self::$trustedHeaders[self::HEADER_CLIENT_IP] && $this->headers->has(self::$trustedHeaders[self::HEADER_CLIENT_IP]);
//
//        if ($hasTrustedForwardedHeader) {
//            $forwardedHeader = $this->headers->get(self::$trustedHeaders[self::HEADER_FORWARDED]);
//            preg_match_all('{(for)=("?\[?)([a-z0-9\.:_\-/]*)}', $forwardedHeader, $matches);
//            $forwardedClientIps = $matches[3];
//
//            $forwardedClientIps = $this->normalizeAndFilterClientIps($forwardedClientIps, $ip);
//            $clientIps = $forwardedClientIps;
//        }
//
//        if ($hasTrustedClientIpHeader) {
//            $xForwardedForClientIps = array_map('trim', explode(',', $this->headers->get(self::$trustedHeaders[self::HEADER_CLIENT_IP])));
//
//            $xForwardedForClientIps = $this->normalizeAndFilterClientIps($xForwardedForClientIps, $ip);
//            $clientIps = $xForwardedForClientIps;
//        }
//
//        if ($hasTrustedForwardedHeader && $hasTrustedClientIpHeader && $forwardedClientIps !== $xForwardedForClientIps) {
//            throw new ConflictingHeadersException('The request has both a trusted Forwarded header and a trusted Client IP header, conflicting with each other with regards to the originating IP addresses of the request. This is the result of a misconfiguration. You should either configure your proxy only to send one of these headers, or configure Symfony to distrust one of them.');
//        }
//
//        if (!$hasTrustedForwardedHeader && !$hasTrustedClientIpHeader) {
//            return $this->normalizeAndFilterClientIps(array(), $ip);
//        }
//
//        return $clientIps;
//    }
//
//}


