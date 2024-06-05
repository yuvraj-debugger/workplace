<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Country;
use App\Models\Employeedepartment;
use App\Models\Employeedesignation;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserJoiningDetail;
use App\Models\UserOfficialContact;
use App\Models\UserEducationInfo;
use App\Models\UserFamilyInfo;
use App\Models\UserEmergencyContact;
use App\Models\UserBankInfo;
use App\Models\UserAdditionalInfo;
use App\Models\UserExperienceInfo;
use App\Models\UserDocument;
use App\Models\UserStatutoryInfo;
use App\Models\UserPayroll;
use App\Models\UserAttendance;
use App\Models\Leave;
use App\Rules\AlphaSpace;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;
use Auth;
use URL;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use App\Models\BloodGroup;
use App\Models\MasterDocument;

class Profile extends Component{
    use WithFileUploads;

    public $tab = 'personal';
    public $showModal = true;
    public $disabled = false;
    public $photo;
    public $emp_id;
    public $countries;
    public $currentStates;
    public $currentCities; 
    public $permanentStates;
    public $permanentCities;
    public $documentId = '';
    public $familyId = '';
    public $employee = '';
    public $month = '';
    public $year = '';
    public $error = '';
    public $employees = [];
    public $departments = [];
    public $check = [];
    public $selectPage = false;
    public $selectAll = false;
    public $ids = [];
    public $allids = [];

    public $gender, $whatsapp,  $email, $nationality, $religion, $blood_group, $marital_status, $spouse_employment, $children, $passport_number ,$user_role,$status,
    $passport_expiry_date, $currentzipcode, $currentaddress, $permanentzipcode, $permanentaddress,$present;
    
    public $User_id,$first_name,$last_name,$joining_date,$contact,$department,$reporting_manager,$app_login,$email_notification,$workplace,$image,$password;
    public $redmine_username, $discord_username, $skype_id;
    public $confirmation_date, $notice_period, $probation_period, $other_terms;
    public $username, $bank_name, $account, $ifsc, $pan;
    public $allergies, $drink, $smoke, $diet, $hobbies;
    public $name, $type, $doc, $date_of_birth, $relationship, $phone, $address;
    public $institute, $degree, $grade, $document, $starting_date, $completed_date;
    
    public $company_name,$designation,$employee_type, $relevant_experience, $skills, $employee_id, $net_pay, $company_city, $company_state, $company_country, $company_pincode, $company_website, $manager_name, $manager_designation, $manager_contact, $manager_email, $verification_status, $leaving_reason, $documents, $period_from, $period_to;
    public $esi, $esi_number, $branch_office, $dispensary, $previous_employment, $nominee_detail, $family_particular, $residing, $pf, $uan, $pf_scheme, $pension_scheme, $pf_number, $pf_joinDate, $previousInsNo, $employerCode, $nameAddress, $employerEmail, $nomineeName, $nomineeRelationship, $nomineeAddress, $particularName, $particularDateofbirth, $particularRelationship, $residancePlace;
    
    public $annual_ctc, $deductions, $allowances, $basic_salary;
    public $selectedPermanentCountry = null;
    public $selectedPermanentState = null;
    public $selectedPermanentCity = null;
    public $selectedCurrentCountry = null;
    public $selectedCurrentState = null;
    public $selectedCurrentCity = null;
    public $userDetail = [];
    public $inputs = [];
    public $familyinputs = [];
    public $contactinputs = [];
    public $experienceinputs = [];

    public bool $checked = false;

    protected function rules(){
        return [              
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,'.$this->emp_id.',_id',
            'date_of_birth' => 'required',
            'joining_date' => 'required',
            'contact' => 'required',
            'designation' => 'required',
            'department' => 'required',
            'reporting_manager' => 'required',
            'app_login' => 'required',
            'email_notification' => 'required',
            'workplace' => 'required'        
        ];
    }
  

