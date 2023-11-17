<?php

namespace App\Http\Controllers\Business;

use App;
use App\Http\Controllers\Controller;
use App\Models\Bookings\Booking;
use App\Models\Locations\Countries;
use App\Models\Product\Product;
use App\Models\ReceivingAccount\ReceivingAccount;
use App\Models\Reservations\Reservation;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class BusinessController extends Controller
{

    public function business(Request $request)
    {

        $data['page_title'] = "All Businesses";

        $data['results'] = User::where('role_id', 3)->get();

        return view('business.view', compact('data'));
    }

    public function get_business(Request $request)
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
        $totalRecords = User::where('role_id', 3)->count();

        // Total records with filtering
        $filteredRecords = User::where('role_id', 3)
            ->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('type', 'like', '%' . $searchValue . '%');
            })
            ->count();

        $records = User::where('role_id', 3)
            ->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('type', 'like', '%' . $searchValue . '%');
            })
            ->orderBy('name', 'asc')
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = [];

        foreach ($records as $record) {

            $action = '
            <div class="dropdown">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                    <i data-feather="more-vertical"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="' . url('admin/businesses', $record->id) . '">
                        <i data-feather="edit-2" class="mr-50"></i>
                        <span>Edit</span>
                    </a>
                    <a data-href="' . url('admin/deletebusiness', $record->id) . '" data-toggle="modal" data-target="#confirm-delete" class="dropdown-item" href="javascript:void(0);">
                        <i data-feather="trash" class="mr-50"></i>
                        <span>Delete</span>
                    </a>
                    <a href="' . url('admin/business_details', $record->id) . '" class="dropdown-item">
                        <i data-feather="file-text" class="mr-50"></i>
                        <span>Detail</span>
                    </a>
                </div>
            </div>';


            $data_arr[] = [
                "id" => $record->id,
                "name" => $record->name,
                "type" => $record->type,
                "email" => $record->email,
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


    public function businesses($id = -1)
    {

        $data['page_title'] = "Add Business Details";

        $data['country'] = Countries::get();

        $data['affiliate'] = User::where('role_id', 4)->get();

        $data['business'] = User::where('role_id', 3)->get();

        if ($id != -1) {

            $data['page_title'] = "Update Business Details";

            $data['results'] = User::where('id', $id)->first();

            // dd(json_decode($data['results']->images));

            $data['products'] = Product::where('business_id', $id)->get();

            $data['products'] = view('business.partials.products', compact('data'))->render();
        }

        return view('business.save', compact('data'));
    }

    public function savebusiness(Request $request)
    {

        $id = $request->id;

        $data = $request->all();

        if (!isset($data['hide_listing'])) {
            $data['hide_listing'] = 0;
        }

        if (!isset($data['top_business'])) {
            $data['top_business'] = 0;
        }

        if (!empty($data['password'])) {

            $data['password'] = Hash::make($data['password']);
        } else {

            unset($data['password']);
        }

        $data['images'] = set_multi_uploads($data['old_images'], $data['images']);

        unset($data['old_images']);

        $action = "Added";

        if ($id) {

            $action = "Updated";

            $affected_rows = User::find($id)->update($data);
        } else {

            $affected_rows = User::create($data);
        }

        $message = set_message($affected_rows, 'Business', $action);

        Session::put('message', $message);

        return Redirect('admin/business');
    }

    public function deletebusiness($id)
    {
        $affected_rows = User::find($id)->delete();

        $message = set_message($affected_rows, 'Business', 'Deleted');

        Session::put('message', $message);

        return Redirect('admin/business');
    }

    public function booking()
    {

        $data['page_title'] = "All Bookings";

        $data['results'] = Booking::get();

        return view('bookings.view', compact('data'));
    }

    public function bookingsdetails($id)
    {

        $data['page_title'] = "Booking Details";

        $data['results'] = Booking::where('id', $id)->first();

        return view('bookings.details', compact('data'));
    }

    //Business Request

    public function accepted()
    {

        $data['page_title'] = "Accepted Request ";

        $data['results'] = User::where('status', 'Accepted')->get();

        return view('business.accepted', compact('data'));
    }

    public function rejected()
    {

        $data['page_title'] = "Rejected Request ";

        $data['results'] = User::where('status', 'Rejected')->get();

        return view('business.rejected', compact('data'));
    }

    public function pending()
    {

        $data['page_title'] = "Pending Request ";

        $data['results'] = User::where('status', 'Pending')->get();

        return view('business.pending', compact('data'));
    }

    public function businessdetails($id)
    {

        $data['page_title'] = "Business Details";

        $data['results'] = User::where('id', $id)->first();

        $data['videos'] = Video::where('users_id', $id)->get();

        $data['reservation'] = Reservation::where('business_id', $id)->where('type', 'Reservation')->get();

        $data['purchase'] = Reservation::where('business_id', $id)->where('type', 'Purchase')->get();

        $data['products'] = Product::where('business_id', $id)->get();

        $data['account_details'] = ReceivingAccount::where('user_id', $id)->first();

        return view('business.details', compact('data'));
    }

    public function reservationDetails($id)
    {

        $data['page_title'] = "Reservation";
        $data['results'] = Reservation::where('id', $id)->where('type', 'Reservation')->first();
        return view('business.reservationdetails', compact('data'));
    }

    public function purchaseDetails($id)
    {
        $data['page_title'] = "Purchase";
        $data['results'] = Reservation::where('id', $id)->where('type', 'Purchase')->first();
        return view('business.purchasedetails', compact('data'));
    }

    //Business Owner

    public function business_owners()
    {

        $data['page_title'] = "Business Owners";

        $data['results'] = User::where('role_id', 3)->get();

        return view('business.owners', compact('data'));
    }

    public function purchased()
    {

        $data['page_title'] = "All Purchase";

        $data['results'] = Reservation::where('type', 'Purchase')->get();

        return view('business.purchase', compact('data'));
    }

    public function get_purchase(Request $request)
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
        $totalRecords = Reservation::where('type', 'Purchase')->count();

        // Total records with filtering
        $filteredRecords = Reservation::where('type', 'Purchase')
            ->where(function ($query) use ($searchValue) {
                $query->where('business_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('date', 'like', '%' . $searchValue . '%')
                    ->orWhere('time', 'like', '%' . $searchValue . '%')
                    ->orWhere('remarks', 'like', '%' . $searchValue . '%')
                    ->orWhere('total_tickets', 'like', '%' . $searchValue . '%')
                    ->orWhere('price', 'like', '%' . $searchValue . '%')
                    ->orWhere('admin_notes', 'like', '%' . $searchValue . '%');
            })
            ->count();

        $records = Reservation::where('type', 'Purchase')
            ->where(function ($query) use ($searchValue) {
                $query->where('business_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('date', 'like', '%' . $searchValue . '%')
                    ->orWhere('time', 'like', '%' . $searchValue . '%')
                    ->orWhere('remarks', 'like', '%' . $searchValue . '%')
                    ->orWhere('total_tickets', 'like', '%' . $searchValue . '%')
                    ->orWhere('price', 'like', '%' . $searchValue . '%')
                    ->orWhere('admin_notes', 'like', '%' . $searchValue . '%');
            })
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = [];

        foreach ($records as $record) {

            $action = '
            <div class="dropdown">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                    <i data-feather="more-vertical"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item remarksbtn" href="javascript:void(0)" data-id="' . ($record->id) . '">
                       <i data-feather="file-text" class="mr-50"></i>
                       <span>Remarks</span>
                    </a>
                     <a class="dropdown-item" href="' . url('admin/purchase_details', $record->id) . '">
                        <i data-feather="file-text" class="mr-50"></i>
                        <span>Detail</span>
                    </a>
                </div>
            </div>';


            $data_arr[] = [
                "id" => $record->id,
                "business_id" => $record->business_name->name,
                "date" => $record->date,
                "time" => $record->time,
                "remarks" => $record->remarks,
                "total_tickets" => $record->total_tickets,
                "price" => $record->price,
                "admin_notes" => $record->admin_notes,
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

    public function reserved()
    {

        $data['page_title'] = "All Reservation";

        $data['results'] = Reservation::where('type', 'Reservation')->get();

        return view('business.reservation', compact('data'));
    }

    public function get_reservation(Request $request)
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
        $totalRecords = Reservation::where('type', 'Reservation')->count();

        // Total records with filtering
        $filteredRecords = Reservation::where('type', 'Reservation')
            ->where(function ($query) use ($searchValue) {
                $query->where('business_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('date', 'like', '%' . $searchValue . '%')
                    ->orWhere('check_out_date', 'like', '%' . $searchValue . '%')
                    ->orWhere('return_date_time', 'like', '%' . $searchValue . '%')
                    ->orWhere('remarks', 'like', '%' . $searchValue . '%')
                    ->orWhere('people', 'like', '%' . $searchValue . '%')
                    ->orWhere('admin_notes', 'like', '%' . $searchValue . '%');
            })
            ->count();

        $records = Reservation::where('type', 'Reservation')
            ->where(function ($query) use ($searchValue) {
                $query->where('business_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('date', 'like', '%' . $searchValue . '%')
                    ->orWhere('check_out_date', 'like', '%' . $searchValue . '%')
                    ->orWhere('return_date_time', 'like', '%' . $searchValue . '%')
                    ->orWhere('remarks', 'like', '%' . $searchValue . '%')
                    ->orWhere('people', 'like', '%' . $searchValue . '%')
                    ->orWhere('admin_notes', 'like', '%' . $searchValue . '%');
            })
            ->orderBy($columnName, $columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();


        $data_arr = [];

        foreach ($records as $record) {

            $action = '
            <div class="dropdown">
                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
                    <i data-feather="more-vertical"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item remarksbtn" href="javascript:void(0)" data-id="' . ($record->id) . '">
                       <i data-feather="file-text" class="mr-50"></i>
                       <span>Remarks</span>
                    </a>
                     <a class="dropdown-item" href="' . url('admin/reservation_details', $record->id) . '">
                        <i data-feather="file-text" class="mr-50"></i>
                        <span>Detail</span>
                    </a>
                </div>
            </div>';


            $data_arr[] = [
                "id" => $record->id,
                "business_id" => $record->business_name->name,
                "date" => $record->date,
                "check_out_date" => $record->check_out_date,
                "return_date_time" => $record->return_date_time,
                "remarks" => $record->remarks,
                "people" => $record->people,
                "admin_notes" => $record->admin_notes,
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

    public function upload_file(Request $request)
    {

        $path = $_GET['url'];

        $path = str_replace('-', '/', $path);

        if (!empty($_FILES)) {

            $date = new \DateTime();

            $current_dir = str_replace('uploads', '', getcwd());

            $tempPath = $_FILES['file']['tmp_name'];

            $name = str_replace(' ', '', $_FILES['file']['name']);

            $filename = $date->getTimestamp() . '-' . $name;

            //            $filename=$name;

            $uploadPath = $current_dir . $path . DIRECTORY_SEPARATOR . $filename;

            //            print_r($uploadPath); exit;

            move_uploaded_file($tempPath, $uploadPath);

            $answer = array('answer' => 'File transfer completed');

            $json = json_encode($answer);

            $newFileName = $path . '/' . $filename;

            echo $newFileName;
        } else {

            echo 'No files';
        }
    }

    public function deletefiles(Request $request)
    {

        $ds = DIRECTORY_SEPARATOR; // Store directory separator (DIRECTORY_SEPARATOR) to a simple variable. This is just a personal preference as we hate to type long variable name.

        $storeFolder = 'uploads';

        $fileList = $_POST['fileList'];

        $path = $_POST['path'];

        $targetPath = getcwd() . $fileList;

        $path = str_replace('/', '/', $path);

        //dd(trim($fileList));

        if (isset($fileList)) {

            unlink($targetPath . $fileList);
        }
    }

    public function uploadImage()
    {

        // dd($_FILES);

        // dd('test');

        if (!empty($_FILES)) {

            $date = new \DateTime();

            $current_dir = getcwd();

            $tempPath = $_FILES['file']['tmp_name'];

            $name = str_replace(' ', '', $_FILES['file']['name']);

            $filename = $date->getTimestamp() . '-' . $name;

            $filePath = '\public\uploads\images' . DIRECTORY_SEPARATOR . $filename;

            $savedPath = '/public/uploads/images/' . $filename;

            // $uploadPath = $current_dir . '' . DIRECTORY_SEPARATOR . $date->getTimestamp() . '-' . $name;

            $uploadPath = $current_dir . $filePath;

            // print_r($uploadPath);

            // exit;

            move_uploaded_file($tempPath, $uploadPath);

            echo $savedPath;
        }
    }

    public function removeimg(Request $request)
    {

        // dd('test');

        $path = $request->path;

        // dd($path);

        $dir_path = getcwd() . '/' . $path;

        unlink($dir_path);
    }

    public function approve_request($id)
    {

        $data['results'] = User::where('id', $id)->update(['status' => 'Accepted']);
        $data['results'] = User::where('id', $id)->first();
        $email = $data['results']->email;
        $message = set_message('Your Request', 'Status', 'Updated');
        $this->send_email($email, 'Welcome to Maxhype', 'emails.accepted', $data);
        Session::put('message', $message);

        return Redirect('admin/accepted');
    }
    public function send_email($email, $subject, $template, $data)
    {
        Mail::send($template, ['data' => $data], function ($message) use ($subject, $email) {
            $message->to($email, $subject)->subject($subject);
            $message->from(env('MAIL_FROM_ADDRESS'), $subject);
        });
    }
    public function reject_request($id)
    {

        $data['results'] = User::where('id', $id)->update(['status' => 'Rejected']);

        $message = set_message('Your Request', 'Status', 'Updated');

        Session::put('message', $message);

        return Redirect('admin/rejected');
    }

    public function productmodal(Request $request)
    {

        $data['users_id'] = $request->users_id;

        $data['results'] = Product::where('id', $request->id)->first();

        // $data['business'] = User::where('role_id',3)->get();

        $modal = view('business.partials.product_form', compact('data'))->render();

        $response = array('response' => $modal);

        return json_encode($response);
    }

    public function saveproduct(Request $request)
    {

        $id = $request->id;

        $data = $request->all();

        if (!isset($data['tickets_available'])) {

            $data['tickets_available'] = 0;
        }

        // dd($data);

        $action = "Added";

        if ($id) {

            $action = "Updated";

            $modal = Product::find($id);

            $affected_rows = $modal->update($data);
        } else {

            $affected_rows = Product::create($data);
        }

        $data['products'] = Product::where('business_id', $request->business_id)->get();

        $response = view('business.partials.products', compact('data'))->render();

        $response = array('response' => $response);

        return json_encode($response);
    }

    public function deleteproduct($id, $user_id)
    {

        $affected_rows = Product::find($id)->delete();

        $data['products'] = Product::where('business_id', $user_id)->get();

        $response = view('business.partials.products', compact('data'))->render();

        $response = array('response' => $response);

        return json_encode($response);
    }
}
