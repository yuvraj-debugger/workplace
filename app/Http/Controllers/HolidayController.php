<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\RolesPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Holiday;
use Illuminate\Support\Facades\Session;

class HolidayController extends Controller
{
    //
    public function holidays(Request $request)
    {
        if ((Auth::user()->user_role == 0) || Permission::userpermissions('holidays', 1) || RolesPermission::userpermissions('holidays', 1)) {
            $date = $request->date_search ?? "";
            $holidays_search = $request->holiday_search ?? "";
            $holidays = Holiday::orderBy('_id','asc');
            
            if (($date) && ($date != 'all') && ($date != '')) {
                $holidays = Holiday::where('date',strtotime($date));
            }
            if (($holidays_search) && ($holidays_search != 'all') && ($holidays_search != '')) {
                $holidays = Holiday::where('_id',$holidays_search);
            }
            $holidays =$holidays->paginate(10);
            return view('admin.holiday.holiday-index',compact('holidays','holidays_search','date'));
        } else {
            return redirect('/dashboard');
        }
        
    }
    public function addHoliday(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'title' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $holiday = Holiday::Create([
            'date' => strtotime($request->date),
            'title' => $request->title,
            'created_by'=>Auth::user()->_id,
        ]);
        Session::flash('success', 'Holiday added successfully');
        
    }
    public function editHoliday(Request $request)
    {       
        $holiday = Holiday::where('_id',$request->id)->first();
        if(! empty($holiday)){
            $title = $holiday->title;
            $date= date('Y-m-d',$holiday->date);
    }
    $data=[
        'title'=>$title,
        'date'=>$date
    ];
    return json_encode($data);
        
    }
    public function updateHoliday(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'title' => 'required|regex:/^[a-zA-Z0-9 ]*$/|min:3|max:25',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $holiday = Holiday::where('_id',$request->holiday_id)->first();
        $holiday->date =  ! empty($request->date) ? strtotime($request->date) :'';
        $holiday->title= ! empty($request->title) ? $request->title :'';
        $holiday->created_by=Auth::user()->_id;
        $holiday->update();
        Session::flash('success', 'Holiday updated successfully');
    }
    public function holidayDelete(Request $request)
    {
        $holidayDelete = Holiday::where('_id', $request->id)->first();
        $holidayDelete->delete();
        Session::flash('info', 'Holiday deleted successfully');
        
    }
    public function MultipleDelete(Request $request)
    {
        if(! empty($request->all_ids)){
            Holiday::whereIn('_id',explode(',',$request->all_ids))->delete();
            Session::flash('info', 'Leave deleted successfully');
        }
    }
}
