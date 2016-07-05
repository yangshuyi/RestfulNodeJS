<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function unicode_encode( $name )
{
				$name = iconv( "UTF-8", "UCS-2", $name );
				$len = strlen( $name );
				$str = "";
				$i = 0;
				for ( ;	$i < $len - 1;	$i += 2	)
				{
								$c = $name[$i];
								$c2 = $name[$i + 1];
								if ( 0 < ord( $c ) )
								{
												$c2 = base_convert( ord( $c2 ), 10, 16 );
												if ( strlen( $c2 ) == 1 )
												{
																$c2 = "0".$c2;
												}
												$str .= "\\u".base_convert( ord( $c ), 10, 16 ).$c2;
								}
								else
								{
												$str .= $c2;
								}
				}
				return $str;
}

function unicode_encodegb( $name )
{
				$name = iconv( "GB2312", "UCS-2", $name );
				$len = strlen( $name );
				$str = "";
				$i = 0;
				for ( ;	$i < $len - 1;	$i += 2	)
				{
								$c = $name[$i];
								$c2 = $name[$i + 1];
								if ( 0 < ord( $c ) )
								{
												$c2 = base_convert( ord( $c2 ), 10, 16 );
												if ( strlen( $c2 ) == 1 )
												{
																$c2 = "0".$c2;
												}
												$str .= "\\u".base_convert( ord( $c ), 10, 16 ).$c2;
								}
								else
								{
												$str .= $c2;
								}
				}
				return $str;
}

function unicode_encodebig5( $name )
{
				$name = iconv( "big5", "UCS-2", $name );
				$len = strlen( $name );
				$str = "";
				$i = 0;
				for ( ;	$i < $len - 1;	$i += 2	)
				{
								$c = $name[$i];
								$c2 = $name[$i + 1];
								if ( 0 < ord( $c ) )
								{
												$c2 = base_convert( ord( $c2 ), 10, 16 );
												if ( strlen( $c2 ) == 1 )
												{
																$c2 = "0".$c2;
												}
												$str .= "\\u".base_convert( ord( $c ), 10, 16 ).$c2;
								}
								else
								{
												$str .= $c2;
								}
				}
				return $str;
}

