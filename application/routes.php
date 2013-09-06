<?php
session_start();
if(!Auth::guest() && Auth::user()->role == 2){
    $_SESSION['admin'] = true;
}else{
    $_SESSION['admin'] = false;
}

define('ADMIN', 'admin');

/*
|--------------------------------------------------------------------------
| Frontoffice Routes
|--------------------------------------------------------------------------
*/

Route::get('contact', array('as'=>'contact', 'uses'=>'frontal@contact'));
Route::post('contact_action', array('as'=>'contact_action', 'uses'=>'frontal@contact_action'));

Route::get('/', array('as'=>'home', 'uses'=>'frontal@home'));

Route::get('(:any)-(:num)-details-(:num)', array('as'=>'show_product', 'uses'=>'frontal@show_product'));

Route::get('(:any)-(:num)', array('as'=>'to_menu', 'uses'=>'frontal@to_menu'));

Route::get('language/(:any)', array('as'=>'change_lang', 'uses'=>'frontal@change_lang'));

Route::get('search', array('as'=>'search', 'uses'=>'frontal@search'));
Route::post('search/result', array('as'=>'search_result', 'uses'=>'frontal@search_result'));

Route::get('member/login', array('as' => 'member_login', 'uses'=>'frontal@login'));
Route::post('member/access', array('as' => 'member_access', 'uses'=>'frontal@access'));

Route::get('member/logout', array('as' => 'member_logout', 'uses'=>'frontal@logout'));
Route::post('member/suscribe', array('as' => 'member_suscribe', 'uses'=>'frontal@suscribe'));

Route::get('acces_pro', array('as' => 'acces_pro', 'uses'=>'frontal@acces_pro'));
Route::get('fiche_pro', array('as' => 'fiche_pro', 'before'=>'ispro', 'uses'=>'frontal@fiche_pro'));

Route::get('add_cart', array('as' => 'add_cart', 'uses'=>'frontal@add_cart'));

Route::group(array('before' => 'auth'), function()
{   
    Route::get('cart', array('as' => 'cart', 'uses'=>'frontal@cart'));
    Route::get('cart/empty', array('as' => 'cart_empty', 'uses'=>'frontal@cart_empty'));
    Route::get('cart/pay', array('as' => 'cart_pay', 'uses'=>'frontal@cart_pay'));
    Route::get('member/profile', array('as' => 'member_profile', 'uses'=>'frontal@profile'));
    Route::put('member/profile/update', array('as' => 'member_profile_update', 'uses'=>'frontal@profile_update'));
});

Route::get('resizer', function(){
    header('Content-Type: image/jpeg');
    $image  = new SimpleImage();
    $path   = $_GET['path'];
    $width  = intval($_GET['w']);
    $image->load($path);
    $image->resizeToWidth($width);
    $image->output();
});

/*
|--------------------------------------------------------------------------
| Backoffice Routes
|--------------------------------------------------------------------------
*/

Route::get('login', array('as' => 'login', 'uses'=>'user@login'));
Route::post('access', array('as' => 'authentification', 'uses'=>'user@access'));
Route::get('logout', array('as' => 'logout', 'uses'=>'user@logout'));

