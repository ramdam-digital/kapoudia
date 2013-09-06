<?php
class SpecificationValues extends Eloquent
{
    public static $table = 'specification_values';
    public static $timestamps = false;

    public static function oneByLang($spec, $lang){
    	$data = self::where_specification($spec)->where_lang($lang)->first();
    	if($data){
    		return $data;
    	}else{
    		return null;
    	}
    }
}