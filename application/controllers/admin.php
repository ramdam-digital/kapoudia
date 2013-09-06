<?php

class Admin_Controller extends Base_Controller {

	function get_admin(){

		$languages 	= Language::all();
		$slides 	= array();

		foreach($languages as $lang){
			$slides[$lang->lang] = Gallery::where_content('slider')->where_lang($lang->lang)->get();
		}

		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();

		$socials 	= array(
						'facebook' 	=> Ramdam::getOption('facebook'),
						'youtube' 	=> Ramdam::getOption('youtube'),
						'blog' 		=> Ramdam::getOption('blog')
						);

		return View::make('admin')
					->with('slides', $slides)
					->with('languages', $languages)
					->with('current', $current)
					->with('socials', $socials);
	}

	function put_update_slider(){
		DB::table('gallery')->where_content('slider')->delete();
		$languages = Language::all();
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
								'content' 	=> 'slider',
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
		return Redirect::to_route('admin')
						->with('message', 'Slider appliqué avec succès!');
	}

	function put_update_socials(){
		$socials = Input::get('socials');
		foreach($socials as $option=>$value){
			Settings::update_option($option, $value);
		}
		return Redirect::to_route('admin')
						->with('message', 'Paramètres modifiées avec succès!');
	}

	function get_degustation(){
		$all 		= Degustation::get(array(DB::raw('DISTINCT id')));
		$langs 		= Language::all();
		$data 		= array();
		foreach($all as $d){
			foreach($langs as $l){
				$val = Degustation::where_id($d->id)->where_lang($l->lang)->first('value');
				$value = ($val) ? $val->value: "";
				$data[$d->id][$l->lang] = $value;
			}
		}
		return View::make('page.degustation')
					->with('languages', $langs)
					->with('data', $data);
	}

	function put_update_degustation(){
		$data 	= Input::get('data');
		$langs 	= Language::all();
		foreach($data as $key => $value){
			foreach($langs as $l){
				$d = Degustation::where_id($key)->where_lang($l->lang)->first();
				if($d){
					DB::table('degustation')
				    ->where_id($key)
				    ->where_lang($l->lang)
				    ->update(array('value'=>$value[$l->lang]));
				}else{
					Degustation::create(array(
							'id' 	=> $key,
							'lang' 	=> $l->lang,
							'value' => $value[$l->lang]
						));
				}
			}
		}
		return Redirect::to_route('degustation');
	}

}