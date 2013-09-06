<?php
class Settings extends Eloquent
{
    public static $table = 'settings';
    public static $timestamps = false;
    
    public static function update_option($option, $value){
    	$option = self::where_option($option)->first();
    	if($option){
    		$option->value = $value;
    		$option->save();
    		return true;
    	}
    	return false;
    }
}