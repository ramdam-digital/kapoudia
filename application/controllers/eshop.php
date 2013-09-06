<?php

class Eshop_Controller extends Base_Controller {


	public function __construct(){
		Config::set('application.language', 'fr');
	}

	public function get_add_product()
	{	
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$cats 		= Category::allByModelByLang('eshop', $current->lang);
		$categories = array();
		$brands		= array(0=>'Pas de marque');
		foreach ($cats as $c) {
			$categories[$c->id] = $c->label;
		}

		return View::make('eshop.add_product')
					->with('languages', 	$languages)
					->with('current', 		$current)
					->with('brands', 		$brands)
					->with('categories', 	$categories);
	}

	public function post_create_product(){
		$new  = array(
						'status' 	=> Input::get('status'),
						'category' 	=> Input::get('category'),
						'brand'		=> Input::get('brand'),
						'reference' => Input::get('reference'),
						'stock' 	=> Input::get('stock'),
						'price'		=> Input::get('price'),
						'price2'	=> Input::get('price2'),
						'volume'	=> Input::get('volume'),
						'tva'		=> Input::get('tva'),
						'bag'		=> Input::get('bag'),
						);

		$product = Product::create($new);
		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 			= Input::get($lang->lang);
			$data['id']		= $product->id;
			$data['lang'] 	= $lang->lang;
			ProductData::create($data);
		}

		return Redirect::to_route('edit_product', array($product->id));
	}


	public function get_edit_product($id)
	{	
		$product 	= Product::find($id);
		$languages = Language::all();
		$data = array();
		foreach($languages as $lang){
			$p = Product::oneByLang($id, $lang->lang);
			if($p){
				$data[$lang->lang]['label'] = $p->label;
				$data[$lang->lang]['description'] = $p->description;
			}else{
				$data[$lang->lang]['label'] = "";
				$data[$lang->lang]['description'] = "";
			}
		}
		$current 	= Config::get('application.language');
		$languages 	= Language::where('lang', '!=', $current)->where_status(1)->get();
		$current 	= Language::where('lang', '=', $current)->first();
		$cats 		= Category::allByModelByLang('eshop', $current->lang);
		$categories = array();
		$brands		= array(0=>'Pas de marque');
		foreach ($cats as $c) {
			$categories[$c->id] = $c->label;
		}

		$images = Gallery::where_content('product')->where_object($id)->get();
		return View::make('eshop.edit_product')
					->with('languages', 	$languages)
					->with('current', 		$current)
					->with('brands', 		$brands)
					->with('categories', 	$categories)
					->with('data', 			$data)
					->with('product', 		$product)
					->with('images', 		$images);
	}

	public function put_update_product(){
		$id 					= Input::get('id');
		$product 				= Product::find($id);
		$product->status 		= Input::get('status');
		$product->category 		= Input::get('category');
		$product->brand 		= Input::get('brand');
		$product->reference 	= Input::get('reference');
		$product->stock 		= Input::get('stock');
		$product->price 		= Input::get('price');
		$product->price2 		= Input::get('price2');
		$product->volume 		= Input::get('volume');
		$product->tva 			= Input::get('tva');
		$product->bag 			= Input::get('bag');
		$product->save();

		$languages = Language::all();
		foreach ($languages as $lang) {
			$data 		= Input::get($lang->lang);
			$d 			= DB::table('product_data')
					    ->where_id($id)
					    ->where_lang($lang->lang)
					    ->first();
			if($d){
				DB::table('product_data')
				    ->where_id($id)
				    ->where_lang($lang->lang)
				    ->update($data);	
			}else{
				$data['id']		= $id;
				$data['lang'] 	= $lang->lang;
				ProductData::create($data);
			}
				
		}

		DB::table('gallery')->where_content('product')->where_object($id)->delete();
		$imgs  = Input::get('imgs');
		if($imgs){
			foreach ($imgs as $i) {
				if(stristr($i, Ramdam::getSepDir())){
					$img = explode(Ramdam::getSepDir(), $i);
					$i = $img[1];
				}
				$image = array(
						'content' 	=> 'product',
						'object' 	=> $id,
						'path'		=> $i,
						'order' 	=> 0
					);
				Gallery::create($image);
			}
		}

		return Redirect::to_route('edit_product', array($id))
						->with('message', 'Produit modifié avec succès!');
	}


	public function put_update_product_specs(){
		$id = Input::get('id');
		$id = intval($id);
		$languages = Language::all();

		foreach($languages as $lang){
			$specs = Input::get($lang->lang);
			foreach ($specs as $k=>$v) {
				$d 		= DB::table('specification_values')
					    ->where_product($id)
					    ->where_specification($k)
					    ->where_lang($lang->lang)
					    ->first();
				if($d){
					DB::table('specification_values')
					    ->where_product($id)
					    ->where_specification($k)
					    ->where_lang($lang->lang)
					    ->update(array('value'=>$v));	
				}else{
					$data = array(
							'product' => $id,
							'specification' => $k,
							'lang' => $lang->lang,
							'value' => $v
						);
					SpecificationValues::create($data);
				}
			}
		}
		return Redirect::to_route('edit_product', array($id))
						->with('message', 'Produit modifié avec succès!');
	}

	public function get_manage_product(){
		$lang 		= Config::get('application.language');
		$products 	= Product::allByLang($lang);
		return View::make('eshop.manage_product')->with('products', $products);
	}

	public function get_delete_product($id){
		DB::table('product_data')->where_id($id)->delete();
		DB::table('product')->where_id($id)->delete();
		DB::table('specification_values')->where_product($id)->delete();
		DB::table('gallery')->where_content('product')->where_object($id)->delete();
		return Redirect::to_route('manage_product')
						->with('message', 'Produit supprimée avec succès!');
	}

	
}