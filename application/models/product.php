<?php
class Product extends Eloquent
{
    public static $table = 'product';
    public static $timestamps = false;

    public static function oneByLang($id, $lang){
    	$data = ProductData::where_id($id)->where_lang($lang)->first();
    	$page = self::find($id);
    	if($data && $page){
    		$object = (object) array_merge( $page->original, $data->original );
    		return $object;
    	}else{
    		return null;
    	}
    }

    public static function getSpecificationsValues($id, $lang){
        $specs = SpecificationValues::where_product($id)->where_lang($lang)->get();
        $specifications = array();
        foreach ($specs as $s) {
            $label = Specification::oneByLang($s->specification, $lang);
            $label = $label->label;
            $specifications[$label] = $s->value;
        }
        return $specifications;
    }

    public static function getSpecifications($id, $l = null){
        $family         = Product::where_id($id)->first('category')->category;
        $specifications = Specification::where_category($family)->get();
        $backdata       = array();
        $languages = Language::all();
        foreach ($specifications as $spec) {
            if(!$l){
                foreach ($languages as $lang) {
                    $sp = Specification::oneByLang($spec->id, $lang->lang);
                    $val = SpecificationValues::oneByLang($id, $spec->id, $lang->lang);
                    $value = ($val) ? $val->value : "";
                    $backdata[$lang->lang][$sp->id] = array("label" => $sp->label, "value" => $value);
                }  
            }else{
                $sp = Specification::oneByLang($spec->id, $l);
                $val = SpecificationValues::oneByLang($id, $spec->id, $l);
                $value = ($val) ? $val->value : "";
                $backdata[$sp->id] = array("label" => $sp->label, "value" => $value);
            }
            
            
        }
        return $backdata;
        
    }

    public static function allByLang($lang){
    	$array 	= array();
    	$pages 	= self::order_by('id', 'desc')->get();
    	foreach ($pages as $p) {
    		$data = ProductData::where_id($p->id)->where_lang($lang)->first();
    		if($data){
	    		$object = (object) array_merge( $p->original, $data->original );
	    		$array[] = $object;
	    	}
    	}
    	
       	return $array;
    }

    public static function allByCategory($cat, $lang){
    	$array 	= array();
    	$pages 	= self::where_category($cat)->get();
    	foreach ($pages as $p) {
    		$data = ProductData::where_id($p->id)->where_lang($lang)->first();
    		if($data){
	    		$object = (object) array_merge( $p->original, $data->original );
	    		$array[] = $object;
	    	}
    	}
    	
       	return $array;
    }
}