<?php
class Language extends Eloquent
{
    public static $table = 'lang';
    public static $timestamps = false;

    public static function getActifLanguages(){
    	$langs = self::where_status(1)->get();
    	return $langs;
    }
}