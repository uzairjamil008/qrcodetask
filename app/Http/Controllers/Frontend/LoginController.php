<?php
namespace App\Http\Controllers\Frontend;

use App;
use App\Http\Controllers\Controller;
use App\Models\Role\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function userlogin()
    {
        $data['roles'] = Role::get();
        return view('frontend.auth.register', compact('data'));
    }
    public function adminlogin(Request $request)
    {
        $remember = false;
        if (isset($_POST['remember'])) {
            $remember = true;
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            $user = Auth::user();
            // dd($user);
            if ($user->status == "Inactive") {
                Auth::logout();
                Session::put("login_error", 'Sorry! Your account is suspended. Contact to our support team for further info');
                return redirect('admin/login');
            }
            return redirect('/admin/home');
        } else {
            Session::put("login_error", 'Credentials do not match our records');
            return redirect('/admin/login');
        }
    }
    public function register_user(Request $request)
    {
        $id = $request->id;
        $data = $request->all();
        $email_exist = User::where('email', $request->email)->first();
        if (!empty($email_exist)) {
            $response = array('response' => 0);
            return json_encode($response);
        } else {
            if ($request->role_id == 4) {
                $data['referral_code'] = uniqid();
            } elseif ($request->role_id == 3) {
                $code_exist = User::where('referral_code', $request->referral_code)->first();
                if (!empty($code_exist)) {
                    $data['affiliate_id'] = $code_exist->id;
                    unset($data['referral_code']);
                } else {
                    $response = array('response' => 2);
                    return json_encode($response);
                }
            }
            $action = "Added";
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            if ($id) {
                $action = "Updated";
                $modal = User::find($id);
                $affected_rows = $modal->update($data);
            } else {
                $affected_rows = User::create($data);
            }
            $this->send_email($request->email, 'Welcome to Maxhype', 'frontend.emails.mail', $data);
            $response = array('response' => 1);
            return json_encode($response);
        }
    }
    public function send_email($email, $subject, $template, $data)
    {
        Mail::send($template, ['data' => $data], function ($message) use ($subject, $email) {
            $message->to($email, $subject)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'), $subject);
        });
    }
    public function userlog()
    {
        $remember = false;
        if (isset($_POST['remember'])) {
            $remember = true;
        }
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            $user = Auth::user();
            if ($user->status == "Rejected" || $user->status == "Pending") {
                Auth::logout();
                Session::flush();
                Session::put('login_msg', "Your account is inactive. Kindly contact to administrator");
                return redirect()->back();
            }if ($user->role_id == 3) {
                return Redirect('/dashboard/' . $user->id);
            } elseif ($user->role_id == 4) {
                return Redirect('/dashboards1/' . $user->id . '/Affiliate');
            } elseif ($user->role_id == 5) {
                return Redirect('/dashboards/' . $user->id);
            }
            return Redirect('admin/admin_dashboard');
        } else {
            Session::put('login_msg', "Credetional do not match our record");
            return redirect()->back();
        }
    }
    //Logout function
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/auth');
    }
    //Forget Password function
    public function forget_password()
    {
        return view('frontend.auth.forget_password');
    }
}
