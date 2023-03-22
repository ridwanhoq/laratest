Refactoring web.php
Besides spacing and proper formatting, I choose to use the proper restful action name as a class method name.

-    // Forget &Reset passowrd
- Route::get('/forget-passowrd', [PasswordController::class, 'forgetPassword'])->name('forget.password');
- Route::post('/forget-password', [PasswordController::class, 'forgetPasswordEmailPost'])->name('forget.password.post');
- Route::get('/reset-password/{token}', [PasswordController::class, 'resetPassword'])->name('reset.password');
- Route::post('/reset_password', [PasswordController::class, 'resetPasswordPost'])->name('reset.password.post');

+ // Forget & Reset Password
+ Route::get('/forget-password', [PasswordController::class, 'create'])->name('forget.password');
+ Route::post('/forget-password', [PasswordController::class, 'store'])->name('forget.password.post');
+ Route::get('/reset-password/{token}', [PasswordController::class, 'show'])->name('reset.password');
+ Route::post('/reset-password', [PasswordController::class, 'update'])->name('reset.password.post');
Refactoring Controller
app/Http/Controllers/Admin/PasswordController.php
There are four methods that I am going to touch on here.

create()
-    public function forgetPassword()
+    public function create()
    {
        return view('admin.pages.password.forget_password');
    }
store()
The original name was forgetPasswordEmailPost which doesn't follow the restful action name. Therefore I suggest using store(), although it does more than persisting data.

- public function forgetPasswordEmailPost(Request $request)
- {
-     $request->validate([
-         'email'=>'required|exists:users'
-     ]);
-     $token=Str::random(50);
-     $user=User::where('email', $request->email)->first();
-     $user->update([
-         'reset_token'=>$token,
-         'reset_token_expire_at'=>Carbon::now()->addMinute(2),
-     ]);
-     $link=route('reset.password', $token);
-     Mail::to($request->email)->send(new ResetPasswordMail($link));
-     return redirect()->route('master.login');
- }
So, here is my suggestion:

+ public function store(Request $request)
+ {
+     $validator = $request->validate([
+         'email' => 'required|exists:users'
+     ]);
+ 
+     if ($validator->fails()) {
+         return redirect()
+             ->back()
+             ->withErrors($validator)
+             ->withInput();
+     }
+ 
+     User::where('email', $request->email)
+         ->firstOrFail()
+         ->update([
+             'reset_token' => $token = Str::random(50),
+             'reset_token_expire_at' => Carbon::now()->addDay(),
+         ]);
+ 
+     // I will suggest to trigger an event from here.
+     Mail::to($request->email)->send(new ResetPasswordMail(route('reset.password', $token)));
+ 
+     return redirect()->route('master.login');
+ }
show(string $token)
Originally it was called resetPassword() which I suggest as show().

original code

- public function resetPassword($token)
- {
-     return view('admin.pages.password.reset_password', compact('token'));
- }
My Suggestion

In my suggestion, I literally add an extra checking before processing, nothing else.

+ public function show(string $token)
+ {
+     if (!$token) {
+         abort(404);
+     }
+ 
+     return view('admin.pages.password.reset_password', compact('token'));
+ }
update()
Here is brought a lot of changes.

Original Code

- public function resetPasswordPost(Request $request)
- {
-     $request->validate([
-         'reset_token'=>'required',
-         'password'=>'required|confirmed',
-     ]);
-     //check token exist or not
-     $userHasToken=User::where('reset_token',$request->reset_token)->first();
-     if($userHasToken){
-         //check token expired or not
-         if($userHasToken->reset_token_expire_at>=Carbon::now()){
-            $userHasToken->update([
-               'password'=> bcrypt($request->password),
-                'reset_token'=>null
-            ]);
-            return redirect()->back();
-         }else{
-             return redirect()->back();
-         }
-     } else
-     {
-         return redirect()->back();
-     }
- }
My Opinion & Changes: Honestly, I don't like too deep indentation and if-else so much. Therefore, I suggest following refactoring-

+ public function update(Request $request)
+ {
+     $validator = $request->validate([
+         'reset_token' => 'required',
+         'password' => 'required|confirmed',
+     ]);
+ 
+     if ($validator->fails()) {
+         return redirect()
+             ->back()
+             ->withErrors($validator)
+             ->withInput();
+     }
+ 
+     $user = User::query()
+         ->where("reset_token", $request->reset_token)
+         ->isTokenAlived()
+         ->firstOrFail();
+ 
+     $user->update([
+         'password' => bcrypt($request->password),
+         'reset_token' => null
+     ]);
+
+     return redirect()->back();
+ }
Honestly to me, it's a huge gain with this method's refactoring.

However, I captured the screencast during refactoring. Unfortunately, it's in Bengali language. If you are interested, you can watch it at the below link.