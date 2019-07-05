<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use App\Post;
use App\Category;
use App\Tag;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class CheckoutController extends Controller
{
    public function charge(Request $request, Post $post, Tag $tag, Category $category)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
        
            $customer = Customer::create(array(
                'email' => $request->stripeEmail,
                'source' => $request->stripeToken
            ));
        
            $charge = Charge::create(array(
                'customer' => $customer->id,
                'amount' => 999,
                'currency' => 'usd'
            ));
            session()->flash('success', 'Welcome to our blog, subscriber');
            return redirect()->back();   
        } catch (\Exception $ex) {
			session()->flash('error', 'Unauthorized purchase');
            return redirect()->back();
        }
	}
	
	public function subscribe_process(Request $request)
	{
		try {
			Stripe::setApiKey(env('STRIPE_SECRET'));

			$user = User::find(1);
			$user->newSubscription('primary', 'plan_FKY1OcutV9Lwzj')->create($request->stripeToken, []);
            //Auth::user($user);
            
            $user->subscriber = 1;
            $user->update();
			//App('App\Http\Controllers\UsersController')->makeAdmin($user);
			//dd($user);
			session()->flash('success', 'Welcome to our blog '. $user->name);
            return redirect()->back();
		} catch (\Exception $ex) {
			return $ex->getMessage();
		}

}
}
