<?php

class Event_Controller extends Base_Controller {


	public function __construct(){
		Config::set('application.language', 'fr');
	}

	public function get_add()
	{	
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$cats 		= Category::allByModelByLang('event', $current->lang);
		$categories = array(0 => 'Sans catégorie');
		foreach ($cats as $c) {
			$categories[$c->id] = $c->label;
		}

		return View::make('event.add')
					->with('languages', $languages)
					->with('current', $current)
					->with('categories', $categories);
	}

	public function post_create(){
		$new_event  = array(
						'status' => Input::get('status'),
						'category' => Input::get('category'),
						'calendar' => Input::get('date')
					);
		$event = Events::create($new_event);
		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 			= Input::get($lang->lang);
			$data['id']		= $event->id;
			$data['lang'] 	= $lang->lang;
			EventData::create($data);
		}

		$imgs  = Input::get('imgs');
		if($imgs){
			foreach ($languages as $lang) {
				$o = 0;
				if(isset($imgs[$lang->lang])){
					foreach ($imgs[$lang->lang] as $i) {
						$img = explode(Ramdam::getSepDir(), $i);
						$image = array(
								'content' 	=> 'event',
								'object' 	=> $event->id,
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


		return Redirect::to_route('manage_event')
						->with('message', 'Evenement ajouté avec succès!');
	}

	public function get_manager(){
		$lang 		= Config::get('application.language');
		$events 	= Events::allByLang($lang);
		return View::make('event.manager')->with('events', $events);
	}

	public function get_modify($id){
		$event = Events::find($id);
		$languages = Language::all();
		$data = array();
		$images = array();

		foreach($languages as $lang){
			$images[$lang->lang] = Gallery::where_content('event')->where_lang($lang->lang)->where_object($id)->get();
		}

		foreach($languages as $lang){
			$p = Events::oneByLang($id, $lang->lang);
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
		$cats 		= Category::allByModelByLang('event', $current->lang);
		$categories = array(0 => 'Sans catégorie');
		foreach ($cats as $c) {
			$categories[$c->id] = $c->label;
		}
		$date = substr($event->calendar, 0, 10);
		return View::make('event.modify')
					->with('event', $event)
					->with('data', $data)
					->with('images', $images)
					->with('languages', $languages)
					->with('current', $current)
					->with('categories', $categories)
					->with('date', $date);
	}

	public function put_update(){
		$id 				= Input::get('id');
		$event 				= Events::find($id);
		$event->status 		= Input::get('status');
		$event->category 	= Input::get('category');
		$event->calendar 	= Input::get('date');
		$event->save();

		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 		= Input::get($lang->lang);
			$d 			= DB::table('event_data')
					    ->where_id($id)
					    ->where_lang($lang->lang)
					    ->first();
			if($d){
				DB::table('event_data')
				    ->where_id($id)
				    ->where_lang($lang->lang)
				    ->update($data);	
			}else{
				$data['id']		= $id;
				$data['lang'] 	= $lang->lang;
				EventData::create($data);
			}
				
		}

		DB::table('gallery')->where_content('event')->where_object($id)->delete();

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
								'content' 	=> 'event',
								'object' 	=> $event->id,
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

		return Redirect::to_route('manage_event')
						->with('message', 'Evenement modifié avec succès!');
	}

	public function get_delete($id){
		DB::table('event_data')->where_id($id)->delete();
		DB::table('event')->where_id($id)->delete();
		DB::table('gallery')->where_content('event')->where_object($id)->delete();
		return Redirect::to_route('manage_event')
						->with('message', 'Evenement supprimé avec succès!');
	}

}