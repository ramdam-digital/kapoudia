<?php
class Category extends Eloquent
{
    public static $table = 'category';
    public static $timestamps = false;

    public static function allByLang($lang){
    	$array 	= array();
    	$cats 	= self::all();
    	foreach ($cats as $c) {
    		$data = CategoryData::where_id($c->id)->where_lang($lang)->first();
    		if($data){
	    		$object = (object) array_merge( $c->original, $data->original );
	    		$array[] = $object;
	    	}
    	}
    	
       	return $array;
    }

    public static function allByModelByLang($model, $lang){
    	$array 	= array();
    	$cats 	= self::where_model($model)->get();
    	foreach ($cats as $c) {
    		$data = CategoryData::where_id($c->id)->where_lang($lang)->first();
    		if($data){
	    		$object = (object) array_merge( $c->original, $data->original );
	    		$array[] = $object;
	    	}
    	}
    	
       	return $array;
    }

    public static function oneByLang($id, $lang){
        $data = CategoryData::where_id($id)->where_lang($lang)->first();
        $cat = Category::find($id);
        if($data && $cat){
            $object = (object) array_merge( $cat->original, $data->original );
            return $object;
        }else{
            return null;
        }
    }


    
}