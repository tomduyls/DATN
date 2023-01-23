<?php

namespace App\Http\Controllers\Front;

use App\Service\User\UserServiceInterface;
use App\Service\Order\OrderServiceInterface;
use App\Utilities\Constant;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function myOrderIndex()
    {
        $orders = $this->orderService->getOrderByUserId(Auth::id());

        return view('front.account.my-order.index', compact('orders'));
    }

    public function myOrderShow($id)
    {
        $order = $this->orderService->find($id);

        return view('front.account.my-order.show', compact('order'));
    }
}
