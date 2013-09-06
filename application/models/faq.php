<?php
class Faq extends Eloquent
{
    public static $table = 'faq';
    public static $timestamps = false;

    public static function oneByLang($id, $lang){
    	$data = FaqData::where_id($id)->where_lang($lang)->first();
    	$page = Faq::find($id);
    	if($data && $page){
    		$object = (object) array_merge( $page->original, $data->original );
    		return $object;
    	}else{
    		return null;
    	}
    }

    public static function allByLang($lang){
    	$array 	= array();
    	$pages 	= Faq::order_by('id', 'desc')->get();
    	foreach ($pages as $p) {
    		$data = FaqData::where_id($p->id)->where_lang($lang)->first();
    		if($data){
	    		$object = (object) array_merge( $p->original, $data->original );
	    		$array[] = $object;
	    	}
    	}
    	
       	return $array;
    }

    public static function allByCategory($cat, $lang){
    	$array 	= array();
    	$pages 	= Faq::where_category($cat)->get();
    	foreach ($pages as $p) {
    		$data = FaqData::where_id($p->id)->where_lang($lang)->first();
    		if($data){
	    		$object = (object) array_merge( $p->original, $data->original );
	    		$array[] = $object;
	    	}
    	}
    	
       	return $array;
    }
}