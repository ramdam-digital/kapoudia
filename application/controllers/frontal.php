<?php
class Frontal_Controller extends Controller {

	public $restful = true;

	public $lang;


	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

	public function __construct(){

		if(Session::has('language')){
			Config::set('application.language', Session::get('language'));
		}else{
			$lang = Ramdam::getOption('language');
			Config::set('application.language', $lang);
		}

		$this->lang = Config::get('application.language');
		
	}

	public function get_change_lang($lang){
		Session::put('language', $lang);
		return Redirect::to_route('home');
	}

	public function get_home(){
		$slides = array();
		$slides = Gallery::where_content('slider')->where_lang($this->lang)->get();
		$title = Lang::line('kapoudia.home')->get();
    	return View::make('home.home')
    				->with('slides', $slides)
    				->with('title', $title);
	}

	public function get_show_product($categorie, $menu, $id){
		$methods	= Config::get('methods');
		$menu 		= Menu::oneByLang($menu, $this->lang);
		if(is_null($menu) || !array_key_exists($menu->method, $methods)){
	        return Event::first('404');
	    }
		$current 	= array();
	    $current[]	= $menu->id;
	    $current[]	= $menu->parent;
	    $produits 	= Product::allByCategory($menu->params, $this->lang);
	    $page 		= Ramdam::getOption('categorypage'.$menu->params);
		$page 		= Page::oneByLang($page, $this->lang);
		foreach ($produits as $p) {
			$images = Gallery::where_content('product')->where_object($p->id)->get();
			if(isset($images[1]))
				$p->image = Ramdam::getUploadDir().$images[1]->path;
			else
				$p->image = Ramdam::getUploadDir().$images[0]->path;
		}
		$pdts = array();
		foreach ($produits as $p) {
			if($p->id==$id){
				$pdts[] = $p;
				break;
			}
		}

		if(count($pdts)==0){
			return Event::first('404');
		}

		foreach ($produits as $p) {
			if($p->id!=$id){
				$pdts[] = $p;
			}
		}


		$specifications = Specification::allByCat($menu->params);
		$specs = array();
		$i=0;
		foreach ($specifications as $key => $value) {
			$specs[$i]['label'] = $value[$this->lang];
			$v = DB::table('specification_values')->where_specification($key)->where_lang($this->lang)->first();
			if(!is_null($v))
				$specs[$i]['value'] = $v->value;
			else
				$specs[$i]['value'] = '';
			$i++;
		}
		return View::make('home.product')
				->with('page', $page)
				->with('specs', $specs)
				->with('produits', $pdts)
	    		->with('title', $menu->label)
	    		->with('current', $current);
	}

	public function get_add_cart(){
		$panier = Session::get('panier');
		if(!is_array($panier)) Session::forget('panier');
		if(is_null($panier)) $panier = array();
		if(isset($_GET['quantite']) && isset($_GET['product'])){
			$q = intval($_GET['quantite']);
			$p = intval($_GET['product']);
			if(array_key_exists($p, $panier)){
				$panier[$p] += $q;
			}else{
				$panier[$p] = $q;
			}
		}
		Session::forget('panier');
		Session::put('panier', $panier);
	}

	public function get_cart_empty(){
		Session::forget('panier');
		$id = Session::get('saved_panier');
		if($id != false){			
			$commande = Commande::find(intval($id));
			if($commande->status == "UNPAID"){
				$commande->delete();
			}
		}
		Session::put('saved_panier', false);
		return Redirect::to_route('cart');
	}

	
	public function get_cart(){
		$panier = Session::get('panier');
		$total = 0;
    	$cart = array();
    	$devise = Auth::user()->devise;
    	if($devise == 'usd'){
    		$devise = 'price2';
    		$code_devise = '$';
    	}else{
    		$devise = 'price';
    		$code_devise = '&euro;';
    	}

    	if(!is_null($panier)){
	    	foreach ($panier as $id => $q) {
	    		$product 				= Product::oneByLang($id, $this->lang);
	    		$product->quantite 		= $q;
	    		$product->unit_price 	= $product->$devise;
	    		$product->price_ttc		= $product->$devise + (($product->$devise*$product->tva)/100);
	    		$product->total_price 	= $q * $product->price_ttc;
	    		$total += $product->total_price;
	    		$images = Gallery::where_content('product')->where_object($id)->get();
				if(isset($images[1]))
					$product->image = Ramdam::getUploadDir().$images[1]->path;
				else
					$product->image = Ramdam::getUploadDir().$images[0]->path;
	    		$cart[] = $product;
	    	}
	    }

	    Session::put('cart', array('data'=> $cart, 'total'=>$total));

    	return View::make('home.cart')
    				->with('cart', $cart)
    				->with('total', $total)
    				->with('devise', $code_devise);
	}

