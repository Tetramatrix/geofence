<?php
/***************************************************************
* Copyright notice
*
* (c) 2010-2013 Chi Hoang (info@chihoang.de)
*  All rights reserved
*
***************************************************************/
define("mapWidth",1000);
define("mapHeight",1000);

require_once("mercator.php");
require_once("geofence.php");

if( !ini_get('safe_mode') )
{
    ini_set("max_execution_time","10000");
    ini_set("memory_limit","800M");
}
set_time_limit(10000);

$s=new mercator(mapWidth,mapHeight);
$shape=$s->loadfile("PAShapeFile.txt");
$res=$s->project($shape);
$filter=$s->filter($s->proj,10);

$map=new mercator(mapWidth,mapHeight);
$arr=$map->loadfile("PennsylvaniaLonLatT.txt");
$arr=array_merge($arr,$filter);
$res=$map->project($arr);

$hull=new hull();
$hull->main($res,$map->mapWidth,$map->mapHeight,$s->proj,8.9);
 
$pic=new Image("/tmp/",$hull);
$pic->create();


?>