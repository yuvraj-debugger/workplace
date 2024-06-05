<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employeedepartment;
use Illuminate\Support\Facades\Validator;
use App\Models\Policy;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\UserActivity;

class PolicyController extends Controller
{

    //
    public function index()
    {
        $policies = Policy::orderBy('_id', 'DESC')->paginate(10);
        return view('admin.policy.index', compact('policies'));
    }

    public function addPolicy()
    {
        $departments = Employeedepartment::get();
        return view('admin.policy.add', compact('departments'));
    }

    public function createPolicy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'policy_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'description' => 'required',
            'upload_policy' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        if (! empty($request->upload_policy)) {
            if (! empty($request->upload_policy->getClientOriginalName())) {
                $filename = time() . '.' . $request->upload_policy->getClientOriginalName();
                $filePath = 'policy_management/' . $filename;
                $path = Storage::disk('s3')->put($filePath, file_get_contents($request->upload_policy));
                $url = Storage::disk('s3')->url($filePath);
            }
        }
        $policy = Policy::Create([
            'policy_name' => $request->policy_name,
            'description' => $request->description,
            'upload_policy' => ! empty($url) ? $url : '',
            'created_by' => Auth::user()->id
        ]);
        Session::flash('success', 'Policy Created Successfully');
    }

    public function updatePolicy($id)
    {
        $policyUpdated = Policy::where('_id', $id)->first();
        $departments = Employeedepartment::get();

        return view('admin.policy.update', compact('policyUpdated', 'departments'));
    }

    public function updatedPolicy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'policy_name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
            'description' => 'required'
            // 'department_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        $updatedPolicy = Policy::where('_id', $request->policy_id)->first();

        if (! empty($updatedPolicy)) {
            if (! empty($request->upload_policy)) {
                if (! empty($request->upload_policy->getClientOriginalName())) {
                    $filename = time() . '.' . $request->upload_policy->getClientOriginalName();
                    $filePath = 'policy_management/' . $filename;
                    $path = Storage::disk('s3')->put($filePath, file_get_contents($request->upload_policy));
                    $url = Storage::disk('s3')->url($filePath);
                    $updatedPolicy->upload_policy = ! empty($url) ? $url : '';
                }
            }
        }
        $updatedPolicy->policy_name = $request->policy_name;
        $updatedPolicy->description = $request->description;
        // $updatedPolicy->department_id = $request->department_id;
        
        $updatedPolicy->update();
        Session::flash('success', 'Policy Updated Successfully');
    }

    public function policyDelete(Request $request)
    {
        $policyDelete = Policy::where('_id', $request->id)->first();
        $policyDelete->delete();
        Session::flash('success', 'Policy Deleted Successfully');
    }

    public function ckeditorUpload(Request $request)
    {
        if ($request->hasFile('file')) {
            $originalName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_EXTENSION);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('file')->move(public_path('images'), $fileName);
            $url = asset('images/' . $fileName);
            return response()->json([
                'fileName' => $fileName,
                'uploaded' => 1,
                'url' => $url
            ]);
        }
    }

    public function updateckeditorUpload(Request $request)
    {
        if ($request->hasFile('file')) {
            $originalName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_EXTENSION);
            $extension = $request->file('file')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('file')->move(public_path('images'), $fileName);
            $url = asset('images/' . $fileName);
            return response()->json([
                'fileName' => $fileName,
                'uploaded' => 1,
                'url' => $url
            ]);
        }
    }

    public function viewPolicy($id)
    {
        $policyView = Policy::where('_id', $id)->first();
        return view('admin.policy.view', compact('policyView'));
    }
}
