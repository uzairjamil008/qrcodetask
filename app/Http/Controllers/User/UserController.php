<?php

namespace App\Http\Controllers\User;

use App;
use App\Http\Controllers\Controller;
use App\Models\Contacts\Contact;
use App\Models\Role\Role;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function role($id = -1)
    {

        $data['page_title'] = "Add Role";

        if ($id != -1) {

            $data['page_title'] = "Update Role";

            $data['results'] = Role::where('id', $id)->first();
        }

        return view('roles.save', compact('data'));
    }

    public function userstatus(Request $request)
    {

        $id = $request->id;

        $data = $request->all();

        $affected_rows = User::find($id)->update($data);

        $response = array('status' => 1, 'msg' => 'Data Updated');

        $response = json_encode($response);

        return $response;
    }

    public function saverole(Request $request)
    {

        $id = $request->id;

        $data = $request->all();

        $action = "Added";

        if ($id) {

            $action = "Updated";

            $modal = Role::find($id);

            $affected_rows = $modal->update($data);
        } else {

            $affected_rows = Role::create($data);
        }

        $message = set_message($affected_rows, 'Role', $action);

        Session::put('message', $message);

        return Redirect('/admin/roles');
    }

    public function roles()
    {

        $data['page_title'] = "Roles";

        $data['results'] = Role::get();

        return view('roles.index', compact('data'));
    }

    public function deleterole($id)
    {

        $affected_rows = Role::find($id)->delete();

        $message = set_message($affected_rows, 'Role', 'Deleted');

        Session::put('message', $message);

        return redirect()->back();
    }

    public function users()
    {

        $data['page_title'] = "Users";

        $data['results'] = User::get();

        return view('users.index', compact('data'));
    }

    public function get_users(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        // Total records
        $totalRecords = User::count();

        // Total records with filtering
        $filteredRecords = User::where(function ($query) use ($searchValue) {
            $query->where('first_name', 'like', '%' . $searchValue . '%')
                ->orWhere('last_name', 'like', '%' . $searchValue . '%')
                ->orWhere('referral_code', 'like', '%' . $searchValue . '%')
                ->orWhere('email', 'like', '%' . $searchValue . '%')
                ->orWhere('role_id', 'like', '%' . $searchValue . '%')
                ->orWhere('status', 'like', '%' . $searchValue . '%');
        })->count();

        $records = User::where(function ($query) use ($searchValue) {
            $query->where('first_name', 'like', '%' . $searchValue . '%')
                ->orWhere('last_name', 'like', '%' . $searchValue . '%')
                ->orWhere('referral_code', 'like', '%' . $searchValue . '%')
                ->orWhere('email', 'like', '%' . $searchValue . '%')
                ->orWhere('role_id', 'like', '%' . $searchValue . '%')
                ->orWhere('status', 'like', '%' . $searchValue . '%');
        })
            ->orderBy('name', 'asc')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = [];

        foreach ($records as $record) {

            $statusBadge = '';
            if ($record->status == "Accepted") {
                $statusBadge = '<span data-id="' . $record->id . '" data-status="' . ($record->status == 'Active' ? 'Inactive' : 'Active') . '" class="badge badge-pill badge-light-primary mr-1 pointer btnstatus">' . $record->status . '</span>';
            } elseif ($record->status == "Rejected" || $record->status == "Pending") {
                $statusBadge = '<span data-id="' . $record->id . '" data-status="' . ($record->status == 'Active' ? 'Inactive' : 'Active') . '" class="badge badge-pill badge-light-warning mr-1 pointer btnstatus">' . $record->status . '</span>';
            }

            $action = '
            <div class="dropdown">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                    <i data-feather="more-vertical"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="' . url('admin/user', $record->id) . '">
                        <i data-feather="edit-2" class="mr-50"></i>
                        <span>Edit</span>
                    </a>
                    
                    <a data-href="' . url('admin/deleteuser', $record->id) . '" data-toggle="modal" data-target="#confirm-delete" class="dropdown-item" href="javascript:void(0);">
                        <i data-feather="trash" class="mr-50"></i>
                        <span>Delete</span>
                    </a>
                    
                </div>
            </div>';


            $data_arr[] = [
                "id" => $record->id,
                "first_name" => $record->first_name,
                "last_name" => $record->last_name,
                "referral_code" => $record->referral_code,
                "email" => $record->email,
                "role_id" => $record->role->role_title,
                "status" => $statusBadge,
                "action" => $action,
            ];
        }

        $response = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $filteredRecords,
            "aaData" => $data_arr,
        ];

        return $response;
    }

    public function user($id = -1)
    {

        $data['page_title'] = "Add User";

        $data['roles'] = Role::get();
        $data['affiliate'] = User::where('role_id', 4)->get();

        if ($id != -1) {

            $data['page_title'] = "Update User";

            $data['results'] = User::where('id', $id)->first();
        }

        return view('users.save', compact('data'));
    }

    public function saveuser(Request $request)
    {

        $id = $request->id;
        $data = $request->all();
        if ($request->role_id == 4) {
            $data['referral_code'] = $request->referral_code;
        }

        unset($data['cpassword']);

        $action = "Added";

        if (!empty($data['password'])) {

            $data['password'] = Hash::make($data['password']);
        } else {

            unset($data['password']);
        }

        if ($id) {

            $action = "Updated";

            $affected_rows = User::find($id)->update($data);
        } else {

            $affected_rows = User::create($data);
        }

        $message = set_message($affected_rows, 'User', $action);

        Session::put('message', $message);

        return Redirect('/admin/users');
    }

    public function deleteuser($id)
    {

        $affected_rows = User::find($id)->delete();

        $message = set_message($affected_rows, 'User', 'Deleted');

        Session::put('message', $message);

        return Redirect('admin/users');
    }

    // User Messages

    public function usermessages()
    {

        $data['page_title'] = "User Queries";

        $data['results'] = Contact::get();

        return view('messages.view', compact('data'));
    }

    public function messagemodal($id)
    {

        $modal = view('messages.details', compact('data'))->render();

        $response = array('response' => $modal);

        return json_encode($response);
    }

    public function adminlogout(Request $request)
    {

        $user = Auth::user();

        Auth::logout();

        Session::flush();

        return redirect('admin/login');
    }

    public function video()
    {

        $data['page_title'] = "Videos";

        $data['results'] = Video::get();

        return view('videos.index', compact('data'));
    }

    public function videos($id = -1)
    {

        $data['page_title'] = "Add Videos URL";

        $data['business'] = User::where('role_id', 3)->get();

        if ($id != -1) {

            $data['page_title'] = "Update Videos URL";

            $data['results'] = Video::where('id', $id)->first();
        }

        return view('videos.save', compact('data'));
    }

    public function savevideo(Request $request)
    {

        $id = $request->id;

        $data = $request->all();

        $action = "Added";

        if ($id) {

            $action = "Updated";

            $modal = Video::find($id);

            $affected_rows = $modal->update($data);
        } else {

            $affected_rows = Video::create($data);
        }

        $message = set_message($affected_rows, 'Video URL', $action);

        Session::put('message', $message);

        return Redirect('/admin/video');
    }

    public function deletevideo($id)
    {

        $affected_rows = Video::find($id)->delete();

        $message = set_message($affected_rows, 'Video URL', 'Deleted');

        Session::put('message', $message);

        return redirect()->back();
    }
}