Route::group(array('before' => 'isadmin'), function()
{	
	Route::get(ADMIN, array('as' => 'admin', 'uses'=>'admin@admin'));

	/*
	|--------------------------------------------------------------------------
	| Pages Routes
	|--------------------------------------------------------------------------
	*/
    Route::get(ADMIN.'/page/add', array('as' => 'add_page', 'uses'=>'page@add'));
    Route::post(ADMIN.'/page/create', array('as' => 'create_page', 'uses'=>'page@create'));
    Route::get(ADMIN.'/page/manager', array('as' => 'manage_page', 'uses'=>'page@manager'));
    Route::get(ADMIN.'/page/modify/(:num)', array('as' => 'modify_page', 'uses'=>'page@modify'));
    Route::put(ADMIN.'/page/update', array('as' => 'update_page', 'uses'=>'page@update'));
    Route::get(ADMIN.'/page/delete/(:num)', array('as' => 'delete_page', 'uses'=>'page@delete'));


    /*
	|--------------------------------------------------------------------------
	| Events Routes
	|--------------------------------------------------------------------------
	*/
    Route::get(ADMIN.'/event/add', array('as' => 'add_event', 'uses'=>'event@add'));
    Route::post(ADMIN.'/event/create', array('as' => 'create_event', 'uses'=>'event@create'));
    Route::get(ADMIN.'/event/manager', array('as' => 'manage_event', 'uses'=>'event@manager'));
    Route::get(ADMIN.'/event/modify/(:num)', array('as' => 'modify_event', 'uses'=>'event@modify'));
    Route::put(ADMIN.'/event/update', array('as' => 'update_event', 'uses'=>'event@update'));
    Route::get(ADMIN.'/event/delete/(:num)', array('as' => 'delete_event', 'uses'=>'event@delete'));

    /*
	|--------------------------------------------------------------------------
	| Faqs Routes
	|--------------------------------------------------------------------------
	*/
    Route::get(ADMIN.'/faq/add', array('as' => 'add_faq', 'uses'=>'faq@add'));
    Route::post(ADMIN.'/faq/create', array('as' => 'create_faq', 'uses'=>'faq@create'));
    Route::get(ADMIN.'/faq/manager', array('as' => 'manage_faq', 'uses'=>'faq@manager'));
    Route::get(ADMIN.'/faq/modify/(:num)', array('as' => 'modify_faq', 'uses'=>'faq@modify'));
    Route::put(ADMIN.'/faq/update', array('as' => 'update_faq', 'uses'=>'faq@update'));
    Route::get(ADMIN.'/faq/delete/(:num)', array('as' => 'delete_faq', 'uses'=>'faq@delete'));


    /*
	|--------------------------------------------------------------------------
	| Category Routes
	|--------------------------------------------------------------------------
	*/
    Route::get(ADMIN.'/category/add', array('as' => 'add_category', 'uses'=>'category@add'));
    Route::post(ADMIN.'/category/create', array('as' => 'create_category', 'uses'=>'category@create'));
    Route::get(ADMIN.'/category/manager', array('as' => 'manage_category', 'uses'=>'category@manager'));
    Route::get(ADMIN.'/category/modify/(:num)', array('as' => 'modify_category', 'uses'=>'category@modify'));
    Route::put(ADMIN.'/category/update', array('as' => 'update_category', 'uses'=>'category@update'));
    Route::get(ADMIN.'/category/delete/(:num)', array('as' => 'delete_category', 'uses'=>'category@delete'));
    Route::get(ADMIN.'/category/assoc/(:num)', array('as' => 'assoc_category', 'uses'=>'category@assoc'));
    Route::post(ADMIN.'/category/create_spec', array('as' => 'add_spec_category', 'uses'=>'category@create_spec'));
    Route::delete(ADMIN.'/category/delete_spec', array('as' => 'delete_spec_category', 'uses'=>'category@remove_spec_category'));
    Route::put(ADMIN.'/category/update_spec', array('as' => 'update_spec_category', 'uses'=>'category@update_spec'));
    Route::get(ADMIN.'/category/values/(:num)', array('as' => 'values_category', 'uses'=>'category@values'));
    Route::put(ADMIN.'/category/update_vals', array('as' => 'update_vals_category', 'uses'=>'category@update_vals'));

    /*
    |--------------------------------------------------------------------------
    | Menu Routes
    |--------------------------------------------------------------------------
    */
    Route::get(ADMIN.'/menu/add', array('as' => 'add_menu', 'uses'=>'menu@add'));
    Route::post(ADMIN.'/menu/create', array('as' => 'create_menu', 'uses'=>'menu@create'));
    Route::post(ADMIN.'/menu/reorder', array('as' => 'reorder_menu', 'uses'=>'menu@reorder'));
    Route::get(ADMIN.'/menu/manager/(:num)', array('as' => 'manage_menu', 'uses'=>'menu@manager'));
    Route::get(ADMIN.'/menu/modify/(:num)', array('as' => 'modify_menu', 'uses'=>'menu@modify'));
    Route::put(ADMIN.'/menu/update', array('as' => 'update_menu', 'uses'=>'menu@update'));
    Route::get(ADMIN.'/menu/delete/(:num)', array('as' => 'delete_menu', 'uses'=>'menu@delete'));

    /*
    |--------------------------------------------------------------------------
    | Users Routes
    |--------------------------------------------------------------------------
    */
    Route::get(ADMIN.'/user/manager', array('as' => 'manage_user', 'uses'=>'user@manager'));
    Route::get(ADMIN.'/user/delete/(:num)', array('as' => 'delete_user', 'uses'=>'user@delete'));
    Route::put(ADMIN.'/user/change', array('as' => 'change_user', 'uses'=>'user@change'));
    /*
    |--------------------------------------------------------------------------
    | eShop Routes
    |--------------------------------------------------------------------------
    */
    Route::get(ADMIN.'/product/add', array('as' => 'add_product', 'uses'=>'eshop@add_product'));
    Route::post(ADMIN.'/product/create', array('as' => 'create_product', 'uses'=>'eshop@create_product'));
    Route::get(ADMIN.'/product/edit/(:num)', array('as' => 'edit_product', 'uses'=>'eshop@edit_product'));
    Route::put(ADMIN.'/product/update', array('as' => 'update_product', 'uses'=>'eshop@update_product'));
    Route::put(ADMIN.'/product/update_specs', array('as' => 'update_product_specs', 'uses'=>'eshop@update_product_specs'));
    Route::get(ADMIN.'/product/manager', array('as' => 'manage_product', 'uses'=>'eshop@manage_product'));
    Route::get(ADMIN.'/product/delete/(:num)', array('as' => 'delete_product', 'uses'=>'eshop@delete_product'));

    
    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::put(ADMIN.'/slider/update', array('as' => 'update_slider', 'uses'=>'admin@update_slider'));
    Route::put(ADMIN.'/socials/update', array('as' => 'update_socials', 'uses'=>'admin@update_socials'));


    /*
    |--------------------------------------------------------------------------
    | Specific Routes
    |--------------------------------------------------------------------------
    */
    Route::get(ADMIN.'/degustation', array('as' => 'degustation', 'uses'=>'admin@degustation'));
    Route::put(ADMIN.'/degustation/update', array('as' => 'update_degustation', 'uses'=>'admin@update_degustation'));
    
});



/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
    
    return View::make('home.404')->with('title', 'Erreur');
	//return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to_route('member_login');
});

Route::filter('isadmin', function()
{
    if (Auth::guest() || Auth::user()->role != 2) return Redirect::to_route('home');
});

Route::filter('ispro', function()
{
    if (Auth::guest() || (Auth::user()->role != 2 && Auth::user()->role != 3)) 
        return Redirect::to_route('contact')
                        ->with('erreur', 'La fiche est révservée pour les membres Pro. Contactez nous pour devenir un membre pro!');
});