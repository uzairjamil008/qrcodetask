<?php
namespace App\Http\Controllers\Api;

use App;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function userlog(Request $request)
    {
        // dd('asdf');
        // return json_encode($request->email);
        // exit;

        $remember = false;

        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role_id' => 5], $remember)) {
            $user = Auth::user();
            if ($user->status == "Rejected" || $user->status == "Pending") {
                $response = array('status' => 0, 'message' => 'Your account is inactive. Kindly contact to administrator');
            } else {
                // $user=User::find($user->id)->first();
                $response = array('status' => 1, 'message' => 'Logged in Successfully', 'user' => $user);
            }

        } else {
            $response = array('status' => 0, 'message' => 'Invalid Credentials');
        }
        $response = json_encode($response);
        return $response;
    }
    public function customerregister(Request $request)
    {
        $id = $request->id;
        $data = $request->all();
        //    return json_encode($data);
        // exit;

        $email_exist = User::where('email', $request->email)->first();
        if (!empty($email_exist)) {
            $response = array('status' => 0, 'message' => 'Email Already Exists');
            return json_encode($response);
        }
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $affected_rows = User::create($data);
        $user = User::find($affected_rows->id);
        //event(new Registered($affected_rows));
        $response = array('status' => 1, 'message' => 'Registered Successfully', 'user' => $user);
        return json_encode($response);
    }
    public function delete_account($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            $response = array('status' => 1, 'message' => 'Account Deleted Successfully');
            return json_encode($response);
        }
        $response = array('status' => 0, 'message' => 'Account does not exist');
        return json_encode($response);
    }
    public function users_list()
    {
        $users = User::get();
        $response = array('status' => 1, 'users' => $users);
        return json_encode($response);
    }

    public function change_password(Request $request)
    {
        $id = $request->user_id;
        $user = User::where('id', $id)->first();
        $current_password = $request->old_password;
        $new_password = $request->new_password;
        if (!Hash::check($current_password, $user->password)) {
            return response()->json(['message' => 'The current password is incorrect'], 422);
        }

        if (Hash::check($new_password, $user->password)) {
            return response()->json(['message' => 'You cannot set your current password as your new password'], 422);
        }

        if ($current_password !== $new_password) {
            $user->update(['password' => bcrypt($new_password)]);
        }
        $response = array('message' => 'Password Updated Successfully');
        return $response;

    }

    public function forgot_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response([
                'message' => 'Email not found in our records',
            ]);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            return [
                'status' => __($status),
            ];
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function reset(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'token' => 'required',
        //     'email' => 'required|email',
        //     'password' => ['required', 'confirmed'],
        // ]);

        // if ($validator->fails()) {
        //     return response([
        //         'message' => 'Validation error',
        //         'errors' => $validator->errors(),
        //     ], 400);
        // }
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return response([
                'message' => 'Password reset successfully',
            ]);
        }

        return response([
            'message' => __($status),
        ], 500);

    }

}
