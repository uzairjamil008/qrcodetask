<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use App\Http\Requests;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
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
           if(Auth::attempt(['email' => $email, 'password' => $password,'role_id'=>5], $remember)) {
               $user = Auth::user();
               if($user->status == "Rejected" || $user->status == "Pending") {
                $response=array('status'=>0,'message'=>'Your account is inactive. Kindly contact to administrator');
               }else{
                 // $user=User::find($user->id)->first();
                   $response=array('status'=>1,'message'=>'Logged in Successfully','user'=>$user);
               }

           } else {
             $response=array('status'=>0,'message'=>'Invalid Credentials');
           }
           $response=json_encode($response);
           return $response;
    }
  public function customerregister(Request $request){
        $id = $request->id;
        $data = $request->all();
      //    return json_encode($data);
      // exit;

        $email_exist=User::where('email',$request->email)->first();
        if(!empty($email_exist)){
        $response = array('status' => 0,'message'=>'Email Already Exists');
        return json_encode($response);
        }
        if(!empty($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
        }
      
            $affected_rows = User::create($data);
            $user = User::find($affected_rows->id);
            //event(new Registered($affected_rows));
            $response = array('status' => 1,'message'=>'Registered Successfully','user'=>$user);
            return json_encode($response);
    }
  public function delete_account($id){
        $user=User::find($id);
          if($user){
              $user->delete();
              $response = array('status' => 1,'message'=>'Account Deleted Successfully');
              return json_encode($response);
            }
            $response = array('status' => 0,'message'=>'Account does not exist');
            return json_encode($response);
  }
   public function users_list(){
            $users=User::get();
            $response = array('status' => 1,'users'=>$users);
            return json_encode($response);
  }

}
?>