	public function get_cart_pay(){
		$user = Auth::user();
		$userdata = array(
				'email' 		=> Auth::user()->email,
				'username'		=> Auth::user()->username,
				'nom'			=> Auth::user()->nom,
				'prenom'		=> Auth::user()->prenom,
				'entreprise'	=> Auth::user()->entreprise,
				'matricule'		=> Auth::user()->matricule,
				'activite'		=> Auth::user()->activite,
				'adresse'		=> Auth::user()->adresse,
				'cp'			=> Auth::user()->cp,
				'tel'			=> Auth::user()->tel,
				'devise'		=> Auth::user()->devise
			);

		if(!Session::get('saved_panier')){
			$data = array(
					'commande' 	=> json_encode(Session::get('cart')),
					'client' 	=> json_encode($userdata),
					'status'	=> 'UNPAID'
				);
			$commande = Commande::create($data);
			Session::put('saved_panier', $commande->id);
		}else{
			$id = Session::get('saved_panier');
			$commande = Commande::find(intval($id));
			$commande->commande = json_encode(Session::get('cart'));
			$commande->client = json_encode($userdata);
			$commande->save();
		}
		return View::make('home.cart_pay')
					->with('user', $user);
	}

	public function get_acces_pro(){
		$page = Page::oneByTemplate($this->lang, 'acces');
		return View::make('home.'.$page->template)
	                        ->with('page', $page)
	                        ->with('title', $page->title);
	}

	public function get_fiche_pro(){
		return View::make('home.fiche')
	                ->with('title', 'Brochure Kapoudia');
	}

	public function get_to_menu($label, $menu){
	    $methods	= Config::get('methods');
	    $menu 		= Menu::oneByLang($menu, $this->lang);

	    if(is_null($menu) || !array_key_exists($menu->method, $methods)){
	        return Event::first('404');
	    }

	    $current 	= array();
	    $current[]	= $menu->id;
	    $current[]	= $menu->parent;

	    if($menu->method == 'view_page'){
	        $p = Page::oneByLang($menu->params, $this->lang);
	        $images = Gallery::where_content('page')->where_object($p->id)->where_lang($this->lang)->get();
	        $render = View::make('home.'.$p->template)
	                        ->with('page', $p)
	                        ->with('images', $images);
	    }


	    if($menu->method == 'view_catalog'){
	        $produits 	= Product::allByCategory($menu->params, $this->lang);
	        if(count($produits)==0){
	        	return Event::first('404');
	        }
	        foreach ($produits as $p) {
	    		$image 	= NULL;
	    		$image2 = NULL;
	    		$images = Gallery::where_content('product')->where_object($p->id)->get();
	    		rsort($images);
	    		if(isset($images[0])) $image = $images[0]->path;
	    		$p->image = $image;

	    		if(isset($images[1])) $image2 = $images[1]->path;
	    		$p->image2 = $image2;
	    	}
	        $render 	= View::make('home.catalog')
	                        ->with('products', $produits)
	                        ->with('menu', $menu);
	    }

	    if($menu->method == 'degustation'){
	    	$degustation = Degustation::getAllByLang($this->lang);
	       	$render = View::make('home.degustation')
	       					->with('data', $degustation);
	    }

	    if($menu->method == 'adopter'){
	       	$render = View::make('home.olivier');
	    }

	    if($menu->method == 'news'){
	    	$events = Events::allByLang($this->lang);
	    	foreach ($events as $e) {
	    		$image = NULL;
	    		$images = Gallery::where_content('event')->where_object($e->id)->where_lang($this->lang)->get();
	    		if($images[0]) $image = $images[0]->path;
	    		$e->image = $image;

	    		$e->calendar = Date('d-m-Y', strtotime($e->calendar));
	    	}
	       	$render = View::make('home.news')
	       					->with('news', $events);
	    }

	    return $render
	    		->with('title', $menu->label)
	    		->with('current', $current);

	}

