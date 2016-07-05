<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


//一次处理的个数，防止超时
execute();

function execute(){
	global $_SGLOBAL, $_SC;
	
$cropstime=array(
        "1" =>86405,
        "2" =>36005,
        "3" =>46805,
        "4" =>50405,
        "5" =>54005,
        "6" =>57605,
        "7" =>61205,
        "8" =>64805,
        "9" =>72005,
        "10" =>79205,
        "11" =>75605,
        "12" =>93600,
        "13" =>165605,
        "14" =>100805,
        "15" =>111605,
        "16" =>126005,
        "17" =>140405,
        "18" =>151205,
        "19" =>133205,
        "20" =>262805,
        "23" =>187205,
        "26" =>219605,
        "27" =>230405,
        "29" =>198005,
        "31" =>219605,
        "33" =>252005,
        "34" =>259205,
        "35" =>277205,
        "36" =>291605,
        "101" =>57605,
        "102" =>57605,
        "103" =>57605,
        "104" =>57605,
        "105" =>86405,
        "106" =>86405,
        "107" =>86405,
        "108" =>86405,
        "109" =>93605,
        "110" =>93605,
        "111" =>93605,
        "112" =>93605,
        "113" =>97205,
        "114" =>97205,
        "115" =>97205,
        "116" =>97205,
        "21" =>212405,
        "22" =>234005,
        "117" =>100805,
        "118" =>100805,
        "119" =>100805,
        "120" =>100805,
        "121" =>108005,
        "122" =>108005,
        "123" =>108005,
        "124" =>108005,
        "2001" =>144000,
        "2002" =>144000,
        "2003" =>144000
);
$query = $_SGLOBAL['db']->query('SELECT uid,farmlandstatus FROM '.tname('plug_newfarm'));
    while ($value = $_SGLOBAL['db']->fetch_array($query)) {
                $list[] = $value;
                }
foreach ($list as $userparameter) {
    $farm=(array) json_decode($userparameter[farmlandstatus]);
    foreach ($farm[farmlandstatus] as $value){
        if(($_SGLOBAL['timestamp']-$value->q)<$cropstime[$value->a])
        {
            $suiji=mt_rand(1,20);
            if($value->f==0)
            {
                if ($suiji<10)
                {
                    if ($suiji<4)
                    {
                        if ($suiji<2)
                        {
                            $value->f=3;
                        }
                        else
                        {
                            $value->f=2;
                        }
                    }
                    else
                    {
                        $value->f=1;
                    }
                }
            }
            $suiji=mt_rand(1,20);
            if($value->g==0)
            {
                if ($suiji<10)
                {
                    if ($suiji<4)
                    {
                        if ($suiji<2)
                        {
                            $value->g=3;
                        }
                        else
                        {
                            $value->g=2;
                        }
                    }
                    else
                    {
                        $value->g=1;
                    }
                }
            }
            $suiji=mt_rand(1,20);
            if($value->h==1)
            {
                if ($suiji<7)
                {
                    $value->h=0;
                }
            }

        }
    }
    $farm=json_encode($farm);
    $_SGLOBAL['db']->query("UPDATE ".tname('plug_newfarm')." set farmlandstatus='".$farm."' where uid=".$userparameter[uid]);

}

}

?>
