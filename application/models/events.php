<?php
class Events extends Eloquent
{
    public static $table = 'event';

    public static function oneByLang($id, $lang){
    	$data = EventData::where_id($id)->where_lang($lang)->first();
    	$page = Events::find($id);
    	if($data && $page){
    		$object = (object) array_merge( $page->original, $data->original );
    		return $object;
    	}else{
    		return null;
    	}
    }

    public static function allByLang($lang){
    	$array 	= array();
    	$pages 	= Events::order_by('id', 'desc')->get();
    	foreach ($pages as $p) {
    		$data = EventData::where_id($p->id)->where_lang($lang)->first();
    		if($data){
	    		$object = (object) array_merge( $p->original, $data->original );
	    		$array[] = $object;
	    	}
    	}
    	
       	return $array;
    }

    public static function allByCategory($cat, $lang){
    	$array 	= array();
    	$pages 	= Events::where_category($cat)->get();
    	foreach ($pages as $p) {
    		$data = EventData::where_id($p->id)->where_lang($lang)->first();
    		if($data){
	    		$object = (object) array_merge( $p->original, $data->original );
	    		$array[] = $object;
	    	}
    	}
    	
       	return $array;
    }

}