<?php

namespace App\Http\Controllers;

use App;

use Illuminate\Http\Request;

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Details;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use Carbon\Carbon;
use Redirect;
use URL;
use Session;
use App\Cart;
use App\Purchase;
use Auth;

class PaymentController extends Controller
{
    private $apiContext;
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }


    public function payWithpaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        
        $item_1 = new Item();
        $item_1->setName('Movies Name') /** item name **/
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($request->amount / 380); /** unit price in NGN**/

        $item_list = new ItemList();
                $item_list->setItems(array($item_1));

        $amount = new Amount();
                $amount->setCurrency('USD')
                    ->setTotal($item_1->getPrice());

        $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('You have decided to purchase the above movie. Please click to continue');

        $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(URL::route('status')) /** Specify return URL **/
                    ->setCancelUrl(URL::route('status'));



        $payment = new Payment();
                $payment->setIntent('Sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
                /** dd($payment->create($this->_api_context));exit; **/

                try {
                    $payment->create($this->_api_context);
                    

                } catch (Exception $ex) {
                    return "djfadfa";
                    print_r(json_decode($ex->getData()));

                    exit;
                    if (\Config::get('app.debug')) {
                        \Session::put('error', 'Connection timeout');
                        return redirect()->route('paywithpaypal');
                    } else {
                        \Session::put('error', 'Some error occured, sorry for inconvenience');
                        return redirect()->route('paywithpaypal');
                    }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        \Session::put('error', 'Unknown error occurred');
            return redirect()->route('paywithpaypal');
        }



        public function getPaymentStatus(){
            /** Get the payment ID before session clear **/
            $payment_id = Session::get('paypal_payment_id');

            /** clear the session payment ID **/
            Session::forget('paypal_payment_id');

            if (empty(\Request::get('PayerID')) || empty(\Request::get('token'))) {
                \Session::put('error', 'Payment failed');
                return redirect()->route('showcart');
            }

            $payment = Payment::get($payment_id, $this->_api_context);
                    $execution = new PaymentExecution();
                    $execution->setPayerId(\Request::get('PayerID'));

            /**Execute the payment **/
            $result = $payment->execute($execution, $this->_api_context);
            if ($result->getState() == 'approved') {
                \Session::put('success', 'Payment Successful.');
                return redirect()->route('payment-info');
                
            }

                \Session::put('error', 'Payment failed');
                    return redirect()->route('showcart');

        }


        public function paymentInfo(){

            //Add cart items to purchased
            $cart = Cart::where('user_id', Auth::id())->get();
            if(!empty($cart) && count($cart) == 1){

                $mIds = explode(',', $cart[0]->movie_ids);
                foreach($mIds as $mId){
                    Purchase::create([
                        'date_purchased' => date('Y-m-d H:i:s'),
                        'movie_id' => $mId,
                        'user_id' => Auth::id()
                    ]);
                }

                $cart[0]->delete();

            }

            return view('purchases.info');
        }
}
