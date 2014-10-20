-$auth = App::make('decoy.auth')
.header
	.inner
		%h1 !=Config::get('decoy::site_name')

		-# The account menu
		%ul.user
			%li.dropdown
				
				-# Dropdown menu
				%a.dropdown-toggle(data-toggle='dropdown')
					.gravatar-wrap
						%img.gravatar(src=$auth->userPhoto())
					%span.caret
		
				-# Options
				%ul.dropdown-menu
		
					-if(is_a($auth, 'Bkwld\Decoy\Auth\Sentry') && $auth->can('read', 'admins'))
						%li
							%a(href=DecoyURL::action('Bkwld\\Decoy\\Controllers\\Admins@index')) Admins
						%li
							%a(href=$auth->userUrl()) Your account
						%li.divider
		
					-$divider = false
					-if($auth->developer())
						-$divider = true
						%li
							%a(href=route('decoy\\commands')) Commands
		
					-if(count(Bkwld\Decoy\Models\Worker::all()))
						-$divider = true
						%li
							%a(href=route('decoy\\workers')) Workers
		
					-if($divider)
						%li.divider
		
					%li
						%a(href='/') Public site
					%li
						%a(href=$auth->logoutUrl()) Log out