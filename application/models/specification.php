<?php
class Specification extends Eloquent
{
    public static $table = 'specification';
    public static $timestamps = false;

    public static function oneByLang($id, $lang){
    	$data = SpecificationData::where_specification($id)->where_lang($lang)->first();
    	$page = self::find($id);
    	if($data && $page){
    		$object = (object) array_merge( $page->original, $data->original );
    		return $object;
    	}else{
    		return null;
    	}
    }

    public static function allByCat($id){
        $array  = array();
        $specs  = self::where_category($id)->order_by('id', 'desc')->get();
        foreach($specs as $spec){
            foreach(Language::all() as $lang){
                $s = SpecificationData::where_specification($spec->id)->where_lang($lang->lang)->first();
                $array[$spec->id][$lang->lang] = $s->label;
            }
        }
        return $array;
    }

    public static function remove($id){
        DB::table('specification_values')->where_specification($id)->delete();
        DB::table('specification_data')->where_specification($id)->delete();
        DB::table('specification')->where_id($id)->delete();
    }

    public static function getAllValues($spec){
        $data = array();
        $langs = Language::all();
        foreach($langs as $l){
            $val = SpecificationValues::where_specification($spec)->where_lang($l->lang)->first();
            if($val){
                $data[$l->lang] = $val->value;
            }else{
                $data[$l->lang] = "";
            }
        }
    
        return $data;

    }

}