    public function mount($selectedCity = null)
    {
        $this->emp_id = $this->emp_id == ''?FacadesAuth::user()->_id:$this->emp_id;
        $user_id = $this->emp_id;
        $this->departments=Employeedepartment::get();
        $this->month = date('m');
        $this->year = date('Y');
        $this->countries = Country::all();
        $this->currentStates = collect();
        $this->currentCities = collect();  
        $this->permanentStates = collect();
        $this->permanentCities = collect();
        $this->addNew();
        $this->addNewFamilyInfo();
        $this->addNewContactInfo();
        $this->addNewExperienceInfo();
        $educations = UserEducationInfo::where('user_id', $user_id)->get()->toArray();
        $families = UserFamilyInfo::where('user_id', $user_id)->get()->toArray();
        $contacts = UserEmergencyContact::where('user_id', $user_id)->get()->toArray();
        $experience = UserExperienceInfo::where('user_id', $user_id)->get()->toArray();
        if (!empty($educations)) {
            foreach($educations as $education){
                $education['starting_date'] = $education['starting_date'] != ''?date('Y-m-d', (int)$education['starting_date']):'';
                $education['completed_date'] = $education['completed_date'] != ''?date('Y-m-d', (int)$education['completed_date']):'';
                $eduArr[] = $education;
            }
           $this->inputs = $eduArr;
        }

        if (!empty($families)) {
            foreach($families as $family){
                $family['date_of_birth'] = $family['date_of_birth'] != '' ?date('Y-m-d', $family['date_of_birth']):'';
                $famillyArr[] = $family;
            }
            $this->familyinputs = $famillyArr;
        } 
        if (!empty($contacts)) {
            $this->contactinputs = $contacts;
        } 
        if (!empty($experience)) {
            foreach($experience as $ex){
                $ex['period_from'] = $ex['period_from'] != '' ?date('Y-m-d', (int)$ex['period_from']):'';
                $ex['period_to'] = $ex['period_to'] != '' ?date('Y-m-d', (int)$ex['period_to']):'';
                $exArr[] = $ex;
            }
           $this->experienceinputs = $exArr;
        }
        $userDetail = User::where('_id', $user_id)->with('address', 'bankDetail')->first();
        $this->checked=!empty($userDetail->status)?true:false;

        if(!empty($userDetail)){
            $this->gender = $userDetail->gender;
            $this->whatsapp = $userDetail->whatsapp;
            $this->email = $userDetail->email;
            $this->nationality = $userDetail->nationality;
            $this->religion = $userDetail->religion;
            $this->blood_group = $userDetail->blood_group;
            $this->marital_status = $userDetail->marital_status;
            $this->spouse_employment = $userDetail->spouse_employment;
            $this->children = $userDetail->children;
            $this->passport_number = $userDetail->passport_number;
            $this->passport_expiry_date = $userDetail->passport_expiry_date != ''?date('Y-m-d', $userDetail->passport_expiry_date):'';
            $this->selectedCurrentCountry = @$userDetail->address->current_country_id;
            $this->selectedCurrentState = @$userDetail->address->current_state_id;
            $this->selectedCurrentCity = @$userDetail->address->current_city_id; 

            $this->current_state_id = @$userDetail->address->current_state_id;
            $this->current_city_id = @$userDetail->address->current_city_id;
            $this->currentaddress = @$userDetail->address->current_address;
            $this->currentzipcode = @$userDetail->address->current_zipcode;  
            $this->selectedPermanentCountry = @$userDetail->address->permanent_country_id;
            $this->selectedPermanentState = @$userDetail->address->permanent_state_id;
            $this->selectedPermanentCity = @$userDetail->address->permanent_city_id; 
            $this->username = @$userDetail->bankDetail->username; 
            $this->bank_name = @$userDetail->bankDetail->bank_name; 
            $this->account = @$userDetail->bankDetail->account; 
            $this->ifsc = @$userDetail->bankDetail->ifsc; 
            $this->pan = @$userDetail->bankDetail->pan; 
            $this->allergies = @$userDetail->additionalInfo->allergies; 
            $this->diet = @$userDetail->additionalInfo->diet; 
            $this->drink = @$userDetail->additionalInfo->drink; 
            $this->hobbies = @$userDetail->additionalInfo->hobbies; 
            $this->smoke = @$userDetail->additionalInfo->smoke; 
            $this->esi = @$userDetail->statutoryInfo->esi; 
            $this->esi_number = @$userDetail->statutoryInfo->esi_number; 
            $this->branch_office = @$userDetail->statutoryInfo->branch_office; 
            $this->dispensary = @$userDetail->statutoryInfo->dispensary; 
            $this->previous_employment = @$userDetail->statutoryInfo->previous_employment; 
            $this->nominee_detail = @$userDetail->statutoryInfo->nominee_detail; 
            $this->family_particular = @$userDetail->statutoryInfo->family_particular; 
            $this->residing = @$userDetail->statutoryInfo->residing; 
            $this->pf = @$userDetail->statutoryInfo->pf; 
            $this->uan = @$userDetail->statutoryInfo->uan; 
            $this->pf_number = @$userDetail->statutoryInfo->pf_number; 
            $this->pf_joinDate = @$userDetail->statutoryInfo->pf_joinDate != ''?date('Y-m-d', (int)$userDetail->statutoryInfo->pf_joinDate):''; 
            $this->pf_scheme = @$userDetail->statutoryInfo->pf_scheme; 
            $this->pension_scheme = @$userDetail->statutoryInfo->pension_scheme; 
            $this->previousInsNo = @$userDetail->statutoryInfo->previousInsNo; 
            $this->employerCode = @$userDetail->statutoryInfo->employerCode; 
            $this->nameAddress = @$userDetail->statutoryInfo->nameAddress; 
            $this->employerEmail = @$userDetail->statutoryInfo->employerEmail; 
            $this->nomineeName = @$userDetail->statutoryInfo->nomineeName; 
            $this->nomineeRelationship = @$userDetail->statutoryInfo->nomineeRelationship; 
            $this->nomineeAddress = @$userDetail->statutoryInfo->nomineeAddress; 
            $this->particularName = @$userDetail->statutoryInfo->particularName; 
            $this->particularDateofbirth = @$userDetail->statutoryInfo->particularDateofbirth != ''?date('Y-m-d', (int)$userDetail->statutoryInfo->particularDateofbirth):''; 
            $this->particularRelationship = @$userDetail->statutoryInfo->particularRelationship; 
            $this->residancePlace = @$userDetail->statutoryInfo->residancePlace; 
            $this->confirmation_date = @$userDetail->joiningDetail->confirmation_date != ''?date('Y-m-d', (int)$userDetail->joiningDetail->confirmation_date):'';
            $this->notice_period = @$userDetail->joiningDetail->notice_period;
            $this->probation_period = @$userDetail->joiningDetail->probation_period;
            $this->other_terms = @$userDetail->joiningDetail->other_terms;
            $this->redmine_username = @$userDetail->officialContact->redmine_username;
            $this->discord_username = @$userDetail->officialContact->discord_username;
            $this->skype_id = @$userDetail->officialContact->skype_id;
            $this->permanent_state_id = @$userDetail->address->permanent_state_id;
            $this->permanent_city_id = @$userDetail->address->permanent_city_id;
            $this->permanentaddress = @$userDetail->address->permanent_address;
            $this->permanentzipcode = @$userDetail->address->permanent_zipcode;
            $this->present = @$userDetail->address->present;
        }
    }
    
    public function render()
    {
        $today = date('Y-m-d', strtotime('now'));
        $query = UserAttendance::with('details')->where(['user_id' => $this->emp_id]);
        if($this->month != '' && $this->year != '' ){
            $firstdate = $this->year.'-'.$this->month.'-'.'01';
            $fDate = strtotime($firstdate);
            $last_date = date("Y-m-t", $fDate);
            $lDate = strtotime($last_date);
            $query = $query->whereBetween('date', [$fDate, $lDate]);  
        }
        $allAttendances = $query->paginate(10);
        $leaves=Leave::where('name', $this->emp_id)->where('from_date','>=',date('Y-m-d'))->orderBy('_id');
        $q=Leave::where('name', $this->emp_id)->orderBy('_id');
        if(!empty($this->search_leave_type)){
            $leaves=$leaves->where('leave_type',$this->search_leave_type);
            $q=$q->where('leave_type',$this->search_leave_type);
        }
        if(!empty($this->search_status)){
            $leaves=$leaves->where('status',$this->search_status);
            $q=$q->where('status',$this->search_status);
        }
        if (!empty($this->fromsearch_date)) {
            $leaves = $leaves->where('from_date', '>=', $this->fromsearch_date);
            $q = $q->where('from_date', '>=', $this->fromsearch_date);
        }
        if (!empty($this->tosearch_date)) {
            $leaves = $leaves->where('to_date', '<=', $this->tosearch_date);
            $q = $q->where('to_date', '<=', $this->tosearch_date);
        }
        $this->allids = $q->pluck('_id')->toArray();
        $this->ids = $leaves->paginate(10)->toArray();

        $leaves=$leaves->paginate(10);

        $roles=Role::get();
        $departments = Employeedepartment::get();
        $designations = Employeedesignation::get();
        $bloodGroup = BloodGroup::get();
        $employee = User::get();
        $user_id = $this->emp_id;
        $masterDocument = MasterDocument::get();
        $userDetail = User::where('_id', $user_id)->with('address', 'bankDetail')->first();
        // dd($employee);
        return view('livewire.profile', [ 'userData' => $userDetail,'bloodGroup' =>$bloodGroup, 'masterDocument'=>$masterDocument,'departments' => $departments, 'designations' => $designations, 'leaves' => $leaves, 'allAttendances' => $allAttendances, 'employees' => $employee,'roles'=>$roles]);
    }
    public function refressData(){
        $user_id = $this->emp_id;
        $userDetail = User::where('_id', $user_id)->with('address', 'bankDetail')->first();
    }
    public function dehydrate (){
        if($this->error == '1'){
            $this->dispatchBrowserEvent('your-prefix:scroll-to', [
                'query' => '.text-danger',
            ]); 
        }
    }
    public function submitProfileInfo()
    {
        $this->error = '1';
        $this->tab = 'personal';
        $this->validate([
            'whatsapp' => 'nullable|numeric|max_digits:15',
            'children' => 'nullable|numeric|max_digits:2',
            'nationality' => 'required|regex:/^[a-zA-Z ]*$/|max:90',
            'marital_status' => 'required|regex:/^[a-zA-Z ]*$/|max:90',
            'email' => 'email:rfc,dns|max:90|unique:users,email,'.$this->emp_id.',_id',
            'blood_group' => array('nullable', 'regex:/^([AaBbOo]|[Aa][Bb])[\+-]$/', 'max:90'),
            'currentzipcode' => 'max:90',
            'currentaddress' => 'max:90',
            'permanentaddress' => 'max:90',
            'permanent_state_id' => 'max:90',
            'passport_number' => 'nullable|regex:/^[a-zA-Z0-9 ]*$/',
            'permanent_city_id' => 'max:90', 
            'current_state_id' => 'max:90',
            'current_city_id' => 'max:90',
            'religion' => 'nullable|alpha',
            'currentzipcode' => 'nullable|numeric|max_digits:15',
            'permanentzipcode' => 'nullable|numeric|max_digits:15',
        ]); 
        $user_id = $this->emp_id;        
        User::where('_id', $user_id)->update([
            'gender' => $this->gender,
            'whatsapp' => $this->whatsapp,
            'email' => $this->email,
            'nationality' => $this->nationality,
            'religion' => $this->religion,
            'blood_group' => $this->blood_group,
            'marital_status' => $this->marital_status,
            'spouse_employment' => $this->spouse_employment,
            'children' => $this->children,
            'passport_number' => $this->passport_number,
            'passport_expiry_date' => strtotime($this->passport_expiry_date),
        ]);
        $addressExist = UserAddress::where(['user_id'=> $user_id])->first();
        $addressData = array(
            'user_id' => $user_id,
            'current_country_id' => $this->selectedCurrentCountry,
            'current_state_id' => $this->current_state_id,
            'current_city_id' => $this->current_city_id,
            'current_zipcode' => $this->currentzipcode,
            'current_address' => $this->currentaddress,
            'permanent_country_id' => $this->selectedPermanentCountry,
            'permanent_state_id' => $this->permanent_state_id,
            'permanent_city_id' => $this->permanent_city_id,
            'permanent_zipcode' => $this->permanentzipcode,
            'permanent_address' => $this->permanentaddress,
            'present' => '0',
        );
        if($addressExist){
            UserAddress::where('_id', $addressExist['_id'])->update($addressData);
        }else{
            UserAddress::create($addressData);
        }    
       
        $this->alertSuccess('Personal Information Updated Successfully!');

       
        return redirect('/profile/'.$user_id);
          
    }

