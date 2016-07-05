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
$tudiarr = array(
				"6" => array( "level" => 5, "money" => 10000 ),
				"7" => array( "level" => 7, "money" => 20000 ),
				"8" => array( "level" => 9, "money" => 30000 ),
				"9" => array( "level" => 11, "money" => 50000 ),
				"10" => array( "level" => 13, "money" => 70000 ),
				"11" => array( "level" => 15, "money" => 90000 ),
				"12" => array( "level" => 17, "money" => 120000 ),
				"13" => array( "level" => 19, "money" => 150000 ),
				"14" => array( "level" => 21, "money" => 180000 ),
				"15" => array( "level" => 23, "money" => 230000 ),
				"16" => array( "level" => 25, "money" => 300000 ),
				"17" => array( "level" => 27, "money" => 500000 )
);
$crops = array(
				"2" => array( "cId" => 2, "cName" => "\\u767d\\u841d\\u535c ", "cType" => "1", "growthCycle" => "36000", "maturingTime" => "1", "expect" => 272, "output" => "16", "sale" => "17", "price" => "125", "cLevel" => "0", "cropExp" => "15", "cCharm" => "0", "cropChr" => "0" ),
				"40" => array( "cId" => 40, "cName" => "\\u7267\\u8349 ", "cType" => "1", "growthCycle" => "28800", "maturingTime" => "1", "expect" => 150, "output" => "25", "sale" => "6", "price" => "120", "cLevel" => "0", "cropExp" => "10", "cCharm" => "0", "cropChr" => "0" ),
				"3" => array( "cId" => 3, "cName" => "\\u80e1\\u841d\\u535c ", "cType" => "1", "growthCycle" => "46800", "maturingTime" => "1", "expect" => 357, "output" => "17", "sale" => "21", "price" => "163", "cLevel" => "0", "cropExp" => "18", "cCharm" => "0", "cropChr" => "0" ),
				"4" => array( "cId" => 4, "cName" => "\\u7389\\u7c73 ", "cType" => "1", "growthCycle" => "50400", "maturingTime" => "1", "expect" => 391, "output" => "17", "sale" => "23", "price" => "175", "cLevel" => "3", "cropExp" => "19", "cCharm" => "0", "cropChr" => "0" ),
				"5" => array( "cId" => 5, "cName" => "\\u571f\\u8c46 ", "cType" => "1", "growthCycle" => "54000", "maturingTime" => "1", "expect" => 432, "output" => "18", "sale" => "24", "price" => "188", "cLevel" => "4", "cropExp" => "20", "cCharm" => "0", "cropChr" => "0" ),
				"6" => array( "cId" => 6, "cName" => "\\u8304\\u5b50 ", "cType" => "1", "growthCycle" => "57600", "maturingTime" => "1", "expect" => 500, "output" => "20", "sale" => "25", "price" => "237", "cLevel" => "5", "cropExp" => "21", "cCharm" => "0", "cropChr" => "0" ),
				"7" => array( "cId" => 7, "cName" => "\\u756a\\u8304 ", "cType" => "1", "growthCycle" => "61200", "maturingTime" => "1", "expect" => 546, "output" => "21", "sale" => "26", "price" => "251", "cLevel" => "6", "cropExp" => "22", "cCharm" => "0", "cropChr" => "0" ),
				"8" => array( "cId" => 8, "cName" => "\\u8c4c\\u8c46 ", "cType" => "1", "growthCycle" => "64800", "maturingTime" => "1", "expect" => 594, "output" => "22", "sale" => "27", "price" => "266", "cLevel" => "7", "cropExp" => "23", "cCharm" => "0", "cropChr" => "0" ),
				"9" => array( "cId" => 9, "cName" => "\\u8fa3\\u6912 ", "cType" => "1", "growthCycle" => "72000", "maturingTime" => "1", "expect" => 672, "output" => "24", "sale" => "28", "price" => "296", "cLevel" => "8", "cropExp" => "25", "cCharm" => "0", "cropChr" => "0" ),
				"10" => array( "cId" => 10, "cName" => "\\u5357\\u74dc ", "cType" => "1", "growthCycle" => "79200", "maturingTime" => "1", "expect" => 750, "output" => "25", "sale" => "30", "price" => "325", "cLevel" => "9", "cropExp" => "27", "cCharm" => "0", "cropChr" => "0" ),
				"11" => array( "cId" => 11, "cName" => "\\u82f9\\u679c ", "cType" => "1", "growthCycle" => "75600", "maturingTime" => "2", "expect" => 1104, "output" => "23", "sale" => "24", "price" => "518", "cLevel" => "10", "cropExp" => "20", "cCharm" => "0", "cropChr" => "0" ),
				"1" => array( "cId" => 1, "cName" => "\\u8349\\u8393 ", "cType" => "1", "growthCycle" => "86400", "maturingTime" => "2", "expect" => 1296, "output" => "24", "sale" => "27", "price" => "605", "cLevel" => "10", "cropExp" => "23", "cCharm" => "0", "cropChr" => "0" ),
				"14" => array( "cId" => 14, "cName" => "\\u897f\\u74dc ", "cType" => "1", "growthCycle" => "100800", "maturingTime" => "2", "expect" => 1566, "output" => "27", "sale" => "29", "price" => "708", "cLevel" => "11", "cropExp" => "26", "cCharm" => "0", "cropChr" => "0" ),
				"15" => array( "cId" => 15, "cName" => "\\u9999\\u8549 ", "cType" => "1", "growthCycle" => "111600", "maturingTime" => "2", "expect" => 1856, "output" => "29", "sale" => "32", "price" => "900", "cLevel" => "12", "cropExp" => "28", "cCharm" => "0", "cropChr" => "0" ),
				"18" => array( "cId" => 18, "cName" => "\\u6843\\u5b50 ", "cType" => "1", "growthCycle" => "151200", "maturingTime" => "2", "expect" => 2560, "output" => "32", "sale" => "40", "price" => "1200", "cLevel" => "13", "cropExp" => "35", "cCharm" => "0", "cropChr" => "0" ),
				"19" => array( "cId" => 19, "cName" => "\\u6a59\\u5b50 ", "cType" => "1", "growthCycle" => "133200", "maturingTime" => "3", "expect" => 3198, "output" => "26", "sale" => "41", "price" => "1587", "cLevel" => "14", "cropExp" => "28", "cCharm" => "0", "cropChr" => "0" ),
				"13" => array( "cId" => 13, "cName" => "\\u8461\\u8404 ", "cType" => "1", "growthCycle" => "165600", "maturingTime" => "3", "expect" => 4089, "output" => "29", "sale" => "47", "price" => "1978", "cLevel" => "15", "cropExp" => "34", "cCharm" => "0", "cropChr" => "0" ),
				"23" => array( "cId" => 23, "cName" => "\\u77f3\\u69b4 ", "cType" => "1", "growthCycle" => "187200", "maturingTime" => "3", "expect" => 4860, "output" => "30", "sale" => "54", "price" => "2425", "cLevel" => "16", "cropExp" => "37", "cCharm" => "0", "cropChr" => "0" ),
				"26" => array( "cId" => 26, "cName" => "\\u67da\\u5b50 ", "cType" => "1", "growthCycle" => "219600", "maturingTime" => "3", "expect" => 5742, "output" => "33", "sale" => "58", "price" => "2855", "cLevel" => "17", "cropExp" => "43", "cCharm" => "0", "cropChr" => "0" ),
				"27" => array( "cId" => 27, "cName" => "\\u83e0\\u841d ", "cType" => "1", "growthCycle" => "230400", "maturingTime" => "3", "expect" => 6510, "output" => "35", "sale" => "62", "price" => "3480", "cLevel" => "18", "cropExp" => "44", "cCharm" => "0", "cropChr" => "0" ),
				"29" => array( "cId" => 29, "cName" => "\\u6930\\u5b50 ", "cType" => "1", "growthCycle" => "198000", "maturingTime" => "4", "expect" => 7020, "output" => "27", "sale" => "65", "price" => "3720", "cLevel" => "19", "cropExp" => "36", "cCharm" => "0", "cropChr" => "0" ),
				"31" => array( "cId" => 31, "cName" => "\\u846b\\u82a6 ", "cType" => "1", "growthCycle" => "219600", "maturingTime" => "4", "expect" => 8520, "output" => "30", "sale" => "71", "price" => "4742", "cLevel" => "20", "cropExp" => "40", "cCharm" => "0", "cropChr" => "0" ),
				"33" => array( "cId" => 33, "cName" => "\\u706b\\u9f99\\u679c ", "cType" => "1", "growthCycle" => "252000", "maturingTime" => "4", "expect" => 9856, "output" => "32", "sale" => "77", "price" => "5356", "cLevel" => "21", "cropExp" => "39", "cCharm" => "0", "cropChr" => "0" ),
				"34" => array( "cId" => 34, "cName" => "\\u6a31\\u6843 ", "cType" => "1", "growthCycle" => "259200", "maturingTime" => "4", "expect" => 10296, "output" => "33", "sale" => "78", "price" => "5527", "cLevel" => "22", "cropExp" => "41", "cCharm" => "0", "cropChr" => "0" ),
				"35" => array( "cId" => 35, "cName" => "\\u8354\\u679d ", "cType" => "1", "growthCycle" => "277200", "maturingTime" => "4", "expect" => 11696, "output" => "34", "sale" => "86", "price" => "6588", "cLevel" => "23", "cropExp" => "43", "cCharm" => "0", "cropChr" => "0" ),
				"36" => array( "cId" => 36, "cName" => "\\u5947\\u5f02\\u679c ", "cType" => "1", "growthCycle" => "291600", "maturingTime" => "4", "expect" => 12512, "output" => "34", "sale" => "92", "price" => "6975", "cLevel" => "24", "cropExp" => "45", "cCharm" => "0", "cropChr" => "0" ),
				"12" => array( "cId" => 12, "cName" => "\\u54c8\\u5bc6\\u74dc ", "cType" => "1", "growthCycle" => "93600", "maturingTime" => "2", "expect" => 2500, "output" => "25", "sale" => "50", "price" => "1388", "cLevel" => "25", "cropExp" => "19", "cCharm" => "0", "cropChr" => "0" ),
				"16" => array( "cId" => 16, "cName" => "\\u67e0\\u6aac ", "cType" => "1", "growthCycle" => "126000", "maturingTime" => "2", "expect" => 3420, "output" => "30", "sale" => "57", "price" => "1875", "cLevel" => "26", "cropExp" => "25", "cCharm" => "0", "cropChr" => "0" ),
				"17" => array( "cId" => 17, "cName" => "\\u6787\\u6777 ", "cType" => "1", "growthCycle" => "140400", "maturingTime" => "2", "expect" => 3720, "output" => "30", "sale" => "62", "price" => "2063", "cLevel" => "27", "cropExp" => "28", "cCharm" => "0", "cropChr" => "0" ),
				"20" => array( "cId" => 20, "cName" => "\\u7518\\u8517 ", "cType" => "1", "growthCycle" => "147600", "maturingTime" => "3", "expect" => 5208, "output" => "28", "sale" => "62", "price" => "2888", "cLevel" => "28", "cropExp" => "26", "cCharm" => "0", "cropChr" => "0" ),
				"101" => array( "cId" => 101, "cName" => "\\u73ab\\u7470\\uff08\\u7ea2\\u8272\\uff09 ", "cType" => "2", "growthCycle" => "57600", "maturingTime" => "1", "expect" => 352, "output" => "2", "sale" => "176", "price" => "54", "cLevel" => "0", "cropExp" => "21", "cCharm" => "0", "cropChr" => "2" ),
				"102" => array( "cId" => 102, "cName" => "\\u73AB\\u7470\\uFF08\\u7C89\\u8272\\uFF09 ", "cType" => "2", "growthCycle" => "57600", "maturingTime" => "1", "expect" => 352, "output" => "2", "sale" => "176", "price" => "54", "cLevel" => "0", "cropExp" => "21", "cCharm" => "0", "cropChr" => "2" ),
				"103" => array( "cId" => 103, "cName" => "\\u73AB\\u7470\\uFF08\\u767D\\u8272\\uFF09 ", "cType" => "2", "growthCycle" => "57600", "maturingTime" => "1", "expect" => 352, "output" => "2", "sale" => "176", "price" => "54", "cLevel" => "0", "cropExp" => "21", "cCharm" => "0", "cropChr" => "2" ),
				"104" => array( "cId" => 104, "cName" => "\\u73AB\\u7470\\uFF08\\u9EC4\\u8272\\uFF09 ", "cType" => "2", "growthCycle" => "57600", "maturingTime" => "1", "expect" => 352, "output" => "2", "sale" => "176", "price" => "54", "cLevel" => "0", "cropExp" => "21", "cCharm" => "0", "cropChr" => "2" ),
				"105" => array( "cId" => 105, "cName" => "\\u592a\\u9633\\u82b1\\uff08\\u9ec4\\u8272\\uff09 ", "cType" => "2", "growthCycle" => "86400", "maturingTime" => "1", "expect" => 524, "output" => "2", "sale" => "262", "price" => "78", "cLevel" => "0", "cropExp" => "30", "cCharm" => "0", "cropChr" => "3" ),
				"106" => array( "cId" => 106, "cName" => "\\u592A\\u9633\\u82B1\\uFF08\\u7C89\\u8272\\uFF09 ", "cType" => "2", "growthCycle" => "86400", "maturingTime" => "1", "expect" => 524, "output" => "2", "sale" => "262", "price" => "78", "cLevel" => "0", "cropExp" => "30", "cCharm" => "0", "cropChr" => "3" ),
				"107" => array( "cId" => 107, "cName" => "\\u592A\\u9633\\u82B1\\uFF08\\u767D\\u8272\\uFF09 ", "cType" => "2", "growthCycle" => "86400", "maturingTime" => "1", "expect" => 524, "output" => "2", "sale" => "262", "price" => "78", "cLevel" => "0", "cropExp" => "30", "cCharm" => "0", "cropChr" => "3" ),
				"108" => array( "cId" => 108, "cName" => "\\u592A\\u9633\\u82B1\\uFF08\\u7C73\\u8272\\uFF09 ", "cType" => "2", "growthCycle" => "86400", "maturingTime" => "1", "expect" => 524, "output" => "2", "sale" => "262", "price" => "78", "cLevel" => "0", "cropExp" => "30", "cCharm" => "0", "cropChr" => "3" ),
				"109" => array( "cId" => 109, "cName" => "\\u5eb7\\u4e43\\u99a8\\uff08\\u767d\\u8272\\uff09 ", "cType" => "2", "growthCycle" => "93600", "maturingTime" => "1", "expect" => 270, "output" => "2", "sale" => "135", "price" => "80", "cLevel" => "0", "cropExp" => "33", "cCharm" => "180", "cropChr" => "3" ),
				"110" => array( "cId" => 110, "cName" => "\\u5EB7\\u4E43\\u99A8\\uFF08\\u7C89\\u8272\\uFF09 ", "cType" => "2", "growthCycle" => "93600", "maturingTime" => "1", "expect" => 270, "output" => "2", "sale" => "135", "price" => "80", "cLevel" => "0", "cropExp" => "33", "cCharm" => "180", "cropChr" => "3" ),
				"111" => array( "cId" => 111, "cName" => "\\u5EB7\\u4E43\\u99A8\\uFF08\\u9EC4\\u8272\\uFF09 ", "cType" => "2", "growthCycle" => "93600", "maturingTime" => "1", "expect" => 270, "output" => "2", "sale" => "135", "price" => "80", "cLevel" => "0", "cropExp" => "33", "cCharm" => "180", "cropChr" => "3" ),
				"112" => array( "cId" => 112, "cName" => "\\u5EB7\\u4E43\\u99A8\\uFF08\\u7D2B\\u8272\\uFF09 ", "cType" => "2", "growthCycle" => "93600", "maturingTime" => "1", "expect" => 270, "output" => "2", "sale" => "135", "price" => "80", "cLevel" => "0", "cropExp" => "33", "cCharm" => "180", "cropChr" => "3" ),
				"113" => array( "cId" => 113, "cName" => "\\u90c1\\u91d1\\u9999\\uff08\\u7d2b\\u8272\\uff09 ", "cType" => "2", "growthCycle" => "97200", "maturingTime" => "1", "expect" => 280, "output" => "2", "sale" => "140", "price" => "82", "cLevel" => "0", "cropExp" => "35", "cCharm" => "440", "cropChr" => "3" ),
				"114" => array( "cId" => 114, "cName" => "\\u90c1\\u91d1\\u9999\\uff08\\u7EA2\\u8272\\uff09 ", "cType" => "2", "growthCycle" => "97200", "maturingTime" => "1", "expect" => 280, "output" => "2", "sale" => "140", "price" => "82", "cLevel" => "0", "cropExp" => "35", "cCharm" => "440", "cropChr" => "3" ),
				"115" => array( "cId" => 115, "cName" => "\\u90c1\\u91d1\\u9999\\uff08\\u7C89\\u8272\\uff09 ", "cType" => "2", "growthCycle" => "97200", "maturingTime" => "1", "expect" => 280, "output" => "2", "sale" => "140", "price" => "82", "cLevel" => "0", "cropExp" => "35", "cCharm" => "440", "cropChr" => "3" ),
				"116" => array( "cId" => 116, "cName" => "\\u90c1\\u91d1\\u9999\\uff08\\u767D\\u8272\\uff09 ", "cType" => "2", "growthCycle" => "97200", "maturingTime" => "1", "expect" => 280, "output" => "2", "sale" => "140", "price" => "82", "cLevel" => "0", "cropExp" => "35", "cCharm" => "440", "cropChr" => "3" ),
				"21" => array( "cId" => 21, "cName" => "\\u8611\\u83c7", "cType" => 1, "growthCycle" => 212400, "maturingTime" => 4, "expect" => 10152, "output" => 47, "sale" => 54, "price" => 5434, "FBPrice" => 0, "cLevel" => 29, "cropExp" => 37, "cCharm" => 0, "cropChr" => 0 ),
				"22" => array( "cId" => 22, "cName" => "\\u6768\\u6885", "cType" => "1", "growthCycle" => "234000", "maturingTime" => "4", "expect" => 10296, "output" => "39", "sale" => "66", "price" => "5544", "FBPrice" => 0, "cLevel" => "30", "cropExp" => "38", "cCharm" => "0", "cropChr" => "0" ),
				"117" => array( "cId" => 117, "cName" => "\\u6c34\\u4ed9\\uff08\\u767d\\u8272\\uff09", "cType" => "2", "growthCycle" => "100800", "maturingTime" => "1", "expect" => 348, "output" => "2", "sale" => "174", "price" => "67", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "16", "cCharm" => "800", "cropChr" => "4" ),
				"118" => array( "cId" => 118, "cName" => "\\u6c34\\u4ed9\\uff08\\u9ec4\\u8272\\uff09", "cType" => "2", "growthCycle" => "100800", "maturingTime" => "1", "expect" => 348, "output" => "2", "sale" => "174", "price" => "67", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "16", "cCharm" => "800", "cropChr" => "4" ),
				"119" => array( "cId" => 119, "cName" => "\\u6c34\\u4ed9\\uff08\\u7c89\\u8272\\uff09", "cType" => "2", "growthCycle" => "100800", "maturingTime" => "1", "expect" => 348, "output" => "2", "sale" => "174", "price" => "67", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "16", "cCharm" => "800", "cropChr" => "4" ),
				"120" => array( "cId" => 120, "cName" => "\\u6c34\\u4ed9\\uff08\\u7d2b\\u8272\\uff09", "cType" => "2", "growthCycle" => "100800", "maturingTime" => "1", "expect" => 348, "output" => "2", "sale" => "174", "price" => "67", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "16", "cCharm" => "800", "cropChr" => "4" ),
				"121" => array( "cId" => 121, "cName" => "\\u98ce\\u4fe1\\u5b50\\uff08\\u767d\\u8272\\uff09", "cType" => "2", "growthCycle" => "108000", "maturingTime" => "1", "expect" => 402, "output" => "2", "sale" => "201", "price" => "77", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "23", "cCharm" => "1300", "cropChr" => "5" ),
				"122" => array( "cId" => 122, "cName" => "\\u98ce\\u4fe1\\u5b50\\uff08\\u7d2b\\u8272\\uff09", "cType" => "2", "growthCycle" => "108000", "maturingTime" => "1", "expect" => 402, "output" => "2", "sale" => "201", "price" => "77", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "23", "cCharm" => "1300", "cropChr" => "5" ),
				"123" => array( "cId" => 123, "cName" => "\\u98ce\\u4fe1\\u5b50\\uff08\\u7ea2\\u8272\\uff09", "cType" => "2", "growthCycle" => "108000", "maturingTime" => "1", "expect" => 402, "output" => "2", "sale" => "201", "price" => "77", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "23", "cCharm" => "1300", "cropChr" => "5" ),
				"124" => array( "cId" => 123, "cName" => "\\u98ce\\u4fe1\\u5b50\\uff08\\u9ec4\\u8272\\uff09", "cType" => "2", "growthCycle" => "108000", "maturingTime" => "1", "expect" => 402, "output" => "2", "sale" => "201", "price" => "77", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "23", "cCharm" => "1300", "cropChr" => "5" ),
				"2001" => array( "cId" => 124, "cName" => "\\u795e\\u79d8\\u73a9\\u5177", "cType" => "2", "growthCycle" => "108000", "maturingTime" => "1", "expect" => 402, "output" => "1", "sale" => "201", "price" => "77", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "23", "cCharm" => "1300", "cropChr" => "5" ),
				"2002" => array( "cId" => 124, "cName" => "\\u795e\\u79d8\\u73a9\\u5177", "cType" => "2", "growthCycle" => "108000", "maturingTime" => "1", "expect" => 402, "output" => "1", "sale" => "201", "price" => "77", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "23", "cCharm" => "1300", "cropChr" => "5" ),
				"2003" => array( "cId" => 124, "cName" => "\\u795e\\u79d8\\u73a9\\u5177", "cType" => "2", "growthCycle" => "108000", "maturingTime" => "1", "expect" => 402, "output" => "1", "sale" => "201", "price" => "77", "FBPrice" => 0, "cLevel" => "0", "cropExp" => "23", "cCharm" => "1300", "cropChr" => "5" )
);
$cropstime = array(
				"1" => array( 14400, 28800, 46800, 64800, 86405, 90000000 ),
				"40" => array( 7200, 14400, 21600, 28800, 28805, 90000000 ),
				"2" => array( 7200, 14400, 25200, 36000, 36005, 90000000 ),
				"3" => array( 7200, 18000, 32400, 46800, 46805, 90000000 ),
				"4" => array( 7200, 14400, 25200, 36000, 50405, 90000000 ),
				"5" => array( 7200, 14400, 25200, 39600, 54005, 90000000 ),
				"6" => array( 7200, 18000, 28800, 43200, 57605, 90000000 ),
				"7" => array( 7200, 18000, 32400, 46800, 61205, 90000000 ),
				"8" => array( 10800, 21600, 32400, 46800, 64805, 90000000 ),
				"9" => array( 10800, 25200, 39600, 54000, 72005, 90000000 ),
				"10" => array( 10800, 25200, 43200, 61200, 79205, 90000000 ),
				"11" => array( 14400, 28800, 43200, 57600, 75605, 90000000 ),
				"12" => array( 14400, 32400, 54000, 72000, 93600, 90000000 ),
				"13" => array( 28800, 61200, 93600, 129600, 165605, 90000000 ),
				"14" => array( 14400, 32400, 54000, 75600, 100805, 90000000 ),
				"15" => array( 18000, 39600, 61200, 86400, 111605, 90000000 ),
				"16" => array( 21600, 46800, 72000, 97200, 126005, 90000000 ),
				"17" => array( 25200, 54000, 82800, 111600, 140405, 90000000 ),
				"18" => array( 28800, 57600, 86400, 118800, 151205, 90000000 ),
				"19" => array( 25200, 50400, 75600, 104400, 133205, 90000000 ),
				"20" => array( 39600, 90000, 147600, 205200, 262805, 90000000 ),
				"23" => array( 36000, 72000, 108000, 147600, 187205, 90000000 ),
				"26" => array( 39600, 82800, 126000, 172800, 219605, 90000000 ),
				"27" => array( 43200, 90000, 136800, 183600, 230405, 90000000 ),
				"29" => array( 36000, 75600, 115200, 154800, 198005, 90000000 ),
				"31" => array( 39600, 82800, 126000, 172800, 219605, 90000000 ),
				"33" => array( 46800, 97200, 147600, 198000, 252005, 90000000 ),
				"34" => array( 50400, 100800, 151200, 205200, 259205, 90000000 ),
				"35" => array( 54000, 108000, 165600, 219600, 277205, 90000000 ),
				"36" => array( 57600, 115200, 172800, 230400, 291605, 90000000 ),
				"101" => array( 7200, 18000, 28800, 43200, 57605, 90000000 ),
				"102" => array( 7200, 18000, 28800, 43200, 57605, 90000000 ),
				"103" => array( 7200, 18000, 28800, 43200, 57605, 90000000 ),
				"104" => array( 7200, 18000, 28800, 43200, 57605, 90000000 ),
				"105" => array( 10800, 25200, 43200, 64800, 86405, 90000000 ),
				"106" => array( 10800, 25200, 43200, 64800, 86405, 90000000 ),
				"107" => array( 10800, 25200, 43200, 64800, 86405, 90000000 ),
				"108" => array( 10800, 25200, 43200, 64800, 86405, 90000000 ),
				"109" => array( 10800, 25200, 46800, 68400, 93605, 90000000 ),
				"110" => array( 10800, 25200, 46800, 68400, 93605, 90000000 ),
				"111" => array( 10800, 25200, 46800, 68400, 93605, 90000000 ),
				"112" => array( 10800, 25200, 46800, 68400, 93605, 90000000 ),
				"113" => array( 10800, 25200, 46800, 68400, 97205, 90000000 ),
				"114" => array( 10800, 25200, 46800, 68400, 97205, 90000000 ),
				"115" => array( 10800, 25200, 46800, 68400, 97205, 90000000 ),
				"116" => array( 10800, 25200, 46800, 68400, 97205, 90000000 ),
				"21" => array( 32400, 68400, 104400, 158400, 212405, 90000000 ),
				"22" => array( 28800, 72000, 129600, 187200, 234005, 90000000 ),
				"117" => array( 14400, 28800, 54000, 75600, 100805, 90000000 ),
				"118" => array( 14400, 28800, 54000, 75600, 100805, 90000000 ),
				"119" => array( 14400, 28800, 54000, 75600, 100805, 90000000 ),
				"120" => array( 14400, 28800, 54000, 75600, 100805, 90000000 ),
				"121" => array( 14400, 32400, 50400, 79200, 108005, 90000000 ),
				"122" => array( 14400, 32400, 50400, 79200, 108005, 90000000 ),
				"123" => array( 14400, 32400, 50400, 79200, 108005, 90000000 ),
				"124" => array( 14400, 32400, 50400, 79200, 108005, 90000000 ),
				"2001" => array( 7200, 25200, 50400, 79200, 144000, 90000000 ),
				"2002" => array( 7200, 25200, 50400, 79200, 144000, 90000000 ),
				"2003" => array( 7200, 25200, 50400, 79200, 144000, 90000000 )
);
$tools = array(
				"1" => array(
								"tId" => 1,
								"tName" => "\\u666e\\u901a\\u5316\\u80a5",
								"list" => array(
												"1" => array( "price" => 50, "FBPrice" => 0 ),
												"10" => array( "price" => 450, "FBPrice" => 0 ),
												"100" => array( "price" => 4000, "FBPrice" => 0 )
								),
								"timeLimit" => "0",
								"effect" => "3600",
								"depict" => "\\u6bcf\\u4e2a\\u9636\\u6bb5\\u53ea\\u80fd\\u4f7f\\u7528\\u4e00\\u6b21\\uff0c\\u51cf\\u5c11\\u8be5\\u9636\\u6bb5\\u6210\\u957f\\u65f6\\u95f41\\u5c0f\\u65f6\\u3002",
								"type" => 3
				),
				"2" => array(
								"tId" => 2,
								"tName" => "\\u9ad8\\u901f\\u5316\\u80a5",
								"list" => array(
												"1" => array( "price" => 0, "FBPrice" => 2 ),
												"10" => array( "price" => 0, "FBPrice" => 12 ),
												"100" => array( "price" => 0, "FBPrice" => 100 )
								),
								"timeLimit" => "0",
								"effect" => "9000",
								"depict" => "\\u6bcf\\u4e2a\\u9636\\u6bb5\\u53ea\\u80fd\\u4f7f\\u7528\\u4e00\\u6b21\\uff0c\\u51cf\\u5c11\\u8be5\\u9636\\u6bb5\\u6210\\u957f\\u65f6\\u95f42.5\\u5c0f\\u65f6\\u3002",
								"type" => 3
				),
				"3" => array(
								"tId" => 3,
								"tName" => "\\u6781\\u901f\\u5316\\u80a5",
								"list" => array(
												"1" => array( "price" => 0, "FBPrice" => 5 ),
												"10" => array( "price" => 0, "FBPrice" => 30 ),
												"100" => array( "price" => 0, "FBPrice" => 250 )
								),
								"timeLimit" => "0",
								"effect" => "19800",
								"depict" => "\\u6bcf\\u4e2a\\u9636\\u6bb5\\u53ea\\u80fd\\u4f7f\\u7528\\u4e00\\u6b21\\uff0c\\u51cf\\u5c11\\u8be5\\u9636\\u6bb5\\u6210\\u957f\\u65f6\\u95f45.5\\u5c0f\\u65f6\\u3002",
								"type" => 3
				),
				"7" => array(
								"tId" => 7,
								"tName" => "\\u98de\\u901f\\u5316\\u80a5",
								"list" => array(
												"1" => array( "price" => 0, "FBPrice" => 8 ),
												"10" => array( "price" => 0, "FBPrice" => 72 ),
												"100" => array( "price" => 0, "FBPrice" => 640 )
								),
								"timeLimit" => "0",
								"effect" => "28800",
								"depict" => "\\u6bcf\\u4e2a\\u9636\\u6bb5\\u53ea\\u80fd\\u4f7f\\u7528\\u4e00\\u6b21\\uff0c\\u51cf\\u5c11\\u8be5\\u9636\\u6bb5\\u6210\\u957f\\u65f6\\u95f48\\u5c0f\\u65f6\\u3002",
								"type" => 3
				),
				"8" => array(
								"tId" => 8,
								"tName" => "\\u795e\\u901f\\u5316\\u80a5",
								"list" => array(
												"1" => array( "price" => 0, "FBPrice" => 9 ),
												"10" => array( "price" => 0, "FBPrice" => 81 ),
												"100" => array( "price" => 0, "FBPrice" => 720 )
								),
								"timeLimit" => "0",
								"effect" => "21600",
								"depict" => "\\u6bcf\\u4e2a\\u9636\\u6bb5\\u53ea\\u80fd\\u4f7f\\u7528\\u4e00\\u6b21\\uff0c\\u51cf\\u5c11\\u8be5\\u9636\\u6bb5\\u6210\\u957f\\u65f6\\u95f46\\u5c0f\\u65f6\\uff0c\\u4eba\\u54c1\\u597d\\u7684\\u8bdd\\u8fd8\\u6709\\u66f4\\u795e\\u5947\\u7684\\u6548\\u679c\\u54e6\\uff01",
								"type" => 3
				),
				"4" => array(
								"tId" => 4,
								"tName" => "\\u53cb\\u60c5\\u5316\\u80a5",
								"list" => array(
												"1" => array( "price" => 0, "FBPrice" => 2 ),
												"10" => array( "price" => 0, "FBPrice" => 12 ),
												"100" => array( "price" => 0, "FBPrice" => 100 )
								),
								"timeLimit" => "0",
								"effect" => "5400",
								"depict" => "\\u53ea\\u80fd\\u5bf9\\u597d\\u53cb\\u571f\\u5730\\u4e0a\\u7684\\u4f5c\\u7269\\u4f7f\\u7528\\uff0c\\u51cf\\u5c11\\u597d\\u53cb\\u4f5c\\u7269\\u5f53\\u524d\\u72b6\\u60011.5\\u5c0f\\u65f6\\u65f6\\u95f4\\u3002",
								"type" => 3
				),
				"6" => array(
								"tId" => 6,
								"tName" => "\\u5f3a\\u529b\\u6740\\u866b\\u5242",
								"list" => array(
												"1" => array( "price" => 0, "FBPrice" => 2 ),
												"10" => array( "price" => 0, "FBPrice" => 12 ),
												"100" => array( "price" => 0, "FBPrice" => 100 )
								),
								"timeLimit" => "0",
								"effect" => "3",
								"depict" => "\\u6bd4\\u666e\\u901a\\u6740\\u866b\\u5242\\u5a01\\u529b\\u66f4\\u5927\\uff0c\\u4f46\\u662f\\u53ea\\u80fd\\u4e13\\u6740\\u5927\\u866b\\u5b50\\u3002",
								"type" => 3
				)
);
$dogs = array(
				"1" => array(
								"tId" => 1,
								"tName" => "\\u54c8\\u58eb\\u5947",
								"list" => array(
												"1" => array( "price" => "0", "FBPrice" => "9", "gouliang" => "3" )
								),
								"effect" => "",
								"depict" => "\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u90013\\u5305\\u72d7\\u7cae\\u3002",
								"type" => 4
				),
				"2" => array(
								"tId" => 2,
								"tName" => "\\u9ec4\\u91d1\\u730e\\u72ac",
								"list" => array(
												"1" => array( "price" => "0", "FBPrice" => "19", "gouliang" => "10" )
								),
								"effect" => "",
								"depict" => "\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u900110\\u5305\\u72d7\\u7cae\\u3002",
								"type" => 4
				),
				"3" => array(
								"tId" => 3,
								"tName" => "\\u8d35\\u5bbe\\u72d7",
								"list" => array(
												"1" => array( "price" => "0", "FBPrice" => "29", "gouliang" => "15" )
								),
								"effect" => "",
								"depict" => "\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u900115\\u5305\\u72d7\\u7cae",
								"type" => 4
				),
				"4" => array(
								"tId" => 4,
								"tName" => "\\u5927\\u9ea6\\u753a\\u72ac",
								"list" => array(
												"1" => array( "price" => "0", "FBPrice" => "39", "gouliang" => "20" )
								),
								"effect" => "",
								"depict" => "\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u900120\\u5305\\u72d7\\u7cae",
								"type" => 4
				),
				"5" => array(
								"tId" => 5,
								"tName" => "\\u677e\\u72ee",
								"list" => array(
												"1" => array( "price" => "0", "FBPrice" => "49", "gouliang" => "20" )
								),
								"effect" => "",
								"depict" => "\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u900110\\u5305\\u72d7\\u7cae",
								"type" => 4
				),
				"6" => array(
								"tId" => 6,
								"tName" => "\\u6fb3\\u6d32\\u4e1d\\u6bdb",
								"list" => array(
												"1" => array( "price" => "0", "FBPrice" => "49", "gouliang" => "20" )
								),
								"effect" => "",
								"depict" => "\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u900110\\u5305\\u72d7\\u7cae",
								"type" => 4
				)
);
$decorative = array(
				"61" => array( "itemId" => "61", "itemName" => "\\u602a\\u5708\\u9ea6\\u7530", "itemDesc" => "\\u91d1\\u79cb\\u573a\\u666f", "itemType" => "1", "itemValidTime" => "2592000", "price" => "30888", "FBPrice" => "31", "setId" => "12" ),
				"62" => array( "itemId" => "62", "itemName" => "\\u4e30\\u6536\\u7ea2\\u5c4b", "itemDesc" => "\\u91d1\\u79cb\\u573a\\u666f", "itemType" => "2", "itemValidTime" => "2592000", "price" => "20999", "FBPrice" => "21", "setId" => "12" ),
				"63" => array( "itemId" => "63", "itemName" => "\\u79cb\\u8272\\u6728\\u680f", "itemDesc" => "\\u91d1\\u79cb\\u573a\\u666f", "itemType" => "3", "itemValidTime" => "2592000", "price" => "12999", "FBPrice" => "13", "setId" => "12" ),
				"64" => array( "itemId" => "64", "itemName" => "\\u7cae\\u8349\\u5c0f\\u7a9d", "itemDesc" => "\\u91d1\\u79cb\\u573a\\u666f", "itemType" => "4", "itemValidTime" => "2592000", "price" => "9999", "FBPrice" => "10", "setId" => "12" ),
				"56" => array( "itemId" => "56", "itemName" => "\\u7545\\u60f3\\u73af\\u5f62\\u5c71", "itemDesc" => "\\u6708\\u7403\\u63a2\\u7d22\\u573a\\u666f", "itemType" => "1", "itemValidTime" => "2592000", "price" => "30888", "FBPrice" => "31", "setId" => "11" ),
				"57" => array( "itemId" => "57", "itemName" => "\\u84dd\\u7535\\u80fd\\u6e90\\u5c4b", "itemDesc" => "\\u6708\\u7403\\u63a2\\u7d22\\u573a\\u666f", "itemType" => "2", "itemValidTime" => "2592000", "price" => "20999", "FBPrice" => "21", "setId" => "11" ),
				"58" => array( "itemId" => "58", "itemName" => "\\u956d\\u5c04\\u9632\\u5fa1\\u680f", "itemDesc" => "\\u6708\\u7403\\u63a2\\u7d22\\u573a\\u666f", "itemType" => "3", "itemValidTime" => "2592000", "price" => "12999", "FBPrice" => "13", "setId" => "11" ),
				"59" => array( "itemId" => "59", "itemName" => "\\u96f7\\u8fbe\\u52c7\\u72ac\\u8231", "itemDesc" => "\\u6708\\u7403\\u63a2\\u7d22\\u573a\\u666f", "itemType" => "4", "itemValidTime" => "2592000", "price" => "9999", "FBPrice" => "10", "setId" => "11" ),
				"51" => array( "itemId" => "51", "itemName" => "\\u6708\\u8ff7\\u9b45\\u5f71", "itemDesc" => "\\u54e5\\u7279\\u5f0f\\u573a\\u666f", "itemType" => "1", "itemValidTime" => "2592000", "price" => "23888", "FBPrice" => "23", "setId" => "10" ),
				"52" => array( "itemId" => "52", "itemName" => "\\u5e7b\\u591c\\u4fe1\\u4ef0", "itemDesc" => "\\u54e5\\u7279\\u5f0f\\u573a\\u666f", "itemType" => "2", "itemValidTime" => "2592000", "price" => "15999", "FBPrice" => "16", "setId" => "10" ),
				"53" => array( "itemId" => "53", "itemName" => "\\u6697\\u9ed1\\u7981\\u5fcc", "itemDesc" => "\\u54e5\\u7279\\u5f0f\\u573a\\u666f", "itemType" => "3", "itemValidTime" => "2592000", "price" => "9888", "FBPrice" => "10", "setId" => "10" ),
				"54" => array( "itemId" => "54", "itemName" => "\\u8ff7\\u8e2a\\u536b\\u58eb", "itemDesc" => "\\u54e5\\u7279\\u5f0f\\u573a\\u666f", "itemType" => "4", "itemValidTime" => "2592000", "price" => "7888", "FBPrice" => "8", "setId" => "10" ),
				"11" => array( "itemId" => "11", "itemName" => "\\u6625\\u65e5\\u98ce\\u8f66\\u80cc\\u666f", "itemDesc" => "\\u8377\\u5170\\u8475\\u82b1\\u7cfb\\u5217", "itemType" => "1", "itemValidTime" => "2592000", "price" => "14499", "FBPrice" => "14", "setId" => "2" ),
				"12" => array( "itemId" => "12", "itemName" => "\\u7eff\\u9876\\u5c0f\\u6728\\u5c4b", "itemDesc" => "\\u8377\\u5170\\u8475\\u82b1\\u7cfb\\u5217", "itemType" => "2", "itemValidTime" => "2592000", "price" => "9999", "FBPrice" => "9", "setId" => "2" ),
				"13" => array( "itemId" => "13", "itemName" => "\\u7231\\u5fc3\\u6728\\u6805\\u680f", "itemDesc" => "\\u8377\\u5170\\u8475\\u82b1\\u7cfb\\u5217", "itemType" => "3", "itemValidTime" => "2592000", "price" => "5999", "FBPrice" => "5", "setId" => "2" ),
				"14" => array( "itemId" => "14", "itemName" => "\\u6728\\u5236\\u5c0f\\u72d7\\u7a9d", "itemDesc" => "\\u8377\\u5170\\u8475\\u82b1\\u7cfb\\u5217", "itemType" => "4", "itemValidTime" => "2592000", "price" => "4999", "FBPrice" => "4", "setId" => "2" ),
				"21" => array( "itemId" => "21", "itemName" => "\\u6625\\u6696\\u82b1\\u5f00\\u80cc\\u666f", "itemDesc" => "\\u6625\\u6696\\u82b1\\u5f00\\u5957\\u88c5", "itemType" => "1", "itemValidTime" => "2592000", "price" => "25999", "FBPrice" => "25", "setId" => "4" ),
				"22" => array( "itemId" => "22", "itemName" => "\\u6625\\u610f\\u5c0f\\u6728\\u5c4b", "itemDesc" => "\\u6625\\u6696\\u82b1\\u5f00\\u5957\\u88c5", "itemType" => "2", "itemValidTime" => "2592000", "price" => "17999", "FBPrice" => "17", "setId" => "4" ),
				"23" => array( "itemId" => "23", "itemName" => "\\u79ef\\u6728\\u767d\\u6805\\u680f ", "itemDesc" => "\\u6625\\u6696\\u82b1\\u5f00\\u5957\\u88c5", "itemType" => "3", "itemValidTime" => "2592000", "price" => "10999", "FBPrice" => "10", "setId" => "4" ),
				"24" => array( "itemId" => "24", "itemName" => "\\u7eff\\u8272\\u6728\\u72d7\\u7a9d", "itemDesc" => "\\u6625\\u6696\\u82b1\\u5f00\\u5957\\u88c5", "itemType" => "4", "itemValidTime" => "2592000", "price" => "8888", "FBPrice" => "8", "setId" => "4" ),
				"32" => array( "itemId" => "31", "itemName" => "\\u6e05\\u51c9\\u4e00\\u590f\\u80cc\\u666f", "itemDesc" => "\\u590f\\u65e5\\u6d77\\u6ee9\\u5957\\u88c5", "itemType" => "1", "itemValidTime" => "2592000", "price" => "28888", "FBPrice" => "28", "setId" => "6" ),
				"32" => array( "itemId" => "32", "itemName" => "\\u6d77\\u6ee8\\u5ea6\\u5047\\u5c4b", "itemDesc" => "\\u590f\\u65e5\\u6d77\\u6ee9\\u5957\\u88c5", "itemType" => "2", "itemValidTime" => "2592000", "price" => "19999", "FBPrice" => "19", "setId" => "6" ),
				"33" => array( "itemId" => "33", "itemName" => "\\u7c89\\u767d\\u6ce2\\u6d6a\\u6805\\u680f", "itemDesc" => "\\u590f\\u65e5\\u6d77\\u6ee9\\u5957\\u88c5", "itemType" => "3", "itemValidTime" => "2592000", "price" => "11999", "FBPrice" => "11", "setId" => "6" ),
				"34" => array( "itemId" => "34", "itemName" => "\\u6d77\\u6ee8\\u5c0f\\u72d7\\u7a9d", "itemDesc" => "\\u590f\\u65e5\\u6d77\\u6ee9\\u5957\\u88c5", "itemType" => "4", "itemValidTime" => "2592000", "price" => "9999", "FBPrice" => "9", "setId" => "6" ),
				"36" => array( "itemId" => "36", "itemName" => "\\u5730\\u4e2d\\u6d77\\u98ce\\u60c5", "itemDesc" => "\\u5730\\u4e2d\\u6d77\\u98ce\\u60c5\\u5957\\u88c5", "itemType" => "1", "itemValidTime" => "2592000", "price" => "27888", "FBPrice" => "27", "setId" => "7" ),
				"37" => array( "itemId" => "37", "itemName" => "\\u8ff7\\u60c5\\u84dd\\u5821", "itemDesc" => "\\u5730\\u4e2d\\u6d77\\u98ce\\u60c5\\u5957\\u88c5", "itemType" => "2", "itemValidTime" => "2592000", "price" => "18999", "FBPrice" => "19", "setId" => "7" ),
				"38" => array( "itemId" => "38", "itemName" => "\\u767d\\u6c99\\u56f4\\u5eca", "itemDesc" => "\\u5730\\u4e2d\\u6d77\\u98ce\\u60c5\\u5957\\u88c5", "itemType" => "3", "itemValidTime" => "2592000", "price" => "11499", "FBPrice" => "11", "setId" => "7" ),
				"39" => array( "itemId" => "39", "itemName" => "\\u8d1d\\u9c81\\u7279\\u72ac\\u820d", "itemDesc" => "\\u5730\\u4e2d\\u6d77\\u98ce\\u60c5\\u5957\\u88c5", "itemType" => "4", "itemValidTime" => "2592000", "price" => "9199", "FBPrice" => "9", "setId" => "7" ),
				"41" => array( "itemId" => "41", "itemName" => "\\u6d53\\u60c5\\u539f\\u91ce", "itemDesc" => "\\u9752\\u9752\\u8349\\u539f\\u5957\\u88c5", "itemType" => "1", "itemValidTime" => "2592000", "price" => "24888", "FBPrice" => "24", "setId" => "8" ),
				"42" => array( "itemId" => "42", "itemName" => "\\u6e29\\u60c5\\u8499\\u53e4\\u5305", "itemDesc" => "\\u9752\\u9752\\u8349\\u539f\\u5957\\u88c5", "itemType" => "2", "itemValidTime" => "2592000", "price" => "16999", "FBPrice" => "17", "setId" => "8" ),
				"43" => array( "itemId" => "43", "itemName" => "\\u6021\\u60c5\\u56f4\\u6be1", "itemDesc" => "\\u9752\\u9752\\u8349\\u539f\\u5957\\u88c5", "itemType" => "3", "itemValidTime" => "2592000", "price" => "10299", "FBPrice" => "10", "setId" => "8" ),
				"44" => array( "itemId" => "44", "itemName" => "\\u98ce\\u60c5\\u7352\\u7a9d", "itemDesc" => "\\u9752\\u9752\\u8349\\u539f\\u5957\\u88c5", "itemType" => "4", "itemValidTime" => "2592000", "price" => "8199", "FBPrice" => "8", "setId" => "8" ),
				"46" => array( "itemId" => "46", "itemName" => "\\u91d1\\u8272\\u539f\\u91ce", "itemDesc" => "\\u91d1\\u8272\\u5047\\u65e5\\u5957\\u88c5", "itemType" => "1", "itemValidTime" => "2592000", "price" => "0", "FBPrice" => "40", "setId" => "9" ),
				"47" => array( "itemId" => "47", "itemName" => "\\u98ce\\u8f66\\u623f\\u5b50", "itemDesc" => "\\u91d1\\u8272\\u5047\\u65e5\\u5957\\u88c5", "itemType" => "2", "itemValidTime" => "2592000", "price" => "0", "FBPrice" => "28", "setId" => "9" ),
				"48" => array( "itemId" => "48", "itemName" => "\\u539f\\u6728\\u6805\\u680f", "itemDesc" => "\\u91d1\\u8272\\u5047\\u65e5\\u5957\\u88c5", "itemType" => "3", "itemValidTime" => "2592000", "price" => "0", "FBPrice" => "17", "setId" => "9" ),
				"49" => array( "itemId" => "49", "itemName" => "\\u539f\\u6728\\u72d7\\u7a9d", "itemDesc" => "\\u91d1\\u8272\\u5047\\u65e5\\u5957\\u88c5", "itemType" => "4", "itemValidTime" => "2592000", "price" => "0", "FBPrice" => "14", "setId" => "9" ),
				"1" => array( "itemId" => "1", "itemName" => "\\u582a\\u8428\\u65af\\u519c\\u573a", "itemDesc" => "\\u582A\\u8428\\u65AF\\u519C\\u573A\\u5957\\u88C5", "itemType" => "1", "itemValidTime" => "2592000", "price" => "0", "FBPrice" => "0", "setId" => "1" ),
				"2" => array( "itemId" => "2", "itemName" => "\\u582a\\u8428\\u65af\\u6728\\u5c4b", "itemDesc" => "\\u582A\\u8428\\u65AF\\u519C\\u573A\\u5957\\u88C5", "itemType" => "2", "itemValidTime" => "2592000", "price" => "0", "FBPrice" => "0", "setId" => "1" ),
				"3" => array( "itemId" => "3", "itemName" => "\\u582a\\u8428\\u65af\\u6728\\u6805\\u680f", "itemDesc" => "\\u582A\\u8428\\u65AF\\u519C\\u573A\\u5957\\u88C5", "itemType" => "3", "itemValidTime" => "2592000", "price" => "0", "FBPrice" => "0", "setId" => "1" ),
				"4" => array( "itemId" => "4", "itemName" => "\\u6728\\u5236\\u5c0f\\u72d7\\u7a9d", "itemDesc" => "\\u582A\\u8428\\u65AF\\u519C\\u573A\\u5957\\u88C5", "itemType" => "4", "itemValidTime" => "2592000", "price" => "0", "FBPrice" => "0", "setId" => "1" ),
				"76" => array( "itemId" => "76", "itemName" => "\\u7409\\u7483\\u5929\\u5916\\u5929", "itemDesc" => "\\u4e2d\\u79cb\\u573a\\u666f", "itemType" => "1", "itemValidTime" => "2592000", "price" => "22999", "FBPrice" => "23", "setId" => "15" ),
				"77" => array( "itemId" => "77", "itemName" => "\\u7fd8\\u6a90\\u548c\\u6bbf", "itemDesc" => "\\u4e2d\\u79cb\\u573a\\u666f", "itemType" => "2", "itemValidTime" => "2592000", "price" => "15999", "FBPrice" => "16", "setId" => "15" ),
				"78" => array( "itemId" => "78", "itemName" => "\\u74e6\\u7247\\u9662\\u5899", "itemDesc" => "\\u4e2d\\u79cb\\u573a\\u666f", "itemType" => "3", "itemValidTime" => "2592000", "price" => "7999", "FBPrice" => "8", "setId" => "15" ),
				"79" => array( "itemId" => "79", "itemName" => "\\u6708\\u6842\\u72ac\\u820d", "itemDesc" => "\\u4e2d\\u79cb\\u573a\\u666f", "itemType" => "4", "itemValidTime" => "2592000", "price" => "6999", "FBPrice" => "7", "setId" => "15" ),
				"66" => array( "itemId" => "66", "itemName" => "\\u87e0\\u9f99\\u7aef\\u4e91\\u5c71", "itemDesc" => "\\u4ed9\\u57df\\u68a6\\u5883\\u573a\\u666f", "itemType" => "1", "itemValidTime" => "2592000", "price" => "21999", "FBPrice" => "22", "setId" => "13" ),
				"67" => array( "itemId" => "67", "itemName" => "\\u8f89\\u714c\\u91d1\\u9601\\u6bbf", "itemDesc" => "\\u4ed9\\u57df\\u68a6\\u5883\\u573a\\u666f", "itemType" => "2", "itemValidTime" => "2592000", "price" => "14999", "FBPrice" => "15", "setId" => "13" ),
				"68" => array( "itemId" => "68", "itemName" => "\\u62a4\\u57ce\\u7ea2\\u7981\\u680f", "itemDesc" => "\\u4ed9\\u57df\\u68a6\\u5883\\u573a\\u666f", "itemType" => "3", "itemValidTime" => "2592000", "price" => "8999", "FBPrice" => "9", "setId" => "13" ),
				"69" => array( "itemId" => "69", "itemName" => "\\u7ebf\\u9999\\u7075\\u72ac\\u5e99", "itemDesc" => "\\u4ed9\\u57df\\u68a6\\u5883\\u573a\\u666f", "itemType" => "4", "itemValidTime" => "2592000", "price" => "7199", "FBPrice" => "7", "setId" => "13" ),
				"71" => array( "itemId" => "71", "itemName" => "\\u7eff\\u91ce\\u4ed9\\u8e2a", "itemDesc" => "\\u539f\\u59cb\\u68ee\\u6797\\u5957\\u88c5", "itemType" => "1", "itemValidTime" => "2592000", "price" => "23999", "FBPrice" => "24", "setId" => "14" ),
				"72" => array( "itemId" => "72", "itemName" => "\\u6a61\\u6811\\u6728\\u5c4b", "itemDesc" => "\\u539f\\u59cb\\u68ee\\u6797\\u5957\\u88c5", "itemType" => "2", "itemValidTime" => "2592000", "price" => "16999", "FBPrice" => "17", "setId" => "14" ),
				"73" => array( "itemId" => "73", "itemName" => "\\u8346\\u68d8\\u680f", "itemDesc" => "\\u539f\\u59cb\\u68ee\\u6797\\u5957\\u88c5", "itemType" => "3", "itemValidTime" => "2592000", "price" => "6199", "FBPrice" => "6", "setId" => "14" ),
				"74" => array( "itemId" => "74", "itemName" => "\\u5706\\u6728\\u5c0f\\u820d", "itemDesc" => "\\u539f\\u59cb\\u68ee\\u6797\\u5957\\u88c5", "itemType" => "4", "itemValidTime" => "2592000", "price" => "5199", "FBPrice" => "5", "setId" => "14" )
);
$makenosegay = array(
				"1" => array( "neednum" => 11, "cid" => 101, "charm" => 13 ),
				"2" => array( "neednum" => 11, "cid" => 102, "charm" => 13 ),
				"3" => array( "neednum" => 11, "cid" => 103, "charm" => 13 ),
				"4" => array( "neednum" => 11, "cid" => 104, "charm" => 13 ),
				"5" => array( "neednum" => 33, "cid" => 101, "charm" => 41 ),
				"6" => array( "neednum" => 33, "cid" => 102, "charm" => 41 ),
				"7" => array( "neednum" => 33, "cid" => 103, "charm" => 41 ),
				"8" => array( "neednum" => 33, "cid" => 104, "charm" => 41 ),
				"9" => array( "neednum" => 99, "cid" => 101, "charm" => 123 ),
				"10" => array( "neednum" => 99, "cid" => 102, "charm" => 123 ),
				"11" => array( "neednum" => 99, "cid" => 103, "charm" => 123 ),
				"12" => array( "neednum" => 99, "cid" => 104, "charm" => 123 ),
				"13" => array( "neednum" => 11, "cid" => 105, "charm" => 27 ),
				"14" => array( "neednum" => 11, "cid" => 106, "charm" => 27 ),
				"15" => array( "neednum" => 11, "cid" => 107, "charm" => 27 ),
				"16" => array( "neednum" => 11, "cid" => 108, "charm" => 27 ),
				"17" => array( "neednum" => 22, "cid" => 105, "charm" => 55 ),
				"18" => array( "neednum" => 22, "cid" => 106, "charm" => 55 ),
				"19" => array( "neednum" => 22, "cid" => 107, "charm" => 55 ),
				"20" => array( "neednum" => 22, "cid" => 108, "charm" => 55 ),
				"21" => array( "neednum" => 123, "cid" => 105, "charm" => 307 ),
				"22" => array( "neednum" => 123, "cid" => 106, "charm" => 307 ),
				"23" => array( "neednum" => 123, "cid" => 107, "charm" => 307 ),
				"24" => array( "neednum" => 123, "cid" => 108, "charm" => 307 ),
				"25" => array( "neednum" => 8, "cid" => 109, "charm" => 14 ),
				"26" => array( "neednum" => 8, "cid" => 110, "charm" => 14 ),
				"27" => array( "neednum" => 8, "cid" => 111, "charm" => 14 ),
				"28" => array( "neednum" => 8, "cid" => 112, "charm" => 14 ),
				"29" => array( "neednum" => 36, "cid" => 109, "charm" => 63 ),
				"30" => array( "neednum" => 36, "cid" => 110, "charm" => 63 ),
				"31" => array( "neednum" => 36, "cid" => 111, "charm" => 63 ),
				"32" => array( "neednum" => 36, "cid" => 112, "charm" => 63 ),
				"33" => array( "neednum" => 88, "cid" => 109, "charm" => 154 ),
				"34" => array( "neednum" => 88, "cid" => 110, "charm" => 154 ),
				"35" => array( "neednum" => 88, "cid" => 111, "charm" => 154 ),
				"36" => array( "neednum" => 88, "cid" => 112, "charm" => 154 ),
				"37" => array( "neednum" => 12, "cid" => 113, "charm" => 33 ),
				"38" => array( "neednum" => 12, "cid" => 114, "charm" => 33 ),
				"39" => array( "neednum" => 12, "cid" => 115, "charm" => 33 ),
				"40" => array( "neednum" => 12, "cid" => 116, "charm" => 33 ),
				"41" => array( "neednum" => 44, "cid" => 113, "charm" => 121 ),
				"42" => array( "neednum" => 44, "cid" => 114, "charm" => 121 ),
				"43" => array( "neednum" => 44, "cid" => 115, "charm" => 121 ),
				"44" => array( "neednum" => 44, "cid" => 116, "charm" => 121 ),
				"45" => array( "neednum" => 100, "cid" => 113, "charm" => 275 ),
				"46" => array( "neednum" => 100, "cid" => 114, "charm" => 275 ),
				"47" => array( "neednum" => 100, "cid" => 115, "charm" => 275 ),
				"48" => array( "neednum" => 100, "cid" => 116, "charm" => 275 ),
				"49" => array( "neednum" => 6, "cid" => 117, "charm" => 10 ),
				"50" => array( "neednum" => 6, "cid" => 118, "charm" => 10 ),
				"51" => array( "neednum" => 6, "cid" => 119, "charm" => 10 ),
				"52" => array( "neednum" => 6, "cid" => 120, "charm" => 10 ),
				"53" => array( "neednum" => 22, "cid" => 117, "charm" => 38 ),
				"54" => array( "neednum" => 22, "cid" => 118, "charm" => 38 ),
				"55" => array( "neednum" => 22, "cid" => 119, "charm" => 38 ),
				"56" => array( "neednum" => 22, "cid" => 120, "charm" => 38 ),
				"57" => array( "neednum" => 66, "cid" => 117, "charm" => 115 ),
				"58" => array( "neednum" => 66, "cid" => 118, "charm" => 115 ),
				"59" => array( "neednum" => 66, "cid" => 119, "charm" => 115 ),
				"60" => array( "neednum" => 66, "cid" => 120, "charm" => 115 ),
				"61" => array( "neednum" => 8, "cid" => 121, "charm" => 26 ),
				"62" => array( "neednum" => 8, "cid" => 122, "charm" => 26 ),
				"63" => array( "neednum" => 8, "cid" => 123, "charm" => 26 ),
				"64" => array( "neednum" => 8, "cid" => 124, "charm" => 26 ),
				"65" => array( "neednum" => 58, "cid" => 121, "charm" => 188 ),
				"66" => array( "neednum" => 58, "cid" => 122, "charm" => 188 ),
				"67" => array( "neednum" => 58, "cid" => 123, "charm" => 188 ),
				"68" => array( "neednum" => 58, "cid" => 124, "charm" => 188 ),
				"69" => array( "neednum" => 88, "cid" => 121, "charm" => 286 ),
				"70" => array( "neednum" => 88, "cid" => 122, "charm" => 286 ),
				"71" => array( "neednum" => 88, "cid" => 123, "charm" => 286 ),
				"72" => array( "neednum" => 88, "cid" => 124, "charm" => 286 ),
				"2001" => array( "neednum" => 8888, "cid" => 123, "charm" => 40 ),
				"2002" => array( "neednum" => 8888, "cid" => 123, "charm" => 40 ),
				"2003" => array( "neednum" => 8888, "cid" => 123, "charm" => 40 ),
				"3001" => array( "neednum" => 8888, "cid" => 123, "charm" => 40 ),
				"3002" => array( "neednum" => 8888, "cid" => 123, "charm" => 40 ),
				"3003" => array( "neednum" => 8888, "cid" => 123, "charm" => 40 ),
				"3004" => array( "neednum" => 8888, "cid" => 123, "charm" => 40 ),
				"3005" => array( "neednum" => 8888, "cid" => 123, "charm" => 40 )
);
if ( $_REQUEST['mod'] == "user" && $_REQUEST['act'] == "run" )
{
				if ( intval( $_REQUEST['ownerId'] ) != $_SGLOBAL['supe_uid'] && $_REQUEST['flag'] == 1 && intval( $_REQUEST['ownerId'] ) != "0" )
				{
								$query = $_SGLOBAL['db']->query( "SELECT farmlandstatus,money,exp,fb,reclaim,decorative,dog,message,charm FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['ownerId'] ) );
								while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
								{
												$list[] = $value;
								}
								$farmlandStatus = ( array )json_decode( $list[0][farmlandstatus] );
								foreach ( $farmlandStatus[farmlandstatus] as $key => $value )
								{
												if ( $key < $list[0][reclaim] )
												{
																if ( stristr( $value->n, ",".$_SGLOBAL['supe_uid']."," ) )
																{
																				$value->n = 1;
																}
																else
																{
																				$value->n = 2;
																}
																$farmlandstatusarr[] = json_encode( $value );
												}
								}
								$farmlandstatusarr = json_encode( $farmlandstatusarr );
								$farmlandstatusarr = str_replace( "\"{", "{", $farmlandstatusarr );
								$farmlandstatusarr = str_replace( "}\"", "}", $farmlandstatusarr );
								$decorativearr = ( array )json_decode( $list[0][decorative] );
								foreach ( $decorativearr as $itemtype => $value )
								{
												foreach ( $value as $key => $value1 )
												{
																if ( $value1->status == 1 )
																{
																				if ( $_SGLOBAL['timestamp'] < $value1->validtime || $value1->validtime == 0 )
																				{
																								$decorativearr_srt[] = "".$itemtype."\":{\"itemId\":".$key."}";
																				}
																				else if ( !( $value1->validtime < $_SGLOBAL['timestamp'] ) || !( $value1->validtime != 0 ) )
																				{
																								foreach ( $value as $key2 => $value2 )
																								{
																												if ( $itemtype == $key2 )
																												{
																																$value2->status = 1;
																												}
																												else
																												{
																																$value2->status = 0;
																												}
																								}
																								$decorativearrsql = json_encode( $decorativearr );
																								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set decorative='".$decorativearrsql."' where uid=".intval( $_REQUEST['ownerId'] ) );
																								$decorativearr_srt[] = "".$itemtype."\":{\"itemId\":".$itemtype."}";
																				}
																}
												}
								}
								$decorative_srt = json_encode( $decorativearr_srt );
								$decorative_srt = str_replace( "\"{", "{", $decorative_srt );
								$decorative_srt = str_replace( "}\"", "}", $decorative_srt );
								$decorative_srt = str_replace( "[", "", $decorative_srt );
								$decorative_srt = str_replace( "]", "", $decorative_srt );
								$dog = json_decode( $list[0][dog] );
								$dogstr = "{\"dogId\":0,\"dogFeedTime\":0,\"dogUnWorkTime\":0}";
								foreach ( $dog as $key => $value )
								{
												if ( $value->status == 1 )
												{
																$dogstr = "{\"dogId\":".$key.",\"dogFeedTime\":".$value->dogFeedTime.",\"dogUnWorkTime\":0}";
												}
								}
								$message = json_decode( $list[0][message] );
								$top = "";
								foreach ( $message->e as $key => $value )
								{
												if ( $value->status == 2 )
												{
																if ( 3000 < $value->formulaId )
																{
																				$type = 3;
																}
																else if ( 2000 < $value->formulaId && $value->formulaId < 3000 )
																{
																				$type = 2;
																}
																else
																{
																				$type = 1;
																}
																$top[] = "{\"id\":".$value->id.",\"formulaId\":\"".$value->formulaId."\",\"type\":".$type.",\"friendId\":\"".$value->friendId."\",\"fName\":\"".$value->fName."\",\"charm\":".$value->charm.",\"msg\":\"".$value->msg."\",\"show\":\"1\",\"x\":\"".$value->x."\",\"y\":\"".$value->y."\",\"z\":\"".$value->z."\"}";
												}
								}
								$top = json_encode( $top );
								$top = str_replace( "\"{", "{", $top );
								$top = str_replace( "}\"", "}", $top );
								if ( $top == "" )
								{
												$top = "null";
								}
								echo stripslashes( "{\"farmlandStatus\":".$farmlandstatusarr.",\"items\":{".$decorative_srt."},\"exp\":".$list[0][exp].",\"charm\":".$list[0][charm].",\"dog\":".$dogstr.",\"top\":".$top."}" );
								exit( );
				}
				$query = $_SGLOBAL['db']->query( "SELECT farmlandstatus,money,exp,fb,reclaim,decorative,dog,message,charm,taskid FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$farmlandStatus = ( array )json_decode( $list[0][farmlandstatus] );
				foreach ( $farmlandStatus[farmlandstatus] as $key => $value )
				{
								if ( $key < $list[0][reclaim] )
								{
												$value->n = 2;
												$farmlandstatusarr[] = json_encode( $value );
								}
				}
				$farmlandstatusarr = json_encode( $farmlandstatusarr );
				$farmlandstatusarr = str_replace( "\"{", "{", $farmlandstatusarr );
				$farmlandstatusarr = str_replace( "}\"", "}", $farmlandstatusarr );
				$decorativearr = ( array )json_decode( $list[0][decorative] );
				foreach ( $decorativearr as $itemtype => $value )
				{
								foreach ( $value as $key => $value1 )
								{
												if ( $value1->status == 1 )
												{
																if ( $_SGLOBAL['timestamp'] < $value1->validtime || $value1->validtime == 0 )
																{
																				$decorativearr_srt[] = "".$itemtype."\":{\"itemId\":".$key."}";
																}
																else if ( !( $value1->validtime < $_SGLOBAL['timestamp'] ) || !( $value1->validtime != 0 ) )
																{
																				foreach ( $value as $key2 => $value2 )
																				{
																								if ( $itemtype == $key2 )
																								{
																												$value2->status = 1;
																								}
																								else
																								{
																												$value2->status = 0;
																								}
																				}
																				$decorativearrsql = json_encode( $decorativearr );
																				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set decorative='".$decorativearrsql."' where uid=".$_SGLOBAL['supe_uid'] );
																				$decorativearr_srt[] = "".$itemtype."\":{\"itemId\":".$itemtype."}";
																}
												}
								}
				}
				$decorative_srt = json_encode( $decorativearr_srt );
				$decorative_srt = str_replace( "\"{", "{", $decorative_srt );
				$decorative_srt = str_replace( "}\"", "}", $decorative_srt );
				$decorative_srt = str_replace( "[", "", $decorative_srt );
				$decorative_srt = str_replace( "]", "", $decorative_srt );
				$dog = json_decode( $list[0][dog] );
				$dogstr = "{\"dogId\":0,\"dogFeedTime\":0,\"dogUnWorkTime\":0}";
				foreach ( $dog as $key => $value )
				{
								if ( $value->status == 1 )
								{
												$dogstr = "{\"dogId\":".$key.",\"dogFeedTime\":".$value->dogFeedTime.",\"dogUnWorkTime\":0}";
								}
				}
				$message = json_decode( $list[0][message] );
				$top = "";
				$c = 0;
				foreach ( $message->e as $key => $value )
				{
								if ( $value->status == 2 )
								{
												if ( 3000 < $value->formulaId )
												{
																$type = 3;
												}
												else if ( 2000 < $value->formulaId && $value->formulaId < 3000 )
												{
																$type = 2;
												}
												else
												{
																$type = 1;
												}
												$top[] = "{\"id\":".$value->id.",\"formulaId\":\"".$value->formulaId."\",\"type\":".$type.",\"friendId\":\"".$value->friendId."\",\"fName\":\"".$value->fName."\",\"charm\":".$value->charm.",\"msg\":\"".$value->msg."\",\"show\":\"1\",\"x\":\"".$value->x."\",\"y\":\"".$value->y."\",\"z\":\"".$value->z."\"}";
								}
								if ( $value->status == 0 )
								{
												++$c;
								}
				}
				$top = json_encode( $top );
				$top = str_replace( "\"{", "{", $top );
				$top = str_replace( "}\"", "}", $top );
				$top = str_replace( "\\u", "\\\\u", $top );
				if ( $top == "" )
				{
								$top = "null";
				}
				$taskid = "";
				if ( $list[0][taskid] < 12 )
				{
								$taskid = ",\"task\":{\"taskId\":".$list[0][taskid].",\"taskFlag\":1}";
				}
				if ( $list[0][taskid] == 1 )
				{
								$taskid = ",\"task\":{\"taskId\":".$list[0][taskid].",\"taskFlag\":1},\"welcome\":1";
				}
				if ( $space['name'] == "" )
				{
								$space['name'] = $space['username'];
				}
				echo stripslashes( "{\"farmlandStatus\":".$farmlandstatusarr.",\"items\":{".$decorative_srt."},\"exp\":".$list[0][exp].",\"charm\":".$list[0][charm].",\"dog\":".$dogstr.",\"top\":".$top.",\"weather\":{\"weatherId\":1},\"serverTime\":{\"time\":".$_SGLOBAL['timestamp']."},\"user\":{\"uId\":\"".$_SGLOBAL['supe_uid']."\",\"userName\":\"".str_replace( "\\u", "\\\\u", unicode_encodegb( $space['name'] ) )."\",\"money\":".$list[0][money].",\"FB\":\"".$list[0][fb]."\",\"exp\":".$list[0][exp].",\"charm\":".$list[0][charm].",\"headPic\":\"".avatar( $_SGLOBAL[supe_uid], "small", TRUE )."\"},\"a\":0,\"c\":".$c.",\"b\":0".$taskid."}" );
				exit( );
}
if ( $_REQUEST['mod'] == "shop" && $_REQUEST['act'] == "getShopInfo" )
{
				if ( $_REQUEST['type'] == "1" )
				{
								echo "{\"1\":[{\"cId\":40,\"cName\":\"\\u7267\\u8349 \",\"cType\":\"1\",\"growthCycle\":\"28800\",\"maturingTime\":\"1\",\"expect\":150,\"output\":\"25\",\"sale\":\"6\",\"price\":\"120\",\"cLevel\":\"0\",\"cropExp\":\"10\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":2,\"cName\":\"\\u767d\\u841d\\u535c \",\"cType\":\"1\",\"growthCycle\":\"36000\",\"maturingTime\":\"1\",\"expect\":272,\"output\":\"16\",\"sale\":\"17\",\"price\":\"125\",\"cLevel\":\"0\",\"cropExp\":\"15\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":3,\"cName\":\"\\u80e1\\u841d\\u535c \",\"cType\":\"1\",\"growthCycle\":\"46800\",\"maturingTime\":\"1\",\"expect\":357,\"output\":\"17\",\"sale\":\"21\",\"price\":\"163\",\"cLevel\":\"0\",\"cropExp\":\"18\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":4,\"cName\":\"\\u7389\\u7c73 \",\"cType\":\"1\",\"growthCycle\":\"50400\",\"maturingTime\":\"1\",\"expect\":391,\"output\":\"17\",\"sale\":\"23\",\"price\":\"175\",\"cLevel\":\"3\",\"cropExp\":\"19\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":5,\"cName\":\"\\u571f\\u8c46 \",\"cType\":\"1\",\"growthCycle\":\"54000\",\"maturingTime\":\"1\",\"expect\":432,\"output\":\"18\",\"sale\":\"24\",\"price\":\"188\",\"cLevel\":\"4\",\"cropExp\":\"20\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":6,\"cName\":\"\\u8304\\u5b50 \",\"cType\":\"1\",\"growthCycle\":\"57600\",\"maturingTime\":\"1\",\"expect\":500,\"output\":\"20\",\"sale\":\"25\",\"price\":\"237\",\"cLevel\":\"5\",\"cropExp\":\"21\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":7,\"cName\":\"\\u756a\\u8304 \",\"cType\":\"1\",\"growthCycle\":\"61200\",\"maturingTime\":\"1\",\"expect\":546,\"output\":\"21\",\"sale\":\"26\",\"price\":\"251\",\"cLevel\":\"6\",\"cropExp\":\"22\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":8,\"cName\":\"\\u8c4c\\u8c46 \",\"cType\":\"1\",\"growthCycle\":\"64800\",\"maturingTime\":\"1\",\"expect\":594,\"output\":\"22\",\"sale\":\"27\",\"price\":\"266\",\"cLevel\":\"7\",\"cropExp\":\"23\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":9,\"cName\":\"\\u8fa3\\u6912 \",\"cType\":\"1\",\"growthCycle\":\"72000\",\"maturingTime\":\"1\",\"expect\":672,\"output\":\"24\",\"sale\":\"28\",\"price\":\"296\",\"cLevel\":\"8\",\"cropExp\":\"25\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":10,\"cName\":\"\\u5357\\u74dc \",\"cType\":\"1\",\"growthCycle\":\"79200\",\"maturingTime\":\"1\",\"expect\":750,\"output\":\"25\",\"sale\":\"30\",\"price\":\"325\",\"cLevel\":\"9\",\"cropExp\":\"27\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":11,\"cName\":\"\\u82f9\\u679c \",\"cType\":\"1\",\"growthCycle\":\"75600\",\"maturingTime\":\"2\",\"expect\":1104,\"output\":\"23\",\"sale\":\"24\",\"price\":\"518\",\"cLevel\":\"10\",\"cropExp\":\"20\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":1,\"cName\":\"\\u8349\\u8393 \",\"cType\":\"1\",\"growthCycle\":\"86400\",\"maturingTime\":\"2\",\"expect\":1296,\"output\":\"24\",\"sale\":\"27\",\"price\":\"605\",\"cLevel\":\"10\",\"cropExp\":\"23\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":14,\"cName\":\"\\u897f\\u74dc \",\"cType\":\"1\",\"growthCycle\":\"100800\",\"maturingTime\":\"2\",\"expect\":1566,\"output\":\"27\",\"sale\":\"29\",\"price\":\"708\",\"cLevel\":\"11\",\"cropExp\":\"26\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":15,\"cName\":\"\\u9999\\u8549 \",\"cType\":\"1\",\"growthCycle\":\"111600\",\"maturingTime\":\"2\",\"expect\":1856,\"output\":\"29\",\"sale\":\"32\",\"price\":\"900\",\"cLevel\":\"12\",\"cropExp\":\"28\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":18,\"cName\":\"\\u6843\\u5b50 \",\"cType\":\"1\",\"growthCycle\":\"151200\",\"maturingTime\":\"2\",\"expect\":2560,\"output\":\"32\",\"sale\":\"40\",\"price\":\"1200\",\"cLevel\":\"13\",\"cropExp\":\"35\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":19,\"cName\":\"\\u6a59\\u5b50 \",\"cType\":\"1\",\"growthCycle\":\"133200\",\"maturingTime\":\"3\",\"expect\":3198,\"output\":\"26\",\"sale\":\"41\",\"price\":\"1587\",\"cLevel\":\"14\",\"cropExp\":\"28\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":13,\"cName\":\"\\u8461\\u8404 \",\"cType\":\"1\",\"growthCycle\":\"165600\",\"maturingTime\":\"3\",\"expect\":4089,\"output\":\"29\",\"sale\":\"47\",\"price\":\"1978\",\"cLevel\":\"15\",\"cropExp\":\"34\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":23,\"cName\":\"\\u77f3\\u69b4 \",\"cType\":\"1\",\"growthCycle\":\"187200\",\"maturingTime\":\"3\",\"expect\":4860,\"output\":\"30\",\"sale\":\"54\",\"price\":\"2425\",\"cLevel\":\"16\",\"cropExp\":\"37\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":26,\"cName\":\"\\u67da\\u5b50 \",\"cType\":\"1\",\"growthCycle\":\"219600\",\"maturingTime\":\"3\",\"expect\":5742,\"output\":\"33\",\"sale\":\"58\",\"price\":\"2855\",\"cLevel\":\"17\",\"cropExp\":\"43\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":27,\"cName\":\"\\u83e0\\u841d \",\"cType\":\"1\",\"growthCycle\":\"230400\",\"maturingTime\":\"3\",\"expect\":6510,\"output\":\"35\",\"sale\":\"62\",\"price\":\"3480\",\"cLevel\":\"18\",\"cropExp\":\"44\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":29,\"cName\":\"\\u6930\\u5b50 \",\"cType\":\"1\",\"growthCycle\":\"198000\",\"maturingTime\":\"4\",\"expect\":7020,\"output\":\"27\",\"sale\":\"65\",\"price\":\"3720\",\"cLevel\":\"19\",\"cropExp\":\"36\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":31,\"cName\":\"\\u846b\\u82a6 \",\"cType\":\"1\",\"growthCycle\":\"219600\",\"maturingTime\":\"4\",\"expect\":8520,\"output\":\"30\",\"sale\":\"71\",\"price\":\"4742\",\"cLevel\":\"20\",\"cropExp\":\"40\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":33,\"cName\":\"\\u706b\\u9f99\\u679c \",\"cType\":\"1\",\"growthCycle\":\"252000\",\"maturingTime\":\"4\",\"expect\":9856,\"output\":\"32\",\"sale\":\"77\",\"price\":\"5356\",\"cLevel\":\"21\",\"cropExp\":\"39\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":34,\"cName\":\"\\u6a31\\u6843 \",\"cType\":\"1\",\"growthCycle\":\"259200\",\"maturingTime\":\"4\",\"expect\":10296,\"output\":\"33\",\"sale\":\"78\",\"price\":\"5527\",\"cLevel\":\"22\",\"cropExp\":\"41\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":35,\"cName\":\"\\u8354\\u679d \",\"cType\":\"1\",\"growthCycle\":\"277200\",\"maturingTime\":\"4\",\"expect\":11696,\"output\":\"34\",\"sale\":\"86\",\"price\":\"6588\",\"cLevel\":\"23\",\"cropExp\":\"43\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":36,\"cName\":\"\\u5947\\u5f02\\u679c \",\"cType\":\"1\",\"growthCycle\":\"291600\",\"maturingTime\":\"4\",\"expect\":12512,\"output\":\"34\",\"sale\":\"92\",\"price\":\"6975\",\"cLevel\":\"24\",\"cropExp\":\"45\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":12,\"cName\":\"\\u54c8\\u5bc6\\u74dc \",\"cType\":\"1\",\"growthCycle\":\"93600\",\"maturingTime\":\"2\",\"expect\":2500,\"output\":\"25\",\"sale\":\"50\",\"price\":\"1388\",\"cLevel\":\"25\",\"cropExp\":\"19\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":16,\"cName\":\"\\u67e0\\u6aac \",\"cType\":\"1\",\"growthCycle\":\"126000\",\"maturingTime\":\"2\",\"expect\":3420,\"output\":\"30\",\"sale\":\"57\",\"price\":\"1875\",\"cLevel\":\"26\",\"cropExp\":\"25\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":17,\"cName\":\"\\u6787\\u6777 \",\"cType\":\"1\",\"growthCycle\":\"140400\",\"maturingTime\":\"2\",\"expect\":3720,\"output\":\"30\",\"sale\":\"62\",\"price\":\"2063\",\"cLevel\":\"27\",\"cropExp\":\"28\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":20,\"cName\":\"\\u7518\\u8517 \\u79cd\\u5b50\",\"cType\":\"1\",\"growthCycle\":\"147600\",\"maturingTime\":\"3\",\"expect\":5208,\"output\":\"28\",\"sale\":\"62\",\"price\":\"2888\",\"cLevel\":\"28\",\"cropExp\":\"26\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":101,\"cName\":\"\\u73ab\\u7470\\uff08\\u7ea2\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"57600\",\"maturingTime\":\"1\",\"expect\":352,\"output\":\"2\",\"sale\":\"176\",\"price\":\"54\",\"cLevel\":\"0\",\"cropExp\":\"21\",\"cCharm\":\"0\",\"cropChr\":\"2\"},{\"cId\":102,\"cName\":\"\\u73AB\\u7470\\uFF08\\u7C89\\u8272\\uFF09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"57600\",\"maturingTime\":\"1\",\"expect\":352,\"output\":\"2\",\"sale\":\"176\",\"price\":\"54\",\"cLevel\":\"0\",\"cropExp\":\"21\",\"cCharm\":\"0\",\"cropChr\":\"2\"},{\"cId\":103,\"cName\":\"\\u73AB\\u7470\\uFF08\\u767D\\u8272\\uFF09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"57600\",\"maturingTime\":\"1\",\"expect\":352,\"output\":\"2\",\"sale\":\"176\",\"price\":\"54\",\"cLevel\":\"0\",\"cropExp\":\"21\",\"cCharm\":\"0\",\"cropChr\":\"2\"},{\"cId\":104,\"cName\":\"\\u73AB\\u7470\\uFF08\\u9EC4\\u8272\\uFF09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"57600\",\"maturingTime\":\"1\",\"expect\":352,\"output\":\"2\",\"sale\":\"176\",\"price\":\"54\",\"cLevel\":\"0\",\"cropExp\":\"21\",\"cCharm\":\"0\",\"cropChr\":\"2\"},{\"cId\":105,\"cName\":\"\\u592a\\u9633\\u82b1\\uff08\\u9ec4\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"86400\",\"maturingTime\":\"1\",\"expect\":524,\"output\":\"2\",\"sale\":\"262\",\"price\":\"78\",\"cLevel\":\"0\",\"cropExp\":\"30\",\"cCharm\":\"0\",\"cropChr\":\"3\"},{\"cId\":106,\"cName\":\"\\u592A\\u9633\\u82B1\\uFF08\\u7C89\\u8272\\uFF09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"86400\",\"maturingTime\":\"1\",\"expect\":524,\"output\":\"2\",\"sale\":\"262\",\"price\":\"78\",\"cLevel\":\"0\",\"cropExp\":\"30\",\"cCharm\":\"0\",\"cropChr\":\"3\"},{\"cId\":107,\"cName\":\"\\u592A\\u9633\\u82B1\\uFF08\\u767D\\u8272\\uFF09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"86400\",\"maturingTime\":\"1\",\"expect\":524,\"output\":\"2\",\"sale\":\"262\",\"price\":\"78\",\"cLevel\":\"0\",\"cropExp\":\"30\",\"cCharm\":\"0\",\"cropChr\":\"3\"},{\"cId\":108,\"cName\":\"\\u592A\\u9633\\u82B1\\uFF08\\u7C73\\u8272\\uFF09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"86400\",\"maturingTime\":\"1\",\"expect\":524,\"output\":\"2\",\"sale\":\"262\",\"price\":\"78\",\"cLevel\":\"0\",\"cropExp\":\"30\",\"cCharm\":\"0\",\"cropChr\":\"3\"},{\"cId\":109,\"cName\":\"\\u5eb7\\u4e43\\u99a8\\uff08\\u767d\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"93600\",\"maturingTime\":\"1\",\"expect\":270,\"output\":\"2\",\"sale\":\"135\",\"price\":\"80\",\"cLevel\":\"0\",\"cropExp\":\"33\",\"cCharm\":\"180\",\"cropChr\":\"3\"},{\"cId\":110,\"cName\":\"\\u5EB7\\u4E43\\u99A8\\uFF08\\u7C89\\u8272\\uFF09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"93600\",\"maturingTime\":\"1\",\"expect\":270,\"output\":\"2\",\"sale\":\"135\",\"price\":\"80\",\"cLevel\":\"0\",\"cropExp\":\"33\",\"cCharm\":\"180\",\"cropChr\":\"3\"},{\"cId\":111,\"cName\":\"\\u5EB7\\u4E43\\u99A8\\uFF08\\u9EC4\\u8272\\uFF09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"93600\",\"maturingTime\":\"1\",\"expect\":270,\"output\":\"2\",\"sale\":\"135\",\"price\":\"80\",\"cLevel\":\"0\",\"cropExp\":\"33\",\"cCharm\":\"180\",\"cropChr\":\"3\"},{\"cId\":112,\"cName\":\"\\u5EB7\\u4E43\\u99A8\\uFF08\\u7D2B\\u8272\\uFF09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"93600\",\"maturingTime\":\"1\",\"expect\":270,\"output\":\"2\",\"sale\":\"135\",\"price\":\"80\",\"cLevel\":\"0\",\"cropExp\":\"33\",\"cCharm\":\"180\",\"cropChr\":\"3\"},{\"cId\":113,\"cName\":\"\\u90c1\\u91d1\\u9999\\uff08\\u7d2b\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"97200\",\"maturingTime\":\"1\",\"expect\":280,\"output\":\"2\",\"sale\":\"140\",\"price\":\"82\",\"cLevel\":\"0\",\"cropExp\":\"35\",\"cCharm\":\"440\",\"cropChr\":\"3\"},{\"cId\":114,\"cName\":\"\\u90c1\\u91d1\\u9999\\uff08\\u7EA2\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"97200\",\"maturingTime\":\"1\",\"expect\":280,\"output\":\"2\",\"sale\":\"140\",\"price\":\"82\",\"cLevel\":\"0\",\"cropExp\":\"35\",\"cCharm\":\"440\",\"cropChr\":\"3\"},{\"cId\":115,\"cName\":\"\\u90c1\\u91d1\\u9999\\uff08\\u7C89\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"97200\",\"maturingTime\":\"1\",\"expect\":280,\"output\":\"2\",\"sale\":\"140\",\"price\":\"82\",\"cLevel\":\"0\",\"cropExp\":\"35\",\"cCharm\":\"440\",\"cropChr\":\"3\"},{\"cId\":116,\"cName\":\"\\u90c1\\u91d1\\u9999\\uff08\\u767D\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"97200\",\"maturingTime\":\"1\",\"expect\":280,\"output\":\"2\",\"sale\":\"140\",\"price\":\"82\",\"cLevel\":\"0\",\"cropExp\":\"35\",\"cCharm\":\"440\",\"cropChr\":\"3\"},{\"cId\":21,\"cName\":\"\\u8611\\u83c7 \\u79cd\\u5b50\",\"cType\":1,\"growthCycle\":212400,\"maturingTime\":4,\"expect\":10152,\"output\":47,\"sale\":54,\"price\":5434,\"FBPrice\":0,\"cLevel\":29,\"cropExp\":37,\"cCharm\":0,\"cropChr\":0},{\"cId\":22,\"cName\":\"\\u6768\\u6885 \\u79cd\\u5b50\",\"cType\":\"1\",\"growthCycle\":\"234000\",\"maturingTime\":\"4\",\"expect\":10296,\"output\":\"39\",\"sale\":\"66\",\"price\":\"5544\",\"FBPrice\":0,\"cLevel\":\"30\",\"cropExp\":\"38\",\"cCharm\":\"0\",\"cropChr\":\"0\"},{\"cId\":117,\"cName\":\"\\u6c34\\u4ed9\\uff08\\u767d\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"100800\",\"maturingTime\":\"1\",\"expect\":348,\"output\":\"2\",\"sale\":\"174\",\"price\":\"67\",\"FBPrice\":0,\"cLevel\":\"0\",\"cropExp\":\"16\",\"cCharm\":\"800\",\"cropChr\":\"4\"},{\"cId\":118,\"cName\":\"\\u6c34\\u4ed9\\uff08\\u9ec4\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"100800\",\"maturingTime\":\"1\",\"expect\":348,\"output\":\"2\",\"sale\":\"174\",\"price\":\"67\",\"FBPrice\":0,\"cLevel\":\"0\",\"cropExp\":\"16\",\"cCharm\":\"800\",\"cropChr\":\"4\"},{\"cId\":119,\"cName\":\"\\u6c34\\u4ed9\\uff08\\u7c89\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"100800\",\"maturingTime\":\"1\",\"expect\":348,\"output\":\"2\",\"sale\":\"174\",\"price\":\"67\",\"FBPrice\":0,\"cLevel\":\"0\",\"cropExp\":\"16\",\"cCharm\":\"800\",\"cropChr\":\"4\"},{\"cId\":120,\"cName\":\"\\u6c34\\u4ed9\\uff08\\u7d2b\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"100800\",\"maturingTime\":\"1\",\"expect\":348,\"output\":\"2\",\"sale\":\"174\",\"price\":\"67\",\"FBPrice\":0,\"cLevel\":\"0\",\"cropExp\":\"16\",\"cCharm\":\"800\",\"cropChr\":\"4\"},{\"cId\":121,\"cName\":\"\\u98ce\\u4fe1\\u5b50\\uff08\\u767d\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"108000\",\"maturingTime\":\"1\",\"expect\":402,\"output\":\"2\",\"sale\":\"201\",\"price\":\"77\",\"FBPrice\":0,\"cLevel\":\"0\",\"cropExp\":\"23\",\"cCharm\":\"1300\",\"cropChr\":\"5\"},{\"cId\":122,\"cName\":\"\\u98ce\\u4fe1\\u5b50\\uff08\\u7d2b\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"108000\",\"maturingTime\":\"1\",\"expect\":402,\"output\":\"2\",\"sale\":\"201\",\"price\":\"77\",\"FBPrice\":0,\"cLevel\":\"0\",\"cropExp\":\"23\",\"cCharm\":\"1300\",\"cropChr\":\"5\"},{\"cId\":123,\"cName\":\"\\u98ce\\u4fe1\\u5b50\\uff08\\u7ea2\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"108000\",\"maturingTime\":\"1\",\"expect\":402,\"output\":\"2\",\"sale\":\"201\",\"price\":\"77\",\"FBPrice\":0,\"cLevel\":\"0\",\"cropExp\":\"23\",\"cCharm\":\"1300\",\"cropChr\":\"5\"},{\"cId\":124,\"cName\":\"\\u98ce\\u4fe1\\u5b50\\uff08\\u9ec4\\u8272\\uff09 \\u79cd\\u5b50\",\"cType\":\"2\",\"growthCycle\":\"108000\",\"maturingTime\":\"1\",\"expect\":402,\"output\":\"2\",\"sale\":\"201\",\"price\":\"77\",\"FBPrice\":0,\"cLevel\":\"0\",\"cropExp\":\"23\",\"cCharm\":\"1300\",\"cropChr\":\"5\"}]}";
								exit( );
				}
				if ( $_REQUEST['type'] == "3,4" )
				{
								echo "{\"3\":[{\"tId\":1,\"tName\":\"\\u666e\\u901a\\u5316\\u80a5\",\"list\":{\"1\":{\"price\":50,\"FBPrice\":0},\"10\":{\"price\":450,\"FBPrice\":0},\"100\":{\"price\":4000,\"FBPrice\":0}},\"timeLimit\":\"0\",\"effect\":\"3600\",\"depict\":\"\\u6bcf\\u4e2a\\u9636\\u6bb5\\u53ea\\u80fd\\u4f7f\\u7528\\u4e00\\u6b21\\uff0c\\u51cf\\u5c11\\u8be5\\u9636\\u6bb5\\u6210\\u957f\\u65f6\\u95f41\\u5c0f\\u65f6\\u3002\",\"type\":3},{\"tId\":2,\"tName\":\"\\u9ad8\\u901f\\u5316\\u80a5\",\"list\":{\"1\":{\"price\":0,\"FBPrice\":2},\"10\":{\"price\":0,\"FBPrice\":12},\"100\":{\"price\":0,\"FBPrice\":100}},\"timeLimit\":\"0\",\"effect\":\"9000\",\"depict\":\"\\u6bcf\\u4e2a\\u9636\\u6bb5\\u53ea\\u80fd\\u4f7f\\u7528\\u4e00\\u6b21\\uff0c\\u51cf\\u5c11\\u8be5\\u9636\\u6bb5\\u6210\\u957f\\u65f6\\u95f42.5\\u5c0f\\u65f6\\u3002\",\"type\":3},{\"tId\":3,\"tName\":\"\\u6781\\u901f\\u5316\\u80a5\",\"list\":{\"1\":{\"price\":0,\"FBPrice\":5},\"10\":{\"price\":0,\"FBPrice\":30},\"100\":{\"price\":0,\"FBPrice\":250}},\"timeLimit\":\"0\",\"effect\":\"19800\",\"depict\":\"\\u6bcf\\u4e2a\\u9636\\u6bb5\\u53ea\\u80fd\\u4f7f\\u7528\\u4e00\\u6b21\\uff0c\\u51cf\\u5c11\\u8be5\\u9636\\u6bb5\\u6210\\u957f\\u65f6\\u95f45.5\\u5c0f\\u65f6\\u3002\",\"type\":3},{\"tId\":7,\"tName\":\"\\u98de\\u901f\\u5316\\u80a5\",\"list\":{\"1\":{\"price\":0,\"FBPrice\":8},\"10\":{\"price\":0,\"FBPrice\":72},\"100\":{\"price\":0,\"FBPrice\":640}},\"timeLimit\":\"0\",\"effect\":\"28800\",\"depict\":\"\\u6bcf\\u4e2a\\u9636\\u6bb5\\u53ea\\u80fd\\u4f7f\\u7528\\u4e00\\u6b21\\uff0c\\u51cf\\u5c11\\u8be5\\u9636\\u6bb5\\u6210\\u957f\\u65f6\\u95f48\\u5c0f\\u65f6\\u3002\",\"type\":3},{\"tId\":8,\"tName\":\"\\u795e\\u901f\\u5316\\u80a5\",\"list\":{\"1\":{\"price\":0,\"FBPrice\":9},\"10\":{\"price\":0,\"FBPrice\":81},\"100\":{\"price\":0,\"FBPrice\":720}},\"timeLimit\":\"0\",\"effect\":\"21600\",\"depict\":\"\\u6bcf\\u4e2a\\u9636\\u6bb5\\u53ea\\u80fd\\u4f7f\\u7528\\u4e00\\u6b21\\uff0c\\u51cf\\u5c11\\u8be5\\u9636\\u6bb5\\u6210\\u957f\\u65f6\\u95f46\\u5c0f\\u65f6\\uff0c\\u4eba\\u54c1\\u597d\\u7684\\u8bdd\\u8fd8\\u6709\\u66f4\\u795e\\u5947\\u7684\\u6548\\u679c\\u54e6\\uff01\",\"type\":3}],\"4\":[{\"tId\":4,\"tName\":\"\\u5927\\u9ea6\\u753a\\u72ac\",\"list\":{\"1\":{\"price\":\"0\",\"FBPrice\":\"39\"}},\"effect\":\"\",\"depict\":\"\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u900110\\u5305\\u72d7\\u7cae\",\"type\":4},{\"tId\":1,\"tName\":\"\\u54c8\\u58eb\\u5947\",\"list\":{\"1\":{\"price\":\"0\",\"FBPrice\":\"9\"}},\"effect\":\"\",\"depict\":\"\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u90013\\u5305\\u72d7\\u7cae\\u3002\",\"type\":4},{\"tId\":2,\"tName\":\"\\u9ec4\\u91d1\\u730e\\u72ac\",\"list\":{\"1\":{\"price\":\"0\",\"FBPrice\":\"19\"}},\"effect\":\"\",\"depict\":\"\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u900110\\u5305\\u72d7\\u7cae\\u3002\",\"type\":4},{\"tId\":3,\"tName\":\"\\u8d35\\u5bbe\\u72d7\",\"list\":{\"1\":{\"price\":\"0\",\"FBPrice\":\"29\"}},\"effect\":\"\",\"depict\":\"\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u900110\\u5305\\u72d7\\u7cae\",\"type\":4},{\"tId\":5,\"tName\":\"\\u677e\\u72ee\",\"list\":{\"1\":{\"price\":\"0\",\"FBPrice\":\"49\"}},\"effect\":\"\",\"depict\":\"\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u900110\\u5305\\u72d7\\u7cae\",\"type\":4},{\"tId\":6,\"tName\":\"\\u6fb3\\u6d32\\u4e1d\\u6bdb\",\"list\":{\"1\":{\"price\":\"0\",\"FBPrice\":\"49\"}},\"effect\":\"\",\"depict\":\"\\u72d7\\u72d7\\u53ef\\u4ee5\\u4fdd\\u62a4\\u4f60\\u7684\\u519c\\u573a\\uff0c\\u9632\\u6b62\\u597d\\u53cb\\u4f7f\\u574f\\u54e6~\\u8d2d\\u4e70\\u540c\\u65f6\\u8d60\\u900110\\u5305\\u72d7\\u7cae\",\"type\":4}]}";
								exit( );
				}
				if ( $_REQUEST['type'] == "2" )
				{
								echo "{\"2\":[{\"itemId\":\"61\",\"itemName\":\"\\u602a\\u5708\\u9ea6\\u7530\",\"itemDesc\":\"\\u91d1\\u79cb\\u573a\\u666f\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"30888\",\"FBPrice\":\"31\",\"setId\":\"12\"},{\"itemId\":\"62\",\"itemName\":\"\\u4e30\\u6536\\u7ea2\\u5c4b\",\"itemDesc\":\"\\u91d1\\u79cb\\u573a\\u666f\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"20999\",\"FBPrice\":\"21\",\"setId\":\"12\"},{\"itemId\":\"63\",\"itemName\":\"\\u79cb\\u8272\\u6728\\u680f\",\"itemDesc\":\"\\u91d1\\u79cb\\u573a\\u666f\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"12999\",\"FBPrice\":\"13\",\"setId\":\"12\"},{\"itemId\":\"64\",\"itemName\":\"\\u7cae\\u8349\\u5c0f\\u7a9d\",\"itemDesc\":\"\\u91d1\\u79cb\\u573a\\u666f\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"9999\",\"FBPrice\":\"10\",\"setId\":\"12\"},{\"itemId\":\"11\",\"itemName\":\"\\u6625\\u65e5\\u98ce\\u8f66\\u80cc\\u666f\",\"itemDesc\":\"\\u8377\\u5170\\u8475\\u82b1\\u7cfb\\u5217\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"14499\",\"FBPrice\":\"14\",\"setId\":\"2\"},{\"itemId\":\"12\",\"itemName\":\"\\u7eff\\u9876\\u5c0f\\u6728\\u5c4b\",\"itemDesc\":\"\\u8377\\u5170\\u8475\\u82b1\\u7cfb\\u5217\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"9999\",\"FBPrice\":\"9\",\"setId\":\"2\"},{\"itemId\":\"13\",\"itemName\":\"\\u7231\\u5fc3\\u6728\\u6805\\u680f\",\"itemDesc\":\"\\u8377\\u5170\\u8475\\u82b1\\u7cfb\\u5217\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"5999\",\"FBPrice\":\"5\",\"setId\":\"2\"},{\"itemId\":\"14\",\"itemName\":\"\\u6728\\u5236\\u5c0f\\u72d7\\u7a9d\",\"itemDesc\":\"\\u8377\\u5170\\u8475\\u82b1\\u7cfb\\u5217\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"4999\",\"FBPrice\":\"4\",\"setId\":\"2\"},{\"itemId\":\"21\",\"itemName\":\"\\u6625\\u6696\\u82b1\\u5f00\\u80cc\\u666f\",\"itemDesc\":\"\\u6625\\u6696\\u82b1\\u5f00\\u5957\\u88c5\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"25999\",\"FBPrice\":\"25\",\"setId\":\"4\"},{\"itemId\":\"22\",\"itemName\":\"\\u6625\\u610f\\u5c0f\\u6728\\u5c4b\",\"itemDesc\":\"\\u6625\\u6696\\u82b1\\u5f00\\u5957\\u88c5\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"17999\",\"FBPrice\":\"17\",\"setId\":\"4\"},{\"itemId\":\"23\",\"itemName\":\"\\u79ef\\u6728\\u767d\\u6805\\u680f \",\"itemDesc\":\"\\u6625\\u6696\\u82b1\\u5f00\\u5957\\u88c5\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"10999\",\"FBPrice\":\"10\",\"setId\":\"4\"},{\"itemId\":\"24\",\"itemName\":\"\\u7eff\\u8272\\u6728\\u72d7\\u7a9d\",\"itemDesc\":\"\\u6625\\u6696\\u82b1\\u5f00\\u5957\\u88c5\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"8888\",\"FBPrice\":\"8\",\"setId\":\"4\"},{\"itemId\":\"31\",\"itemName\":\"\\u6e05\\u51c9\\u4e00\\u590f\\u80cc\\u666f\",\"itemDesc\":\"\\u590f\\u65e5\\u6d77\\u6ee9\\u5957\\u88c5\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"28888\",\"FBPrice\":\"28\",\"setId\":\"6\"},{\"itemId\":\"32\",\"itemName\":\"\\u6d77\\u6ee8\\u5ea6\\u5047\\u5c4b\",\"itemDesc\":\"\\u590f\\u65e5\\u6d77\\u6ee9\\u5957\\u88c5\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"19999\",\"FBPrice\":\"19\",\"setId\":\"6\"},{\"itemId\":\"33\",\"itemName\":\"\\u7c89\\u767d\\u6ce2\\u6d6a\\u6805\\u680f\",\"itemDesc\":\"\\u590f\\u65e5\\u6d77\\u6ee9\\u5957\\u88c5\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"11999\",\"FBPrice\":\"11\",\"setId\":\"6\"},{\"itemId\":\"34\",\"itemName\":\"\\u6d77\\u6ee8\\u5c0f\\u72d7\\u7a9d\",\"itemDesc\":\"\\u590f\\u65e5\\u6d77\\u6ee9\\u5957\\u88c5\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"9999\",\"FBPrice\":\"9\",\"setId\":\"6\"},{\"itemId\":\"36\",\"itemName\":\"\\u5730\\u4e2d\\u6d77\\u98ce\\u60c5\",\"itemDesc\":\"\\u5730\\u4e2d\\u6d77\\u98ce\\u60c5\\u5957\\u88c5\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"27888\",\"FBPrice\":\"27\",\"setId\":\"7\"},{\"itemId\":\"37\",\"itemName\":\"\\u8ff7\\u60c5\\u84dd\\u5821\",\"itemDesc\":\"\\u5730\\u4e2d\\u6d77\\u98ce\\u60c5\\u5957\\u88c5\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"18999\",\"FBPrice\":\"19\",\"setId\":\"7\"},{\"itemId\":\"38\",\"itemName\":\"\\u767d\\u6c99\\u56f4\\u5eca\",\"itemDesc\":\"\\u5730\\u4e2d\\u6d77\\u98ce\\u60c5\\u5957\\u88c5\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"11499\",\"FBPrice\":\"11\",\"setId\":\"7\"},{\"itemId\":\"39\",\"itemName\":\"\\u8d1d\\u9c81\\u7279\\u72ac\\u820d\",\"itemDesc\":\"\\u5730\\u4e2d\\u6d77\\u98ce\\u60c5\\u5957\\u88c5\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"9199\",\"FBPrice\":\"9\",\"setId\":\"7\"},{\"itemId\":\"41\",\"itemName\":\"\\u6d53\\u60c5\\u539f\\u91ce\",\"itemDesc\":\"\\u9752\\u9752\\u8349\\u539f\\u5957\\u88c5\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"24888\",\"FBPrice\":\"24\",\"setId\":\"8\"},{\"itemId\":\"42\",\"itemName\":\"\\u6e29\\u60c5\\u8499\\u53e4\\u5305\",\"itemDesc\":\"\\u9752\\u9752\\u8349\\u539f\\u5957\\u88c5\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"16999\",\"FBPrice\":\"17\",\"setId\":\"8\"},{\"itemId\":\"43\",\"itemName\":\"\\u6021\\u60c5\\u56f4\\u6be1\",\"itemDesc\":\"\\u9752\\u9752\\u8349\\u539f\\u5957\\u88c5\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"10299\",\"FBPrice\":\"10\",\"setId\":\"8\"},{\"itemId\":\"44\",\"itemName\":\"\\u98ce\\u60c5\\u7352\\u7a9d\",\"itemDesc\":\"\\u9752\\u9752\\u8349\\u539f\\u5957\\u88c5\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"8199\",\"FBPrice\":\"8\",\"setId\":\"8\"},{\"itemId\":\"46\",\"itemName\":\"\\u91d1\\u8272\\u539f\\u91ce\",\"itemDesc\":\"\\u91d1\\u8272\\u5047\\u65e5\\u5957\\u88c5\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"0\",\"FBPrice\":\"40\",\"setId\":\"9\"},{\"itemId\":\"47\",\"itemName\":\"\\u98ce\\u8f66\\u623f\\u5b50\",\"itemDesc\":\"\\u91d1\\u8272\\u5047\\u65e5\\u5957\\u88c5\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"0\",\"FBPrice\":\"28\",\"setId\":\"9\"},{\"itemId\":\"48\",\"itemName\":\"\\u539f\\u6728\\u6805\\u680f\",\"itemDesc\":\"\\u91d1\\u8272\\u5047\\u65e5\\u5957\\u88c5\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"0\",\"FBPrice\":\"17\",\"setId\":\"9\"},{\"itemId\":\"49\",\"itemName\":\"\\u539f\\u6728\\u72d7\\u7a9d\",\"itemDesc\":\"\\u91d1\\u8272\\u5047\\u65e5\\u5957\\u88c5\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"0\",\"FBPrice\":\"14\",\"setId\":\"9\"},{\"itemId\":\"51\",\"itemName\":\"\\u6708\\u8ff7\\u9b45\\u5f71\",\"itemDesc\":\"\\u54e5\\u7279\\u5f0f\\u573a\\u666f\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"23888\",\"FBPrice\":\"23\",\"setId\":\"10\"},{\"itemId\":\"52\",\"itemName\":\"\\u5e7b\\u591c\\u4fe1\\u4ef0\",\"itemDesc\":\"\\u54e5\\u7279\\u5f0f\\u573a\\u666f\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"15999\",\"FBPrice\":\"16\",\"setId\":\"10\"},{\"itemId\":\"53\",\"itemName\":\"\\u6697\\u9ed1\\u7981\\u5fcc\",\"itemDesc\":\"\\u54e5\\u7279\\u5f0f\\u573a\\u666f\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"9888\",\"FBPrice\":\"10\",\"setId\":\"10\"},{\"itemId\":\"54\",\"itemName\":\"\\u8ff7\\u8e2a\\u536b\\u58eb\",\"itemDesc\":\"\\u54e5\\u7279\\u5f0f\\u573a\\u666f\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"7888\",\"FBPrice\":\"8\",\"setId\":\"10\"},{\"itemId\":\"56\",\"itemName\":\"\\u7545\\u60f3\\u73af\\u5f62\\u5c71\",\"itemDesc\":\"\\u6708\\u7403\\u63a2\\u7d22\\u573a\\u666f\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"30888\",\"FBPrice\":\"31\",\"setId\":\"11\"},{\"itemId\":\"57\",\"itemName\":\"\\u84dd\\u7535\\u80fd\\u6e90\\u5c4b\",\"itemDesc\":\"\\u6708\\u7403\\u63a2\\u7d22\\u573a\\u666f\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"20999\",\"FBPrice\":\"21\",\"setId\":\"11\"},{\"itemId\":\"58\",\"itemName\":\"\\u956d\\u5c04\\u9632\\u5fa1\\u680f\",\"itemDesc\":\"\\u6708\\u7403\\u63a2\\u7d22\\u573a\\u666f\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"12999\",\"FBPrice\":\"13\",\"setId\":\"11\"},{\"itemId\":\"59\",\"itemName\":\"\\u96f7\\u8fbe\\u52c7\\u72ac\\u8231\",\"itemDesc\":\"\\u6708\\u7403\\u63a2\\u7d22\\u573a\\u666f\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"9999\",\"FBPrice\":\"10\",\"setId\":\"11\"},{\"itemId\":\"76\",\"itemName\":\"\\u7409\\u7483\\u5929\\u5916\\u5929\",\"itemDesc\":\"\\u4e2d\\u79cb\\u573a\\u666f\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"22999\",\"FBPrice\":\"23\",\"setId\":\"15\"},{\"itemId\":\"77\",\"itemName\":\"\\u7fd8\\u6a90\\u548c\\u6bbf\",\"itemDesc\":\"\\u4e2d\\u79cb\\u573a\\u666f\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"15999\",\"FBPrice\":\"16\",\"setId\":\"15\"},{\"itemId\":\"78\",\"itemName\":\"\\u74e6\\u7247\\u9662\\u5899\",\"itemDesc\":\"\\u4e2d\\u79cb\\u573a\\u666f\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"7999\",\"FBPrice\":\"8\",\"setId\":\"15\"},{\"itemId\":\"79\",\"itemName\":\"\\u6708\\u6842\\u72ac\\u820d\",\"itemDesc\":\"\\u4e2d\\u79cb\\u573a\\u666f\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"6999\",\"FBPrice\":\"7\",\"setId\":\"15\"},{\"itemId\":\"66\",\"itemName\":\"\\u87e0\\u9f99\\u7aef\\u4e91\\u5c71\",\"itemDesc\":\"\\u4ed9\\u57df\\u68a6\\u5883\\u573a\\u666f\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"21999\",\"FBPrice\":\"22\",\"setId\":\"13\"},{\"itemId\":\"67\",\"itemName\":\"\\u8f89\\u714c\\u91d1\\u9601\\u6bbf\",\"itemDesc\":\"\\u4ed9\\u57df\\u68a6\\u5883\\u573a\\u666f\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"14999\",\"FBPrice\":\"15\",\"setId\":\"13\"},{\"itemId\":\"68\",\"itemName\":\"\\u62a4\\u57ce\\u7ea2\\u7981\\u680f\",\"itemDesc\":\"\\u4ed9\\u57df\\u68a6\\u5883\\u573a\\u666f\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"8999\",\"FBPrice\":\"9\",\"setId\":\"13\"},{\"itemId\":\"69\",\"itemName\":\"\\u7ebf\\u9999\\u7075\\u72ac\\u5e99\",\"itemDesc\":\"\\u4ed9\\u57df\\u68a6\\u5883\\u573a\\u666f\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"7199\",\"FBPrice\":\"7\",\"setId\":\"13\"},{\"itemId\":\"71\",\"itemName\":\"\\u7eff\\u91ce\\u4ed9\\u8e2a\",\"itemDesc\":\"\\u539f\\u59cb\\u68ee\\u6797\\u5957\\u88c5\",\"itemType\":\"1\",\"itemValidTime\":\"2592000\",\"price\":\"23999\",\"FBPrice\":\"24\",\"setId\":\"14\"},{\"itemId\":\"72\",\"itemName\":\"\\u6a61\\u6811\\u6728\\u5c4b\",\"itemDesc\":\"\\u539f\\u59cb\\u68ee\\u6797\\u5957\\u88c5\",\"itemType\":\"2\",\"itemValidTime\":\"2592000\",\"price\":\"16999\",\"FBPrice\":\"17\",\"setId\":\"14\"},{\"itemId\":\"73\",\"itemName\":\"\\u8346\\u68d8\\u680f\",\"itemDesc\":\"\\u539f\\u59cb\\u68ee\\u6797\\u5957\\u88c5\",\"itemType\":\"3\",\"itemValidTime\":\"2592000\",\"price\":\"6199\",\"FBPrice\":\"6\",\"setId\":\"14\"},{\"itemId\":\"74\",\"itemName\":\"\\u5706\\u6728\\u5c0f\\u820d\",\"itemDesc\":\"\\u539f\\u59cb\\u68ee\\u6797\\u5957\\u88c5\",\"itemType\":\"4\",\"itemValidTime\":\"2592000\",\"price\":\"5199\",\"FBPrice\":\"5\",\"setId\":\"14\"}]}";
								exit( );
				}
}
if ( $_REQUEST['mod'] == "Package" && $_REQUEST['act'] == "getPackageInfo" )
{
				$query = $_SGLOBAL['db']->query( "SELECT package,fertilizer,decorative,dog,nosegay FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$package = ( array )json_decode( $list[0][package] );
				foreach ( $package as $key => $value )
				{
								if ( 0 < $value )
								{
												$packagearr[] = "{\"type\":1,\"cId\":".$key.",\"cName\":\"".$crops[$key][cName]."\",\"amount\":".$value.",\"view\":1}";
								}
				}
				$package = json_encode( $packagearr );
				$package = str_replace( "\"{", "{", $package );
				$package = str_replace( "}\"", "}", $package );
				$fertilizer = ( array )json_decode( $list[0][fertilizer] );
				foreach ( $fertilizer as $key => $value )
				{
								if ( 0 < $value && $key < 500 )
								{
												$fertilizerarr[] = "{\"type\":3,\"tId\":".$key.",\"tName\":\"".$tools[$key][tName]."\",\"amount\":".$value.",\"view\":1}";
								}
								if ( !( 0 < $value ) && !( 500 <= $key ) )
								{
												$fertilizerarr[] = "{\"type\":23,\"tId\":501,\"tName\":\"\\u72d7\\u7cae\",\"amount\":".$value.",\"view\":\"3\"}";
								}
				}
				$fertilizer = json_encode( $fertilizerarr );
				$fertilizer = str_replace( "\"{", "{", $fertilizer );
				$fertilizer = str_replace( "}\"", "}", $fertilizer );
				$decorativearr = ( array )json_decode( $list[0][decorative] );
				foreach ( $decorativearr as $itemtype => $value )
				{
								foreach ( $value as $key => $value1 )
								{
												if ( !( $value1->validtime == 0 ) || !( $_SGLOBAL['timestamp'] < $value1->validtime ) )
												{
																$decorativearr_srt[] = "{\"id\":".$key.",\"itemId\":".$key.",\"itemType\":".$itemtype.",\"itemName\":\"".$decorative[$key][itemName]."\",\"validTime\":".$value1->validtime.",\"status\":".$value1->status."}";
												}
								}
				}
				$decorative_srt = json_encode( $decorativearr_srt );
				$decorative_srt = str_replace( "\"{", "{", $decorative_srt );
				$decorative_srt = str_replace( "}\"", "}", $decorative_srt );
				$dogarr = json_decode( $list[0][dog] );
				foreach ( $dogarr as $key => $value )
				{
								if ( 0 < $value->dogFeedTime )
								{
												$dog_arr[] = "{\"id\":".$value->id.",\"dogId\":\"".$key."\",\"dogName\":\"".$dogs[$key][tName]."\",\"dogValidTime\":".$value->dogValidTime.",\"status\":".$value->status."}";
								}
				}
				$dog_arr = json_encode( $dog_arr );
				$dog_arr = str_replace( "\"{", "{", $dog_arr );
				$dog_arr = str_replace( "}\"", "}", $dog_arr );
				$nosegay = json_decode( $list[0][nosegay] );
				foreach ( $nosegay as $key => $value )
				{
								if ( 0 < $value )
								{
												$nosegay_arr[] = "{\"id\":".$key.",\"num\":".$value."}";
								}
				}
				$nosegay_arr = json_encode( $nosegay_arr );
				$nosegay_arr = str_replace( "\"{", "{", $nosegay_arr );
				$nosegay_arr = str_replace( "}\"", "}", $nosegay_arr );
				echo stripslashes( "{\"1\":".$package.",\"2\":".$decorative_srt.",\"3\":".$fertilizer.",\"4\":".$dog_arr.",\"9\":".$nosegay_arr."}" );
				exit( );
}
if ( $_REQUEST['mod'] == "friend" )
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
				//$query = $_SGLOBAL['db']->query( "SELECT uid,exp,money FROM ".tname( "plug_newfarm" )." WHERE uid IN (".$space[friend].$_SGLOBAL['supe_uid'].")" );
				$query = $_SGLOBAL['db']->query( "SELECT uid,exp,money FROM ".tname( "plug_newfarm" )." WHERE 1=1" );
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
								$friend_str[] = "{\"userId\":".$value[uid].",\"userName\":\"".unicode_encodegb( $value[name] )."\",\"headPic\":\"".avatar( $value[uid], "small", TRUE )."\",\"exp\":".$value[exp].",\"money\":".$value[money]."}";
				}
				$friend_str = json_encode( $friend_str );
				$friend_str = str_replace( "\"{", "{", $friend_str );
				$friend_str = str_replace( "}\"", "}", $friend_str );
				$friend_str = str_replace( "\\/", "\\\\/", $friend_str );
				$friend_str = str_replace( ",null,", ",", $friend_str );
				echo stripslashes( $friend_str );
				exit( );
}
if ( $_REQUEST['mod'] == "farmlandstatus" && $_REQUEST['act'] == "scarify" )
{
				$query = $_SGLOBAL['db']->query( "SELECT farmlandstatus,exp FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$farm_arr = ( array )json_decode( $list[0][farmlandstatus] );
				if ( 0 < $farm_arr[farmlandstatus][$_REQUEST['place']]->a )
				{
								echo "{\"farmlandIndex\":".$_REQUEST['place'].",\"code\":1,\"direction\":\"\",\"exp\":3,\"levelUp\":false}";
								$farm_arr[farmlandstatus][$_REQUEST['place']]->a = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->b = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->f = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->g = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->h = 1;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->i = array( );
								$farm_arr[farmlandstatus][$_REQUEST['place']]->j = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->k = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->l = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->m = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->n = "";
								$farm_arr[farmlandstatus][$_REQUEST['place']]->o = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->p = array( );
								$farm_arr[farmlandstatus][$_REQUEST['place']]->q = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->r = $_SGLOBAL['timestamp'];
								$farm_arr[farmlandstatus][$_REQUEST['place']]->s = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->t = 0;
								$farm_arr[farmlandstatus][$_REQUEST['place']]->u = 0;
								$farm_arr = json_encode( $farm_arr );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set farmlandstatus='".$farm_arr."',exp=exp+3 where uid=".$_SGLOBAL['supe_uid'] );
				}
				else
				{
								echo "{\"farmlandIndex\":".$_REQUEST['place'].",\"code\":0,\"poptype\":1,\"direction\":\"\\u5df2\\u7ecf\\u9504\\u8fc7\\u8fd9\\u5757\\u5730\\u4e86\\u54df\\uff01\"}";
				}
				include_once( S_ROOT."./source/function_cp.php" );
				$icon = "farm";
				$title_template = "{actor} 去自己的 <a href=\"newfarm.php\">农场</a> 辛勤工作了一番";
				$body_general = "锄禾日当午，汗滴禾下土，谁知盘中餐，粒粒皆辛苦！";
				feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
				exit( );
}
if ( $_REQUEST['mod'] == "shop" && $_REQUEST['act'] == "buy" && $_REQUEST['type'] == "2" )
{
				if ( strchr( $_REQUEST['id'], "," ) )
				{
								echo "{\"farmlandIndex\":1,\"code\":0,\"poptype\":1,\"direction\":\"\\u60A8\\u7684\\u7B49\\u7EA7\\u8FD8\\u4E0D\\u80FD\\u6279\\u91CF\\u8D2D\\u4E70\\uFF0C\\u4E00\\u4E2A\\u4E00\\u4E2A\\u4E70\\u5427\"}";
								exit( );
				}
				$query = $_SGLOBAL['db']->query( "SELECT money,fb,decorative FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$_fb = 0;
				$_money = 0;
				if ( $_REQUEST['useFB'] == "true" )
				{
								if ( $list[0][fb] < $decorative[$_REQUEST['id']][FBPrice] )
								{
												exit( );
								}
								$list[0][fb] = $list[0][fb] - $decorative[$_REQUEST['id']][FBPrice];
								$_fb = 0 - $decorative[$_REQUEST['id']][FBPrice];
				}
				else
				{
								if ( $list[0][money] < $decorative[$_REQUEST['id']][price] )
								{
												exit( );
								}
								$list[0][money] = $list[0][money] - $decorative[$_REQUEST['id']][price];
								$_money = 0 - $decorative[$_REQUEST['id']][price];
				}
				$decorativearr = ( array )json_decode( $list[0][decorative] );
				foreach ( $decorativearr as $itemtype => $value )
				{
								foreach ( $value as $key => $value1 )
								{
												if ( $key == $_REQUEST['id'] )
												{
																$value1->validtime = $_SGLOBAL['timestamp'] + $decorative[$_REQUEST['id']][itemValidTime];
																$decorativearr_srt = "[{\"id\":".$key.",\"itemId\":".$key.",\"itemType\":".$itemtype.",\"itemName\":\"".$decorative[$key][itemName]."\",\"validTime\":".$value1->validtime.",\"status\":".$value1->status."}]";
												}
								}
				}
				$decorativearr = json_encode( $decorativearr );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=".$list[0][money].",fb=".$list[0][fb].",decorative='".$decorativearr."' where uid=".$_SGLOBAL['supe_uid'] );
				echo stripslashes( "{\"code\":1,\"item\":".$decorativearr_srt.",\"money\":".$_money.",\"FB\":".$_fb."}" );
				exit( );
}
if ( $_REQUEST['mod'] == "item" && $_REQUEST['act'] == "activeItem" )
{
				$query = $_SGLOBAL['db']->query( "SELECT money,fb,decorative FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$decorativearr = ( array )json_decode( $list[0][decorative] );
				foreach ( $decorativearr as $itemtype => $value )
				{
								foreach ( $value as $itemid => $value1 )
								{
												if ( $itemtype == $decorative[$_REQUEST['id']][itemType] )
												{
																if ( $itemid == $_REQUEST['id'] )
																{
																				if ( $_SGLOBAL['timestamp'] < $value1->validtime || $value1->validtime == 0 )
																				{
																								$value1->status = 1;
																				}
																				else
																				{
																								exit( );
																				}
																}
																$value1->status = 0;
												}
								}
				}
				$decorativearr = json_encode( $decorativearr );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set decorative='".$decorativearr."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1,\"id\":".$_REQUEST['id']."}";
				include_once( S_ROOT."./source/function_cp.php" );
				$icon = "farm";
				$title_template = "{actor} 装饰了自己的 <a href=\"newfarm.php\">农场</a> 。";
				$body_general = "大家过来看看，我农场装饰的漂亮不？";
				feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
				exit( );
}
if ( $_REQUEST['mod'] == "shop" && $_REQUEST['act'] == "buy" && $_REQUEST['type'] == "1" )
{
				$query = $_SGLOBAL['db']->query( "SELECT money,package FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				if ( $list[0][money] < $crops[$_REQUEST['id']][price] * $_REQUEST['number'] )
				{
								exit( );
				}
				$package = json_decode( $list[0][package] );
				$package->$_REQUEST['id'] = $package->$_REQUEST['id'] + $_REQUEST['number'];
				$package = json_encode( $package );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money-".$crops[$_REQUEST['id']][price] * $_REQUEST['number'].",package='".$package."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1,\"cId\":".$_REQUEST['id'].",\"cName\":\"".$crops[$_REQUEST['id']][cName]."\",\"num\":".$_REQUEST['number'].",\"money\":-".$crops[$_REQUEST['id']][price] * $_REQUEST['number']."}";
				exit( );
}
if ( $_REQUEST['mod'] == "shop" && $_REQUEST['act'] == "buy" && $_REQUEST['type'] == "3" )
{
				$query = $_SGLOBAL['db']->query( "SELECT money,fb,fertilizer FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$_fb = 0;
				$_money = 0;
				if ( $_REQUEST['useFB'] == "true" )
				{
								$_fb = $tools[$_REQUEST['id']]['list'][1][FBPrice] * $_REQUEST['number'];
								if ( $_REQUEST['number'] == 10 )
								{
												$_fb = $tools[$_REQUEST['id']]['list'][10][FBPrice];
								}
								if ( $_REQUEST['number'] == 100 )
								{
												$_fb = $tools[$_REQUEST['id']]['list'][100][FBPrice];
								}
								if ( $list[0][fb] < $_fb )
								{
												exit( );
								}
								$list[0][fb] = $list[0][fb] - $_fb;
				}
				else
				{
								$_money = $tools[$_REQUEST['id']]['list'][1][price] * $_REQUEST['number'];
								if ( $_REQUEST['number'] == 10 )
								{
												$_money = $tools[$_REQUEST['id']]['list'][10][price];
								}
								if ( $_REQUEST['number'] == 100 )
								{
												$_money = $tools[$_REQUEST['id']]['list'][100][price];
								}
								if ( $list[0][money] < $_money )
								{
												exit( );
								}
								$list[0][money] = $list[0][money] - $_money;
				}
				$fertilizer = json_decode( $list[0][fertilizer] );
				$fertilizer->$_REQUEST['id'] = $fertilizer->$_REQUEST['id'] + $_REQUEST['number'];
				$fertilizer = json_encode( $fertilizer );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money-".$_money.",fb=fb-".$_fb.",fertilizer='".$fertilizer."' where uid=".$_SGLOBAL['supe_uid'] );
				$_fb = 0 - $_fb;
				$_money = 0 - $_money;
				echo "{\"tId\":".$_REQUEST['id'].",\"tName\":\"".$tools[$_REQUEST['id']][tName]."\",\"code\":1,\"direction\":\"\\u8d2d\\u4e70\\u6210\\u529f\\u3002\",\"num\":".$_REQUEST['number'].",\"money\":".$_money.",\"FB\":".$_fb.",\"type\":3}";
				exit( );
}
if ( $_REQUEST['mod'] == "farmlandstatus" && $_REQUEST['act'] == "planting" )
{
				$query = $_SGLOBAL['db']->query( "SELECT package,exp,farmlandstatus FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$farmarr = json_decode( $list[0][farmlandstatus] );
				$packagearr = json_decode( $list[0][package] );
				if ( $packagearr->$_REQUEST['cId'] == 0 )
				{
								exit( );
				}
				if ( $farmarr->farmlandstatus[$_REQUEST['place']]->a != 0 )
				{
								exit( );
				}
				$packagearr->$_REQUEST['cId'] = $packagearr->$_REQUEST['cId'] - 1;
				$farmarr->farmlandstatus[$_REQUEST['place']]->a = $_REQUEST['cId'];
				$farmarr->farmlandstatus[$_REQUEST['place']]->b = 6;
				$farmarr->farmlandstatus[$_REQUEST['place']]->f = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->g = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->h = 1;
				$farmarr->farmlandstatus[$_REQUEST['place']]->i = array( );
				$farmarr->farmlandstatus[$_REQUEST['place']]->j = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->k = $crops[$_REQUEST['cId']][output];
				$farmarr->farmlandstatus[$_REQUEST['place']]->l = floor( $crops[$_REQUEST['cId']][output] * 0.6 );
				if ( $farmarr->farmlandstatus[$_REQUEST['place']]->l == 0 )
				{
								$farmarr->farmlandstatus[$_REQUEST['place']]->l = 1;
				}
				$farmarr->farmlandstatus[$_REQUEST['place']]->m = $crops[$_REQUEST['cId']][output];
				$farmarr->farmlandstatus[$_REQUEST['place']]->n = "";
				$farmarr->farmlandstatus[$_REQUEST['place']]->o = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->p = array( );
				$farmarr->farmlandstatus[$_REQUEST['place']]->q = $_SGLOBAL['timestamp'];
				$farmarr->farmlandstatus[$_REQUEST['place']]->r = $_SGLOBAL['timestamp'];
				$farmarr->farmlandstatus[$_REQUEST['place']]->s = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->t = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->u = 0;
				$farmarr = json_encode( $farmarr );
				$packagearr = json_encode( $packagearr );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+2,farmlandstatus='".$farmarr."',package='".$packagearr."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"cId\":".$_REQUEST['cId'].",\"farmlandIndex\":".$_REQUEST['place'].",\"code\":1,\"poptype\":0,\"direction\":\"\",\"exp\":2,\"levelUp\":false}";
				include_once( S_ROOT."./source/function_cp.php" );
				$icon = "farm";
				$title_template = "{actor} 去自己的 <a href=\"newfarm.php\">农场</a> 辛勤工作了一番";
				$body_general = "锄禾日当午，汗滴禾下土，谁知盘中餐，粒粒皆辛苦！";
				feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
				exit( );
}
if ( $_REQUEST['mod'] == "farmlandstatus" && $_REQUEST['act'] == "fertilize" )
{
				if ( intval( $_REQUEST['ownerId'] ) == $_SGLOBAL['supe_uid'] && $_REQUEST['tId'] != "4" )
				{
								$query = $_SGLOBAL['db']->query( "SELECT fertilizer,farmlandstatus FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
								while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
								{
												$list[] = $value;
								}
								$farmarr = json_decode( $list[0][farmlandstatus] );
								$fertarr = json_decode( $list[0][fertilizer] );
								if ( $fertarr->$_REQUEST['tId'] == 0 )
								{
												exit( );
								}
								$zuowutime = $_SGLOBAL['timestamp'] - $farmarr->farmlandstatus[$_REQUEST['place']]->q;
								$ii = 0;
								foreach ( $cropstime[$farmarr->farmlandstatus[$_REQUEST['place']]->a] as $key => $value )
								{
												if ( $value <= $zuowutime )
												{
																$ii = $key + 1;
												}
								}
								if ( $farmarr->farmlandstatus[$_REQUEST['place']]->o == $ii + 1 )
								{
												exit( );
								}
								$zuowutime += $tools[$_REQUEST['tId']][effect];
								if ( $cropstime[$farmarr->farmlandstatus[$_REQUEST['place']]->a][$ii] < $zuowutime )
								{
												$zuowutime = $cropstime[$farmarr->farmlandstatus[$_REQUEST['place']]->a][$ii];
								}
								$farmarr->farmlandstatus[$_REQUEST['place']]->q = $_SGLOBAL['timestamp'] - $zuowutime;
								$farmarr->farmlandstatus[$_REQUEST['place']]->o = $ii + 1;
								$fertarr = $_REQUEST['tId'];
								$farmarr_str = json_encode( $farmarr );
								$fertarr = json_encode( $fertarr );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set farmlandstatus='".$farmarr_str."',fertilizer='".$fertarr."' where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"farmlandIndex\":".$_REQUEST['place'].",\"code\":1,\"tId\":".$_REQUEST['tId'].",\"status\":{\"cId\":".$farmarr->farmlandstatus[$_REQUEST['place']]->a.",\"cropStatus\":".$farmarr->farmlandstatus[$_REQUEST['place']]->b.",\"weed\":".$farmarr->farmlandstatus[$_REQUEST['place']]->f.",\"pest\":".$farmarr->farmlandstatus[$_REQUEST['place']]->g.",\"humidity\":".$farmarr->farmlandstatus[$_REQUEST['place']]->h.",\"killer\":".json_encode( $farmarr->farmlandstatus[$_REQUEST['place']]->i ).",\"harvestTimes\":".$farmarr->farmlandstatus[$_REQUEST['place']]->j.",\"output\":".$farmarr->farmlandstatus[$_REQUEST['place']]->k.",\"min\":".$farmarr->farmlandstatus[$_REQUEST['place']]->l.",\"leavings\":".$farmarr->farmlandstatus[$_REQUEST['place']]->m.",\"thief\":2,\"fertilize\":".$farmarr->farmlandstatus[$_REQUEST['place']]->o.",\"action\":".json_encode( $farmarr->farmlandstatus[$_REQUEST['place']]->p ).",\"plantTime\":".$farmarr->farmlandstatus[$_REQUEST['place']]->q.",\"updateTime\":".$farmarr->farmlandstatus[$_REQUEST['place']]->r.",\"pId\":".$farmarr->farmlandstatus[$_REQUEST['place']]->s.",\"nph\":".$farmarr->farmlandstatus[$_REQUEST['place']]->t.",\"mph\":".$farmarr->farmlandstatus[$_REQUEST['place']]->u."}}";
								include_once( S_ROOT."./source/function_cp.php" );
								$icon = "farm";
								$title_template = "{actor} 去自己的 <a href=\"newfarm.php\">农场</a> 辛勤工作了一番";
								$body_general = "锄禾日当午，汗滴禾下土，谁知盘中餐，粒粒皆辛苦！";
								feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
								exit( );
				}
				if ( !( intval( $_REQUEST['ownerId'] ) != $_SGLOBAL['supe_uid'] ) && !( $_REQUEST['tId'] == "4" ) )
				{
								exit( );
				}
}
if ( $_REQUEST['mod'] == "repertory" && $_REQUEST['act'] == "getUserCrop" )
{
				$fruit = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT fruit FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$fruit = ( array )json_decode( $fruit );
				$fruitarr = array( );
				foreach ( $fruit as $key => $value )
				{
								if ( 0 < $value )
								{
												$fruitarr[] = "{\"cId\":".$key.",\"cType\":".$crops[$key][cType].",\"cName\":\"".$crops[$key][cName]."\",\"amount\":".$value.",\"price\":\"".$crops[$key][sale]."\"}";
								}
				}
				$fruitarr = json_encode( $fruitarr );
				$fruitarr = str_replace( "\"{", "{", $fruitarr );
				$fruitarr = str_replace( "}\"", "}", $fruitarr );
				echo stripslashes( $fruitarr );
}
if ( $_REQUEST['mod'] == "farmlandstatus" && $_REQUEST['act'] == "harvest" )
{
				$query = $_SGLOBAL['db']->query( "SELECT fruit,farmlandstatus,nosegay FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$farmarr = json_decode( $list[0][farmlandstatus] );
				$fruitarr = json_decode( $list[0][fruit] );
				$nosegayarr = json_decode( $list[0][nosegay] );
				$cid = $farmarr->farmlandstatus[$_REQUEST['place']]->a;
				if ( 2000 < $cid )
				{
								$nosegayarr->$cid = $nosegayarr->$cid + $farmarr->farmlandstatus[$_REQUEST['place']]->m;
				}
				else
				{
								$fruitarr->$cid = $fruitarr->$cid + $farmarr->farmlandstatus[$_REQUEST['place']]->m;
				}
				$charm = 0;
				if ( 100 < $cid )
				{
								$charm = $crops[$cid][cropChr];
				}
				$harvest = $farmarr->farmlandstatus[$_REQUEST['place']]->m;
				$farmarr->farmlandstatus[$_REQUEST['place']]->f = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->g = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->h = 1;
				$farmarr->farmlandstatus[$_REQUEST['place']]->i = array( );
				$farmarr->farmlandstatus[$_REQUEST['place']]->n = "";
				$farmarr->farmlandstatus[$_REQUEST['place']]->o = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->p = array( );
				$farmarr->farmlandstatus[$_REQUEST['place']]->r = $_SGLOBAL['timestamp'];
				$farmarr->farmlandstatus[$_REQUEST['place']]->s = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->t = 0;
				$farmarr->farmlandstatus[$_REQUEST['place']]->u = 0;
				if ( $farmarr->farmlandstatus[$_REQUEST['place']]->j + 1 == $crops[$farmarr->farmlandstatus[$_REQUEST['place']]->a][maturingTime] )
				{
								$farmarr->farmlandstatus[$_REQUEST['place']]->b = 7;
								$farmarr->farmlandstatus[$_REQUEST['place']]->j = 0;
								$farmarr->farmlandstatus[$_REQUEST['place']]->q = 0;
								$farmarr->farmlandstatus[$_REQUEST['place']]->k = 0;
								$farmarr->farmlandstatus[$_REQUEST['place']]->l = 0;
								$farmarr->farmlandstatus[$_REQUEST['place']]->m = 0;
				}
				else
				{
								$farmarr->farmlandstatus[$_REQUEST['place']]->b = 6;
								$farmarr->farmlandstatus[$_REQUEST['place']]->j = $farmarr->farmlandstatus[$_REQUEST['place']]->j + 1;
								$farmarr->farmlandstatus[$_REQUEST['place']]->q = $_SGLOBAL['timestamp'] - $cropstime[$farmarr->farmlandstatus[$_REQUEST['place']]->a][2];
								$farmarr->farmlandstatus[$_REQUEST['place']]->k = $crops[$farmarr->farmlandstatus[$_REQUEST['place']]->a][output];
								$farmarr->farmlandstatus[$_REQUEST['place']]->l = floor( $crops[$farmarr->farmlandstatus[$_REQUEST['place']]->a][output] * 0.6 );
								$farmarr->farmlandstatus[$_REQUEST['place']]->m = $crops[$farmarr->farmlandstatus[$_REQUEST['place']]->a][output];
				}
				$farmarr_str = json_encode( $farmarr );
				$fruitarr = json_encode( $fruitarr );
				$nosegayarr = json_encode( $nosegayarr );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set charm=charm+".$charm.",exp=exp+".$crops[$farmarr->farmlandstatus[$_REQUEST['place']]->a][cropExp].",farmlandstatus='".$farmarr_str."',fruit='".$fruitarr."',nosegay='".$nosegayarr."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"farmlandIndex\":".$_REQUEST['place'].",\"code\":1,\"poptype\":4,\"direction\":\"\",\"harvest\":".$harvest.",\"exp\":".$crops[$farmarr->farmlandstatus[$_REQUEST['place']]->a][cropExp].",\"levelUp\":false,\"charm\":\"".$charm."\",\"status\":{\"cId\":".$farmarr->farmlandstatus[$_REQUEST['place']]->a.",\"cropStatus\":".$farmarr->farmlandstatus[$_REQUEST['place']]->b.",\"weed\":".$farmarr->farmlandstatus[$_REQUEST['place']]->f.",\"pest\":".$farmarr->farmlandstatus[$_REQUEST['place']]->g.",\"humidity\":".$farmarr->farmlandstatus[$_REQUEST['place']]->h.",\"killer\":".json_encode( $farmarr->farmlandstatus[$_REQUEST['place']]->i ).",\"harvestTimes\":".$farmarr->farmlandstatus[$_REQUEST['place']]->j.",\"output\":".$farmarr->farmlandstatus[$_REQUEST['place']]->k.",\"min\":".$farmarr->farmlandstatus[$_REQUEST['place']]->l.",\"leavings\":".$farmarr->farmlandstatus[$_REQUEST['place']]->m.",\"thief\":2,\"fertilize\":".$farmarr->farmlandstatus[$_REQUEST['place']]->o.",\"action\":".json_encode( $farmarr->farmlandstatus[$_REQUEST['place']]->p ).",\"plantTime\":".$farmarr->farmlandstatus[$_REQUEST['place']]->q.",\"updateTime\":".$farmarr->farmlandstatus[$_REQUEST['place']]->r.",\"pId\":".$farmarr->farmlandstatus[$_REQUEST['place']]->s.",\"nph\":".$farmarr->farmlandstatus[$_REQUEST['place']]->t.",\"mph\":".$farmarr->farmlandstatus[$_REQUEST['place']]->u."}}";
				include_once( S_ROOT."./source/function_cp.php" );
				$icon = "farm";
				$title_template = "{actor} 去自己的 <a href=\"newfarm.php\">农场</a> 辛勤工作了一番";
				$body_general = "锄禾日当午，汗滴禾下土，谁知盘中餐，粒粒皆辛苦！";
				feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
				exit( );
}
if ( $_REQUEST['mod'] == "farmlandstatus" && $_REQUEST['act'] == "scrounge" )
{
				$farm = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT farmlandstatus FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['ownerId'] ) ), 0 );
				$fruit = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT fruit FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$farmarr = json_decode( $farm );
				$fruitarr = json_decode( $fruit );
				if ( stristr( $farmarr->farmlandstatus[$_REQUEST['place']]->n, ",".$_SGLOBAL['supe_uid']."," ) )
				{
								exit( );
				}
				$cid = $farmarr->farmlandstatus[$_REQUEST['place']]->a;
				$fruitarr->$cid = $fruitarr->$cid + 1;
				$farmarr->farmlandstatus[$_REQUEST['place']]->m = $farmarr->farmlandstatus[$_REQUEST['place']]->m - 1;
				if ( $farmarr->farmlandstatus[$_REQUEST['place']]->m < $farmarr->farmlandstatus[$_REQUEST['place']]->l )
				{
								exit( );
				}
				$farmarr->farmlandstatus[$_REQUEST['place']]->n = $farmarr->farmlandstatus[$_REQUEST['place']]->n.",".$_SGLOBAL['supe_uid'].",";
				$farmarr_str = json_encode( $farmarr );
				$fruitarr = json_encode( $fruitarr );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set farmlandstatus='".$farmarr_str."' where uid=".intval( $_REQUEST['ownerId'] ) );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set fruit='".$fruitarr."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"farmlandIndex\":".$_REQUEST['place'].",\"code\":1,\"poptype\":4,\"direction\":\"\",\"harvest\":1,\"status\":{\"cId\":".$farmarr->farmlandstatus[$_REQUEST['place']]->a.",\"cropStatus\":".$farmarr->farmlandstatus[$_REQUEST['place']]->b.",\"weed\":".$farmarr->farmlandstatus[$_REQUEST['place']]->f.",\"pest\":".$farmarr->farmlandstatus[$_REQUEST['place']]->g.",\"humidity\":".$farmarr->farmlandstatus[$_REQUEST['place']]->h.",\"killer\":".json_encode( $farmarr->farmlandstatus[$_REQUEST['place']]->i ).",\"harvestTimes\":".$farmarr->farmlandstatus[$_REQUEST['place']]->j.",\"output\":".$farmarr->farmlandstatus[$_REQUEST['place']]->k.",\"min\":".$farmarr->farmlandstatus[$_REQUEST['place']]->l.",\"leavings\":".$farmarr->farmlandstatus[$_REQUEST['place']]->m.",\"thief\":1,\"fertilize\":".$farmarr->farmlandstatus[$_REQUEST['place']]->o.",\"action\":".json_encode( $farmarr->farmlandstatus[$_REQUEST['place']]->p ).",\"plantTime\":".$farmarr->farmlandstatus[$_REQUEST['place']]->q.",\"updateTime\":".$farmarr->farmlandstatus[$_REQUEST['place']]->r.",\"pId\":".$farmarr->farmlandstatus[$_REQUEST['place']]->s.",\"nph\":".$farmarr->farmlandstatus[$_REQUEST['place']]->t.",\"mph\":".$farmarr->farmlandstatus[$_REQUEST['place']]->u."}}";
				include_once( S_ROOT."./source/function_cp.php" );
				$icon = "farm";
				$title_template = "{actor}去{touser}的 <a href=\"newfarm.php\">农场</a> 好好洗劫了一番，收获不小！";
				$touserspace = getspace( intval( $_REQUEST['ownerId'] ) );
				if ( empty( $touserspace[name] ) )
				{
								$touserspace[name] = $touserspace[username];
				}
				$title_data = array(
								"touser" => "<a href=\"space.php?uid=".intval( $_REQUEST['ownerId'] )."\">".$touserspace[name]."</a>"
				);
				$body_general = "我们是害虫，我们是害虫，正义的敌人、正义的敌人！";
				feed_add( $icon, $title_template, $title_data, NULL, NULL, NULL );
				exit( );
}
if ( $_REQUEST['mod'] == "repertory" && $_REQUEST['act'] == "sale" )
{
				$fruit = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT fruit FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$fruitarr = json_decode( $fruit );
				if ( $fruitarr->$_REQUEST['cId'] < $_REQUEST['number'] )
				{
								exit( );
				}
				$fruitarr->$_REQUEST['cId'] = $fruitarr->$_REQUEST['cId'] - $_REQUEST['number'];
				$fruitarr = json_encode( $fruitarr );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money+".$crops[$_REQUEST['cId']][sale] * $_REQUEST['number'].",fruit='".$fruitarr."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"cId\":".$_REQUEST['cId'].",\"code\":1,\"direction\":\"\\u6210\\u529f\\u5356\\u51fa<font color=\\\"#0099FF\\\"> <b>".$_REQUEST['number']."<\\/b> <\\/font>\\u4e2a".$crops[$_REQUEST['cId']][cName]."\\uff0c\\u5f97\\u5230\\u91d1\\u5e01<font color=\\\"#FF6600\\\"> <b>".$crops[$_REQUEST['cId']][sale] * $_REQUEST['number']."<\\/b> <\\/font>\",\"money\":".$crops[$_REQUEST['cId']][sale] * $_REQUEST['number']."}";
				include_once( S_ROOT."./source/function_cp.php" );
				$icon = "farm";
				$title_template = "{actor} 去自己的 <a href=\"newfarm.php\">农场</a> 辛勤工作了一番";
				$body_general = "锄禾日当午，汗滴禾下土，谁知盘中餐，粒粒皆辛苦！";
				feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
				exit( );
}
if ( $_REQUEST['mod'] == "repertory" && $_REQUEST['act'] == "saleAll" )
{
				if ( $_REQUEST['type'] == "1" )
				{
								$fruit = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT fruit FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
								$fruitarr = json_decode( $fruit );
								$money = 0;
								foreach ( $fruitarr as $key => $value )
								{
												if ( !( 0 < $value ) && !( $crops[$key][cType] == 1 ) )
												{
																$money += $crops[$key][sale] * $value;
																$fruitarr->$key = 0;
												}
								}
								$fruitarr = json_encode( $fruitarr );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money+".$money.",fruit='".$fruitarr."' where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"code\":1,\"direction\":\"\",\"money\":".$money."}";
								include_once( S_ROOT."./source/function_cp.php" );
								$icon = "farm";
								$title_template = "{actor} 去自己的 <a href=\"newfarm.php\">农场</a> 辛勤工作了一番";
								$body_general = "锄禾日当午，汗滴禾下土，谁知盘中餐，粒粒皆辛苦！";
								feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
								exit( );
				}
				if ( $_REQUEST['type'] == "2" )
				{
								$fruit = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT fruit FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
								$fruitarr = json_decode( $fruit );
								$money = 0;
								foreach ( $fruitarr as $key => $value )
								{
												if ( !( 0 < $value ) && !( $crops[$key][cType] == 2 ) )
												{
																$money += $crops[$key][sale] * $value;
																$fruitarr->$key = 0;
												}
								}
								$fruitarr = json_encode( $fruitarr );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money+".$money.",fruit='".$fruitarr."' where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"code\":1,\"direction\":\"\",\"money\":".$money."}";
								include_once( S_ROOT."./source/function_cp.php" );
								$icon = "farm";
								$title_template = "{actor} 去自己的 <a href=\"newfarm.php\">农场</a> 辛勤工作了一番";
								$body_general = "锄禾日当午，汗滴禾下土，谁知盘中餐，粒粒皆辛苦！";
								feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
								exit( );
				}
}
if ( $_REQUEST['mod'] == "farmlandstatus" && $_REQUEST['act'] == "clearWeed" )
{
				$farm = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT farmlandstatus FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['ownerId'] ) ), 0 );
				$farm = json_decode( $farm );
				if ( $farm->farmlandstatus[$_REQUEST['place']]->f == 0 )
				{
								exit( );
				}
				$farm->farmlandstatus[$_REQUEST['place']]->f = $farm->farmlandstatus[$_REQUEST['place']]->f - 1;
				$farm_srt = json_encode( $farm );
				if ( intval( $_REQUEST['ownerId'] ) == $_SGLOBAL['supe_uid'] )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money+2,exp=exp+2,farmlandstatus='".$farm_srt."' where uid=".$_SGLOBAL['supe_uid'] );
								$direction = "";
								include_once( S_ROOT."./source/function_cp.php" );
								$icon = "farm";
								$title_template = "{actor} 去自己的 <a href=\"newfarm.php\">农场</a> 辛勤工作了一番";
								$body_general = "锄禾日当午，汗滴禾下土，谁知盘中餐，粒粒皆辛苦！";
								feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
				}
				else
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set farmlandstatus='".$farm_srt."' where uid=".intval( $_REQUEST['ownerId'] ) );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money+2,exp=exp+2 where uid=".$_SGLOBAL['supe_uid'] );
								$direction = "\\u8c22\\u8c22\\u4f60\\uff0c\\u6742\\u8349\\u6e05\\u9664\\u5e72\\u51c0\\u4e86\\uff01";
								include_once( S_ROOT."./source/function_cp.php" );
								$icon = "farm";
								$title_template = "{actor} 去 {touser} 的 <a href=\"newfarm.php\">农场</a> 帮忙。！";
								$touserspace = getspace( intval( $_REQUEST['ownerId'] ) );
								if ( empty( $touserspace[name] ) )
								{
												$touserspace[name] = $touserspace[username];
								}
								$title_data = array(
												"touser" => "<a href=\"space.php?uid=".intval( $_REQUEST['ownerId'] )."\">".$touserspace[name]."</a>"
								);
								$body_general = "我为人人，人人为我！";
								feed_add( $icon, $title_template, $title_data, NULL, NULL, NULL );
				}
				echo "{\"tId\":0,\"farmlandIndex\":".$_REQUEST['place'].",\"code\":1,\"poptype\":1,\"direction\":\"".$direction."\",\"money\":2,\"exp\":2,\"levelUp\":false,\"humidity\":".$farm->farmlandstatus[$_REQUEST['place']]->h.",\"pest\":".$farm->farmlandstatus[$_REQUEST['place']]->g.",\"weed\":".$farm->farmlandstatus[$_REQUEST['place']]->f.",\"pId\":".$farm->farmlandstatus[$_REQUEST['place']]->s.",\"nph\":".$farm->farmlandstatus[$_REQUEST['place']]->t.",\"mph\":".$farm->farmlandstatus[$_REQUEST['place']]->u.",\"killer\":[]}";
}
if ( $_REQUEST['mod'] == "farmlandstatus" && $_REQUEST['act'] == "spraying" )
{
				$farm = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT farmlandstatus FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['ownerId'] ) ), 0 );
				$farm = json_decode( $farm );
				if ( $farm->farmlandstatus[$_REQUEST['place']]->g == 0 )
				{
								exit( );
				}
				$farm->farmlandstatus[$_REQUEST['place']]->g = $farm->farmlandstatus[$_REQUEST['place']]->g - 1;
				$farm_srt = json_encode( $farm );
				if ( intval( $_REQUEST['ownerId'] ) == $_SGLOBAL['supe_uid'] )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money+2,exp=exp+2,farmlandstatus='".$farm_srt."' where uid=".$_SGLOBAL['supe_uid'] );
								$direction = "";
								include_once( S_ROOT."./source/function_cp.php" );
								$icon = "farm";
								$title_template = "{actor} 去自己的 <a href=\"newfarm.php\">农场</a> 辛勤工作了一番";
								$body_general = "锄禾日当午，汗滴禾下土，谁知盘中餐，粒粒皆辛苦！";
								feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
				}
				else
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set farmlandstatus='".$farm_srt."' where uid=".intval( $_REQUEST['ownerId'] ) );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money+2,exp=exp+2 where uid=".$_SGLOBAL['supe_uid'] );
								$direction = "\\u8c22\\u8c22\\u4f60\\uff0c\\u5bb3\\u866b\\u6e05\\u9664\\u5e72\\u51c0\\u4e86\\uff01";
								include_once( S_ROOT."./source/function_cp.php" );
								$icon = "farm";
								$title_template = "{actor} 去 {touser} 的 <a href=\"newfarm.php\">农场</a> 帮忙。！";
								$touserspace = getspace( intval( $_REQUEST['ownerId'] ) );
								if ( empty( $touserspace[name] ) )
								{
												$touserspace[name] = $touserspace[username];
								}
								$title_data = array(
												"touser" => "<a href=\"space.php?uid=".intval( $_REQUEST['ownerId'] )."\">".$touserspace[name]."</a>"
								);
								$body_general = "我为人人，人人为我！";
								feed_add( $icon, $title_template, $title_data, NULL, NULL, NULL );
				}
				echo "{\"tId\":0,\"farmlandIndex\":".$_REQUEST['place'].",\"code\":1,\"poptype\":1,\"direction\":\"".$direction."\",\"money\":2,\"exp\":2,\"levelUp\":false,\"humidity\":".$farm->farmlandstatus[$_REQUEST['place']]->h.",\"pest\":".$farm->farmlandstatus[$_REQUEST['place']]->g.",\"weed\":".$farm->farmlandstatus[$_REQUEST['place']]->f.",\"pId\":".$farm->farmlandstatus[$_REQUEST['place']]->s.",\"nph\":".$farm->farmlandstatus[$_REQUEST['place']]->t.",\"mph\":".$farm->farmlandstatus[$_REQUEST['place']]->u.",\"killer\":[]}";
}
if ( $_REQUEST['mod'] == "farmlandstatus" && $_REQUEST['act'] == "water" )
{
				$farm = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT farmlandstatus FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['ownerId'] ) ), 0 );
				$farm = json_decode( $farm );
				if ( $farm->farmlandstatus[$_REQUEST['place']]->h == 1 )
				{
								exit( );
				}
				$farm->farmlandstatus[$_REQUEST['place']]->h = 1;
				$farm_srt = json_encode( $farm );
				if ( intval( $_REQUEST['ownerId'] ) == $_SGLOBAL['supe_uid'] )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money+2,exp=exp+2,farmlandstatus='".$farm_srt."' where uid=".$_SGLOBAL['supe_uid'] );
								$direction = "";
								include_once( S_ROOT."./source/function_cp.php" );
								$icon = "farm";
								$title_template = "{actor} 去自己的 <a href=\"newfarm.php\">农场</a> 辛勤工作了一番";
								$body_general = "锄禾日当午，汗滴禾下土，谁知盘中餐，粒粒皆辛苦！";
								feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
				}
				else
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set farmlandstatus='".$farm_srt."' where uid=".intval( $_REQUEST['ownerId'] ) );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set money=money+2,exp=exp+2 where uid=".$_SGLOBAL['supe_uid'] );
								$direction = "\\u8c22\\u8c22\\u5e2e\\u5fd9\\uff0c\\u4f60\\u771f\\u662f\\u4e2a\\u597d\\u4eba\\uff01";
								include_once( S_ROOT."./source/function_cp.php" );
								$icon = "farm";
								$title_template = "{actor} 去 {touser} 的 <a href=\"newfarm.php\">农场</a> 帮忙。！";
								$touserspace = getspace( intval( $_REQUEST['ownerId'] ) );
								if ( empty( $touserspace[name] ) )
								{
												$touserspace[name] = $touserspace[username];
								}
								$title_data = array(
												"touser" => "<a href=\"space.php?uid=".intval( $_REQUEST['ownerId'] )."\">".$touserspace[name]."</a>"
								);
								$body_general = "我为人人，人人为我！";
								feed_add( $icon, $title_template, $title_data, NULL, NULL, NULL );
				}
				echo "{\"tId\":0,\"farmlandIndex\":".$_REQUEST['place'].",\"code\":1,\"poptype\":1,\"direction\":\"".$direction."\",\"money\":2,\"exp\":2,\"levelUp\":false,\"humidity\":".$farm->farmlandstatus[$_REQUEST['place']]->h.",\"pest\":".$farm->farmlandstatus[$_REQUEST['place']]->g.",\"weed\":".$farm->farmlandstatus[$_REQUEST['place']]->f.",\"pId\":".$farm->farmlandstatus[$_REQUEST['place']]->s.",\"nph\":".$farm->farmlandstatus[$_REQUEST['place']]->t.",\"mph\":".$farm->farmlandstatus[$_REQUEST['place']]->u.",\"killer\":[]}";
}
if ( $_REQUEST['mod'] == "shop" && $_REQUEST['act'] == "buy" && $_REQUEST['type'] == "4" )
{
				$query = $_SGLOBAL['db']->query( "SELECT dog,fertilizer,fb FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				if ( $list[0][fb] < $dogs[$_REQUEST['id']]['list'][1][FBPrice] )
				{
								exit( );
				}
				$dog = json_decode( $list[0][dog] );
				$fertilizerarr = json_decode( $list[0][fertilizer] );
				$dog->$_REQUEST['id']->dogFeedTime = $_SGLOBAL['timestamp'] + 172800;
				foreach ( $dog as $key => $value )
				{
								if ( $key == $_REQUEST['id'] )
								{
												$value->status = 1;
								}
								else
								{
												$value->status = 0;
								}
				}
				$gouliang = 501;
				$fertilizerarr->$gouliang = $fertilizerarr->$gouliang + $dogs[$_REQUEST['id']]['list'][1][gouliang];
				$fertilizerarr_srt = json_encode( $fertilizerarr );
				$dog_srt = json_encode( $dog );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set fb=fb-".$dogs[$_REQUEST['id']]['list'][1][FBPrice].",dog='".$dog_srt."',fertilizer='".$fertilizerarr_srt."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1,\"id\":".$dog->$_REQUEST['id']->id.",\"dogName\":\"".$dogs[$_REQUEST['id']][tName]."\",\"userDog\":{\"dogId\":\"".$_REQUEST['id']."\",\"dogValidTime\":".$dog->$_REQUEST['id']->dogValidTime.",\"dogFeedTime\":".$dog->$_REQUEST['id']->dogValidTime.",\"dogUnWorkTime\":0},\"direction\":\"\\u8d2d\\u4e70\\u6210\\u529f\\u3002\",\"money\":0,\"FB\":-".$dogs[$_REQUEST['id']]['list'][1][FBPrice].",\"type\":4,\"item\":{\"eType\":3,\"eParam\":501,\"eNum\":".$dogs[$_REQUEST['id']]['list'][1][gouliang].",\"name\":\"\\u72d7\\u7cae\"}}";
				include_once( S_ROOT."./source/function_cp.php" );
				$icon = "farm";
				$title_template = "{actor} 在自己的 <a href=\"newfarm.php\">农场</a> 放了一条旺财，嘿嘿！";
				$body_general = "我让你们知道什么叫肉包子打旺财，有去无回！";
				feed_add( $icon, $title_template, NULL, NULL, NULL, NULL );
				exit( );
}
if ( $_REQUEST['mod'] == "dog" && $_REQUEST['act'] == "changeDog" )
{
				$dog = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT dog FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$dog = json_decode( $dog );
				foreach ( $dog as $key => $value )
				{
								if ( $value->id == $_REQUEST['id'] )
								{
												if ( $value->status == 1 )
												{
																$value->status = 0;
																$dog_echo = "{\"code\":1,\"id\":".$value->id.",\"userDog\":{\"dogId\":0,\"dogValidTime\":0,\"dogFeedTime\":".$value->dogFeedTime.",\"dogUnWorkTime\":0}}";
												}
												else
												{
																$value->status = 1;
																$dog_echo = "{\"code\":1,\"id\":".$value->id.",\"userDog\":{\"dogId\":".$key.",\"dogValidTime\":0,\"dogFeedTime\":".$value->dogFeedTime.",\"dogUnWorkTime\":0}}";
												}
								}
								else
								{
												$value->status = 0;
								}
				}
				$dog_srt = json_encode( $dog );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set dog='".$dog_srt."' where uid=".$_SGLOBAL['supe_uid'] );
				echo $dog_echo;
				exit( );
}
if ( $_REQUEST['mod'] == "Nosegay" && $_REQUEST['act'] == "makeDogFood" )
{
				$query = $_SGLOBAL['db']->query( "SELECT fruit,fertilizer FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$fruit = json_decode( $list[0][fruit] );
				$cIds = explode( ",", $_REQUEST['cIds'] );
				foreach ( $cIds as $key => $value )
				{
								if ( $fruit->$value < 3 )
								{
												exit( );
								}
								$fruit->$value = $fruit->$value - 3;
				}
				$fertilizer = json_decode( $list[0][fertilizer] );
				$gouliang = 501;
				$fertilizer->$gouliang = $fertilizer->$gouliang + 2;
				$fruit = json_encode( $fruit );
				$fertilizer = json_encode( $fertilizer );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set fruit='".$fruit."',fertilizer='".$fertilizer."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1,\"cIds\":[".$_REQUEST['cIds']."],\"item\":{\"tId\":501,\"tName\":\"\\u72d7\\u7cae\",\"num\":2,\"type\":5}}";
				exit( );
}
if ( $_REQUEST['mod'] == "Nosegay" && $_REQUEST['act'] == "makeToySeed" )
{
				$query = $_SGLOBAL['db']->query( "SELECT fruit,package FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$fruit = json_decode( $list[0][fruit] );
				$cIds = explode( ",", $_REQUEST['cIds'] );
				foreach ( $cIds as $key => $value )
				{
								if ( $fruit->$value < 15 )
								{
												exit( );
								}
								$fruit->$value = $fruit->$value - 15;
				}
				$toyid = mt_rand( 2001, 2003 );
				$package = json_decode( $list[0][package] );
				$package->$toyid = $package->$toyid + 1;
				$fruit = json_encode( $fruit );
				$package = json_encode( $package );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set fruit='".$fruit."',package='".$package."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1,\"cIds\":[".$_REQUEST['cIds']."],\"item\":{\"cId\":".$toyid.",\"tName\":\"\\u795e\\u79d8\\u73a9\\u5177 \\u79cd\\u5b50\",\"num\":1,\"type\":3}}";
				exit( );
}
if ( $_REQUEST['mod'] == "Nosegay" && $_REQUEST['act'] == "makeNosegay" )
{
				if ( 3000 < $_REQUEST['id'] )
				{
								$GLOBALS['_REQUEST']['cIds'] = "4,7,10,15,13";
								$query = $_SGLOBAL['db']->query( "SELECT fruit,nosegay FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
								while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
								{
												$list[] = $value;
								}
								$fruit = json_decode( $list[0][fruit] );
								$cIds = explode( ",", $_REQUEST['cIds'] );
								foreach ( $cIds as $key => $value )
								{
												if ( $fruit->$value < 15 )
												{
																exit( );
												}
												$fruit->$value = $fruit->$value - 15;
								}
								$mooncakeid = mt_rand( 3001, 3005 );
								$nosegay = json_decode( $list[0][nosegay] );
								$nosegay->$mooncakeid = $nosegay->$mooncakeid + 1;
								$fruit = json_encode( $fruit );
								$nosegay = json_encode( $nosegay );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set fruit='".$fruit."',nosegay='".$nosegay."',charm=charm+20 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"code\":1,\"id\":".$mooncakeid.",\"charm\":20,\"direction\":\"\"}";
								exit( );
				}
				$query = $_SGLOBAL['db']->query( "SELECT fruit,nosegay FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				$fruit = json_decode( $list[0][fruit] );
				if ( $fruit->$makenosegay[$_REQUEST['id']][cid] < $makenosegay[$_REQUEST['id']][neednum] )
				{
								exit( );
				}
				$nosegay = json_decode( $list[0][nosegay] );
				$fruit->$makenosegay[$_REQUEST['id']][cid] = $fruit->$makenosegay[$_REQUEST['id']][cid] - $makenosegay[$_REQUEST['id']][neednum];
				$nosegay->$_REQUEST['id'] = $nosegay->$_REQUEST['id'] + 1;
				$fruit = json_encode( $fruit );
				$nosegay = json_encode( $nosegay );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set fruit='".$fruit."',nosegay='".$nosegay."',charm=charm+".$makenosegay[$_REQUEST['id']][charm]." where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1,\"id\":\"".$_REQUEST['id']."\",\"direction\":\"\"}";
				exit( );
}
if ( $_REQUEST['mod'] == "message" && $_REQUEST['act'] == "getList" )
{
				$message = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT message FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$message = json_decode( $message );
				foreach ( $message->c as $key => $value )
				{
								$messagetype3[] = "{\"id\":".$value->id.",\"sendTime\":".$value->sendTime.",\"status\":".$value->status."}";
				}
				$messagetype3 = json_encode( $messagetype3 );
				$messagetype3 = str_replace( "\"{", "{", $messagetype3 );
				$messagetype3 = str_replace( "}\"", "}", $messagetype3 );
				foreach ( $message->d as $key => $value )
				{
								$messagetype4[] = "{\"id\":".$value->id.",\"fromId\":".$value->fromId.",\"fName\":\"".str_ireplace( "\\u", "\\\\u", $value->name )."\",\"sendTime\":".$value->sendTime.",\"validTime\":".$value->validTime."}";
				}
				$messagetype4 = json_encode( $messagetype4 );
				$messagetype4 = str_replace( "\"{", "{", $messagetype4 );
				$messagetype4 = str_replace( "}\"", "}", $messagetype4 );
				foreach ( $message->e as $key => $value )
				{
								if ( $value->status == 0 )
								{
												$messagetype5[] = "{\"id\":".$value->id.",\"fromId\":".$value->friendId.",\"fName\":\"".$value->fName."\",\"sendTime\":".$value->sendTime.",\"validTime\":".$value->validTime."}";
								}
				}
				$messagetype5 = json_encode( $messagetype5 );
				$messagetype5 = str_replace( "\"{", "{", $messagetype5 );
				$messagetype5 = str_replace( "}\"", "}", $messagetype5 );
				$result = "{\"1\":[],\"2\":[],\"3\":".$messagetype3.",\"4\":".$messagetype4.",\"5\":".$messagetype5."}";
				echo stripslashes( str_ireplace( "null", "[]", $result ) );
				exit( );
}
if ( $_REQUEST['mod'] == "message" && $_REQUEST['act'] == "openMessage" && $_REQUEST['type'] == "3" )
{
				$message = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT message FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$message = json_decode( $message );
				$writesql = 0;
				foreach ( $message->c as $key => $value )
				{
								if ( $_REQUEST['id'] == $value->sendTime )
								{
												if ( $value->status == 0 )
												{
																$writesql = 1;
																$value->status = 1;
												}
												$messagetype3 = "{\"fromId\":\"".$value->fromId."\",\"sendTime\":".$value->sendTime.",\"eDesc\":\"".$value->eDesc."\",\"status\":".$value->status.",\"id\":".$value->id.",\"name\":\"".$value->name."\"}";
								}
				}
				if ( $writesql == 1 )
				{
								$message = str_replace( "\\", "\\\\", json_encode( $message ) );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set message='".$message."' where uid=".$_SGLOBAL['supe_uid'] );
				}
				echo $messagetype3;
}
if ( $_REQUEST['mod'] == "Message" && $_REQUEST['act'] == "deleteMessage" )
{
				$message = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT message FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$message = json_decode( $message );
				foreach ( $message->c as $key => $value )
				{
								if ( $value->id == $_REQUEST['id'] )
								{
												unset( $message->$this->c[$key] );
								}
				}
				$message = json_encode( $message );
				$message = preg_replace( "'\"[0-9]+\":{'", "{", $message );
				$message = str_ireplace( "\"c\":{{", "\"c\":[{", $message );
				$message = str_ireplace( "}},\"d\"", "}],\"d\"", $message );
				$message = str_replace( "\\u", "\\\\u", $message );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set message='".$message."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1}";
				exit( );
}
if ( $_REQUEST['mod'] == "message" && $_REQUEST['act'] == "sendMessage" && $_REQUEST['type'] == "3" )
{
				$message = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT message FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['toId'] ) ), 0 );
				$message = json_decode( $message );
				if ( empty( $space[name] ) )
				{
								$space[name] = $space[username];
				}
				$space[name] = unicode_encodegb( $space[name] );
				$message->c[] = "{\"fromId\":\"".$_SGLOBAL['supe_uid']."\",\"sendTime\":".$_SGLOBAL['timestamp'].",\"eDesc\":\"".$_REQUEST['msg']."\",\"status\":0,\"id\":".$_SGLOBAL['timestamp'].",\"name\":\"".$space[name]."\"}";
				$message = json_encode( $message );
				$message = str_replace( "\"{", "{", $message );
				$message = str_replace( "}\"", "}", $message );
				$message = str_replace( "\\u", "\\\\u", $message );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set message='".$message."' where uid=".intval( $_REQUEST['toId'] ) );
				echo "{\"code\":1}";
				exit( );
}
if ( $_REQUEST['mod'] == "message" && $_REQUEST['act'] == "openMessage" && $_REQUEST['type'] == "5" )
{
				$message = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT message FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$message = json_decode( $message );
				$charm = 0;
				foreach ( $message->e as $key => $value )
				{
								if ( $_REQUEST['id'] == $value->id )
								{
												$value->status = 1;
												if ( 3000 < $value->formulaId )
												{
																$type = 3;
												}
												else if ( 2000 < $value->formulaId && $value->formulaId < 3000 )
												{
																$type = 2;
												}
												else
												{
																$type = 1;
												}
												$messagetype5 = "{\"id\":".$value->id.",\"formulaId\":".$value->formulaId.",\"type\":".$type.",\"friendId\":\"".$value->friendId."\",\"fName\":\"".$value->fName."\",\"charm\":".$value->charm.",\"msg\":\"".$value->msg."\",\"show\":0,\"x\":0,\"y\":0,\"z\":0,\"addCharm\":".$value->charm."}";
												$charm = $value->charm;
								}
				}
				$message = str_replace( "\\", "\\\\", json_encode( $message ) );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set message='".$message."',charm=charm+".$charm." where uid=".$_SGLOBAL['supe_uid'] );
				echo stripslashes( $messagetype5 );
}
if ( $_REQUEST['mod'] == "Gift" && $_REQUEST['act'] == "setXYZ" )
{
				$message = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT message FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$message = json_decode( $message );
				foreach ( $message->e as $key => $value )
				{
								if ( $_REQUEST['id'] == $value->id )
								{
												if ( $_REQUEST['z'] == "0" )
												{
																$value->status = 1;
												}
												else
												{
																$value->status = 2;
																$value->z = $_REQUEST['z'];
																$value->x = $_REQUEST['x'];
																$value->y = $_REQUEST['y'];
												}
								}
				}
				$message = str_replace( "\\", "\\\\", json_encode( $message ) );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set message='".$message."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1}";
				exit( );
}
if ( $_REQUEST['mod'] == "Gift" && $_REQUEST['act'] == "getGift" )
{
				$message = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT message FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$message = json_decode( $message );
				foreach ( $message->e as $key => $value )
				{
								if ( $value->status == 2 )
								{
												if ( 3000 < $value->formulaId )
												{
																$type = 3;
												}
												else if ( 2000 < $value->formulaId && $value->formulaId < 3000 )
												{
																$type = 2;
												}
												else
												{
																$type = 1;
												}
												$result[] = "\"".$value->id."\":{\"id\":".$value->id.",\"formulaId\":".$value->formulaId.",\"type\":".$type.",\"friendId\":\"".$value->friendId."\",\"fName\":\"".$value->fName."\",\"charm\":".$value->charm.",\"msg\":\"".$value->msg."\",\"show\":1,\"x\":".$value->x.",\"y\":".$value->y.",\"z\":".$value->z."}";
								}
								if ( $value->status == 1 )
								{
												if ( 3000 < $value->formulaId )
												{
																$type = 3;
												}
												else if ( 2000 < $value->formulaId && $value->formulaId < 3000 )
												{
																$type = 2;
												}
												else
												{
																$type = 1;
												}
												$result[] = "\"".$value->id."\":{\"id\":".$value->id.",\"formulaId\":".$value->formulaId.",\"type\":".$type.",\"friendId\":\"".$value->friendId."\",\"fName\":\"".$value->fName."\",\"charm\":".$value->charm.",\"msg\":\"".$value->msg."\",\"show\":1,\"x\":0,\"y\":0,\"z\":0}";
								}
				}
				$result = json_encode( $result );
				$result = str_replace( "[\"", "", $result );
				$result = str_replace( "\"]", "", $result );
				$result = str_replace( ",\"\\\"", ",\\\"", $result );
				$result = str_replace( "\\u", "\\\\u", $result );
				$result = str_replace( "}\"", "}", $result );
				$result = "{".$result."}";
				echo stripslashes( str_ireplace( "{null}", "[]", $result ) );
				exit( );
}
if ( $_REQUEST['mod'] == "Gift" && $_REQUEST['act'] == "deleteGift" )
{
				$message = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT message FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$message = json_decode( $message );
				foreach ( $message->e as $key => $value )
				{
								if ( $value->id == $_REQUEST['id'] )
								{
												unset( $message->$this->e[$key] );
								}
				}
				$message = json_encode( $message );
				$message = preg_replace( "'\"[0-9]+\":{'", "{", $message );
				$message = str_ireplace( "\"e\":{{", "\"e\":[{", $message );
				$message = str_ireplace( "}}}", "}]}", $message );
				$message = str_replace( "\\u", "\\\\u", $message );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set message='".$message."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1}";
				exit( );
}
if ( $_REQUEST['mod'] == "message" && $_REQUEST['act'] == "sendMessage" && $_REQUEST['type'] == "5" )
{
				$nosegay = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT nosegay FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$nosegay = json_decode( $nosegay );
				if ( $nosegay->$_REQUEST['id'] < 1 )
				{
								exit( );
				}
				$nosegay->$_REQUEST['id'] = $nosegay->$_REQUEST['id'] - 1;
				$message = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT message FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['toId'] ) ), 0 );
				$message = json_decode( $message );
				if ( empty( $space[name] ) )
				{
								$space[name] = $space[username];
				}
				$space[name] = unicode_encodegb( $space[name] );
				$duixiang = "{\"id\":".$_SGLOBAL['timestamp'].",\"formulaId\":".$_REQUEST['id'].",\"friendId\":\"".$_SGLOBAL['supe_uid']."\",\"fName\":\"".$space[name]."\",\"charm\":".$makenosegay[$_REQUEST['id']][charm].",\"validTime\":0,\"msg\":\"".$_REQUEST['msg']."\",\"sendTime\":".$_SGLOBAL['timestamp'].",\"status\":0,\"x\":50,\"y\":150,\"z\":3}";
				$duixiang = json_decode( $duixiang );
				$message->e[] = $duixiang;
				$message = json_encode( $message );
				$message = str_replace( "\\u", "\\\\u", $message );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set message='".$message."' where uid=".intval( $_REQUEST['toId'] ) );
				$nosegay = json_encode( $nosegay );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set nosegay='".$nosegay."' where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1,\"type\":5,\"id\":".$_REQUEST['id']."}";
				include_once( S_ROOT."./source/function_cp.php" );
				$icon = "farm";
				$title_template = "{actor} 赠送给 {touser} 一个神秘的礼物。去 <a href=\"newfarm.php\">农场</a> 看看吧！";
				$touserspace = getspace( intval( $_REQUEST['toId'] ) );
				if ( empty( $touserspace[name] ) )
				{
								$touserspace[name] = $touserspace[username];
				}
				$title_data = array(
								"touser" => "<a href=\"space.php?uid=".intval( $_REQUEST['toId'] )."\">".$touserspace[name]."</a>"
				);
				$body_general = "什么时候还能收到礼物啊，呜呜呜～～～！";
				feed_add( $icon, $title_template, $title_data, NULL, NULL, NULL );
				exit( );
}
if ( $_REQUEST['mod'] == "dog" && $_REQUEST['act'] == "feed" )
{
				$fertilizer = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT fertilizer FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				$fertilizer = json_decode( $fertilizer );
				$gouliang = 501;
				if ( $fertilizer->$gouliang < $_REQUEST['num'] )
				{
								exit( );
				}
				$fertilizer->$gouliang = $fertilizer->$gouliang - $_REQUEST['num'];
				$dog = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT dog FROM ".tname( "plug_newfarm" )." where uid=".intval( $_REQUEST['ownerId'] ) ), 0 );
				$dog = json_decode( $dog );
				foreach ( $dog as $key => $value )
				{
								if ( $value->status == 1 )
								{
												$value->dogFeedTime = $_SGLOBAL['timestamp'] + $_REQUEST['num'] * 86400;
								}
				}
				$dog = json_encode( $dog );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set dog='".$dog."' where uid=".intval( $_REQUEST['ownerId'] ) );
				$fertilizer = json_encode( $fertilizer );
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set fertilizer='".$fertilizer."' where uid=".$_SGLOBAL['supe_uid'] );
				echo ( "{\"dogFeedTime\":".( $_SGLOBAL['timestamp'] + $_REQUEST['num'] * 86400 ) ).",\"id\":501,\"num\":".$_REQUEST['num']."}";
}
if ( $_REQUEST['mod'] == "task" && $_REQUEST['act'] == "update" )
{
				$taskid = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT taskid FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				if ( $taskid == 0 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+50,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c50\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":50}],\"levelUp\":false,\"task\":{\"taskId\":0,\"taskFlag\":2}}";
				}
				if ( $taskid == 1 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+50,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c50\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":50}],\"levelUp\":false,\"task\":{\"taskId\":1,\"taskFlag\":2}}";
				}
				if ( $taskid == 2 )
				{
								$fertilizer = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT fertilizer FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
								$fertilizer = json_decode( $fertilizer );
								$putonghuafei = 1;
								$fertilizer->$putonghuafei = $fertilizer->$putonghuafei + 1;
								$fertilizer = json_encode( $fertilizer );
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set fertilizer='".$fertilizer."',exp=exp+100,money=money+100,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c100\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":100}],\"levelUp\":{\"title\":\"\\u5347\\u7ea7\\u5956\\u52b1\",\"eDesc\":\"\\u8fd9\\u4e48\\u5feb\\u5c31\\u5347\\u7ea7\\u52301\\u7ea7\\u4e86\\u554a\\uff1f\\u771f\\u662f\\u795e\\u901f\\uff0c\\u5956\\u52b1\\u4f60\\u4e24\\u888b\\u666e\\u901a\\u5316\\u80a5\\uff0c\\u5feb\\u5230\\u80cc\\u5305\\u91cc\\u770b\\u770b\\u5427\\u3002\",\"item\":[{\"eType\":\"3\",\"eParam\":\"1\",\"eNum\":\"2\",\"name\":\"\\u666e\\u901a\\u5316\\u80a5\"}],\"level\":1},\"task\":{\"taskId\":2,\"taskFlag\":2}}";
				}
				if ( $taskid == 3 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+150,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c150\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":150}],\"levelUp\":false,\"task\":{\"taskId\":3,\"taskFlag\":2}}";
				}
				if ( $taskid == 4 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+200,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c200\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":200}],\"levelUp\":false,\"task\":{\"taskId\":4,\"taskFlag\":2}}";
				}
				if ( $taskid == 5 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+250,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c250\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":250}],\"levelUp\":false,\"task\":{\"taskId\":5,\"taskFlag\":2}}";
				}
				if ( $taskid == 6 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+300,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c300\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":300}],\"levelUp\":false,\"task\":{\"taskId\":6,\"taskFlag\":2}}";
				}
				if ( $taskid == 7 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+350,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c350\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":350}],\"levelUp\":false,\"task\":{\"taskId\":7,\"taskFlag\":2}}";
				}
				if ( $taskid == 8 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+400,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c400\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":400}],\"levelUp\":false,\"task\":{\"taskId\":8,\"taskFlag\":2}}";
				}
				if ( $taskid == 9 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+450,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c450\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":450}],\"levelUp\":false,\"task\":{\"taskId\":9,\"taskFlag\":2}}";
				}
				if ( $taskid == 10 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+500,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c500\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":500}],\"levelUp\":false,\"task\":{\"taskId\":10,\"taskFlag\":2}}";
				}
				if ( $taskid == 11 )
				{
								$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set exp=exp+100,money=money+550,taskid=taskid+1 where uid=".$_SGLOBAL['supe_uid'] );
								echo "{\"eDesc\":\"\\u606d\\u559c\\u60a8\\u5b8c\\u6210\\u4efb\\u52a1,\\u83b7\\u5f97100\\u4e2a\\u7ecf\\u9a8c\\u548c550\\u4e2a\\u91d1\\u5e01\",\"item\":[{\"eType\":7,\"eParam\":0,\"eNum\":100},{\"eType\":6,\"eParam\":0,\"eNum\":550}],\"levelUp\":false,\"task\":{\"taskId\":11,\"taskFlag\":2}}";
				}
}
if ( $_REQUEST['mod'] == "user" && $_REQUEST['act'] == "welcome" )
{
				echo "null";
}
if ( $_REQUEST['mod'] == "task" && $_REQUEST['act'] == "accept" )
{
				$taskid = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT taskid FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				echo "{\"taskId\":".$taskid."}";
}
if ( $_REQUEST['mod'] == "user" && $_REQUEST['act'] == "reclaimPay" )
{
				$reclaim = $_SGLOBAL['db']->result( $_SGLOBAL['db']->query( "SELECT reclaim FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] ), 0 );
				echo "{\"money\":".$tudiarr[$reclaim][money].",\"level\":".$tudiarr[$reclaim][level]."}";
}
if ( $_REQUEST['mod'] == "user" && $_REQUEST['act'] == "reclaim" )
{
				$query = $_SGLOBAL['db']->query( "SELECT reclaim,money,exp FROM ".tname( "plug_newfarm" )." where uid=".$_SGLOBAL['supe_uid'] );
				while ( $value = $_SGLOBAL['db']->fetch_array( $query ) )
				{
								$list[] = $value;
				}
				if ( $list[0][money] < $tudiarr[$list[0][reclaim]][money] || $list[0][exp] < $tudiarr[$list[0][reclaim]][exp] )
				{
								exit( );
				}
				$_SGLOBAL['db']->query( "UPDATE ".tname( "plug_newfarm" )." set reclaim=reclaim+1,money=money-".$tudiarr[$list[0][reclaim]][money]." where uid=".$_SGLOBAL['supe_uid'] );
				echo "{\"code\":1,\"direction\":\"\",\"money\":-".$tudiarr[$list[0][reclaim]][money]."}";
}
if ( $_REQUEST['mod'] == "fb" )
{
				echo "<HTML>\r\n<HEAD>\r\n<meta http-equiv=\"refresh\" content=\"0.001; url=fb.htm\">\r\n</HEAD>\r\n<BODY>\r\n跳转中。。。\r\n</BODY>\r\n</HTML>\r\n";
				exit( );
}
if ( $_REQUEST['mod'] == "user" && $_REQUEST['act'] == "getLog" )
{
				echo "[{\"time\":".$_SGLOBAL['supe_uid'].",\"msg\":\"<a href=\\\"event:222769470\\\"><font color=\\\"#009900\\\"><b>\\u7CFB\\u7EDF<\\/b><\\/font><\\/a> \\u6B64\\u529F\\u80FD\\u6682\\u65F6\\u672A\\u5F00\\u653E\\uFF01\\uFF01\"}]";
}
?>
