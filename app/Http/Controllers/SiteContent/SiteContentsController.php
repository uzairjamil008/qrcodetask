<?php

namespace App\Http\Controllers\SiteContent;

use App\Http\Controllers\Controller;
use App\Models\SiteContent\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SiteContentsController extends Controller
{
    public function siteContent(Request $request)
    {
        $data['page_title'] = "Update Site Content";
        $data['results'] = SiteContent::get()->first();
        return view("sitecontent.index", compact('data'));
    }

    public function saveSiteContent(Request $request)
    {
        $id = $request->id;
        $modal = new SiteContent();
        $data = $request->all();
        $action = "Added";
        if ($id) {
            $action = "Updated";
            $modal = SiteContent::find($id);
            $affected_rows = $modal->update($data);
        } else {

            $affected_rows =  $modal::create($data);
        }
        $message =   set_message($affected_rows, 'site content', $action);
        Session::put('message', $message);
        return Redirect('/admin/site_content');
    }
}