    public function submitJoiningDetail(){
        $this->error = '1';
        $this->tab = 'personal';
        $this->validate([
            'notice_period' => 'nullable|regex:/^[a-zA-Z0-9 ]*$/|max:20',
            'probation_period' => 'nullable|regex:/^[a-zA-Z0-9 ]*$/|max:20',
        ]);

        $user_id = $this->emp_id;
        $joiningExist = UserJoiningDetail::where('user_id', $user_id)->first();
        $joiningData = array(
            'user_id' => $user_id,
            'confirmation_date' => strtotime($this->confirmation_date),
            'notice_period' => $this->notice_period,
            'probation_period' => $this->probation_period,
            'other_terms' => $this->other_terms
        );
        if($joiningExist){
            UserJoiningDetail::where('_id', $joiningExist['_id'])->update($joiningData);
            if($this->confirmation_date != '' || $this->notice_period != '' || $this->probation_period != '' || $this->other_terms != ''){
                $this->alertSuccess('Joining Detail Updated Successfully!');
            }
        }else{
            UserJoiningDetail::create($joiningData);
            if($this->confirmation_date != '' || $this->notice_period != '' || $this->probation_period != '' || $this->other_terms != ''){
                $this->alertSuccess('Joining Detail Created Successfully!');
            }
        }
        return redirect('/profile/'.$user_id);
        
    }
    
    public function submitOfficialContact()
    {
        $this->error = '1';
        $this->tab = 'personal';
        $this->validate([
            'redmine_username' => 'nullable|max:90',
            'discord_username' => 'nullable|max:90',
            'skype_id' => 'nullable|max:20',
        ]);

        $user_id = $this->emp_id;
        $officialContactExist = UserOfficialContact::where('user_id', $user_id)->first();
        $officialData = array(
            'user_id' => $user_id,
            'redmine_username' => $this->redmine_username,
            'discord_username' => $this->discord_username,
            'skype_id' => $this->skype_id
        );
        if($officialContactExist){
            UserOfficialContact::where('_id', $officialContactExist['_id'])->update($officialData);
            if($this->redmine_username != '' || $this->discord_username != '' || $this->skype_id != ''){
                $msg = 'Official Contact Detail Updated Successfully!';
            }
        }else{
            UserOfficialContact::create($officialData);
            if($this->redmine_username != '' || $this->discord_username != '' || $this->skype_id != ''){
                $msg = 'Official Contact Detail Created Successfully!';
            }
        }

        if($this->redmine_username != '' || $this->discord_username != '' || $this->skype_id != ''){
            $this->alertSuccess($msg);
        }
        return redirect('/profile/'.$user_id);
        
    }
    
    public function submitFamilyInfo(){
        $this->error = '1';
        $this->tab = 'personal';
        $this->validate([
            'familyinputs.*.date_of_birth'=> 'nullable|before:' . now()->toDateString(),
            'familyinputs.*.phone' => 'nullable|numeric|min_digits:10|max_digits:15',
            'familyinputs.*.name' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'familyinputs.*.relationship' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'familyinputs.*.address' => 'min:3|max:90',
        ],
        [
        'familyinputs.*.name.required' => 'The name field is required!',
        'familyinputs.*.name.min' => 'The name field must not be less than 3 characters!',
        'familyinputs.*.name.max' => 'The name field must not be greater than 25 characters!',
        'familyinputs.*.relationship.min' => 'The relationship field must not be less than 3 characters!',
        'familyinputs.*.address.min' => 'The address field must not be less than 3 characters!',
        'familyinputs.*.relationship.max' => 'The relationship field must not be greater than 25 characters!',
        'familyinputs.*.name.regex' => 'The name format is invalid!',
        'familyinputs.*.relationship.regex' => 'The relationship format is invalid!',
        'familyinputs.*.date_of_birth.required' => 'The date of birth field is required!',
        'familyinputs.*.date_of_birth.before' => 'please choose valid date of birth!',
        'familyinputs.*.name.max' => 'The name field must not be greater than 40 characters!',
        'familyinputs.*.relationship.max' => 'The relationship field must not be greater than 40 characters!',
        'familyinputs.*.relationship.required' => 'The relationship field is required!',
        'familyinputs.*.phone.required'=> 'The phone number field is required!',
        'familyinputs.*.phone.max_digits'=> 'The phone number field must not be greater than 15 digits!',
        'familyinputs.*.phone.min_digits'=> 'The phone number field must not be less than 10 digits!',
        ]);
        $user_id = $this->emp_id;
            
        foreach ($this->familyinputs as $input) {
            if (!empty($input['_id'])) {
                $input['date_of_birth'] = @$input['date_of_birth'] != ''?strtotime($input['date_of_birth']):'';
                UserFamilyInfo::find($input['_id'])->update($input);
            } else {
                $input['date_of_birth'] = @$input['date_of_birth'] != ''?strtotime($input['date_of_birth']):'';

                $input['user_id'] = $user_id;
                UserFamilyInfo::create($input);
            }
        }

        $this->familyinputs = [];

        $families = UserFamilyInfo::where('user_id', $user_id)->get()->toArray();

        if (!empty($families)) {
            foreach($families as $family){
                $family['date_of_birth'] = $family['date_of_birth'] != '' ?date('Y-m-d', $family['date_of_birth']):'';
                $famillyArr[] = $family;
            }
            $this->familyinputs = $famillyArr;
        } 
        $this->alertSuccess('Family Info Updated Successfully!');
        return redirect('/profile/'.$user_id);
    }