	function get_contact(){
		return View::make('home.contact')->with('title', 'Contact');
	}


	function post_contact_action(){
		$rules = array(
                'nom'       	=> 'required|min:2|max:50',
                'email'     	=> 'required|email',
                'sujet'     	=> 'required|min:10|max:255',
                'message'   	=> 'required|min:10',
                'captcha_user' 	=> 'laracaptcha|required'
                );

	    $messages = array(
	        'laracaptcha' => Lang::line('kapoudia.captcha_invlaid')->get(),
	    );

        $validation = Validator::make(Input::all(), $rules, $messages);
        if ( $validation->fails() )
        {
            return Redirect::to_route('contact')
                    ->with_errors($validation)
                    ->with_input();
        }

        $smtp = Config::get('smtp');

        $mailer = IoC::resolve('mailer');
        $transport = Swift_SmtpTransport::newInstance($smtp['smtp'], $smtp['smtp_port'], $smtp['smtp_ssl'])
          ->setUsername($smtp['smtp_user'])
          ->setPassword($smtp['smtp_pass']);

      
        $mailer = Swift_Mailer::newInstance($transport);
        // Construct the message
        $message = Swift_Message::newInstance('Message From Kapoudia')
            ->setFrom(array(Input::get('email')=>Input::get('nom')))
            ->setTo(array('aymenlabidi88@gmail.com'=>'Admin Kapoudia'))
            ->setSubject('Kapoudia - '.Input::get('sujet'))
            ->addPart(Input::get('message'),'text/plain')
            ->setBody(Input::get('message'),'text/html');

        // Send the email
        if($mailer->send($message))
            return Redirect::to_route('contact')->with('message', Lang::line('kapoudia.contact_msg_success')->get());
        else
            return Redirect::to_route('contact')->with('erreur', Lang::line('kapoudia.contact_msg_problem')->get());

	}
	

	function get_login(){
		if(!Auth::guest()){
			return Redirect::to_route('member_profile');
		}
		return View::make('home.login')->with('title', 'Authentification');
	}

	function post_suscribe(){

		$user = Input::all();
		$rules = array(
				'username'  	=> 'required|min:2|max:50|unique:users',
				'email'     	=> 'required|email|max:100|unique:users',
				'pass' 			=> 'required|min:4',
				'repass' 		=> 'same:pass',
                'entreprise' 	=> 'required|min:2',
                'matricule' 	=> 'required|min:2',
                'captcha_user' 	=> 'laracaptcha|required'
                );
		$messages = array(
	        'laracaptcha' => Lang::line('kapoudia.captcha_invlaid')->get(),
	    );
        $validation = Validator::make($user, $rules, $messages);
        if ( $validation->fails() )
        {
            return Redirect::to_route('member_login')
                    ->with_errors($validation)
                    ->with_input();
        }

        $user['password'] = Hash::make($user['pass']);
        $user['nickname'] = ucfirst(strtolower($user['username']));
        
        unset($user['pass']);
        unset($user['repass']);
        unset($user['captcha_x']);
        unset($user['captcha_y']);
        unset($user['captcha_user']);
        if(User::create($user))
			return Redirect::to_route('member_login')->with('message', Lang::line('kapoudia.compte_cree_succes')->get());
		else
			return Redirect::to_route('member_login')->with('error', Lang::line('kapoudia.compte_erreur')->get());

	}

	function post_access(){

		$username = Input::get('username');
	    $password = Input::get('password');
	    if ( Auth::attempt(array('username' => $username, 'password' => $password)) )
	    {
	        return Redirect::to_route('member_profile');
	    }
	    else
	    {
	        return Redirect::to_route('member_login')
	            ->with('login_errors', true);
	    }

	}

	public function get_logout(){
		Auth::logout();
	    return Redirect::to_route('member_login');
	}

	public function get_profile(){
		if(Auth::guest()){
			return Redirect::to_route('member_login');
		}
        $acts = array(		
        		0 										=> Lang::line('login.activite')->get(),
        		Lang::line('login.importateur')->get()	=> Lang::line('login.importateur')->get(), 
        		Lang::line('login.grossiste')->get() 	=> Lang::line('login.grossiste')->get(),
        		Lang::line('login.distributeur')->get() => Lang::line('login.distributeur')->get(),
        		Lang::line('login.epiceriefine')->get() => Lang::line('login.epiceriefine')->get(),
        		Lang::line('login.autre')->get()		=> Lang::line('login.autre')->get()
        	);

		$user = Auth::user();
		return View::make('home.profile')
					->with('title', 'Profile')
					->with('user', $user)
					->with('acts', $acts);
	}


