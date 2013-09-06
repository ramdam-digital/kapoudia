<?php
class Degustation extends Eloquent
{
    public static $table = 'degustation';
    public static $timestamps = false;

    public static function getAllByLang($lang){
    	$all 		= self::get(array(DB::raw('DISTINCT id')));
		$data 		= array();
		foreach($all as $d){
			$val = self::where_id($d->id)->where_lang($lang)->first('value');
			$value = ($val) ? $val->value: "";
			$data[$d->id] = $value;
		}
		return $data;
    }
}