    public function editFamilyInfo($familyId = ''){
        $this->tab = 'personal';
        $this->resetValidation();
        $this->familyId = $familyId;   
        $familyinfo = UserFamilyInfo::where('_id', $familyId)->first();
        $this->name = @$familyinfo->name;
        $this->relationship = @$familyinfo->relationship;
        $this->date_of_birth = @$familyinfo->date_of_birth != ''?date('Y-m-d', $familyinfo->date_of_birth):'';
        $this->phone = @$familyinfo->phone;
        $this->address = @$familyinfo->address;
    } 

    public function deleteEduInfo($eduId = ''){
        $this->tab = 'personal';
        $user_id = $this->emp_id;
        UserEducationInfo::where('_id', $eduId)->delete();
        $this->alertSuccess('Education Info Deleted Successfully!');
    }

    public function deleteFamilyInfo($familyId = ''){
        $this->tab = 'personal';
        $user_id = $this->emp_id;
        UserFamilyInfo::where('_id', $familyId)->delete();
        $this->alertSuccess('Family Info Deleted Successfully!');
    }

    public function updateFamilyInfo(){
        $this->tab = 'personal';
        $user_id = $this->emp_id;
        $this->error = '1';
        $this->validate([
            'date_of_birth' => 'nullable|before:' . now()->toDateString(),
            'name' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'relationship' => 'required|min:3|max:25',
            'phone' => 'nullable|numeric|min_digits:10|max_digits:15',
            'address' => 'nullable|min:3'
        ]);
        $family=UserFamilyInfo::find($this->familyId);
        $familyData = array(
            'user_id' => $user_id,
            'name' => $this->name,
            'relationship' => $this->relationship,
            'date_of_birth' => $this->date_of_birth != ''?strtotime($this->date_of_birth):'',
            'phone' => $this->phone,
            'address' => $this->address
        );
        if(!empty($family)){
            $family->update($familyData);
            $this->alertSuccess('Family Info Updated Successfully!');
        }else{
            UserFamilyInfo::create($familyData);
            $this->alertSuccess('Family Info Created Successfully!');
        }
        $this->name = '';
        $this->relationship = '';
        $this->date_of_birth = '';
        $this->phone = '';
        $this->address = '';    
        $this->familyinputs = [];
        $families = UserFamilyInfo::where('user_id', $user_id)->get()->toArray();
        if (!empty($families)) {
            foreach($families as $family){
                $family['date_of_birth'] = $family['date_of_birth'] != '' ?date('Y-m-d', $family['date_of_birth']):'';
                $famillyArr[] = $family;
            }
            $this->familyinputs = $famillyArr;
        } 
        return redirect('/profile/'.$user_id);
        
    }
    public function submitEducationInfo(){
        $this->error = '1';
        $this->tab = 'personal';
        $user_id = $this->emp_id;
        $this->validate([
            'inputs.*.institute' => 'required|regex:/^[a-zA-Z ]*$/|max:90',
            'inputs.*.starting_date' => 'nullable|before:' . now()->toDateString(),
            'inputs.*.completed_date' => 'nullable|after:inputs.*.starting_date|before:' . now()->toDateString(),
        ],
        [
            'inputs.*.institute.regex' => 'The institute format is invalid!',
            'inputs.*.institute.required' => 'The institute field is required!',
            'inputs.*.institute.max' => 'The institute field must not be greater than 40 characters!',
            'inputs.*.starting_date.before' => 'The starting date must be a date before '.date('Y-m-d').'!',
            'inputs.*.completed_date.before' => 'The completed date must be a date before '.date('Y-m-d').'!',
            'inputs.*.completed_date.after' => 'The completed date must be a date after starting date.!',
        ]);

        foreach ($this->inputs as $k=>$input) {
            $input['user_id'] = $user_id;
            $input['starting_date'] = @$input['starting_date'] != ''?strtotime($input['starting_date']):'';
            $input['completed_date'] = @$input['completed_date'] != ''?strtotime($input['completed_date']):'';
            $url ='';
            if (!empty($input['document']) && !is_string($input['document'])) {
                $filename = time() . '.'.$input['document']->getClientOriginalExtension();
                $filePath = 'employee_document/' . $filename;
                $path=Storage::disk('s3')->put($filePath,file_get_contents($input['document']->temporaryUrl()));
                $input['document']= Storage::disk('s3')->url($filePath);
            }
            if (!empty($input['_id'])) {
                UserEducationInfo::find($input['_id'])->update($input);
            } else {
                $input['user_id'] = $user_id;
                $educationData = UserEducationInfo::create($input);
            }
        }
        $this->alertSuccess('Education Info Updated Successfully!');
        $this->inputs = [];
        $educations = UserEducationInfo::where('user_id', $user_id)->get()->toArray();
        if (!empty($educations)) {
            foreach($educations as $education){
                $education['starting_date'] = $education['starting_date'] != ''?date('Y-m-d', (int)$education['starting_date']):'';
                $education['completed_date'] = $education['completed_date'] != ''?date('Y-m-d', (int)$education['completed_date']):'';
                $eduArr[] = $education;
            }
            $this->inputs = $eduArr;
        }
        return redirect('/profile/'.$user_id);
        
    } 

    public function createEducationInfo(){
        $this->error = '1';
        $this->tab = 'personal';
        $user_id = $this->emp_id;
        $this->validate([
            'institute' => 'required|regex:/^[a-zA-Z ]*$/|max:90',
            'starting_date' => 'bail|nullable|before:' . now()->toDateString(),
            'completed_date' => 'nullable|after:starting_date|before:' . now()->toDateString(),
            'document' => 'required|mimes:pdf,docs,docx,doc'
        ]);
        $url = "";
        if (!empty($this->document) && !is_string($this->document)) {

            $filename = time() . '.'.$this->document->getClientOriginalExtension();
            $filePath = 'employee_document/' . $filename;
            $path=Storage::disk('s3')->put($filePath,file_get_contents($this->document->temporaryUrl()));
            $url = Storage::disk('s3')->url($filePath);
        }
        $document = $url;
        $eduData = array(
            'user_id' => $user_id,
            'institute' => $this->institute,
            'grade' => $this->grade,
            'degree' => $this->degree,
            'document' => $document,
            'starting_date' => @$this->starting_date != ''?strtotime($this->starting_date):'',
            'completed_date' => @$this->completed_date != ''?strtotime($this->completed_date):'',
        );
        UserEducationInfo::create($eduData);
        $this->institute = '';
        $this->grade = '';
        $this->degree = '';
        $this->document = '';
        $this->stuih8yuh8uharting_date = '';
        $this->completed_date = '';
        $educations = UserEducationInfo::where('user_id', $user_id)->get()->toArray();
        if (!empty($educations)) {
            foreach($educations as $education){
                $education['starting_date'] = $education['starting_date'] != ''?date('Y-m-d', (int)$education['starting_date']):'';
                $education['completed_date'] = $education['completed_date'] != ''?date('Y-m-d', (int)$education['completed_date']):'';
                $eduArr[] = $education;
            }
           $this->inputs = $eduArr;
        }
        $userData = User::where('_id', $user_id)->with('address', 'bankDetail')->first();

        $this->alertSuccess('Education Info Created Successfully!');

        return redirect('/profile/'.$user_id);
        
    }