	public function put_profile_update(){
		$data = Input::all();
		$user = User::find($data['id']);
		unset($data['_method']);
		unset($data['id']);
		foreach($data as $k=>$v){
			$user->$k = $v;
		}
		$user->save();
		return Redirect::to_route('member_profile');
	}


	public function get_search(){
		return View::make('home.search')
					->with('title', 'Recherche');
	}

	public function post_search_result(){
		$keyword = Input::get('keyword');

		if(strlen($keyword)<2){
			return Redirect::to_route('search')
							->with('erreur', Lang::line('kapoudia.result_not_found')->get());
		}

		$found = false;

		$render = View::make('home.search')
					->with('title', 'Recherche');

		$data = Input::all();

		if(isset($data['pages'])){
			$pages = PageData::where_lang($this->lang)
								->where(function($q){
									$keyword = Input::get('keyword');
                                    $q->where('title', 'like' , '%'.$keyword.'%');
                                    $q->or_where('description', 'like' , '%'.$keyword.'%');
                                    $q->or_where('content', 'like' , '%'.$keyword.'%');
                                })
								->get();
			$result = array();

			foreach($pages as $p){
				$m 			= Menu::where_method('view_page')->where_params($p->id)->first();
				if(!is_null($m)){
					$menu 		= Menu::oneByLang($m->id, $this->lang);
					$link 		= URL::to_route('to_menu', array(Ramdam::getSlug($menu->label), $menu->id));
					$result[] 	= array(
									'description' 	=> Ramdam::summary(strip_tags($p->content)),
									'label'			=> $menu->label,
									'link'			=> $link
									);
				}
			}
			if(count($result)>0){
				$render->with('pages', $result);
				$found = true;
			}
		}

		if(isset($data['news'])){
			$result = array();
			$m 		= Menu::where_method('news')->first();
			if(!is_null($m)){
				$menu = Menu::oneByLang($m->id, $this->lang);
				$events 	= EventData::where_lang($this->lang)
									->where(function($q){
										$keyword = Input::get('keyword');
	                                    $q->where('title', 'like' , '%'.$keyword.'%');
	                                    $q->or_where('content', 'like' , '%'.$keyword.'%');
	                                })
									->get();
				
				foreach($events as $p){
					$menu 		= Menu::oneByLang($m->id, $this->lang);
					$link 		= URL::to_route('to_menu', array(Ramdam::getSlug($menu->label), $menu->id));
					$result[] 	= array(
									'description' 	=> Ramdam::summary(strip_tags($p->content)),
									'label'			=> $p->title,
									'link'			=> $link
									);
				}
				
				if(count($result)>0){
					$render->with('events', $result);
					$found = true;
				}

			}
		}

		if(isset($data['products'])){
			$products = array();
			$pdts = ProductData::where_lang($this->lang)
								->where(function($q){
                                    $keyword = Input::get('keyword');
                                    $q->where('label', 'like' , '%'.$keyword.'%');
                                    $q->or_where('description', 'like' , '%'.$keyword.'%');
                                })
								->get();

			foreach ($pdts as $p) {
				$pdt 	= Product::oneByLang($p->id, $this->lang);
				$cat 	= Category::oneByLang($pdt->category, $this->lang);
				$m 		= Menu::where_method('view_catalog')->where_params($cat->id)->first();
				if(!is_null($m)){
					$menu 		= Menu::oneByLang($m->id, $this->lang);
					$link 		= URL::to_route('show_product', array(Ramdam::getSlug($menu->label), $menu->id, $p->id));
					$products[] = array(
									'description' 	=> Ramdam::summary(strip_tags($pdt->description)),
									'label'			=> $pdt->label,
									'link'			=> $link
									);
				}
			}
			if(count($products)>0){
				$render->with('products', $products);
				$found = true;
			}
		}

		if(!$found) return Redirect::to_route('search')
							->with('erreur', Lang::line('kapoudia.result_not_found')->get());

		return $render;
	}	


}