<?php
namespace App\Http\Livewire;

use App\Models\Employeedepartment;
use App\Models\Employeedesignation;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
;

class EmployeeList extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $first_name, $last_name, $email, $password, $photo, $date_of_birth, $joining_date, $contact, $department, $designation, $reporting_manager, $app_login, $email_notification, $workplace, $User_id, $type, $image, $employee_id;

    public $search_role = '';

    public $status;

    public $employees = [];

    public $employeeArray = [];

    public $upload_data;

    # [Url()]
    public $search_name;

    public $search_designation = '';

    public $search_status = '';
    
    public $search_gender;

    public $sortField = 'designation';

    public $sortfieldname = 'first_name';

    public $sortfieldstatus = 'status';

    public $sortDirection = 'asc';

    public $department_id = '';

    public $hideaddtitle = false;

    public $hideedittitle = false;

    public $hideid = false;

    public $user_role;
    
    

    protected function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,' . $this->User_id . ',_id',
            'date_of_birth' => 'required|before:' . now()->subYears(18)->toDateString(),
            'joining_date' => 'required|after:date_of_birth',
            'contact' => 'required|numeric|max_digits:15',
            'password' => 'required_without:User_id|nullable',
            'designation' => 'required',
            'department' => 'required',
            'app_login' => 'required',
            'email_notification' => 'required',
            'workplace' => 'required',
            'user_role' => 'required',
            'status' => 'required'
        ];
    }

    protected $messages = [
        'password.required_without' => 'The password field is required'
    ];

    public function edit($user_id)
    {
        $this->hideaddtitle = false;
        $this->hideedittitle = true;
        $user = User::where('_id', $user_id)->first();
        $this->User_id = $user->_id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->password = '';
        $this->date_of_birth = $user->date_of_birth;
        $this->joining_date = $user->joining_date;
        $this->contact = $user->contact;
        $this->department = $user->department;
        $this->designation = $user->designation;
        $this->reporting_manager = $user->reporting_manager;
        $this->app_login = $user->app_login;
        $this->email_notification = $user->email_notification;
        $this->workplace = $user->workplace;
        $this->image = $user->photo;
        $this->user_role = $user->user_role;
        $this->status = $user->status;
    }

    public function render()
    {
        $roles = Role::get();
        $departments = Employeedepartment::get();
        $designations = Employeedesignation::get();
        $employee = User::where('user_role', '!=', '0')->get();

        $users = User::where('user_role', '!=', '0')->orderBy('_id', 'DESC');
        if ($this->search_name != 'all' && $this->search_name != '') {
            $users = $users->where('_id', $this->search_name);
        }
        if (! empty($this->search_designation)) {
            $users = $users->where('designation', $this->search_designation);
        }
        if (! empty($this->search_role) || $this->search_role == 0) {

            $users = $users->where('user_role', $this->search_role);
        }

        if ($this->search_status != 'all' && $this->search_status != '') {

            $users = $users->whereIn('status', [
                (int) $this->search_status,
                $this->search_status
            ]);
        }
        if (! empty($this->search_name)) {
            
            $users = User::whereIn('_id', $this->search_name);
        }
        if ($this->search_gender != 'all' && $this->search_gender != '') {
            $users = $users->where('gender','like','%'.$this->search_gender.'%');
        }
        $users = $users->paginate(10);
        return view('livewire.employee-list', compact('departments', 'designations', 'users', 'employee', 'roles'));
    }

    public function submit()
    {
        $this->validate();
        $users = User::find($this->User_id);
        if (! empty($users)) {
            if (! empty($this->photo)) {
                $filename = time() . '.' . $this->photo->getClientOriginalName();
                $filePath = 'employee_image/' . $filename;
                $path = Storage::disk('s3')->put($filePath, file_get_contents($this->photo->temporaryUrl()));

                $url = Storage::disk('s3')->url($filePath);
            } else {
                $url = $this->image;
            }
            $users->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'photo' => $url,
                'password' => $this->password != '' ? Hash::make($this->password) : $users->password,
                'date_of_birth' => $this->date_of_birth,
                'joining_date' => $this->joining_date,
                'contact' => $this->contact,
                'designation' => $this->designation,
                'department' => $this->department,
                'reporting_manager' => $this->reporting_manager,
                'app_login' => $this->app_login,
                'email_notification' => $this->email_notification,
                'workplace' => $this->workplace,
                'user_role' => $this->user_role,
                'status' => $this->status
            ]);
            $this->alertSuccess('Employee updated  Successfully!');
        } else {
            $url = "";
            if (! empty($this->photo)) {
                $filename = time() . '.' . $this->photo->getClientOriginalName();
                $filePath = 'employee_image/' . $filename;
                $path = Storage::disk('s3')->put($filePath, file_get_contents($this->photo->temporaryUrl()));
                $url = Storage::disk('s3')->url($filePath);
            }
            $user = User::Create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'date_of_birth' => $this->date_of_birth,
                'joining_date' => $this->joining_date,
                'contact' => $this->contact,
                'photo' => $url,
                'contact' => $this->contact,
                'designation' => $this->designation,
                'department' => $this->department,
                'reporting_manager' => $this->reporting_manager,
                'app_login' => $this->app_login,
                'employee_id' => 'SSPL' . (1000 + User::count() + 1),
                'email_notification' => $this->email_notification,
                'workplace' => $this->workplace,
                'user_role' => $this->user_role,
                'status' => $this->status
            ]);

            $this->alertSuccess('Employee added  Successfully!');
            $this->createTeam($user);
        }
        $this->employeeArray = User::get()->toArray();
        $this->emit('refreshDropdown');
        $this->emit('userStore', 'personalInfo');
    }

    protected function createTeam(User $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
            'personal_team' => true
        ]));
    }

    public function delete($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();
        $this->search_name = '';
        $this->alertSuccess('Employee deleted Successfully');

        $this->employeeArray = User::get()->toArray();
        $this->emit('refreshDropdown');
    }

    public function resetData()
    {
        $this->User_id = '';
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->date_of_birth = '';
        $this->joining_date = '';
        $this->contact = '';
        $this->department = '';
        $this->designation = '';
        $this->reporting_manager = '';
        $this->app_login = '';
        $this->password = '';
        $this->email_notification = '';
        $this->workplace = '';
        $this->photo = '';
        $this->image = '';
    }

    public function addform()
    {
        $this->resetData();
        $this->hideaddtitle = true;
        $this->hideedittitle = false;
    }

    public function changeEvent($employ_id, $value)
    {
        $user = User::where('_id', $employ_id)->first();
        $user->designation = $value;
        $user->update();
    }

    public function changeDepartment($employ_id, $value)
    {
        $user = User::where('_id', $employ_id)->first();
        $user->department = $value;
        $user->update();
    }

    public function exportData(Request $request)
    {
        $fileName = 'EmployeeData.csv';
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $query = Cache::get('business_export', function () {

            return User::orderBy('_id', 'Desc')->get();
        }, now()->addMinutes(50));
        $columns = array(
            'Employee_id ',
            'First Name',
            'Last Name',
            'Email',
            'Date Of Birth',
            'Joining Date',
            'Contact',
            'Photo',
            'Department',
            'Designation',
            'Reporting Manager',
            'Email Notification',
            'App Login',
            'Workplace',
            'Status',
            'User Role',
            'Gender',
            'Whats App Number',
            'Blood Group',
            'Marital Status',
            'Children',
            'Passport Number',
            'Passport Expiry Date',
            'Spouse Employment',
            'Religion',
            'Nationality'
        );
        $callback = function () use ($query, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($query as $task) {
                $row = array(
                    $task->employee_id,
                    $task->first_name,
                    $task->last_name,
                    $task->email,
                    $task->date_of_birth,
                    $task->joining_date,
                    $task->contact,
                    $task->photo,
                    $task->getdepartment()->title ?? '',
                    $task->getdesignation()->title ?? '',
                    $task->getReportingmanager(),
                    $task->email_notification == 1 ? 'no' : 'yes',
                    $task->app_login == 1 ? 'no' : 'yes',
                    $task->workplace == 1 ? 'WFO' : 'WFH',
                    $task->status == 1 ? 'Active' : 'Inactive',
                    $task->get_userrole()->name ?? 'admin',
                    $task->gender ?? '',
                    $task->whatsapp ?? '',
                    $task->blood_group ?? '',
                    $task->marital_status ?? '',
                    $task->children ?? '',
                    $task->passport_number ?? '',
                    $task->passport_expiry_date ?? '',
                    $task->spouse_employment ?? '',
                    $task->religion ?? '',
                    $task->nationality ?? ''
                );
                fputcsv($file, $row);
            }
        };
        return response()->stream($callback, 200, $headers);
    }

    public function csvToArray($filename = '', $delimiter = ',')
    {
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (! $header)
                    $header = $row;
                else
                    $data[] = $row;
            }
            fclose($handle);
        }

        return $data;
    }

    public function import()
    {
        $this->validate([
            'upload_data' => 'required|mimes:csv'
        ]);
        if (! empty($this->upload_data)) {
            $filename = time() . '.' . $this->upload_data->getClientOriginalName();
            $filePath = 'employee_image/' . $filename;
            $path = Storage::disk('s3')->put($filePath, file_get_contents($this->upload_data->temporaryUrl()));
            $url = Storage::disk('s3')->url($filePath);
        }
        $customerArr = $this->csvToArray($url);
        for ($i = 0; $i < count($customerArr); $i ++) {
            $count = User::where('email', $customerArr[$i][3])->count();
            if ($count == 0) {
                $employment = Employeedepartment::updateOrCreate([
                    'title' => $customerArr[$i][8]
                ]);
                $customerArr[$i]['department'] = $employment->_id;
                $designation = Employeedesignation::updateOrCreate([
                    'title' => $customerArr[$i][9]
                ]);
                $customerArr[$i]['designation'] = $designation->_id;
                $customerArr[$i]['employee_id'] = 'SSPL' . (1000 + User::count() + 1);
                $customerArr[$i]['user_role'] = Role::where('name', 'employee')->value('_id');
                $customerArr[$i]['status'] = '2';
                $user = User::firstOrCreate($customerArr[$i]);
                $this->createTeam($user);
            }
        }
        $this->employeeArray = User::get()->toArray();
        $this->emit('refreshDropdown');
        $this->emit('userStore', 'import_info');
    }

    public function alertSuccess($msg)
    {
        $this->dispatchBrowserEvent('alert', [
            'type' => 'success',
            'message' => $msg
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertError($msg)
    {
        $this->dispatchBrowserEvent('alert', [
            'type' => 'error',
            'message' => $msg
        ]);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function alertInfo($msg)
    {
        $this->dispatchBrowserEvent('alert', [
            'type' => 'info',
            'message' => $msg
        ]);
    }
}
