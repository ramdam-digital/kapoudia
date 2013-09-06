<?php
class Page extends Eloquent
{
    public static $table = 'page';

    public static function oneByLang($id, $lang){
    	$data = PageData::where_id($id)->where_lang($lang)->first();
    	$page = Page::find($id);
    	if($data && $page){
    		$object = (object) array_merge( $page->original, $data->original );
    		return $object;
    	}else{
    		return null;
    	}
    }

    public static function oneByTemplate($lang, $template){
        $page = Page::where_template($template)->first();
        $data = PageData::where_id($page->id)->where_lang($lang)->first();
        if($data && $page){
            $object = (object) array_merge( $page->original, $data->original );
            return $object;
        }else{
            return null;
        }
    }

    public static function allByLang($lang){
    	$array 	= array();
    	$pages 	= Page::order_by('id', 'desc')->get();
    	foreach ($pages as $p) {
    		$data = PageData::where_id($p->id)->where_lang($lang)->first();
    		if($data){
	    		$object = (object) array_merge( $p->original, $data->original );
	    		$array[] = $object;
	    	}
    	}
    	
       	return $array;
    }

    public static function allByCategory($cat, $lang){
    	$array 	= array();
    	$pages 	= Page::where_category($cat)->get();
    	foreach ($pages as $p) {
    		$data = PageData::where_id($p->id)->where_lang($lang)->first();
    		if($data){
	    		$object = (object) array_merge( $p->original, $data->original );
	    		$array[] = $object;
	    	}
    	}
    	
       	return $array;
    }

}