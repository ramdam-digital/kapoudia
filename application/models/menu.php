<?php
class Menu extends Eloquent
{
    public static $table = 'menu';
    public static $timestamps = false;

    public static function menuTree($id){
        
    }

    public static function oneByLang($id, $lang){
    	$data = MenuData::where_id($id)->where_lang($lang)->first();
    	$menu = Menu::find($id);
    	if($data && $menu){
    		$object = (object) array_merge( $menu->original, $data->original );
    		return $object;
    	}else{
    		return null;
    	}
    }

    public static function allByCategory($parent, $lang){
        $array  = array();
        $pages  = Menu::where_parent($parent)->order_by('order')->get();
        foreach ($pages as $p) {
            $data = MenuData::where_id($p->id)->where_lang($lang)->first();
            if($data){
                $object = (object) array_merge( $p->original, $data->original );
                $array[] = $object;
            }
        }
        
        return $array;
    }


}