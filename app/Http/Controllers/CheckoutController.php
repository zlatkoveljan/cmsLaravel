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
            return view('blog.show')->with('post', $post);
        }
	}
	
	public function subscribe_process(Request $request)
	{
		try {
			Stripe::setApiKey(env('STRIPE_SECRET'));

			$user = User::find(1);
			$user->newSubscription('primary', 'plan_FJc3YcGsfqMnDB')->create($request->stripeToken, []);

			session()->flash('success', 'Welcome to our blog, subscriber');
            return redirect()->back();
		} catch (\Exception $ex) {
			return $ex->getMessage();
		}

}
}
