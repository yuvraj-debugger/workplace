<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\BloodGroup;
use App\Models\MasterDocument;
use Illuminate\Support\Facades\Session;
use App\Models\EmployeeDegree;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\NotificationRead;
use App\Models\Role;
use App\Models\User;

class SettingController extends Controller
{

    //
    public function bloodGroupAdd()
    {
        $bloodGroup = BloodGroup::orderBy('_id', 'DESC')->paginate(10)->withQueryString();
        return view('admin.Setting.blood-group', compact('bloodGroup'));
    }

    public function addBlood(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'blood_group' => 'required|unique:blood_group,blood_group|regex:/^[a-zA-Z()+-]+$/u|max:10|min:2'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $bloodGroup = new BloodGroup();
        $bloodGroup->blood_group = $request->blood_group;
        $bloodGroup->save();
        Session::flash('success', 'Blood group added successfully');
    }

    public function editBlood(Request $request)
    {
        $bloodGroup = BloodGroup::where('_id', $request->id)->first();

        if (! empty($bloodGroup)) {
            $bloodGroup = $bloodGroup->blood_group;
        }
        $data = [
            'blood_group' => $bloodGroup
        ];
        return json_encode($data);
    }

    public function updateBlood(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blood_group' => 'required|regex:/^[a-zA-Z()+-]+$/u|max:10|min:2'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $updateBlood = BloodGroup::where('_id', $request->blood_id)->first();
        $updateBlood->blood_group = ! empty($request->blood_group) ? $request->blood_group : '';
        $updateBlood->update();
        Session::flash('success', 'Blood group updated successfully');
    }

    public function bloodDelete(Request $request)
    {
        $bloodDelete = BloodGroup::where('_id', $request->id)->first();
        $bloodDelete->delete();
        Session::flash('success', 'Blood group deleted successfully');
    }

    public function documentIndex()
    {
        $masterDocument = MasterDocument::orderBy('_id', 'DESC')->paginate(10);
        return view('admin.Setting.document-index', compact('masterDocument'));
    }

    public function documentAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document' => 'required|unique:master_document,document|required|regex:/^[\pL\s\-]+$/u|min:2|max:25'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $masterDocument = new MasterDocument();
        $masterDocument->document = $request->document;
        $masterDocument->save();
        Session::flash('success', 'Document added successfully');
    }

    public function documentEdit(Request $request)
    {
        $masterDocument = MasterDocument::where('_id', $request->id)->first();

        if (! empty($masterDocument)) {
            $document = $masterDocument->document;
        }
        $data = [
            'document' => $document
        ];
        return json_encode($data);
    }

    public function updateDocument(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'document' => 'required|regex:/^[a-zA-Z0-9 ]*$/|max:20'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $updateBlood = MasterDocument::where('_id', $request->document_id)->first();
        $updateBlood->document = ! empty($request->document) ? $request->document : '';
        $updateBlood->update();
        Session::flash('success', 'Document updated successfully');
    }

    public function documentDelete(Request $request)
    {
        $documentDelete = MasterDocument::where('_id', $request->id)->first();
        $documentDelete->delete();
        Session::flash('success', 'Document deleted successfully');
    }

    public function degreeeIndex()
    {
        $alldegree = EmployeeDegree::orderBy('_id', 'DESC')->paginate(10);
        return view('admin.Setting.degree-index', compact('alldegree'));
    }

    public function addDegree(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'degree_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $userDegree = EmployeeDegree::Create([
            'degree_name' => $request->degree_name,
            'created_by' => Auth::user()->_id
        ]);
        Session::flash('success', 'Degree added successfully');
    }

    public function editDegree(Request $request)
    {
        $degree = EmployeeDegree::where('_id', $request->id)->first();

        if (! empty($degree)) {
            $degree = $degree->degree_name;
            $data = [
                'degree_name' => $degree
            ];
        }
        return json_encode($data);
    }

    public function updatedDegree(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'degree_name' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $updateBlood = EmployeeDegree::where('_id', $request->degree_id)->first();
        $updateBlood->degree_name = ! empty($request->degree_name) ? $request->degree_name : '';
        $updateBlood->update();
        Session::flash('success', 'Degree updated successfully');
    }

    public function degreeDelete(Request $request)
    {
        $degreetDelete = EmployeeDegree::where('_id', $request->id)->first();
        $degreetDelete->delete();
        Session::flash('success', 'Document deleted successfully');
    }

    public function multipleDeleteBlood(Request $request)
    {
        if (! empty($request->all_ids)) {
            BloodGroup::whereIn('_id', explode(',', $request->all_ids))->delete();
            Session::flash('success', 'Blood deleted successfully');
        }
    }

    public function multipleDeleteDegree(Request $request)
    {
        if (! empty($request->all_ids)) {
            EmployeeDegree::whereIn('_id', explode(',', $request->all_ids))->delete();
            Session::flash('success', 'Degree deleted successfully');
        }
    }

    public function multipleDeleteDocument(Request $request)
    {
        if (! empty($request->all_ids)) {
            MasterDocument::whereIn('_id', explode(',', $request->all_ids))->delete();
            Session::flash('success', 'Degree deleted successfully');
        }
    }

    public function readMessage(Request $request)
    {
        $notifications = Notification::get();
        $role = Role::where('_id', Auth::user()->user_role)->first();
        foreach ($notifications as $notification) {
            $notificationUpdate = NotificationRead::updateOrCreate([
                'notification_id' => $notification->_id,
                'read' => 1,
                'created_by'=>Auth::user()->id
            ], [
                'notification_id' => $notification->_id,
                'read' => 1,
                'created_by'=>Auth::user()->id
            ]);
        }
        if((! empty($role) && $role->name == "Management")){
            $userManager =User::where('reporting_manager', Auth::user()->_id)->get() ->pluck('_id')->toArray();
            $readNotification = Notification::whereIn('created_by',$userManager)->paginate(10);
        }elseif ((Auth::user()->user_role == '0') || (! empty($role) && $role->name == "HR") ){
            $readNotification = Notification::orderBy('_id','DESC')->paginate(10);
        }
        return view('admin.Notification.index', compact('readNotification'));
    }
    public function getNotification(Request $request)
    {
        $notifications = Notification::get();
        foreach ($notifications as $notification) {
            $notificationUpdate = NotificationRead::updateOrCreate([
                'notification_id' => $notification->_id,
                'read' => 1,
                'created_by'=>Auth::user()->id
            ], [
                'notification_id' => $notification->_id,
                'read' => 1,
                'created_by'=>Auth::user()->id
            ]);
        }
        $totalNotifcation = NotificationRead::where('created_by',Auth::user()->id)->get();
        $totalCount = count($notifications) - count($totalNotifcation);
        return response()->json(['data' =>$totalCount]);
    }
}
