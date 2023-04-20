<?php

namespace App\Http\Controllers\Front;

use App\Service\User\UserServiceInterface;
use App\Service\Order\OrderServiceInterface;
use App\Utilities\Constant;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utilities\Common;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AccountController extends Controller
{
    private $userService;
    private $orderService;

    public function __construct(UserServiceInterface $userService,
                                OrderServiceInterface $orderService)
    {
        $this->userService = $userService;
        $this->orderService = $orderService;
    }

    public function login()
    {
        if(Auth::id())
            return redirect('');
        else
            return view('front.account.login');
    }

    public function checkLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => Constant::user_level_client, //Tai khoan cap do khach hang
        ];

        $remember = $request->remember;

        if(Auth::attempt($credentials, $remember))
            return redirect()->intended('');
        else 
            return back()->with('notification', 'Error: Email or password is wrong');
    }

    public function logout()
    {
        Auth::logout();

        return back();
    }

    public function register()
    {
        if(Auth::id())
            return redirect('');
        else
            return view('front.account.register');
    }

    public function postRegister(Request $request) 
    {
        $email = User::where('email', $request->email)->get();
        
        if($email->count() != 0) {
            return back()->with('notification', "Error: Email already exists");
        }
        if($request->password != $request->password_confirmation) {
            return back()->with('notification', "Error: Confirm passsword does not match");
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'level' => Constant::user_level_client,
        ];

        $this->userService->create($data);

        return redirect('account/login')->with('notification', "Register Success! Please login.");
    }

    public function forgotPass()
    {
        if(Auth::id())
            return redirect('');
        else
            return view('front.account.forgotPass');
    }

    public function postForgotPass(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users'
        ]);

        $user = $this->userService->getUserByEmail($request->email);
        $email_to = $user[0]->email;
        $data = [
            'token' => Str::random(10)
        ];
        $this->userService->update($data, $user[0]->id);     

        $user_updated = $this->userService->find($user[0]->id);
        Mail::send('front.account.email',
                compact('user_updated'), 
                function($message) use($email_to){
                    $message->from('codelean@gmail.com', "CodeLean eShop");
                    $message->subject('Reset password');
                    $message->to($email_to, $email_to);
                });

        return redirect('account/forgot-password')->with('notification', "Success! Please check your email.");
    }

    public function resetPass($id, $token)
    {
        $user = $this->userService->find($id);
        
        if(Auth::id())
            return redirect('');
        if($user->token === $token)
            return view('front.account.resetPass');
        return abort(404);
    }

    public function postResetPass($id, $token, Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $data = [
            'password' => bcrypt($request->password),
            'token' => null
        ];
        
        $this->userService->update($data, $id);

        return redirect('account/login')->with('notification', "Success! Please login.");
    }

    //My Order
    public function myOrderIndex()
    {
        $orders = $this->orderService->getOrderByUserId(Auth::id());

        foreach($orders as $order) {
            $coupon_id = $order->orderDetails[0]->coupon;
            if($coupon_id != null) {
                $order->coupon_type = $coupon_id->type;
                $order->coupon_value = $coupon_id->value;
            }
        }

        return view('front.account.my-order.index', compact('orders'));
    }

    public function myOrderShow($id)
    {
        $order = $this->orderService->find($id);

        $coupon_id = $order->orderDetails[0]->coupon;
        if($coupon_id != null) {
            $order->coupon_type = $coupon_id->type;
            $order->coupon_value = $coupon_id->value;
        }

        return view('front.account.my-order.show', compact('order'));
    }

    //My Account
    public function myAccountIndex()
    {
        $user = $this->userService->find(Auth::id());

        return view('front.account.my-account.index', compact('user'));
    }

    public function myAccountEdit()
    {
        $user = $this->userService->find(Auth::id());

        return view('front.account.my-account.edit', compact('user'));
    }

    public function myAccountUpdate(Request $request)
    {
        $request->validate([
            'email' => 'unique:users,email,'.$request->id,
            'password_confirmation' => 'same:password'
        ]);
        $data = $request->all();

        //Xu ly mat khau
        if ($request->get('password') != null)
            $data['password'] = bcrypt($request->get('password'));
        else
            unset($data['password']);

        //Xu ly file anh
        if ($request->hasFile('image')) {
            //Them file moi
            $data['avatar'] = Common::uploadFile($request->file('image'), 'front/img/user');

            //Xoa file cu
            $file_name_old = $request->get('image_old');
            if($file_name_old != '') {
                unlink('front/img/user/' . $file_name_old);
            }
        }

        //Cap nhat du lieu
        $this->userService->update($data, $request->id);

        return redirect('./account/my-account')->with('notification', 'Update account succeed!');
    }
}
