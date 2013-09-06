<?php

class Page_Controller extends Base_Controller {


	public function __construct(){
		Config::set('application.language', 'fr');
	}

	public function get_add()
	{	
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$cats 		= Category::allByModelByLang('page', $current->lang);
		$categories = array(0 => 'Sans catégorie');
		foreach ($cats as $c) {
			$categories[$c->id] = $c->label;
		}

		$templates	= Config::get('templates');

		return View::make('page.add')
					->with('languages', $languages)
					->with('current', $current)
					->with('categories', $categories)
					->with('templates', $templates);
	}

	public function post_create(){
		$new_page  = array(
						'status' => Input::get('status'),
						'category' => Input::get('category'),
						'template' => Input::get('template')
					);
		$imgs  = Input::get('imgs');

		$page = Page::create($new_page);
		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 			= Input::get($lang->lang);
			$data['id']		= $page->id;
			$data['lang'] 	= $lang->lang;
			PageData::create($data);
		}

		$imgs  = Input::get('imgs');
		if($imgs){
			foreach ($languages as $lang) {
				$o = 0;
				if(isset($imgs[$lang->lang])){
					foreach ($imgs[$lang->lang] as $i) {
						$img = explode(Ramdam::getSepDir(), $i);
						$image = array(
								'content' 	=> 'page',
								'object' 	=> $page->id,
								'lang'		=> $lang->lang,
								'path'		=> $img[1],
								'order' 	=> $o
							);
						Gallery::create($image);
						$o++;
					}
				}
			}
		}

		

		return Redirect::to_route('manage_page')
						->with('message', 'Page ajoutée avec succès!');
	}

	public function get_manager(){
		$lang = Config::get('application.language');
		$pages = Page::allByLang($lang);
		return View::make('page.manager')->with('pages', $pages);
	}

	public function get_modify($id){
		$page = Page::find($id);
		$languages = Language::all();
		$data = array();
		$images = array();

		foreach($languages as $lang){
			$images[$lang->lang] = Gallery::where_content('page')->where_lang($lang->lang)->where_object($id)->get();
		}

		foreach($languages as $lang){
			$p = Page::oneByLang($id, $lang->lang);
			if($p){
				$data[$lang->lang]['title'] = $p->title;
				$data[$lang->lang]['description'] = $p->description;
				$data[$lang->lang]['content'] = $p->content;
			}else{
				$data[$lang->lang]['title'] = "";
				$data[$lang->lang]['description'] = "";
				$data[$lang->lang]['content'] = "";
			}
		}
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$cats 		= Category::allByModelByLang('page', $current->lang);
		$categories = array(0 => 'Sans catégorie');
		foreach ($cats as $c) {
			$categories[$c->id] = $c->label;
		}
		
		
		$templates	= Config::get('templates');
		return View::make('page.modify')
					->with('page', $page)
					->with('data', $data)
					->with('images', $images)
					->with('languages', $languages)
					->with('current', $current)
					->with('categories', $categories)
					->with('templates', $templates);
	}

	public function put_update(){
		$id 				= Input::get('id');
		$page 				= Page::find($id);
		$page->status 		= Input::get('status');
		$page->category 	= Input::get('category');
		$page->template 	= Input::get('template');
		$page->save();

		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 		= Input::get($lang->lang);
			$d 			= DB::table('page_data')
					    ->where_id($id)
					    ->where_lang($lang->lang)
					    ->first();
			if($d){
				DB::table('page_data')
				    ->where_id($id)
				    ->where_lang($lang->lang)
				    ->update($data);	
			}else{
				$data['id']		= $id;
				$data['lang'] 	= $lang->lang;
				PageData::create($data);
			}
				
		}
		DB::table('gallery')->where_content('page')->where_object($id)->delete();



		$imgs  = Input::get('imgs');
		if($imgs){
			foreach ($languages as $lang) {
				$o = 0;
				if(isset($imgs[$lang->lang])){
					foreach ($imgs[$lang->lang] as $i) {
						if(stristr($i, Ramdam::getSepDir())){
							$img = explode(Ramdam::getSepDir(), $i);
							$i = $img[1];
						}
						$image = array(
								'content' 	=> 'page',
								'object' 	=> $page->id,
								'lang'		=> $lang->lang,
								'path'		=> $i,
								'order' 	=> $o
							);
						Gallery::create($image);
						$o++;
					}
				}
			}
		}

		return Redirect::to_route('manage_page')
						->with('message', 'Page modifiée avec succès!');
	}

	public function get_delete($id){
		DB::table('page_data')->where_id($id)->delete();
		DB::table('page')->where_id($id)->delete();
		DB::table('gallery')->where_content('page')->where_object($id)->delete();
		return Redirect::to_route('manage_page')
						->with('message', 'Page supprimée avec succès!');
	}

}