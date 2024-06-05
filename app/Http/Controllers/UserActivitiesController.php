<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemLogs;

class UserActivitiesController extends Controller
{
    //
    public function index()
    {
        $userActivities = SystemLogs::orderBy('_id','DESC')->paginate(10);
        return view('admin.user-activity.index',compact('userActivities'));
    }
    public function getDetails($id)
    {
        $systemLogs = SystemLogs::where('_id',$id)->first();
        return view('admin.user-activity.details',compact('systemLogs'));
    }
}