    public function submitEmergencyContact(){
        $this->error = '1';
        $this->tab = 'personal';
        $user_id = $this->emp_id;
        $this->validate([
            'contactinputs.*.name' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'contactinputs.*.relationship' => 'required|regex:/^[a-zA-Z ]*$/|min:3|max:25',
            'contactinputs.*.phone' => 'required|numeric|min_digits:10|max_digits:15',
            'contactinputs.*.phone_two' => 'numeric|min_digits:10|max_digits:15',
            'contactinputs.*.email' => 'nullable|email:rfc,dns|max:90',
        ],
        [
            'contactinputs.*.name.required' => 'The name field is required!',
            'contactinputs.*.name.regex' => 'The name must only contain letters.!',
            'contactinputs.*.relationship.regex' => 'The relationship must only contain letters.!',
            'contactinputs.*.name.max' => 'The name field must not be greater than 25 characters!',
            'contactinputs.*.name.min' => 'The name field must not be less than 3 characters!',
            'contactinputs.*.relationship.max' => 'The relationship field must not be greater than 25 characters!',
            'contactinputs.*.relationship.min' => 'The relationship field must not be less than 3 characters!',
            'contactinputs.*.relationship.required' => 'The relationship field is required!',
            'contactinputs.*.phone.required'=> 'The phone number field is required!',
            'contactinputs.*.phone.max_digits'=> 'The phone number field must not be greater than 15 digits!',
            'contactinputs.*.phone.min_digits'=> 'The phone number field must not be less than 10 digits!',
            'contactinputs.*.phone_two.max_digits'=> 'The phone number 2 field must not be greater than 15 digits!',
            'contactinputs.*.phone_two.min_digits'=> 'The phone number 2 field must not be less than 10 digits!',
            'contactinputs.*.email.max'=> 'The email field must not be greater than 40 characters!',
            'contactinputs.*.email.email'=> 'Please enter valid email!',
        ]);
        foreach ($this->contactinputs as $input) {
            if (!empty($input['_id'])) {
                UserEmergencyContact::find($input['_id'])->update($input);
            }else {
                $input['user_id'] = $user_id;
                UserEmergencyContact::create($input);
            }
        }
        $this->alertSuccess('Contact Info Updated Successfully!');
        $userDetail = User::where('_id', $user_id)->with('address', 'bankDetail')->first();
        $this->contactinputs = [];
        $contacts = UserEmergencyContact::where('user_id', $user_id)->get()->toArray();
        if (!empty($contacts)) {
            $this->contactinputs = $contacts;
        } 
        return redirect('/profile/'.$user_id);
        
    }

    public function submitBankInfo()
    {
        $this->error = '1';
        $this->tab = 'account';
        $this->validate([
            'username' => 'required|regex:/^[a-zA-Z ]*$/|max:90',
            'bank_name' => 'required|regex:/^[a-zA-Z ]*$/|max:90',
            'account' => 'required|numeric|min:10|min:17',
            'ifsc' => 'required|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/|max:15',
            'pan' => 'required|regex:/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/|max:15',    
        ],
            [
                'account.required' => 'The accounts must not have more than 17 digits',
            ]);
        $user_id = $this->emp_id;
        $bankInfoExist = UserBankInfo::where('user_id', $user_id)->first();
        $bankData = array(
            'user_id' => $user_id,
            'username' => $this->username,
            'bank_name' => $this->bank_name,
            'account' => $this->account,
            'ifsc' => $this->ifsc,
            'pan' => $this->pan
        );
        if($bankInfoExist){
            UserBankInfo::where('_id', $bankInfoExist['_id'])->update($bankData);
        }else{
            UserBankInfo::create($bankData);
        }
        $this->alertSuccess('Bank Info Updated Successfully!');
        return redirect('/profile/'.$user_id);
        
    }  
    public function submitStatutoryInfo(){
        $this->error = '1';
        $this->tab = 'account';
        $this->validate([
            'esi_number' => 'numeric|regex:/^[0-9]{2}[0-9]{2}[0-9]{6}[0-9]{3}[0-9]{4}$/|min_digits:17|max_digits:17',
            'branch_office' => 'nullable|regex:/^[a-zA-Z ]*$/',
            'previousInsNo' => 'nullable|regex:/^[A-Z]{0,2}[0-9]{1,6}[A-Z]{1}?$/|max:9',
            'employerCode' => 'nullable|max:90',
            'nameAddress' => 'nullable|regex:/^[a-zA-Z ]*$/|max:90',
            'nomineeName' => 'nullable|regex:/^[a-zA-Z ]*$/|max:90',
            'particularName' => 'nullable|regex:/^[a-zA-Z ]*$/|max:90',
            'particularDateofbirth' => 'nullable|before:' . now()->toDateString(),
            'particularRelationship' => 'nullable|regex:/^[a-zA-Z ]*$/|max:90',
            'nomineeAddress' => 'nullable|regex:/^[a-zA-Z ]*$/|max:90',
            'nomineeRelationship' => 'nullable|regex:/^[a-zA-Z ]*$/|max:90',
            'employerEmail' => 'nullable|email:rfc,dns|max:20',
            'uan' => 'nullable|numeric|min_digits:12|max_digits:12',
            'pf_number' => 'nullable|regex:/^[A-Z]{2}[\s\/]?[A-Z]{3}[\s\/]?[0-9]{7}[\s\/]?[0-9]{3}[\s\/]?[0-9]{7}$/'
        ],[

            'pf_number.regex' => 'PF account number is a 22 digit unique number, the first 2 letters are “region code”, the next 3 letters are “office code”, & next 7 digits are “establishment registration code”, & the next 3 Zeroes are “establishment extension” & last 7 digits are PF member id of the employee.',
            'esi_number.min_digits' => 'Only 17 digits is acceptable.',
            'esi_number.max_digits' => 'Only 17 digits is acceptable.',
            'esi_number.regex' => 'Only 17 digits is acceptable.',
            'previousInsNo.regex' => 'Previous Ins. No. should appear in the following combination of letters and numbers - two letters, six numbers, one letter'

        ]);
        $user_id = $this->emp_id;
        $statutoryInfoExist = UserStatutoryInfo::where('user_id', $user_id)->first();
        $statutoryData = array(
            'user_id' => $user_id,
            'esi' => $this->esi,
            'esi_number' => $this->esi_number,
            'branch_office' => $this->branch_office,
            'dispensary' => $this->dispensary,
            'previous_employment' => $this->previous_employment,
            'previousInsNo' => $this->previousInsNo,
            'employerCode' => $this->employerCode,
            'nameAddress' => $this->nameAddress,
            'employerEmail' => $this->employerEmail,
            'nomineeName' => $this->nomineeName,
            'nomineeRelationship' => $this->nomineeRelationship,
            'nomineeAddress' => $this->nomineeAddress,
            'particularName' => $this->particularName,
            'particularDateofbirth' => $this->particularDateofbirth    != ''?strtotime($this->particularDateofbirth):'',
            'particularRelationship' => $this->particularRelationship,
            'residancePlace' => $this->residancePlace,
            'nominee_detail' => $this->nominee_detail,
            'family_particular' => $this->family_particular,
            'residing' => $this->residing,
            'pf' => $this->pf,
            'uan' => $this->uan,
            'pf_scheme' => $this->pf_scheme,
            'pension_scheme' => $this->pension_scheme,
            'pf_number' => $this->pf_number,
            'pf_joinDate' => $this->pf_joinDate != ''?strtotime($this->pf_joinDate):'',
        );
        if($statutoryInfoExist){
            UserStatutoryInfo::where('_id', $statutoryInfoExist['_id'])->update($statutoryData);
        }else{
            UserStatutoryInfo::create($statutoryData);
        }
        $this->alertSuccess('Statutory Info Updated Successfully!');
        return redirect('/profile/'.$user_id);
        
    }  
    public function submitAdditionalInfo(){
        $this->error = '1';
        $this->tab = 'additional';
        $user_id = $this->emp_id;
        $additionalInfoExist = UserAdditionalInfo::where('user_id', $user_id)->first();
        $additionalData = array(
            'user_id' => $user_id,
            'allergies' => $this->allergies,
            'smoke' => $this->smoke,
            'drink' => $this->drink,
            'diet' => $this->diet,
            'hobbies' => $this->hobbies,
        );
        if($additionalInfoExist){
            UserAdditionalInfo::where('_id', $additionalInfoExist['_id'])->update($additionalData);
        }else{
            UserAdditionalInfo::create($additionalData);
        }
        $this->alertSuccess('Addition Details Updated Successfully!');
        return redirect('/profile/'.$user_id);
        
    } 

