<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;

class PaymentController extends Controller
{
    public function charge(String $product, $price)
    {
        $user = auth()->user();
        return view('payment',[
        'user'=>$user,
        'intent' => $user->createSetupIntent(),
        'product' => $product,
        'price' => $price
    ]);
    }
    public function processPayment(Request $request, String $product, $price)
    {
        $user = Auth::user();

        $paymentMethod = $request->input('payment_method');
        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);
        try
        {
        $user->charge($price*100, $paymentMethod);
        }
        catch (\Exception $e)
        {
        return back()->withErrors(['message' => 'Error creating subscription. ' . $e->getMessage()]);
        }
        return redirect('home');
    }
    public function reportUsage(Request $request)
    {
        $user = Auth()->user();
       return $user->subscription('default')->reportUsage(15);
    }
}