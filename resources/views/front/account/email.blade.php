<div style="width:600px; margin: 0 auto;">
    <div style="text-align: center">
        <h2>Hello {{ $user_updated->name}}</h2>
        <p>Click the link below to reset your password</p>
        <p>
            <a href="{{ route('account.resetPass', ['id' => $user_updated->id, 'token' => $user_updated->token])}}"
                style="display: inline-block; background: rgb(8, 19, 63); color: #fff; padding: 7px 25px; font-weight:bold">
                Reset Password
            </a>
        </p>
    </div>
</div>