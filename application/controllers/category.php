<?php

class Category_Controller extends Base_Controller {


	public function __construct(){
		Config::set('application.language', 'fr');
	}

	public function get_add(){
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$models		= Config::get('models');
		return View::make('category.add')
					->with('languages', $languages)
					->with('current', $current)
					->with('models', $models);
	}

	public function post_create(){
		$new_obj  = array('model' => Input::get('model'));
		$category = Category::create($new_obj);
		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 			= Input::get($lang->lang);
			$data['id']		= $category->id;
			$data['lang'] 	= $lang->lang;
			CategoryData::create($data);
		}

		return Redirect::to_route('manage_category')
						->with('message', 'Catégorie ajoutée avec succès!');
	}

	public function get_manager(){
		$lang = Config::get('application.language');
		$categories = Category::allByLang($lang);
		return View::make('category.manager')->with('categories', $categories);
	}


	public function get_modify($id){
		$cat = Category::find($id);
		$languages = Language::all();
		$data = array();
		foreach($languages as $lang){
			$p = Category::oneByLang($id, $lang->lang);
			if($p){
				$data[$lang->lang]['label'] = $p->label;
			}else{
				$data[$lang->lang]['label'] = "";
			}
		}
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$models		= Config::get('models');
		return View::make('category.modify')
					->with('category', $cat)
					->with('data', $data)
					->with('languages', $languages)
					->with('current', $current)
					->with('models', $models);
	}

	public function put_update(){
		$id 				= Input::get('id');
		$cat 				= Category::find($id);
		$cat->model 		= Input::get('model');
		$cat->save();

		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 		= Input::get($lang->lang);
			$d 			= DB::table('category_data')
					    ->where_id($id)
					    ->where_lang($lang->lang)
					    ->first();
			if($d){
				DB::table('category_data')
				    ->where_id($id)
				    ->where_lang($lang->lang)
				    ->update($data);	
			}else{
				$data['id']		= $id;
				$data['lang'] 	= $lang->lang;
				CategoryData::create($data);
			}
				
		}
		return Redirect::to_route('manage_category')
						->with('message', 'Catégorie modifiée avec succès!');
	}

	public function get_delete($id){

		$cat = Category::find($id);
		if($cat){
			$count = DB::table($cat->model)->where_category($id)->count();
			if($count>0){
				return Redirect::to_route('manage_category')
					->with('warning', 'La catégorie ne pas pas être supprimée car elle contient des éléments!');
			}else{
				DB::table('category_data')->where_id($id)->delete();
				DB::table('category')->where_id($id)->delete();
				return Redirect::to_route('manage_category')
								->with('message', 'Catégorie supprimée avec succès!');
			}
			
		}else{
			return Redirect::to_route('manage_category')
					->with('error', "La catégorie n'existe pas!");
		}
	}

	public function get_assoc($id){
		$specifications = Specification::allByCat($id);
		$languages 		= Language::all();
		$pages 			= array(0 => 'Aucune');
		$ps				= Page::allByLang('fr');
		foreach($ps as $p){
			$pages[$p->id] = $p->title;
		}
		$current = Ramdam::getOption('categorypage'.$id);
		return View::make('category.assoc')
					->with('specs', $specifications)
					->with('languages', $languages)
					->with('id', intval($id))
					->with('pages', $pages)
					->with('current', $current);
	}

	public function post_create_spec(){
		$id = Input::get('id');

		if(isset($_POST['page'])){
			$s = Settings::where_option('categorypage'.$id)->first();
			if($s){
				DB::table('settings')
				    ->where_option('categorypage'.$id)
				    ->update(array('value'=>$_POST['page']));
			}else{
				Settings::create(array('option'=>'categorypage'.$id, 'value'=>$_POST['page']));
			}
			return Redirect::to_route('assoc_category', array($id));	
			exit();
		}

		
		$spec = Specification::create(array(
								'category' => $id
							));
		$data = Input::get('label');
		foreach($data as $k=>$d){
			SpecificationData::create(array(
									'specification' => $spec->id,
									'lang'			=> $k,
									'label'			=> $d
								));
		}
		return Redirect::to_route('assoc_category', array($id));
	}

	public function delete_remove_spec_category(){
		$id = Input::get('id');
		$spec = Specification::find($id);
		Specification::remove($id);
		return Redirect::to_route('assoc_category', array($spec->category));
	}

	public function put_update_spec(){
		$id 				= Input::get('id');
		$spec 				= Specification::find($id);
		$labels				= Input::get('label');
		foreach ($labels as $k=>$v) {
			$d 			= DB::table('specification_data')
					    ->where_specification($id)
					    ->where_lang($k)
					    ->first();
			if($d){
				DB::table('specification_data')
				    ->where_specification($id)
				    ->where_lang($k)
				    ->update(array('label'=>$v));	
			}else{
				SpecificationData::create(array('specification'=>$id, 'lang'=>$k, 'label'=>$v));
			}
				
		}
		return Redirect::to_route('assoc_category', array($spec->category));
	}

	public function get_values($id){
		$spec = Specification::oneByLang($id, 'fr');
		$vals = Specification::getAllValues($id);
		return View::make('category.values')
					->with('vals', $vals)
					->with('spec', $spec);
	}

	public function put_update_vals(){
		$id = Input::get('id');
		DB::table('specification_values')->where_specification($id)->delete();
		$values = Input::get('label');
		foreach($values as $k=>$v){
			SpecificationValues::create(
									array(
										'specification' => $id,
										'lang'			=> $k,
										'value'			=> $v
									)
								);
		}
		return Redirect::to_route('values_category', array($id));
	}

}
