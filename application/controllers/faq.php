<?php

class Faq_Controller extends Base_Controller {


	public function __construct(){
		Config::set('application.language', 'fr');
	}

	public function get_add()
	{	
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$cats 		= Category::allByModelByLang('faq', $current->lang);
		$categories = array(0 => 'Sans catégorie');
		foreach ($cats as $c) {
			$categories[$c->id] = $c->label;
		}

		return View::make('faq.add')
					->with('languages', $languages)
					->with('current', $current)
					->with('categories', $categories);
	}

	public function post_create(){
		$new_faq  = array(
						'status' => Input::get('status'),
						'category' => Input::get('category')
						);
		$faq = Faq::create($new_faq);
		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 			= Input::get($lang->lang);
			$data['id']		= $faq->id;
			$data['lang'] 	= $lang->lang;
			FaqData::create($data);
		}

		return Redirect::to_route('manage_faq')
							->with('message', 'FAQ ajoutée avec succès!');
	}

	public function get_manager(){
		$lang 		= Config::get('application.language');
		$faqs 		= Faq::allByLang($lang);
		return View::make('faq.manager')->with('faqs', $faqs);
	}

	public function get_modify($id){
		$faq = Faq::find($id);
		$languages = Language::all();
		$data = array();
		foreach($languages as $lang){
			$p = Faq::oneByLang($id, $lang->lang);
			if($p){
				$data[$lang->lang]['question'] = $p->question;
				$data[$lang->lang]['answer'] = $p->answer;
			}else{
				$data[$lang->lang]['question'] = "";
				$data[$lang->lang]['answer'] = "";
			}
		}
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$cats 		= Category::allByModelByLang('faq', $current->lang);
		$categories = array(0 => 'Sans catégorie');
		foreach ($cats as $c) {
			$categories[$c->id] = $c->label;
		}
		return View::make('faq.modify')
					->with('faq', $faq)
					->with('data', $data)
					->with('languages', $languages)
					->with('current', $current)
					->with('categories', $categories);
	}

	public function put_update(){
		$id 				= Input::get('id');
		$faq 				= Faq::find($id);
		$faq->status 		= Input::get('status');
		$faq->category 		= Input::get('category');
		$faq->save();

		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 		= Input::get($lang->lang);
			$d 			= DB::table('faq_data')
					    ->where_id($id)
					    ->where_lang($lang->lang)
					    ->first();
			if($d){
				DB::table('faq_data')
				    ->where_id($id)
				    ->where_lang($lang->lang)
				    ->update($data);	
			}else{
				$data['id']		= $id;
				$data['lang'] 	= $lang->lang;
				FaqData::create($data);
			}
				
		}
		return Redirect::to_route('manage_faq')
						->with('message', 'FAQ modifié avec succès!');
	}

	public function get_delete($id){
		DB::table('faq_data')->where_id($id)->delete();
		DB::table('faq')->where_id($id)->delete();
		return Redirect::to_route('manage_faq')
						->with('message', 'FAQ supprimé avec succès!');
	}


}