    public function resetDoc(){
        $this->tab="document";
          $this->name = '';
        $this->type = '';
        $this->document = '';
    }

    public function submitDocument()
    {
        $this->error = '1';
        $this->validate([
            'type' => 'bail|required',
            'name' => 'required|regex:/^[a-zA-Z0-9 ]*$/|max:90',
        ]);
        if($this->type == 'pdf'){
            if(!is_string($this->document)){
                $this->validate([
                    'document' => 'required',
                ]);
            }
        }else{
            if(!is_string($this->document)){
                $this->validate([
                    'document' => 'required',
                ]);
            }
        }

        $user_id = $this->emp_id;
        $url = UserDocument::where('_id', $this->documentId)->value('document');
        if (!empty($this->document) && !is_string($this->document)) {
            $filename = time() . '.'.$this->document->getClientOriginalExtension();
            $filePath = 'employee_document/' . $filename;
            $path=Storage::disk('s3')->put($filePath,file_get_contents($this->document->temporaryUrl()));

            $url = Storage::disk('s3')->url($filePath);
        }
        $docData= array(
            'user_id' => $user_id,
            'name' => $this->name,
            'type' => $this->type,
            'document' => $url
        );
        if (!empty($this->documentId)){
            UserDocument::where('_id', $this->documentId)->update($docData);
            $this->alertSuccess('Document Updated Successfully!');
        }else{
            UserDocument::create($docData);
            $this->alertSuccess('Document Created Successfully!');
        }
        return redirect('/profile/'.$user_id);
        $this->name = '';
        $this->type = '';
        $this->document = '';
    }

    public function deleteDocument($docId = ''){
        $this->tab = 'document';
        
        UserDocument::where('_id', $docId)->delete();
    }

    public function editDocument($docId = ''){
        $this->tab = 'document';
        $userDoc = UserDocument::where('_id', $docId)->first();
        $this->documentId = $userDoc['_id'];
        $this->name = $userDoc['name'];
        $this->type = $userDoc['type'];
        $this->document = $userDoc['document'];
    }
    public function submitExperienceInfo(){
        $this->tab= 'experience';
        $this->error = '1';

        $user_id = $this->emp_id;
         $this->validate([
            'experienceinputs.*.company_name' => 'required|regex:/^[a-zA-Z0-9 ]*$/|max:90',
            'experienceinputs.*.designation' => 'required|regex:/^[a-zA-Z ]*$/',
            'experienceinputs.*.employee_type' => 'required',
            'experienceinputs.*.relevant_experience' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'experienceinputs.*.employee_id' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'experienceinputs.*.period_from' => 'required|before:' . now()->toDateString(),
            'experienceinputs.*.period_to' => 'nullable|after:experienceinputs.*.period_from|before:' . now()->toDateString(),
        ],
        [
            'experienceinputs.*.company_name.required' => 'The company name field is required!',
            'experienceinputs.*.company_name.regex' => 'The company name must only contain letters and numbers!',
            'experienceinputs.*.designation.required' => 'The designation field is required!',
            'experienceinputs.*.designation.regex' => 'The designation must only contain letters!',
            'experienceinputs.*.relevant_experience.regex' => 'The relevant experience must only contain letters and numbers!',
            'experienceinputs.*.employee_id.regex' => 'The employee id must only contain letters and numbers!',
            'experienceinputs.*.employee_type.max' => 'The company name field must not be greater than 40 characters!',
            'experienceinputs.*.employee_type.required' => 'The employee type field is required!',
            'experienceinputs.*.relevant_experience.required'=> 'The relevant experience field is required!',
            'experienceinputs.*.employee_id.required'=> 'The employee Id field is required!',
             'experienceinputs.*.period_from.before' => 'The period from date must be a date before '.date('Y-m-d').'!',
            'experienceinputs.*.period_to.before' => 'The period to date must be a date before '.date('Y-m-d').'!',
            'experienceinputs.*.period_to.after' => 'The period to date must be a date after period from.!'        
        ]);
        
        foreach ($this->experienceinputs as $input) {
            $url = '';
            if (!empty($input['documents']) && !is_string($input['documents'])) {
                $filename = time() . '.'.$input['documents']->getClientOriginalExtension();
                $filePath = 'employee_document/' . $filename;
                $path=Storage::disk('s3')->put($filePath,file_get_contents($input['documents']->temporaryUrl()));
                $input['documents'] = Storage::disk('s3')->url($filePath);
            }
            $input['period_from'] = @$input['period_from'] != ''?strtotime($input['period_from']):'';
            $input['period_to'] = @$input['period_to'] != ''?strtotime($input['period_to']):'';

            if (!empty($input['_id'])) {
                UserExperienceInfo::find($input['_id'])->update($input);
            }else {
                $input['user_id'] = $user_id;
                UserExperienceInfo::create($input);
            }
        }
        $this->experienceinputs = [];
        $experience = UserExperienceInfo::where('user_id', $user_id)->get()->toArray();
        if (!empty($experience)) {
            foreach($experience as $ex){
                $ex['period_from'] = $ex['period_from'] != '' ?date('Y-m-d', (int)$ex['period_from']):'';
                $ex['period_to'] = $ex['period_to'] != '' ?date('Y-m-d', (int)$ex['period_to']):'';
                $exArr[] = $ex;
            }
           $this->experienceinputs = $exArr;
        }
        $this->alertSuccess('Experience Details Updated Successfully!');
        return redirect('/profile/'.$user_id);
        
    } 
    public function createExperienceInfo(){
        $this->tab= 'experience';
        $this->error = '1';

        $user_id = $this->emp_id;
        $this->validate([
            'company_name' => 'required|regex:/^[a-zA-Z0-9 ]*$/|max:90',
            'designation' => 'required|regex:/^[a-zA-Z ]*$/',
            'employee_type' => 'required',
            'relevant_experience' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'employee_id' => 'required|regex:/^[a-zA-Z0-9 ]*$/',
            'period_from'=>'required'
        ]);
        
        $url ='';
        if (!empty($this->documents) && !is_string($this->documents)) {

            $filename = time(). '.'.$this->documents->getClientOriginalExtension();
            $filePath = 'employee_document/' . $filename;
            $path=Storage::disk('s3')->put($filePath,file_get_contents($this->documents->temporaryUrl()));

            $url = Storage::disk('s3')->url($filePath);
        }
        $experienceData = array(
            'user_id' => $user_id,
            'company_name' => $this->company_name,
            'designation' => $this->designation,
            'employee_type' => $this->employee_type,
            'period_from' => $this->period_from != ''?strtotime($this->period_from):'',
            'period_to' => $this->period_to != ''?strtotime($this->period_to):'',
            'relevant_experience' => $this->relevant_experience,
            'skills' => $this->skills,
            'employee_id' => $this->employee_id,
            'net_pay' => $this->net_pay,
            'company_city' => $this->company_city,
            'company_state' => $this->company_state,
            'company_country' => $this->company_country,
            'company_pincode' => $this->company_pincode,
            'company_website' => $this->company_website,
            'manager_name' => $this->manager_name,
            'manager_designation' => $this->manager_designation,
            'manager_contact' => $this->manager_contact,
            'manager_email' => $this->manager_email,
            'leaving_reason' => $this->leaving_reason,
            'documents' => $url,
        );
        UserExperienceInfo::create($experienceData);
        
        $this->company_name = '';
        $this->designation = '';
        $this->employee_type = '';
        $this->period_from = '';
        $this->period_to = '';
        $this->relevant_experience = '';
        $this->skills = '';
        $this->employee_id = '';
        $this->net_pay = '';
        $this->company_city = '';
        $this->company_pincode = '';
        $this->company_website = '';
        $this->manager_name = '';
        $this->manager_designation = '';
        $this->manager_contact = '';
        $this->manager_email = '';
        $this->leaving_reason = '';
        $this->company_state = '';
        $this->documents = '';
        $this->experienceinputs = [];
        
        $experience = UserExperienceInfo::where('user_id', $user_id)->get()->toArray();
        if (!empty($experience)) {
            foreach($experience as $ex){
                $ex['period_from'] = $ex['period_from'] != '' ?date('Y-m-d', (int)$ex['period_from']):'';
                $ex['period_to'] = $ex['period_to'] != '' ?date('Y-m-d', (int)$ex['period_to']):'';
                $exArr[] = $ex;
            }
            $this->experienceinputs = $exArr;
        }
        $this->alertSuccess('Experience Details Created Successfully!');
        return redirect('/profile/'.$user_id);
        
    } 

