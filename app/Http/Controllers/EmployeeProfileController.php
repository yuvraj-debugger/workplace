<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Session;

class EmployeeProfileController extends Controller
{
    //
    public function employeeProfile($employee_id)
    {
        if(! empty($employee_id)){
            $userData = User::where('_id', $employee_id)->first();
        }
        return view('admin.Profile.employee-profile', compact('userData'));
    }
    public function personalInformation($employee_id)
    {
        $countries = Country::all();
        $userDetails = User::where('_id',$employee_id)->first();
        $userAddress = UserAddress::where('user_id',$employee_id)->first();
        return view('admin.Profile.personal-information',compact('countries','employee_id','userDetails','userAddress'));
        
    }
    public function savePersoanlInformation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'whatsapp' => 'nullable|numeric|max_digits:15',
            'children' => 'nullable|numeric|max_digits:2',
            'nationality' => 'required|regex:/^[a-zA-Z ]*$/|max:90',
            'marital_status' => 'required|regex:/^[a-zA-Z ]*$/|max:90',
            'email' => 'email:rfc,dns|max:90|unique:users,email,'.$request->employee_id.',_id',
//             'blood_group' => array('nullable', 'regex:/^([AaBbOo]|[Aa][Bb])[\+-]$/', 'max:90'),
            'passport_number' => 'nullable|regex:/^[a-zA-Z0-9 ]*$/',
            'religion' => 'nullable|alpha',
            'currentzipcode' => 'nullable|numeric|max_digits:15',
            'permanentzipcode' => 'nullable|numeric|max_digits:15',
            
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        User::where('_id', $request->employee_id)->update([
            'gender' => $request->gender,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email,
            'nationality' => $request->nationality,
            'religion' => $request->religion,
            'blood_group' => $request->blood_group,
            'marital_status' => $request->marital_status,
            'spouse_employment' => $request->spouse_employment,
            'children' => $request->children,
            'passport_number' => $request->passport_number,
            'passport_expiry_date' => strtotime($request->passport_expiry_date),
        ]);
        $addressExist = UserAddress::where(['user_id'=> $request->employee_id])->first();
        $addressData = array(
            'user_id' => $request->employee_id,
            'current_country_id' => $request->selectedCurrentCountry,
            'current_state_id' => $request->current_state_id,
            'current_city_id' => $request->current_city_id,
            'current_zipcode' => $request->currentzipcode,
            'current_address' => $request->currentaddress,
            'permanent_country_id' => $request->permanent_country_id,
            'permanent_state_id' => $request->permanent_state_id,
            'permanent_city_id' => $request->permanent_city_id,
            'permanent_zipcode' => $request->permanent_zipcode,
            'permanent_address' => $request->permanentaddress,
            'present' => '0',
        );
        if($addressExist){
            UserAddress::where('_id', $addressExist['_id'])->update($addressData);
        }else{
            UserAddress::create($addressData);
        }
        Session::flash('success', 'user updated successfully');
        
    }
    public function sameAddress(Request $request)
    {
        $sameAddress = UserAddress::where('_id',$request->id)->first();
        if(! empty($sameAddress)){
            $state =$sameAddress->current_state_id;
            $city = $sameAddress->current_city_id;
            $country = $sameAddress->current_country_id;
            $address = $sameAddress->current_address;
            $zipcode = $sameAddress->current_zipcode;
            
        }
        $data = [
            'permanent_state_id'=>$state,
            'permanent_city_id'=>$city,
            'permanent_country_id'=>$country,
            'permanent_address'=>$address,
            'permanent_zipcode'=>$zipcode
        ];
        return json_encode($data);
    }
}
