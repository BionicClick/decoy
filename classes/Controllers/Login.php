<?php namespace Bkwld\Decoy\Controllers;

// Dependencies
use Auth;
use Bkwld\Decoy\Models\Admin;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Former;

/**
 * Handle logging in of users.  This is based on the AuthController.php and
 * PasswordController that Laravel's `php artisan make:auth` generates.
 */
class Login extends Controller {
	use AuthenticatesUsers, ThrottlesLogins, ValidatesRequests;

	/**
	 * Use the guest middleware to redirect logged in admins away from the login
	 * screen, exepct for the getLogout() action.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('decoy.guest', ['except' => 'getLogout']);
	}

	/**
	 * Show the application login form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function showLoginForm()   {

		// Pass validation rules
		Former::withRules(array(
			'email'    => 'required|email',
			'password' => 'required',
		));

		// Show the login homepage
		return view('decoy::layouts.blank', [
			'content' => view('decoy::account.login'),
		]);
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function logout() {

		// Logout the session
		Auth::guard($this->getGuard())->logout();

		// Redirect back to previous page so that switching users takes you back to
		// your previous page.
		$previous = url()->previous();
		if ($previous == url('/')) return redirect(route('decoy::account@login'));
		else return redirect($previous);
	}

	/**
	 * Get the post register / login redirect path. This is set to the login route
	 * so that the guest middleware can pick it up and redirect to the proper
	 * start page.
	 *
	 * @return string
	 */
	public function redirectPath() {
		return route('decoy::account@login');
	}
}
