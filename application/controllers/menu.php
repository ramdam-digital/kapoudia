<?php

class Menu_Controller extends Base_Controller {


	public function __construct(){
		Config::set('application.language', 'fr');
	}

	public function get_add(){
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$methods	= Config::get('methods');
		$menus		= Menu::allByCategory(0, 'fr');
		$parents	= array(0=>'Aucun');
		foreach ($menus as $m) {
			$parents[$m->id] = $m->label;
		}
		return View::make('menu.add')
					->with('languages', $languages)
					->with('current', $current)
					->with('methods', $methods)
					->with('parents', $parents);
	}

	public function post_create(){
		$new_obj  = array(
						'parent' => Input::get('parent'),
						'method' => Input::get('method'),
						'params' => Input::get('params')
					);
		$menu = Menu::create($new_obj);
		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 			= Input::get($lang->lang);
			$data['id']		= $menu->id;
			$data['lang'] 	= $lang->lang;
			MenuData::create($data);
		}
		return Redirect::to_route('manage_menu', array(0))
						->with('message', 'Menu ajouté avec succès!');
	}

	public function get_manager($id){
		$lang 	= Config::get('application.language');
		$menus	= Menu::allByCategory($id, $lang);
		return View::make('menu.manager')
					->with('menus', $menus)
					->with('lang', $lang)
					->with('current_menu', $id);
	}


	public function get_modify($id){
		$menu = Menu::find($id);
		$languages = Language::all();
		$data = array();
		foreach($languages as $lang){
			$p = Menu::oneByLang($id, $lang->lang);
			if($p){
				$data[$lang->lang]['label'] = $p->label;
			}else{
				$data[$lang->lang]['label'] = "";
			}
		}
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$methods	= Config::get('methods');
		$menus		= Menu::allByCategory(0, 'fr');
		$parents	= array(0=>'Aucun');
		foreach ($menus as $m) {
			$parents[$m->id] = $m->label;
		}
		return View::make('menu.modify')
					->with('languages', $languages)
					->with('current', $current)
					->with('methods', $methods)
					->with('parents', $parents)
					->with('menu', $menu)
					->with('data', $data);
	}

	public function put_update(){
		$id 				= Input::get('id');
		$menu 				= Menu::find($id);
		$menu->parent 		= Input::get('parent');
		$menu->method 		= Input::get('method');
		$menu->params 		= Input::get('params');
		$menu->save();

		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 		= Input::get($lang->lang);
			$d 			= DB::table('menu_data')
					    ->where_id($id)
					    ->where_lang($lang->lang)
					    ->first();
			if($d){
				DB::table('menu_data')
				    ->where_id($id)
				    ->where_lang($lang->lang)
				    ->update($data);	
			}else{
				$data['id']		= $id;
				$data['lang'] 	= $lang->lang;
				MenuData::create($data);
			}
				
		}
		return Redirect::to_route('manage_menu', array($menu->parent))
						->with('message', 'Menu modifié avec succès!');
	}

	public function get_delete($id){
		$m = Menu::find($id);
		$p = ($m) ? $m->parent: 0;
		DB::table('menu_data')->where_id($id)->delete();
		DB::table('menu')->where_id($id)->delete();
		return Redirect::to_route('manage_menu', array($p))
						->with('message', 'Menu supprimé avec succès!');
	}

	public function post_reorder(){
		$id = Input::get('current');
		$str = Input::get('order');
		$str = substr($str, 0, strlen($str)-1);
		$tab = explode(';', $str);
		for($i=0;$i<count($tab);$i++){
			preg_match_all('/\d+/', $tab[$i], $matches);
			$menu = Menu::find($matches[0][0]);
			if($menu){
				$menu->order = $i;
				$menu->save();
			}
		}
		return Redirect::to_route('manage_menu', array($id))
						->with('message', 'Ordre défini avec succès!');
	}

}