    public function edit($user_id){
        $user=User::where('_id',$user_id)->first();
        $this->User_id = $user->_id;
        $this->employee_id=$user->employee_id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->date_of_birth = $user->date_of_birth;
        $this->joining_date = $user->joining_date;
        $this->contact = $user->contact;
        $this->department = $user->department;
        $this->designation = $user->designation;
        $this->reporting_manager = $user->reporting_manager;
        $this->app_login = $user->app_login;
        $this->email_notification = $user->email_notification;
        $this->workplace = $user->workplace;
        $this->image=$user->photo;
        $this->user_role=$user->user_role;
        $this->status=$user->status;
    }
    
    public function updateProfile(){
        $this->validate();
        $users=User::find($this->User_id);
        if (!empty($this->photo)) {
            $filename = time() . '.'.$this->photo->getClientOriginalExtension();
            $filePath = 'employee_image/' . $filename;
            $path=Storage::disk('s3')->put($filePath,file_get_contents($this->photo->temporaryUrl()));
            $url = Storage::disk('s3')->url($filePath);
        }else{
            $url = $this->image;
        }
        
        $users->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'photo'=>$url,
            'password' => $this->password != ''?Hash::make($this->password):$users->password,
            'date_of_birth' => $this->date_of_birth,
            'joining_date' => $this->joining_date,
            'contact'=>$this->contact,                
            'designation'=>$this->designation,
            'department'=>$this->department,
            'reporting_manager'=>$this->reporting_manager,
            'app_login'=>$this->app_login,
            'email_notification'=>$this->email_notification,
            'workplace'=>$this->workplace,
            'user_role'=>$this->user_role,
            'status'=>$this->status    
        ]);
        $this->alertSuccess('Employee updated  Successfully!');   
        return redirect('/profile/'.$user_id);
        
    }

    public function processMark(){
        $user=User::find($this->emp_id);
        if ($this->checked) {
           $user->status=1;
        }else {            
           $user->status=0;
        }
        $user->update();
    }
   
    public function addNew(){
        $this->inputs[] = [];
    }

    public function remove($index){
        $count = UserEducationInfo::where('_id', @$this->inputs[$index]['_id'])->delete();
        if($count > 0){

            UserEducationInfo::where('_id', @$this->inputs[$index]['_id'])->delete();
            $this->alertSuccess('Data delete successfully!');
        }

        unset($this->inputs[$index]);
        $this->inputs = array_values($this->inputs);
        $this->closeModal();
    } 

    public function closeModal(){
        $this->resetValidation();
        $this->institute = '';
        $this->grade = '';
        $this->degree = '';
        $this->document = '';
        $this->starting_date = '';
        $this->completed_date = '';
        $user_id = $this->emp_id;
        $educations = UserEducationInfo::where('user_id', $user_id)->get()->toArray();
        $families = UserFamilyInfo::where('user_id', $user_id)->get()->toArray();
        $contacts = UserEmergencyContact::where('user_id', $user_id)->get()->toArray();
        $experience = UserExperienceInfo::where('user_id', $user_id)->get()->toArray();
        if (!empty($educations)) {
            foreach($educations as $education){
                $education['starting_date'] = $education['starting_date'] != ''?date('Y-m-d', (int)$education['starting_date']):'';
                $education['completed_date'] = $education['completed_date'] != ''?date('Y-m-d', (int)$education['completed_date']):'';
                $eduArr[] = $education;

            }
           $this->inputs = $eduArr;
         }

         if (!empty($families)) {
            foreach($families as $family){
                $family['date_of_birth'] = $family['date_of_birth'] != '' ?date('Y-m-d', $family['date_of_birth']):'';
                $famillyArr[] = $family;
            }
           $this->familyinputs = $famillyArr;
         } 
        if (!empty($contacts)) {
           $this->contactinputs = $contacts;
        } 
        if (!empty($experience)) {
            foreach($experience as $ex){
                $ex['period_from'] = $ex['period_from'] != '' ?date('Y-m-d', (int)$ex['period_from']):'';
                $ex['period_to'] = $ex['period_to'] != '' ?date('Y-m-d', (int)$ex['period_to']):'';
                $exArr[] = $ex;
            }
            $this->experienceinputs = $exArr;
        }
        $userDetail = User::where('_id', $user_id)->with('address', 'bankDetail')->first();
        if(!empty($userDetail)){
            $this->gender = $userDetail->gender;
            $this->whatsapp = $userDetail->whatsapp;
            $this->email = $userDetail->email;
            $this->nationality = $userDetail->nationality;
            $this->religion = $userDetail->religion;
            $this->blood_group = $userDetail->blood_group;
            $this->marital_status = $userDetail->marital_status;
            $this->spouse_employment = $userDetail->spouse_employment;
            $this->children = $userDetail->children;
            $this->passport_number = $userDetail->passport_number;
            $this->passport_expiry_date = $userDetail->passport_expiry_date != ''?date('Y-m-d', $userDetail->passport_expiry_date):'';
            $this->selectedCurrentCountry = @$userDetail->address->current_country_id;
            $this->selectedCurrentState = @$userDetail->address->current_state_id;
            $this->selectedCurrentCity = @$userDetail->address->current_city_id; 

            $this->current_state_id = @$userDetail->address->current_state_id;
            $this->current_city_id = @$userDetail->address->current_city_id;
            $this->currentaddress = @$userDetail->address->current_address;
            
            $this->currentzipcode = @$userDetail->address->current_zipcode;  
            $this->selectedPermanentCountry = @$userDetail->address->permanent_country_id;
            $this->selectedPermanentState = @$userDetail->address->permanent_state_id;
            $this->selectedPermanentCity = @$userDetail->address->permanent_city_id; 
            $this->username = @$userDetail->bankDetail->username; 
            $this->bank_name = @$userDetail->bankDetail->bank_name; 
            $this->account = @$userDetail->bankDetail->account; 
            $this->ifsc = @$userDetail->bankDetail->ifsc; 
            $this->pan = @$userDetail->bankDetail->pan; 
            $this->allergies = @$userDetail->additionalInfo->allergies; 
            $this->diet = @$userDetail->additionalInfo->diet; 
            $this->drink = @$userDetail->additionalInfo->drink; 
            $this->hobbies = @$userDetail->additionalInfo->hobbies; 
            $this->smoke = @$userDetail->additionalInfo->smoke; 
            $this->esi = @$userDetail->statutoryInfo->esi; 
            $this->esi_number = @$userDetail->statutoryInfo->esi_number; 
            $this->branch_office = @$userDetail->statutoryInfo->branch_office; 
            $this->dispensary = @$userDetail->statutoryInfo->dispensary; 
            $this->previous_employment = @$userDetail->statutoryInfo->previous_employment; 
            $this->nominee_detail = @$userDetail->statutoryInfo->nominee_detail; 
            $this->family_particular = @$userDetail->statutoryInfo->family_particular; 
            $this->residing = @$userDetail->statutoryInfo->residing; 
            $this->pf = @$userDetail->statutoryInfo->pf; 
            $this->uan = @$userDetail->statutoryInfo->uan; 
            $this->pf_number = @$userDetail->statutoryInfo->pf_number; 
            $this->pf_joinDate = @$userDetail->statutoryInfo->pf_joinDate != ''?date('Y-m-d', (int)$userDetail->statutoryInfo->pf_joinDate):''; 
            $this->pf_scheme = @$userDetail->statutoryInfo->pf_scheme; 
            $this->pension_scheme = @$userDetail->statutoryInfo->pension_scheme; 
            $this->previousInsNo = @$userDetail->statutoryInfo->previousInsNo; 
            $this->employerCode = @$userDetail->statutoryInfo->employerCode; 
            $this->nameAddress = @$userDetail->statutoryInfo->nameAddress; 
            $this->employerEmail = @$userDetail->statutoryInfo->employerEmail; 
            $this->nomineeName = @$userDetail->statutoryInfo->nomineeName; 
            $this->nomineeRelationship = @$userDetail->statutoryInfo->nomineeRelationship; 
            $this->nomineeAddress = @$userDetail->statutoryInfo->nomineeAddress; 
            $this->particularName = @$userDetail->statutoryInfo->particularName; 
            $this->particularDateofbirth = @$userDetail->statutoryInfo->particularDateofbirth != ''?date('Y-m-d', (int)$userDetail->statutoryInfo->particularDateofbirth):''; 
            $this->particularRelationship = @$userDetail->statutoryInfo->particularRelationship; 
            $this->residancePlace = @$userDetail->statutoryInfo->residancePlace; 
            $this->confirmation_date = @$userDetail->joiningDetail->confirmation_date != ''?date('Y-m-d', (int)$userDetail->joiningDetail->confirmation_date):'';
            $this->notice_period = @$userDetail->joiningDetail->notice_period;
            $this->probation_period = @$userDetail->joiningDetail->probation_period;
            $this->other_terms = @$userDetail->joiningDetail->other_terms;
            $this->redmine_username = @$userDetail->officialContact->redmine_username;
            $this->discord_username = @$userDetail->officialContact->discord_username;
            $this->skype_id = @$userDetail->officialContact->skype_id;
            $this->permanent_state_id = @$userDetail->address->permanent_state_id;
            $this->permanent_city_id = @$userDetail->address->permanent_city_id;
            $this->permanentaddress = @$userDetail->address->permanent_address;
            $this->permanentzipcode = @$userDetail->address->permanent_zipcode;
            $this->present = @$userDetail->address->present;
        }
    }

    public function submitPayroll(){
        $this->tab = 'payroll';
        $this->validate([
            'annual_ctc' => 'nullable|numeric|max_digits:10',
            'basic_salary' => 'nullable|numeric|max_digits:10',
            'deductions' => 'nullable|numeric|max_digits:10',
            'allowances' => 'nullable|numeric|max_digits:10',
        ]);

        $user_id = $this->emp_id;
        $payrollExist = UserPayroll::where('user_id', $user_id)->first();
        $payrollData = array(
            'user_id' => $user_id,
            'annual_ctc' => $this->annual_ctc,
            'basic_salary' => $this->basic_salary,
            'deductions' => $this->deductions,
            'allowances' => $this->allowances
        );        
        if($payrollExist){
            UserPayroll::where('_id', $payrollExist['_id'])->update($payrollData);
            $this->alertSuccess('Payroll Detail Updated Successfully!');
        }else{
            UserPayroll::create($payrollData);
            $this->alertSuccess('Payroll Detail Created Successfully!');
        }
        return redirect('/profile/'.$user_id);
        
    }

    public function copyAddress(){
        $this->permanent_state_id = $this->current_state_id;
        $this->permanent_city_id = $this->current_city_id;
        $this->selectedPermanentCountry = $this->selectedCurrentCountry;
        $this->permanentzipcode = $this->currentzipcode;
        $this->permanentaddress = $this->currentaddress;
        if($this->current_state_id != '' || $this->current_state_id != '' || $this->selectedCurrentCountry != '' || $this->currentzipcode != '' || $this->currentaddress != ''){
            $this->disabled = true;
        }
    }

    public function addNewFamilyInfo(){
        $this->familyinputs[] = [];
    }

    public function removeFamilyInfo($index){
        UserFamilyInfo::where('_id', @$this->familyinputs[$index]['_id'])->delete();
        unset($this->familyinputs[$index]);
        $this->familyinputs = array_values($this->familyinputs);
    }
    public function addNewContactInfo(){
        $this->contactinputs[] = [];
    }

    public function removeContactInfo($index)
    {

        UserEmergencyContact::where('_id', @$this->contactinputs[$index]['_id'])->delete();

        unset($this->contactinputs[$index]);
        $this->contactinputs = array_values($this->contactinputs);   
    }
    public function addNewExperienceInfo()
    {
        $this->experienceinputs[] = [];
    }

    public function removeExperienceInfo($index)
    {
        $this->tab= 'experience';
        
        UserExperienceInfo::where('_id', @$this->experienceinputs[$index]['_id'])->delete();
        unset($this->experienceinputs[$index]);
        $this->experienceinputs = array_values($this->experienceinputs);
    }
    public function delete($id)
    {
        $deleteLeave = Leave::where('_id',$id)->first();
        $deleteLeave->delete();
        return redirect('/profile/'.$this->emp_id);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertSuccess($msg)
    {
        $this->dispatchBrowserEvent('alert',
                ['type' => 'success',  'message' => $msg]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertError($msg)
    {
        $this->dispatchBrowserEvent('alert',
        ['type' => 'error',  'message' => $msg]);
    }
       /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertInfo($msg){
        $this->dispatchBrowserEvent('alert',
                ['type' => 'info',  'message' => $msg]);
    }
}

    