include_once( "../common.php" );
$space = getspace( $_SGLOBAL['supe_uid'] );
$animaltime = array(
				"1001" => array( 14400, 14400, 129600, 180, 21420, 158400 ),
				"1002" => array( 18000, 18000, 129600, 180, 28620, 165600 ),
				"1003" => array( 16200, 16200, 151200, 180, 25200, 183600 ),
				"1004" => array( 34200, 34200, 216000, 180, 32400, 284400 ),
				"1005" => array( 37800, 37800, 237600, 180, 43200, 313200 ),
				"1006" => array( 41400, 41400, 259200, 180, 54000, 342000 ),
				"1501" => array( 27000, 27000, 172800, 180, 43020, 226800 ),
				"1502" => array( 32400, 32400, 216000, 180, 43020, 280800 ),
				"1503" => array( 36000, 36000, 216000, 180, 36000, 288000 ),
				"1504" => array( 39600, 39600, 237600, 180, 43200, 316800 )
);
$shop = array(
				"1001" => array( "byproductprice" => 17, "cId" => 1001, "cLevel" => 0, "cName" => "\\u9E21", "consum" => 1, "cub" => 14400, "cycle" => 21600, "expect" => 0, "growing" => "14400,14400,129600,180", "growthCycle" => 0, "harvestbExp" => 10, "harvestpExp" => 30, "maturingTime" => 28800, "output" => 20, "price" => 700, "procreation" => 129600, "productime" => 180, "productprice" => 860 ),
				"1002" => array( "byproductprice" => 39, "cId" => 1002, "cLevel" => 1, "cName" => "\\u5154\\u5B50", "consum" => 2, "cub" => 18000, "cycle" => 28800, "expect" => 0, "growing" => "18000,18000,129600,180", "growthCycle" => 0, "harvestbExp" => 12, "harvestpExp" => 32, "maturingTime" => 36000, "output" => 12, "price" => 1200, "procreation" => 129600, "productime" => 180, "productprice" => 1460 ),
				"1501" => array( "byproductprice" => 29, "cId" => 1501, "cLevel" => 2, "cName" => "\\u7F8A", "consum" => 4, "cub" => 27000, "cycle" => 43200, "expect" => 0, "growing" => "27000,27000,172800,180", "growthCycle" => 0, "harvestbExp" => 16, "harvestpExp" => 38, "maturingTime" => 54000, "output" => 24, "price" => 2000, "procreation" => 172800, "productime" => 180, "productprice" => 2860 ),
				"1003" => array( "byproductprice" => 19, "cId" => 1003, "cLevel" => 3, "cName" => "\\u9E45", "consum" => 3, "cub" => 16200, "cycle" => 25200, "expect" => 0, "growing" => "16200,16200,151200,180", "growthCycle" => 0, "harvestbExp" => 11, "harvestpExp" => 36, "maturingTime" => 32400, "output" => 20, "price" => 900, "procreation" => 151200, "productime" => 180, "productprice" => 1060 ),
				"1502" => array( "byproductprice" => 55, "cId" => 1502, "cLevel" => 4, "cName" => "\\u725B", "consum" => 5, "cub" => 32400, "cycle" => 43200, "expect" => 0, "growing" => "32400,32400,216000,180", "growthCycle" => 0, "harvestbExp" => 17, "harvestpExp" => 40, "maturingTime" => 64800, "output" => 12, "price" => 3000, "procreation" => 216000, "productime" => 180, "productprice" => 4260 ),
				"1004" => array( "byproductprice" => 56, "cId" => 1004, "cLevel" => 5, "cName" => "\\u732B", "consum" => 2, "cub" => 34200, "cycle" => 32400, "expect" => 0, "growing" => "34200,34200,216000,180", "growthCycle" => 0, "harvestbExp" => 14, "harvestpExp" => 37, "maturingTime" => 68400, "output" => 12, "price" => 3200, "procreation" => 216000, "productime" => 180, "productprice" => 4060 ),
				"1503" => array( "byproductprice" => 58, "cId" => 1503, "cLevel" => 6, "cName" => "\\u7334\\u5B50", "consum" => 4, "cub" => 36000, "cycle" => 36000, "expect" => 0, "growing" => "36000,36000,216000,180", "growthCycle" => 0, "harvestbExp" => 14, "harvestpExp" => 38, "maturingTime" => 72000, "output" => 12, "price" => 4000, "procreation" => 216000, "productime" => 180, "productprice" => 5260 ),
				"1005" => array( "byproductprice" => 35, "cId" => 1005, "cLevel" => 7, "cName" => "\\u5B54\\u96C0", "consum" => 3, "cub" => 37800, "cycle" => 43200, "expect" => 0, "growing" => "37800,37800,237600,180", "growthCycle" => 0, "harvestbExp" => 16, "harvestpExp" => 39, "maturingTime" => 75600, "output" => 24, "price" => 5000, "procreation" => 237600, "productime" => 180, "productprice" => 6060 ),
				"1504" => array( "byproductprice" => 64, "cId" => 1504, "cLevel" => 8, "cName" => "\\u888B\\u9F20", "consum" => 5, "cub" => 39600, "cycle" => 43200, "expect" => 0, "growing" => "39600,39600,237600,180", "growthCycle" => 0, "harvestbExp" => 16, "harvestpExp" => 40, "maturingTime" => 79200, "output" => 12, "price" => 8000, "procreation" => 237600, "productime" => 180, "productprice" => 9860 ),
				"1006" => array( "byproductprice" => 68, "cId" => 1006, "cLevel" => 9, "cName" => "\\u4F01\\u9E45", "consum" => 3, "cub" => 41400, "cycle" => 54000, "expect" => 0, "growing" => "41400,41400,259200,180", "growthCycle" => 0, "harvestbExp" => 22, "harvestpExp" => 44, "maturingTime" => 82800, "output" => 16, "price" => 10000, "procreation" => 259200, "productime" => 180, "productprice" => 11860 )
);
$animalname = array(
				"1001" => array( "name" => "\\u9E21\\u86CB", "price" => 17, "exp" => 10 ),
				"1002" => array( "name" => "\\u5154\\u4ED4", "price" => 39, "exp" => 12 ),
				"1003" => array( "name" => "\\u9E45\\u86CB", "price" => 19, "exp" => 11 ),
				"1004" => array( "name" => "\\u5C0F\\u732B\\u4ED4", "price" => 56, "exp" => 14 ),
				"1005" => array( "name" => "\\u5B54\\u96C0\\u86CB", "price" => 35, "exp" => 16 ),
				"1006" => array( "name" => "\\u5C0F\\u4F01\\u9E45", "price" => 68, "exp" => 22 ),
				"1501" => array( "name" => "\\u7F8A\\u6BDB", "price" => 29, "exp" => 16 ),
				"1502" => array( "name" => "\\u725B\\u5976", "price" => 55, "exp" => 17 ),
				"1503" => array( "name" => "\\u5C0F\\u7334\\u4ED4", "price" => 58, "exp" => 14 ),
				"1504" => array( "name" => "\\u5C0F\\u888B\\u9F20", "price" => 64, "exp" => 16 ),
				"11001" => array( "name" => "\\u9E21", "price" => 860, "exp" => 30 ),
				"11002" => array( "name" => "\\u5154\\u5B50", "price" => 1460, "exp" => 32 ),
				"11003" => array( "name" => "\\u9E45", "price" => 1060, "exp" => 36 ),
				"11004" => array( "name" => "\\u732B", "price" => 4060, "exp" => 37 ),
				"11005" => array( "name" => "\\u5B54\\u96C0", "price" => 6060, "exp" => 39 ),
				"11006" => array( "name" => "\\u4F01\\u9E45", "price" => 11860, "exp" => 44 ),
				"11501" => array( "name" => "\\u7F8A", "price" => 2860, "exp" => 38 ),
				"11502" => array( "name" => "\\u725B", "price" => 4260, "exp" => 40 ),
				"11503" => array( "name" => "\\u7334\\u5B50", "price" => 5260, "exp" => 38 ),
				"11504" => array( "name" => "\\u888B\\u9F20", "price" => 9860, "exp" => 40 )
);
if ( $_REQUEST['mod'] == "cgi_enter" || $_REQUEST['mod'] == "cgi_enter?" )
{
				if ( 0 < intval( $_REQUEST['uId'] ) )
				{
								$touarr = array( "1001" => 0, "1002" => 0, "1003" => 0, "1004" => 0, "1005" => 0, "1006" => 0, "1501" => 0, "1502" => 0, "1503" => 0, "1504" => 0 );
								$query = $_SGLOBAL['db']->query( "SELECT money,animal,mc_exp FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['uId'] ) );
								while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
								{
												$list[] = $value;
								}
								$animal = ( array )json_decode( $list[0][animal] );
								$needfood = 0;
								foreach ( $animal[animal] as $key => $value )
								{
												if ( 0 < $value->cId )
												{
																if ( $touarr[$value->cId] != 3 )
																{
																				$touarr[$value->cId] = 3;
																				if ( stristr( $value->tou, ",".$_SGLOBAL['supe_uid']."," ) )
																				{
																								$touarr[$value->cId] = 2;
																				}
																				if ( $value->totalCome <= $shop[$value->cId][output] / 2 )
																				{
																								$touarr[$value->cId] = 1;
																				}
																}
																$needfood += $shop[$value->cId][consum];
																if ( $value->postTime == 0 )
																{
																				$time = $_SGLOBAL['timestamp'] - $value->buyTime;
																				if ( $animaltime[$value->cId][0] + $animaltime[$value->cId][1] <= $time )
																				{
																								$status = 3;
																								$growTimeNext = 12993;
																								$statusNext = 6;
																				}
																				if ( $animaltime[$value->cId][0] <= $time && $time < $animaltime[$value->cId][0] + $animaltime[$value->cId][1] )
																				{
																								$status = 2;
																								$growTimeNext = $animaltime[$value->cId][0] + $animaltime[$value->cId][1] - $time;
																								$statusNext = 3;
																				}
																				if ( $time < $animaltime[$value->cId][0] )
																				{
																								$status = 1;
																								$growTimeNext = $animaltime[$value->cId][0] - $time;
																								$statusNext = 2;
																				}
																				if ( $animaltime[$value->cId][5] < $time )
																				{
																								$status = 6;
																								$growTimeNext = 0;
																								$statusNext = 6;
																				}
																				$newanimal[] = "{\"buyTime\":".$value->buyTime.",\"cId\":".$value->cId.",\"growTime\":".$time.",\"growTimeNext\":".$growTimeNext.",\"hungry\":0,\"serial\":".$key.",\"status\":".$status.",\"statusNext\":".$statusNext.",\"totalCome\":".$value->totalCome."}";
																}
																else
																{
																				$totalCome = $value->totalCome;
																				$time = $_SGLOBAL['timestamp'] - $value->buyTime;
																				if ( $animaltime[$value->cId][5] < $time )
																				{
																								$status = 6;
																								$statusNext = 6;
																								$growTimeNext = 0;
																				}
																				if ( $animaltime[$value->cId][4] < $_SGLOBAL['timestamp'] - $value->postTime )
																				{
																								$status = 3;
																								$statusNext = 6;
																								$growTimeNext = 12993;
																				}
																				if ( $_SGLOBAL['timestamp'] - $value->postTime <= $animaltime[$value->cId][4] )
																				{
																								$status = 5;
																								$statusNext = 3;
																								$growTimeNext = $animaltime[$value->cId][4] - ( $_SGLOBAL['timestamp'] - $value->postTime );
																				}
																				if ( $_SGLOBAL['timestamp'] - $value->postTime <= $animaltime[$value->cId][3] )
																				{
																								$status = 4;
																								$statusNext = 5;
																								$growTimeNext = $animaltime[$value->cId][3] - ( $_SGLOBAL['timestamp'] - $value->postTime );
																								$totalCome -= $shop[$value->cId][output];
																				}
																				if ( $value->buyTime + $animaltime[$value->cId][5] - $animaltime[$value->cId][3] - $animaltime[$value->cId][4] < $_SGLOBAL['timestamp'] )
																				{
																								$status = 5;
																								$statusNext = 6;
																								$growTimeNext = $animaltime[$value->cId][5] - $time;
																				}
																				$newanimal[] = "{\"buyTime\":".$value->buyTime.",\"cId\":".$value->cId.",\"growTime\":".$time.",\"growTimeNext\":".$growTimeNext.",\"hungry\":0,\"serial\":".$key.",\"status\":".$status.",\"statusNext\":".$statusNext.",\"totalCome\":".$totalCome."}";
																}
												}
								}
								$newanimal = json_encode( $newanimal );
								$newanimal = str_replace( "\"{", "{", $newanimal );
								$newanimal = str_replace( "}\"", "}", $newanimal );
								$newanimal = str_replace( "null", "[]", $newanimal );
								$animal[animalfood] = $animal[animalfood] - ( $_SGLOBAL['timestamp'] - $animal[animalfeedtime] ) / 3600 * $needfood / 4;
								if ( $animal[animalfood] < 0 )
								{
												$animal[animalfood] = 0;
								}
								if ( $animal[animalfood] == 0 )
								{
												$newanimal = str_replace( "\\\"hungry\\\":0", "\\\"hungry\\\":1", $newanimal );
								}
								$animal[animalfeedtime] = $_SGLOBAL['timestamp'];
								$stranimal = json_encode( $animal );
								$animal[animalfood] = floor( $animal[animalfood] );
								$touyes = ">";
								foreach ( $touarr as $key => $value )
								{
												if ( 0 < $value )
												{
																$touyes = $touyes.",\"".$key."\":".$value."";
												}
								}
								$touyes = str_replace( ">,", "", $touyes );
								$touyes = str_replace( ">", "", $touyes );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set animal='".$stranimal."' where uid=".intval( $_REQUEST['uId'] ) );
								if ( $animal[item2] == 10220 )
								{
												$animal[item2] = "";
								}
								else
								{
												$animal[item2] = "\"2\":{\"itemId\":".$animal[item2]."},";
								}
								if ( $animal[item3] == 10330 )
								{
												$animal[item3] = "";
								}
								else
								{
												$animal[item3] = "\"3\":{\"itemId\":".$animal[item3]."},";
								}
								echo stripslashes( "{\"animal\":".$newanimal.",\"animalFood\":".$animal[animalfood].",\"badinfo\":[{\"mynum\":0,\"num\":0,\"type\":1}],\"items\":{\"1\":{\"itemId\":".$animal[item1]."},".$animal[item2].$animal[item3]."\"4\":{\"itemId\":".$animal[item4]."}},\"notice\":\"\",\"serverTime\":{\"time\":".$_SGLOBAL['timestamp']."},\"stealflag\":{".$touyes."},\"task\":{\"taskFlag\":1,\"taskId\":8},\"user\":{\"exp\":".$list[0][mc_exp].",\"headPic\":\"".avatar( $_SGLOBAL[supe_uid], "small", TRUE )."\",\"money\":".$list[0][money].",\"uId\":".$_SGLOBAL['supe_uid'].",\"userName\":\"".$space[name]."\",\"yellowlevel\":7,\"yellowstatus\":0},\"weather\":{\"weatherDesc\":\"晴天\",\"weatherId\":1}}" );
								exit( );
				}
				$query = $_SGLOBAL['db']->query( "SELECT money,animal,mc_exp,mc_taskid FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$animal = ( array )json_decode( $list[0][animal] );
				$needfood = 0;
				foreach ( $animal[animal] as $key => $value )
				{
								if ( 0 < $value->cId )
								{
												$needfood += $shop[$value->cId][consum];
												if ( $value->postTime == 0 )
												{
																$time = $_SGLOBAL['timestamp'] - $value->buyTime;
																if ( $animaltime[$value->cId][0] + $animaltime[$value->cId][1] <= $time )
																{
																				$status = 3;
																				$growTimeNext = 12993;
																				$statusNext = 6;
																}
																if ( $animaltime[$value->cId][0] <= $time && $time < $animaltime[$value->cId][0] + $animaltime[$value->cId][1] )
																{
																				$status = 2;
																				$growTimeNext = $animaltime[$value->cId][0] + $animaltime[$value->cId][1] - $time;
																				$statusNext = 3;
																}
																if ( $time < $animaltime[$value->cId][0] )
																{
																				$status = 1;
																				$growTimeNext = $animaltime[$value->cId][0] - $time;
																				$statusNext = 2;
																}
																if ( $animaltime[$value->cId][5] < $time )
																{
																				$status = 6;
																				$growTimeNext = 0;
																				$statusNext = 6;
																}
																$newanimal[] = "{\"buyTime\":".$value->buyTime.",\"cId\":".$value->cId.",\"growTime\":".$time.",\"growTimeNext\":".$growTimeNext.",\"hungry\":0,\"serial\":".$key.",\"status\":".$status.",\"statusNext\":".$statusNext.",\"totalCome\":".$value->totalCome."}";
												}
												else
												{
																$time = $_SGLOBAL['timestamp'] - $value->buyTime;
																$totalCome = $value->totalCome;
																if ( $animaltime[$value->cId][5] < $time )
																{
																				$status = 6;
																				$statusNext = 6;
																				$growTimeNext = 0;
																}
																if ( $animaltime[$value->cId][4] < $_SGLOBAL['timestamp'] - $value->postTime )
																{
																				$status = 3;
																				$statusNext = 6;
																				$growTimeNext = 12993;
																}
																if ( $_SGLOBAL['timestamp'] - $value->postTime <= $animaltime[$value->cId][4] )
																{
																				$status = 5;
																				$statusNext = 3;
																				$growTimeNext = $animaltime[$value->cId][4] - ( $_SGLOBAL['timestamp'] - $value->postTime );
																}
																if ( $_SGLOBAL['timestamp'] - $value->postTime <= $animaltime[$value->cId][3] )
																{
																				$status = 4;
																				$statusNext = 5;
																				$growTimeNext = $animaltime[$value->cId][3] - ( $_SGLOBAL['timestamp'] - $value->postTime );
																				$totalCome -= $shop[$value->cId][output];
																}
																if ( $value->buyTime + $animaltime[$value->cId][5] - $animaltime[$value->cId][3] - $animaltime[$value->cId][4] < $_SGLOBAL['timestamp'] )
																{
																				$status = 5;
																				$statusNext = 6;
																				$growTimeNext = $animaltime[$value->cId][5] - $time;
																}
																$newanimal[] = "{\"buyTime\":".$value->buyTime.",\"cId\":".$value->cId.",\"growTime\":".$time.",\"growTimeNext\":".$growTimeNext.",\"hungry\":0,\"serial\":".$key.",\"status\":".$status.",\"statusNext\":".$statusNext.",\"totalCome\":".$totalCome."}";
												}
								}
				}
				$newanimal = json_encode( $newanimal );
				$newanimal = str_replace( "\"{", "{", $newanimal );
				$newanimal = str_replace( "}\"", "}", $newanimal );
				$newanimal = str_replace( "null", "[]", $newanimal );
				$animal[animalfood] = $animal[animalfood] - ( $_SGLOBAL['timestamp'] - $animal[animalfeedtime] ) / 3600 * $needfood / 4;
				if ( $animal[animalfood] < 0 )
				{
								$animal[animalfood] = 0;
				}
				if ( $animal[animalfood] == 0 )
				{
								$newanimal = str_replace( "\\\"hungry\\\":0", "\\\"hungry\\\":1", $newanimal );
				}
				$animal[animalfeedtime] = $_SGLOBAL['timestamp'];
				$stranimal = json_encode( $animal );
				$animal[animalfood] = floor( $animal[animalfood] );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set animal='".$stranimal."' where uid=".$_SGLOBAL['supe_uid'] );
				if ( $animal[item2] == 10220 )
				{
								$animal[item2] = "";
				}
				else
				{
								$animal[item2] = "\"2\":{\"itemId\":".$animal[item2]."},";
				}
				if ( $animal[item3] == 10330 )
				{
								$animal[item3] = "";
				}
				else
				{
								$animal[item3] = "\"3\":{\"itemId\":".$animal[item3]."},";
				}
				$taskFlag = 1;
				if ( $list[0][mc_taskid] == 10 )
				{
								$taskFlag = 0;
				}
				if ( $space['name'] == "" )
				{
								$space['name'] = $space['username'];
				}
				echo stripslashes( "{\"animal\":".$newanimal.",\"animalFood\":".$animal[animalfood].",\"badinfo\":[{\"mynum\":0,\"num\":0,\"type\":1}],\"items\":{\"1\":{\"itemId\":".$animal[item1]."},".$animal[item2].$animal[item3]."\"4\":{\"itemId\":".$animal[item4]."}},\"notice\":\"\",\"serverTime\":{\"time\":".$_SGLOBAL['timestamp']."},\"stealflag\":{},\"task\":{\"taskFlag\":".$taskFlag.",\"taskId\":".$list[0][mc_taskid]."},\"user\":{\"exp\":".$list[0][mc_exp].",\"headPic\":\"".avatar( $_SGLOBAL[supe_uid], "small", TRUE )."\",\"money\":".$list[0][money].",\"uId\":".$_SGLOBAL['supe_uid'].",\"userName\":\"".str_replace( "\\u", "\\\\u", unicode_encodegb( $space['name'] ) )."\",\"yellowlevel\":7,\"yellowstatus\":0},\"weather\":{\"weatherDesc\":\"晴天\",\"weatherId\":1}}" );
				exit( );
}
if ( $_REQUEST['mod'] == "cgi_get_animals" )
{
				echo "[{\"byproductprice\":17,\"cId\":1001,\"cLevel\":0,\"cName\":\"\\u9E21\",\"consum\":1,\"cub\":14400,\"cycle\":21600,\"expect\":0,\"growing\":\"14400,14400,129600,180\",\"growthCycle\":0,\"harvestbExp\":10,\"harvestpExp\":30,\"maturingTime\":28800,\"output\":20,\"price\":700,\"procreation\":129600,\"productime\":180,\"productprice\":860},{\"byproductprice\":39,\"cId\":1002,\"cLevel\":1,\"cName\":\"\\u5154\\u5B50\",\"consum\":2,\"cub\":18000,\"cycle\":28800,\"expect\":0,\"growing\":\"18000,18000,129600,180\",\"growthCycle\":0,\"harvestbExp\":12,\"harvestpExp\":32,\"maturingTime\":36000,\"output\":12,\"price\":1200,\"procreation\":129600,\"productime\":180,\"productprice\":1460},{\"byproductprice\":29,\"cId\":1501,\"cLevel\":2,\"cName\":\"\\u7F8A\",\"consum\":4,\"cub\":27000,\"cycle\":43200,\"expect\":0,\"growing\":\"27000,27000,172800,180\",\"growthCycle\":0,\"harvestbExp\":16,\"harvestpExp\":38,\"maturingTime\":54000,\"output\":24,\"price\":2000,\"procreation\":172800,\"productime\":180,\"productprice\":2860},{\"byproductprice\":19,\"cId\":1003,\"cLevel\":3,\"cName\":\"\\u9E45\",\"consum\":3,\"cub\":16200,\"cycle\":25200,\"expect\":0,\"growing\":\"16200,16200,151200,180\",\"growthCycle\":0,\"harvestbExp\":11,\"harvestpExp\":36,\"maturingTime\":32400,\"output\":20,\"price\":900,\"procreation\":151200,\"productime\":180,\"productprice\":1060},{\"byproductprice\":55,\"cId\":1502,\"cLevel\":4,\"cName\":\"\\u725B\",\"consum\":5,\"cub\":32400,\"cycle\":43200,\"expect\":0,\"growing\":\"32400,32400,216000,180\",\"growthCycle\":0,\"harvestbExp\":17,\"harvestpExp\":40,\"maturingTime\":64800,\"output\":12,\"price\":3000,\"procreation\":216000,\"productime\":180,\"productprice\":4260},{\"byproductprice\":56,\"cId\":1004,\"cLevel\":5,\"cName\":\"\\u732B\",\"consum\":2,\"cub\":34200,\"cycle\":32400,\"expect\":0,\"growing\":\"34200,34200,216000,180\",\"growthCycle\":0,\"harvestbExp\":14,\"harvestpExp\":37,\"maturingTime\":68400,\"output\":12,\"price\":3200,\"procreation\":216000,\"productime\":180,\"productprice\":4060},{\"byproductprice\":58,\"cId\":1503,\"cLevel\":6,\"cName\":\"\\u7334\\u5B50\",\"consum\":4,\"cub\":36000,\"cycle\":36000,\"expect\":0,\"growing\":\"36000,36000,216000,180\",\"growthCycle\":0,\"harvestbExp\":14,\"harvestpExp\":38,\"maturingTime\":72000,\"output\":12,\"price\":4000,\"procreation\":216000,\"productime\":180,\"productprice\":5260},{\"byproductprice\":35,\"cId\":1005,\"cLevel\":7,\"cName\":\"\\u5B54\\u96C0\",\"consum\":3,\"cub\":37800,\"cycle\":43200,\"expect\":0,\"growing\":\"37800,37800,237600,180\",\"growthCycle\":0,\"harvestbExp\":16,\"harvestpExp\":39,\"maturingTime\":75600,\"output\":24,\"price\":5000,\"procreation\":237600,\"productime\":180,\"productprice\":6060},{\"byproductprice\":64,\"cId\":1504,\"cLevel\":8,\"cName\":\"\\u888B\\u9F20\",\"consum\":5,\"cub\":39600,\"cycle\":43200,\"expect\":0,\"growing\":\"39600,39600,237600,180\",\"growthCycle\":0,\"harvestbExp\":16,\"harvestpExp\":40,\"maturingTime\":79200,\"output\":12,\"price\":8000,\"procreation\":237600,\"productime\":180,\"productprice\":9860},{\"byproductprice\":68,\"cId\":1006,\"cLevel\":9,\"cName\":\"\\u4F01\\u9E45\",\"consum\":3,\"cub\":41400,\"cycle\":54000,\"expect\":0,\"growing\":\"41400,41400,259200,180\",\"growthCycle\":0,\"harvestbExp\":22,\"harvestpExp\":44,\"maturingTime\":82800,\"output\":16,\"price\":10000,\"procreation\":259200,\"productime\":180,\"productprice\":11860}]";
}
if ( $_REQUEST['mod'] == "cgi_get_food" )
{
				echo "[{\"FBPrice\":0,\"depict\":\"\\u52A8\\u7269\\u6328\\u997F\\u4F1A\\u505C\\u6B62\\u751F\\u957F\\u6216\\u751F\\u4EA7\\u3002\\u7267\\u8349\\u53EF\\u4EE5\\u5728\\u519C\\u573A\\u79CD\\u690D\\uFF0C\\u5546\\u5E97\\u8D2D\\u4E70\\u7267\\u8349\\u7684\\u529F\\u80FD\\u6682\\u65F6\\u4E0D\\u5F00\\u653E\\u3002\",\"effect\":0,\"price\":60,\"tId\":1,\"tName\":\"\\u7267\\u8349\",\"timeLimit\":0,\"type\":25}]";
}
if ( $_REQUEST['mmod'] == "friend" && $_REQUEST['mod'] == "common" )
{
				if ( $_REQUEST['false'] == "refresh" )
				{
								echo "{\"code\":0}";
								exit( );
				}
				if ( !empty( $space[friend] ) )
				{
								$space[friend] = $space[friend].",";
				}
				$query = $_SGLOBAL['db']->query( "SELECT uid,exp,money FROM ".tname( "plug_newfarm" )." WHERE uid IN (".$space[friend].$_SGLOBAL['supe_uid'].")" );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[$value['uid']] = $value;
				}
				$friendid = "";
				foreach ( $list as $value )
				{
								$friendid .= $value[uid];
								$friendid .= ",";
				}
				$friendid = substr( $friendid, 0, -1 );
				$query = $_SGLOBAL['db']->query( "SELECT uid,username,name FROM ".tname( "space" )." WHERE uid IN (".$friendid.")" );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[$value['uid']] = array_merge( $list[$value['uid']], $value );
				}
				$jishu = 0;
				foreach ( $list as $key => $value )
				{
								++$jishu;
								if ( 300 < $jishu )
								{
												break;
								}
								if ( empty( $value[name] ) )
								{
												$value[name] = $value[username];
								}
								$friend_str[] = "{\"userId\":".$value[uid].",\"userName\":\"".unicode_encodegb( $value[name] )."\",\"headPic\":\"".avatar( $value[uid], "small", TRUE )."\",\"exp\":".$value[exp].",\"money\":".$value[money].",\"pf\":1,\"yellowlevel\":0,\"yellowstatus\":0}";
				}
				$friend_str = json_encode( $friend_str );
				$friend_str = str_replace( "\"{", "{", $friend_str );
				$friend_str = str_replace( "}\"", "}", $friend_str );
				$friend_str = str_replace( "\\/", "\\\\/", $friend_str );
				$friend_str = str_replace( ",null,", ",", $friend_str );
				echo stripslashes( $friend_str );
				exit( );
}
if ( $_REQUEST['mod'] == "cgi_get_Exp" )
{
				if ( !empty( $space[friend] ) )
				{
								$space[friend] = $space[friend].",";
				}
				$query = $_SGLOBAL['db']->query( "SELECT uid,mc_exp FROM ".tname( "plug_newfarm" )." WHERE uid IN (".$space[friend].$_SGLOBAL['supe_uid'].")" );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[$value['uid']] = $value[mc_exp];
				}
				$list = json_encode( $list );
				echo "{\"msg\":\"success\",\"result\":0,\"serverTime\":".$_SGLOBAL['timestamp'].",\"userExp\":".$list."}";
				exit( );
}
if ( $_REQUEST['mod'] == "cgi_buy_animal" )
{
				$query = $_SGLOBAL['db']->query( "SELECT money,animal FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$animal = ( array )json_decode( $list[0][animal] );
				if ( $list[0][money] < $shop[$_REQUEST['cId']][price] * $_REQUEST['number'] )
				{
								exit( );
				}
				$number = 0;
				foreach ( $animal[animal] as $key => $value )
				{
								if ( !( $value->cId == 0 ) && !( $number < $_REQUEST['number'] ) )
								{
												$value->buyTime = $_SGLOBAL['timestamp'];
												$value->cId = $_REQUEST['cId'];
												$value->tou = "";
												++$number;
												$buyanimal[] = ( ( "{\"buyTime\":".$_SGLOBAL['timestamp'].",\"cId\":".$_REQUEST['cId'].",\"createTime\":0,\"feedTime\":".( $_SGLOBAL['timestamp'] - 14400 ) ).",\"growTime\":0,\"growTimeNext\":".( $animaltime[$_REQUEST['cId']][0] - 1 ) ).",\"postTime\":0,\"productNum\":0,\"serial\":".$key.",\"status\":1,\"statusNext\":2,\"totalCome\":0}";
								}
				}
				$animal = json_encode( $animal );
				$animal = str_replace( "\"{", "{", $animal );
				$animal = str_replace( "}\"", "}", $animal );
				$_SGLOBAL['db']->query( ( "UPDATE ".tname( "plug_newfarm" )." set animal='".$animal."',money=money-".$shop[$_REQUEST['cId']][price] * $_REQUEST['number'].",mc_exp=mc_exp+".$_REQUEST['number'] * 5 )." where uid=".$_SGLOBAL['supe_uid'] );
				$buyanimal = json_encode( $buyanimal );
				$buyanimal = str_replace( "\"{", "{", $buyanimal );
				$buyanimal = str_replace( "}\"", "}", $buyanimal );
				echo stripslashes( ( "{\"addExp\":".$_REQUEST['number'] * 5 ).",\"animal\":".$buyanimal.",\"code\":0,\"money\":".$shop[$_REQUEST['cId']][price] * $_REQUEST['number'].",\"msg\":\"success\",\"num\":".$_REQUEST['number'].",\"uin\":\"\"}" );
				exit( );
}
if ( $_REQUEST['mod'] == "cgi_post_product" )
{
				$needlog = 1;
				if ( $_REQUEST['uId'] == NULL )
				{
								$GLOBALS['_REQUEST']['uId'] = $_SGLOBAL['supe_uid'];
								$needlog = 0;
				}
				$GLOBALS['_REQUEST']['serial'] = intval( $_REQUEST['serial'] );
				$query = $_SGLOBAL['db']->query( "SELECT animal,mc_log FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['uId'] ) );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$animal = json_decode( $list[0][animal] );
				if ( $animal->animalfood == 0 )
				{
								echo "{\"errorContent\":\"\\u52A8\\u7269\\u6328\\u997F\\u5566\\uFF0C\\u7F3A\\u5C11\\u7267\\u8349\\u4F1A\\u505C\\u6B62\\u751F\\u4EA7\\uFF0C\\u5FEB\\u53BB\\u6DFB\\u52A0\",\"errorType\":\"1011\"}";
								exit( );
				}
				if ( $_SGLOBAL['timestamp'] - $animal->animal[$_REQUEST['serial']]->postTime < $shop[$animal->animal[$_REQUEST['serial']]->cid][cycle] )
				{
								exit( );
				}
				$animal->animal[$_REQUEST['serial']]->postTime = $_SGLOBAL['timestamp'];
				$animal->animal[$_REQUEST['serial']]->tou = "";
				$animal->animal[$_REQUEST['serial']]->totalCome = $animal->animal[$_REQUEST['serial']]->totalCome + $shop[$animal->animal[$_REQUEST['serial']]->cId][output];
				$stranimal = json_encode( $animal );
				if ( $needlog == 1 )
				{
								$mc_log = unserialize( $list[0][mc_log] );
								$logyes = 0;
								foreach ( $mc_log[help] as $key => $value )
								{
												if ( !( $_SGLOBAL['timestamp'] < $key + 1800 ) && !( $value[uid] == $_SGLOBAL['supe_uid'] ) )
												{
																continue;
												}
												++$mc_log[help][$key][$animal->animal[$_REQUEST['serial']]->cId];
												$logyes = 1;
												break;
								}
								if ( $logyes == 0 )
								{
												if ( empty( $space[name] ) )
												{
																$space[name] = $space[username];
												}
												$mc_log[help][$_SGLOBAL['timestamp']] = array(
																"uid" => $_SGLOBAL['supe_uid'],
																"name" => unicode_encodegb( $space[name] ),
																"1001" => 0,
																"1002" => 0,
																"1003" => 0,
																"1004" => 0,
																"1005" => 0,
																"1006" => 0,
																"1501" => 0,
																"1502" => 0,
																"1503" => 0,
																"1504" => 0,
																"40" => 0
												);
												++$mc_log[help][$_SGLOBAL['timestamp']][$animal->animal[$_REQUEST['serial']]->cId];
								}
								foreach ( $mc_log[help] as $key => $value )
								{
												if ( $key < $_SGLOBAL['timestamp'] - 172800 )
												{
																unset( $_SGLOBAL['timestamp'][$key] );
												}
								}
								krsort( &$mc_log[help] );
								$mc_log = serialize( $mc_log );
								$mc_log = str_replace( "\\u", "\\\\u", $mc_log );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set animal='".$stranimal."',mc_log='".$mc_log."' where uid=".intval( $_REQUEST['uId'] ) );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+5 where uid=".$_SGLOBAL['supe_uid'] );
				}
				else
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set animal='".$stranimal."' where uid=".intval( $_REQUEST['uId'] ) );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+5 where uid=".$_SGLOBAL['supe_uid'] );
				}
				echo "{\"addExp\":5,\"animal\":{\"buyTime\":".$animal->animal[$_REQUEST['serial']]->buyTime.",\"cId\":".$animal->animal[$_REQUEST['serial']]->cId.",\"createTime\":0,\"feedTime\":".( $_SGLOBAL['timestamp'] - $animaltime[$animal->animal[$_REQUEST['serial']]->cId][0] ).",\"growTime\":".( $_SGLOBAL['timestamp'] - $animal->animal[$_REQUEST['serial']]->buyTime ).",\"growTimeNext\":".$animaltime[$animal->animal[$_REQUEST['serial']]->cId][3].",\"postTime\":".$_SGLOBAL['timestamp'].",\"productNum\":2,\"serial\":".$_REQUEST['serial'].",\"status\":4,\"statusNext\":5,\"totalCome\":".$shop[$animal->animal[$_REQUEST['serial']]->cId][output]."}}";
				exit( );
}
if ( $_REQUEST['mod'] == "cgi_harvest_product" )
{
				if ( $_REQUEST['harvesttype'] == "1" )
				{
								$query = $_SGLOBAL['db']->query( "SELECT animal,mc_package FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
								while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
								{
												$list[] = $value;
								}
								$animal = ( array )json_decode( $list[0][animal] );
								$totalCome = 0;
								$exp = 0;
								foreach ( $animal[animal] as $key => $value )
								{
												if ( $value->cId == $_REQUEST['type'] )
												{
																$totalCome += $value->totalCome;
																$value->totalCome = 0;
																$value->tou = "";
																++$exp;
												}
								}
								if ( $totalCome == 0 )
								{
												exit( );
								}
								$animal = json_encode( $animal );
								$mc_package = json_decode( $list[0][mc_package] );
								$mc_package->$_REQUEST['type'] = $mc_package->$_REQUEST['type'] + $totalCome;
								$mc_package = json_encode( $mc_package );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set animal='".$animal."',mc_exp=mc_exp+".$exp * $animalname[$_REQUEST['type']][exp].",mc_package='".$mc_package."' where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":".$exp * $animalname[$_REQUEST['type']][exp].",\"cId\":".$_REQUEST['type'].",\"code\":0,\"harvestnum\":".$totalCome.",\"msg\":\"success\",\"serial\":-1}";
								exit( );
				}
				if ( $_REQUEST['harvesttype'] == "2" )
				{
								$query = $_SGLOBAL['db']->query( "SELECT animal,mc_package FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
								while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
								{
												$list[] = $value;
								}
								$animal = ( array )json_decode( $list[0][animal] );
								$cid = "1".$animal[animal][$_REQUEST['serial']]->cId;
								$cid1 = $animal[animal][$_REQUEST['serial']]->cId;
								$mc_package = json_decode( $list[0][mc_package] );
								$mc_package->$cid = $mc_package->$cid + 1;
								$mc_package = json_encode( $mc_package );
								$animal[animal][$_REQUEST['serial']]->buyTime = 0;
								$animal[animal][$_REQUEST['serial']]->cId = 0;
								$animal[animal][$_REQUEST['serial']]->postTime = 0;
								$animal[animal][$_REQUEST['serial']]->totalCome = 0;
								$animal[animal][$_REQUEST['serial']]->tou = "";
								$animal = json_encode( $animal );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set animal='".$animal."',mc_exp=mc_exp+".$animalname[$cid][exp].",mc_package='".$mc_package."' where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":".$animalname[$cid][exp].",\"cId\":".$cid1.",\"code\":0,\"harvestnum\":0,\"msg\":\"success\",\"serial\":".$_REQUEST['serial']."}";
								exit( );
				}
}
if ( $_REQUEST['mod'] == "cgi_steal_product" )
{
				$query = $_SGLOBAL['db']->query( "SELECT animal,mc_log FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['uId'] ) );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$animal = ( array )json_decode( $list[0][animal] );
				$tounum = 0;
				foreach ( $animal[animal] as $key => $value )
				{
								if ( $_REQUEST['type'] == $value->cId )
								{
												if ( !stristr( $value->tou, ",".$_SGLOBAL['supe_uid']."," ) )
												{
																if ( $shop[$_REQUEST['type']][output] / 2 < $value->totalCome )
																{
																				$value = "totalCome";
																				++$tounum;
																				$value->tou = $value->tou.",".$_SGLOBAL['supe_uid'].",";
																}
												}
								}
				}
				$mc_log = unserialize( $list[0][mc_log] );
				$logyes = 0;
				foreach ( $mc_log[scrounge] as $key => $value )
				{
								if ( !( $_SGLOBAL['timestamp'] < $key + 1800 ) && !( $value[uid] == $_SGLOBAL['supe_uid'] ) )
								{
												continue;
								}
								$mc_log[scrounge][$key][$_REQUEST['type']] = $mc_log[scrounge][$key][$_REQUEST['type']] + $tounum;
								$logyes = 1;
								break;
				}
				if ( $logyes == 0 )
				{
								if ( empty( $space[name] ) )
								{
												$space[name] = $space[username];
								}
								$mc_log[scrounge][$_SGLOBAL['timestamp']] = array(
												"uid" => $_SGLOBAL['supe_uid'],
												"name" => unicode_encodegb( $space[name] ),
												"1001" => 0,
												"1002" => 0,
												"1003" => 0,
												"1004" => 0,
												"1005" => 0,
												"1006" => 0,
												"1501" => 0,
												"1502" => 0,
												"1503" => 0,
												"1504" => 0
								);
								$mc_log[scrounge][$_SGLOBAL['timestamp']][$_REQUEST['type']] = $tounum;
				}
				foreach ( $mc_log[scrounge] as $key => $value )
				{
								if ( $key < $_SGLOBAL['timestamp'] - 172800 )
								{
												unset( $_SGLOBAL['timestamp'][$key] );
								}
				}
				krsort( &$mc_log[scrounge] );
				$mc_log = serialize( $mc_log );
				$mc_log = str_replace( "\\u", "\\\\u", $mc_log );
				$mc_package = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT mc_package FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$mc_package = json_decode( $mc_package );
				$mc_package->$_REQUEST['type'] = $mc_package->$_REQUEST['type'] + $tounum;
				$animal = json_encode( $animal );
				$mc_package = json_encode( $mc_package );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set animal='".$animal."',mc_log='".$mc_log."' where uid=".intval( $_REQUEST['uId'] ) );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_package='".$mc_package."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"cId\":".$_REQUEST['type'].",\"harvestnum\":".$tounum."}";
				exit( );
}
if ( $_REQUEST['mod'] == "cgi_get_repertory?target=animal" )
{
				$mc_package = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT mc_package FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$mc_package = json_decode( $mc_package );
				foreach ( $mc_package as $key => $value )
				{
								if ( 0 < $value )
								{
												$package[] = "{\"amount\":".$value.",\"cId\":".$key.",\"cName\":\"".$animalname[$key][name]."\",\"price\":".$animalname[$key][price]."}";
								}
				}
				$package = json_encode( $package );
				$package = str_replace( "\\u", "\\\\u", $package );
				$package = str_replace( "\"{", "{", $package );
				$package = str_replace( "}\"", "}", $package );
				$package = str_replace( "null", "[]", $package );
				echo stripslashes( $package );
}
if ( $_REQUEST['mod'] == "cgi_sale_product" )
{
				if ( $_REQUEST['saleAll'] == "1" )
				{
								$mc_package = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT mc_package FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
								$mc_package = json_decode( $mc_package );
								$money = 0;
								foreach ( $mc_package as $key => $value )
								{
												if ( 0 < $value )
												{
																$money += $animalname[$key][price] * $value;
																$mc_package->$key = 0;
												}
								}
								$mc_package = json_encode( $mc_package );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_package='".$mc_package."',money=money+".$money." where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"direction\":\"\\u64CD\\u4F5C\\u6210\\u529F\\uFF0C\\u5171\\u83B7\\u5F97\\u6536\\u5165\\u548C\\u611F\\u8C22\\u91D1<font color=\\\"#FF6600\\\"> <b>".$money."</b> </font>\\u91D1\\u5E01\",\"money\":".$money."}";
				}
				else
				{
								$mc_package = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT mc_package FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
								$mc_package = json_decode( $mc_package );
								if ( $mc_package->$_REQUEST['cId'] < $_REQUEST['num'] )
								{
												exit( );
								}
								$mc_package->$_REQUEST['cId'] = $mc_package->$_REQUEST['cId'] - $_REQUEST['num'];
								$mc_package = json_encode( $mc_package );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_package='".$mc_package."',money=money+".$animalname[$_REQUEST['cId']][price] * $_REQUEST['num']." where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"cId\":".$_REQUEST['cId'].",\"direction\":\"\\u6210\\u529F\\u5356\\u51FA<font color=\\\"#0099FF\\\"> <b>".$_REQUEST['num']."</b> </font>\\u4E2A".$animalname[$_REQUEST['cId']][name]."，\\u8D5A\\u5230\\u91D1\\u5E01<font color=\\\"#FF6600\\\"> <b>".$animalname[$_REQUEST['cId']][price] * $_REQUEST['num']."</b> </font>\",\"money\":".$animalname[$_REQUEST['cId']][price] * $_REQUEST['num']."}";
				}
}
if ( $_REQUEST['mod'] == "cgi_get_repertory?target=package" )
{
				$fruit = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT fruit FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$fruit = json_decode( $fruit );
				$id = 40;
				echo "[{\"amount\":".$fruit->$id.",\"tId\":40,\"tName\":\"\\u7267\\u8349\",\"type\":4}]";
}
if ( $_REQUEST['mod'] == "cgi_feed_food" )
{
				if ( $_REQUEST['type'] == "1" )
				{
								echo "{\"errorContent\":\"\\u8D2D\\u4E70\\u7267\\u8349\\u7684\\u529F\\u80FD\\u6682\\u65F6\\u4E0D\\u5F00\\u653E\\uFF0C\\u8BF7\\u53BB\\u519C\\u573A\\u79CD\\u690D\\u7267\\u8349\\uFF01\",\"errorType\":\"1011\"}";
								exit( );
				}
				if ( $_REQUEST['uId'] == NULL )
				{
								$GLOBALS['_REQUEST']['uId'] = $_SGLOBAL['supe_uid'];
				}
				$fruit = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT fruit FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$fruit = json_decode( $fruit );
				$mucaoid = 40;
				if ( $fruit->$mucaoid < $_REQUEST['foodnum'] )
				{
								exit( );
				}
				$fruit->$mucaoid = $fruit->$mucaoid - $_REQUEST['foodnum'];
				$query = $_SGLOBAL['db']->query( "SELECT animal,mc_log FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['uId'] ) );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$animal = ( array )json_decode( $list[0][animal] );
				if ( 200 < $animal[animalfood] + $_REQUEST['foodnum'] )
				{
								$GLOBALS['_REQUEST']['foodnum'] = floor( 200 - $animal[animalfood] );
				}
				$animal[animalfood] = $animal[animalfood] + $_REQUEST['foodnum'];
				$needfood = 0;
				foreach ( $animal[animal] as $key => $value )
				{
								if ( 0 < $value->cId )
								{
												$needfood += $shop[$value->cId][consum];
												if ( $value->postTime == 0 )
												{
																$time = $_SGLOBAL['timestamp'] - $value->buyTime;
																if ( $animaltime[$value->cId][0] + $animaltime[$value->cId][1] <= $time )
																{
																				$status = 3;
																				$growTimeNext = 12993;
																				$statusNext = 6;
																}
																if ( $animaltime[$value->cId][0] <= $time && $time < $animaltime[$value->cId][0] + $animaltime[$value->cId][1] )
																{
																				$status = 2;
																				$growTimeNext = $animaltime[$value->cId][0] + $animaltime[$value->cId][1] - $time;
																				$statusNext = 3;
																}
																if ( $time < $animaltime[$value->cId][0] )
																{
																				$status = 1;
																				$growTimeNext = $animaltime[$value->cId][0] - $time;
																				$statusNext = 2;
																}
																if ( $animaltime[$value->cId][5] < $time )
																{
																				$status = 6;
																				$growTimeNext = 0;
																				$statusNext = 6;
																}
																$newanimal[] = "{\"buyTime\":".$value->buyTime.",\"cId\":".$value->cId.",\"growTime\":".$time.",\"growTimeNext\":".$growTimeNext.",\"hungry\":0,\"serial\":".$key.",\"status\":".$status.",\"statusNext\":".$statusNext.",\"totalCome\":".$value->totalCome."}";
												}
												else
												{
																$totalCome = $value->totalCome;
																$time = $_SGLOBAL['timestamp'] - $value->buyTime;
																if ( $animaltime[$value->cId][5] < $time )
																{
																				$status = 6;
																				$statusNext = 6;
																				$growTimeNext = 0;
																}
																if ( $animaltime[$value->cId][4] < $_SGLOBAL['timestamp'] - $value->postTime )
																{
																				$status = 3;
																				$statusNext = 6;
																				$growTimeNext = 12993;
																}
																if ( $_SGLOBAL['timestamp'] - $value->postTime <= $animaltime[$value->cId][4] )
																{
																				$status = 5;
																				$statusNext = 3;
																				$growTimeNext = $animaltime[$value->cId][4] - ( $_SGLOBAL['timestamp'] - $value->postTime );
																}
																if ( $_SGLOBAL['timestamp'] - $value->postTime <= $animaltime[$value->cId][3] )
																{
																				$status = 4;
																				$statusNext = 5;
																				$growTimeNext = $animaltime[$value->cId][3] - ( $_SGLOBAL['timestamp'] - $value->postTime );
																				$totalCome -= $shop[$value->cId][output];
																}
																if ( $value->buyTime + $animaltime[$value->cId][5] - $animaltime[$value->cId][3] - $animaltime[$value->cId][4] < $_SGLOBAL['timestamp'] )
																{
																				$status = 5;
																				$statusNext = 6;
																				$growTimeNext = $animaltime[$value->cId][5] - $time;
																}
																$newanimal[] = "{\"buyTime\":".$value->buyTime.",\"cId\":".$value->cId.",\"growTime\":".$time.",\"growTimeNext\":".$growTimeNext.",\"hungry\":0,\"serial\":".$key.",\"status\":".$status.",\"statusNext\":".$statusNext.",\"totalCome\":".$totalCome."}";
												}
								}
				}
				$newanimal = json_encode( $newanimal );
				$newanimal = str_replace( "\"{", "{", $newanimal );
				$newanimal = str_replace( "}\"", "}", $newanimal );
				$newanimal = str_replace( "null", "[]", $newanimal );
				$animal[animalfood] = $animal[animalfood] - ( $_SGLOBAL['timestamp'] - $animal[animalfeedtime] ) / 3600 * $needfood / 4;
				if ( $animal[animalfood] < 0 )
				{
								$animal[animalfood] = 0;
				}
				$animal[animalfeedtime] = $_SGLOBAL['timestamp'];
				$stranimal = json_encode( $animal );
				$mc_log = unserialize( $list[0][mc_log] );
				$logyes = 0;
				foreach ( $mc_log[help] as $key => $value )
				{
								if ( !( $_SGLOBAL['timestamp'] < $key + 1800 ) && !( $value[uid] == $_SGLOBAL['supe_uid'] ) )
								{
												continue;
								}
								$mc_log[help][$key]['40'] = $mc_log[help][$key]['40'] + $_REQUEST['foodnum'];
								$logyes = 1;
								break;
				}
				if ( $logyes == 0 )
				{
								if ( empty( $space[name] ) )
								{
												$space[name] = $space[username];
								}
								$mc_log[help][$_SGLOBAL['timestamp']] = array(
												"uid" => $_SGLOBAL['supe_uid'],
												"name" => unicode_encodegb( $space[name] ),
												"1001" => 0,
												"1002" => 0,
												"1003" => 0,
												"1004" => 0,
												"1005" => 0,
												"1006" => 0,
												"1501" => 0,
												"1502" => 0,
												"1503" => 0,
												"1504" => 0,
												"40" => $_REQUEST['foodnum']
								);
				}
				foreach ( $mc_log[help] as $key => $value )
				{
								if ( $key < $_SGLOBAL['timestamp'] - 172800 )
								{
												unset( $_SGLOBAL['timestamp'][$key] );
								}
				}
				krsort( &$mc_log[help] );
				$mc_log = serialize( $mc_log );
				$mc_log = str_replace( "\\u", "\\\\u", $mc_log );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set animal='".$stranimal."',mc_log='".$mc_log."' where uid=".intval( $_REQUEST['uId'] ) );
				$fruit = json_encode( $fruit );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set fruit='".$fruit."' where uid=".$_SGLOBAL['supe_uid'] );
				echo stripslashes( "{\"added\":".$_REQUEST['foodnum'].",\"animal\":".$newanimal.",\"direction\":\"\\\\u6210\\\\u529F\\\\u6DFB\\\\u52A0".$_REQUEST['foodnum']."\\\\u68F5\\\\u7267\\\\u8349\",\"money\":0,\"total\":".$animal[animalfood].",\"uId\":".intval( $_REQUEST['uId'] )."}" );
				exit( );
}
if ( $_REQUEST['mod'] == "cgi_up_animalhouse" )
{
				if ( $_REQUEST['act'] == "query" )
				{
								if ( $_REQUEST['type'] == "1" )
								{
												switch ( $_REQUEST['level'] )
												{
												case 0 :
																echo "{\"level\":0,\"money\":0}";
																break;
												case 1 :
																echo "{\"level\":5,\"money\":100000}";
																break;
												case 2 :
																echo "{\"level\":11,\"money\":500000}";
																break;
												case 3 :
																echo "{\"level\":19,\"money\":1000000}";
												}
								}
								else
								{
												switch ( $_REQUEST['level'] )
												{
												case 0 :
																echo "{\"level\":2,\"money\":20000}";
																break;
												case 1 :
																echo "{\"level\":8,\"money\":300000}";
																break;
												case 2 :
																echo "{\"level\":14,\"money\":1000000}";
																break;
												case 3 :
																echo "{\"level\":21,\"money\":2000000}";
												}
								}
				}
				else
				{
								$query = $_SGLOBAL['db']->query( "SELECT money,animal FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
								while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
								{
												$list[] = $value;
								}
								$animal = ( array )json_decode( $list[0][animal] );
								if ( $_REQUEST['type'] == "1" )
								{
												$item = "item2";
								}
								else
								{
												$item = "item3";
								}
								$animal[$item] = $animal[$item] + 1;
								$itemarr = array( "10221" => 1, "10222" => 100000, "10223" => 500000, "10224" => 1000000, "10331" => 20000, "10332" => 300000, "10333" => 1000000, "10334" => 2000000 );
								if ( $list[0][money] < $itemarr[$animal[$item]] )
								{
												exit( );
								}
								$list[0][money] = $list[0][money] - $itemarr[$animal[$item]];
								$money = $itemarr[$animal[$item]];
								$srtanimal = json_encode( $animal );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set animal='".$srtanimal."',money=".$list[0][money]." where uid=".$_SGLOBAL['supe_uid'] );
								if ( $animal[item2] == 10220 )
								{
												$animal[item2] = "";
								}
								else
								{
												$animal[item2] = "\"2\":{\"itemId\":".$animal[item2]."},";
								}
								if ( $animal[item3] == 10330 )
								{
												$animal[item3] = "";
								}
								else
								{
												$animal[item3] = "\"3\":{\"itemId\":".$animal[item3]."},";
								}
								echo "{\"code\":1,\"money\":-".$money.",\"items\":{\"1\":{\"itemId\":".$animal[item1]."},".$animal[item2].$animal[item3]."\"4\":{\"itemId\":".$animal[item4]."}}}";
				}
}
if ( $_REQUEST['mod'] == "cgi_up_task" )
{
				$mc_taskid = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT mc_taskid FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				if ( $_REQUEST['act'] == "1" )
				{
								echo "{\"taskFlag\":1,\"taskId\":".$mc_taskid."}";
								exit( );
				}
				if ( $mc_taskid == 0 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+50,money=money+50,mc_taskid=1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":50,\"item\":[{\"num\":50,\"type\":7},{\"num\":50,\"type\":6}],\"money\":50,\"task\":{\"taskDesc\":\"\\u606D\\u559C\\u60A8\\u5B8C\\u6210\\u4EFB\\u52A1\\uFF0C\\u83B7\\u5F9750\\u4E2A\\u7ECF\\u9A8C\\u548C50\\u4E2A\\u91D1\\u5E01。\",\"taskFlag\":1,\"taskId\":1}}";
				}
				if ( $mc_taskid == 1 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+100,money=money+100,mc_taskid=2 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":100,\"item\":[{\"num\":100,\"type\":7},{\"num\":100,\"type\":6}],\"money\":100,\"task\":{\"taskDesc\":\"\\u606D\\u559C\\u60A8\\u5B8C\\u6210\\u4EFB\\u52A1\\uFF0C\\u83B7\\u5F97100\\u4E2A\\u7ECF\\u9A8C\\u548C100\\u4E2A\\u91D1\\u5E01。\",\"taskFlag\":1,\"taskId\":2}}";
				}
				if ( $mc_taskid == 2 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+100,money=money+150,mc_taskid=3 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":100,\"item\":[{\"num\":100,\"type\":7},{\"num\":150,\"type\":6}],\"money\":150,\"task\":{\"taskDesc\":\"\\u606D\\u559C\\u60A8\\u5B8C\\u6210\\u4EFB\\u52A1\\uFF0C\\u83B7\\u5F97100\\u4E2A\\u7ECF\\u9A8C\\u548C150\\u4E2A\\u91D1\\u5E01。\",\"taskFlag\":1,\"taskId\":3}}";
				}
				if ( $mc_taskid == 3 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+100,money=money+200,mc_taskid=4 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":100,\"item\":[{\"num\":100,\"type\":7},{\"num\":200,\"type\":6}],\"money\":200,\"task\":{\"taskDesc\":\"\\u606D\\u559C\\u60A8\\u5B8C\\u6210\\u4EFB\\u52A1\\uFF0C\\u83B7\\u5F97100\\u4E2A\\u7ECF\\u9A8C\\u548C200\\u4E2A\\u91D1\\u5E01。\",\"taskFlag\":1,\"taskId\":4}}";
				}
				if ( $mc_taskid == 4 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+100,money=money+250,mc_taskid=5 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":100,\"item\":[{\"num\":100,\"type\":7},{\"num\":250,\"type\":6}],\"money\":250,\"task\":{\"taskDesc\":\"\\u606D\\u559C\\u60A8\\u5B8C\\u6210\\u4EFB\\u52A1\\uFF0C\\u83B7\\u5F97100\\u4E2A\\u7ECF\\u9A8C\\u548C250\\u4E2A\\u91D1\\u5E01。\",\"taskFlag\":1,\"taskId\":5}}";
				}
				if ( $mc_taskid == 5 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+100,money=money+300,mc_taskid=6 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":100,\"item\":[{\"num\":100,\"type\":7},{\"num\":300,\"type\":6}],\"money\":300,\"task\":{\"taskDesc\":\"\\u606D\\u559C\\u60A8\\u5B8C\\u6210\\u4EFB\\u52A1\\uFF0C\\u83B7\\u5F97100\\u4E2A\\u7ECF\\u9A8C\\u548C300\\u4E2A\\u91D1\\u5E01。\",\"taskFlag\":1,\"taskId\":6}}";
				}
				if ( $mc_taskid == 6 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+100,money=money+350,mc_taskid=7 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":100,\"item\":[{\"num\":100,\"type\":7},{\"num\":350,\"type\":6}],\"money\":350,\"task\":{\"taskDesc\":\"\\u606D\\u559C\\u60A8\\u5B8C\\u6210\\u4EFB\\u52A1\\uFF0C\\u83B7\\u5F97100\\u4E2A\\u7ECF\\u9A8C\\u548C350\\u4E2A\\u91D1\\u5E01。\",\"taskFlag\":1,\"taskId\":7}}";
				}
				if ( $mc_taskid == 7 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+100,money=money+400,mc_taskid=8 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":100,\"item\":[{\"num\":100,\"type\":7},{\"num\":400,\"type\":6}],\"money\":400,\"task\":{\"taskDesc\":\"\\u606D\\u559C\\u60A8\\u5B8C\\u6210\\u4EFB\\u52A1\\uFF0C\\u83B7\\u5F97100\\u4E2A\\u7ECF\\u9A8C\\u548C400\\u4E2A\\u91D1\\u5E01。\",\"taskFlag\":1,\"taskId\":8}}";
				}
				if ( $mc_taskid == 8 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+100,money=money+450,mc_taskid=9 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":100,\"item\":[{\"num\":100,\"type\":7},{\"num\":450,\"type\":6}],\"money\":450,\"task\":{\"taskDesc\":\"\\u606D\\u559C\\u60A8\\u5B8C\\u6210\\u4EFB\\u52A1\\uFF0C\\u83B7\\u5F97100\\u4E2A\\u7ECF\\u9A8C\\u548C450\\u4E2A\\u91D1\\u5E01。\",\"taskFlag\":1,\"taskId\":9}}";
				}
				if ( $mc_taskid == 9 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set mc_exp=mc_exp+100,money=money+500,mc_taskid=10 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"addExp\":100,\"item\":[{\"num\":100,\"type\":7},{\"num\":500,\"type\":6}],\"money\":500,\"task\":{\"taskDesc\":\"\\u606D\\u559C\\u60A8\\u5B8C\\u6210\\u4EFB\\u52A1\\uFF0C\\u83B7\\u5F97100\\u4E2A\\u7ECF\\u9A8C\\u548C500\\u4E2A\\u91D1\\u5E01。\",\"taskFlag\":1,\"taskId\":10}}";
				}
}
if ( $_REQUEST['mod'] == "cgi_get_user_info" )
{
				$query = $_SGLOBAL['db']->query( "SELECT money,mc_exp,mc_log FROM ".tname( "plug_newfarm" )." where uid=".$_REQUEST['uId'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$mc_log = unserialize( $list[0][mc_log] );
				$logarr = array( );
				foreach ( $mc_log[scrounge] as $key => $value )
				{
								$logarr[$key] = "{\"domain\":2,\"msg\":\"<font color=\\\"#009900\\\"><b>".$value[name]."</b></font> \\u6765\\u7267\\u573A\\u5077\\u8D70\\u4E86";
								if ( 0 < $value['1001'] )
								{
												$logarr[$key] .= $value['1001']."\\u4E2A\\u9E21\\u86CB";
								}
								if ( 0 < $value['1002'] )
								{
												$logarr[$key] .= $value['1002']."\\u53EA\\u5154\\u4ED4";
								}
								if ( 0 < $value['1003'] )
								{
												$logarr[$key] .= $value['1003']."\\u4E2A\\u9E45\\u86CB";
								}
								if ( 0 < $value['1004'] )
								{
												$logarr[$key] .= $value['1004']."\\u53EA\\u5C0F\\u732B\\u4ED4";
								}
								if ( 0 < $value['1005'] )
								{
												$logarr[$key] .= $value['1005']."\\u4E2A\\u5B54\\u96C0\\u86CB";
								}
								if ( 0 < $value['1006'] )
								{
												$logarr[$key] .= $value['1006']."\\u53EA\\u5C0F\\u4F01\\u9E45";
								}
								if ( 0 < $value['1501'] )
								{
												$logarr[$key] .= $value['1501']."\\u5377\\u7F8A\\u6BDB";
								}
								if ( 0 < $value['1502'] )
								{
												$logarr[$key] .= $value['1502']."\\u74F6\\u725B\\u5976";
								}
								if ( 0 < $value['1503'] )
								{
												$logarr[$key] .= $value['1503']."\\u53EA\\u5C0F\\u7334\\u4ED4";
								}
								if ( 0 < $value['1504'] )
								{
												$logarr[$key] .= $value['1504']."\\u53EA\\u5C0F\\u888B\\u9F20";
								}
								$logarr[$key] .= "\\u3002\",\"time\":".$key."}";
				}
				foreach ( $mc_log[help] as $key => $value )
				{
								$logarr[$key] = "{\"domain\":2,\"msg\":\"<font color=\\\"#009900\\\"><b>".$value[name]."</b></font> \\u5E2E\\u5FD9\\u628A";
								if ( 0 < $value['1001'] )
								{
												$logarr[$key] .= $value['1001']."\\u53EA\\u9E21\\u8D76\\u53BB\\u751F\\u4EA7";
								}
								if ( 0 < $value['1002'] )
								{
												$logarr[$key] .= $value['1002']."\\u53EA\\u5154\\u8D76\\u53BB\\u751F\\u4EA7";
								}
								if ( 0 < $value['1003'] )
								{
												$logarr[$key] .= $value['1003']."\\u53EA\\u9E45\\u8D76\\u53BB\\u751F\\u4EA7";
								}
								if ( 0 < $value['1004'] )
								{
												$logarr[$key] .= $value['1004']."\\u53EA\\u732B\\u4ED4\\u8D76\\u53BB\\u751F\\u4EA7";
								}
								if ( 0 < $value['1005'] )
								{
												$logarr[$key] .= $value['1005']."\\u53EA\\u5B54\\u96C0\\u8D76\\u53BB\\u751F\\u4EA7";
								}
								if ( 0 < $value['1006'] )
								{
												$logarr[$key] .= $value['1006']."\\u53EA\\u4F01\\u9E45\\u8D76\\u53BB\\u751F\\u4EA7";
								}
								if ( 0 < $value['1501'] )
								{
												$logarr[$key] .= $value['1501']."\\u53EA\\u7F8A\\u8D76\\u53BB\\u751F\\u4EA7";
								}
								if ( 0 < $value['1502'] )
								{
												$logarr[$key] .= $value['1502']."\\u53EA\\u725B\\u8D76\\u53BB\\u751F\\u4EA7";
								}
								if ( 0 < $value['1503'] )
								{
												$logarr[$key] .= $value['1503']."\\u53EA\\u7334\\u4ED4\\u8D76\\u53BB\\u751F\\u4EA7";
								}
								if ( 0 < $value['1504'] )
								{
												$logarr[$key] .= $value['1504']."\\u53EA\\u888B\\u9F20\\u8D76\\u53BB\\u751F\\u4EA7";
								}
								$logarr[$key] .= "\\u3002\",\"time\":".$key."}";
				}
				krsort( &$logarr );
				$log = "[";
				foreach ( $logarr as $key => $value )
				{
								$log .= ",".$value;
				}
				$log = str_replace( "[,{", "[{", $log );
				$uidspace = getspace( $_REQUEST['uId'] );
				if ( empty( $uidspace[name] ) )
				{
								$uidspace[name] = $uidspace[username];
				}
				echo "{\"log\":".$log."],\"repertory\":[],\"user\":{\"homePage\":\"".str_ireplace( "newfarm/", "space.php?uid=", $_SC['siteurl'] ).$_REQUEST['uId']."\",\"money\":".$list[0][money].",\"uExp\":".$list[0][mc_exp].",\"uId\":".$_REQUEST['uId'].",\"uLevel\":".floor( sqrt( $list[0][mc_exp] / 100 + 0.25 ) - 0.5 ).",\"uName\":\"".unicode_encodegb( $uidspace[name] )."\"}}";
}
if ( $_REQUEST['mmod'] == "chat" && $_REQUEST['mod'] == "common" && $_REQUEST['act'] == "getChat" )
{
				echo "{\"chat\":[{\"fromId\":\"273040633\",\"fromName\":\"\\u519c\\u573a\\u7ba1\\u7406\\u5458\",\"toId\":\"273040633\",\"toName\":null,\"time\":1251184450,\"msg\":\"\\u6B22\\u8FCE\\u5927\\u5BB6\\u6765\\u4E00\\u8D77\\u73A9\\u7267\\u573A\\uFF01\\uFF01\",\"isReply\":true}]}";
}
?>
