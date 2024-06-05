// <?php
// namespace App\Http\Livewire;

// use Livewire\Component;
// use App\Models\User;
// use App\Models\Employeedepartment;
// use App\Exports\attendanceExport;
// use App\Models\UserAttendance;
// use Excel;
// use App\Models\Role;
// use Illuminate\Support\Facades\Auth;
// use App\Models\Leave;
// use App\Models\UserAttendanceDetail;
// use Livewire\WithPagination;

// class AdminAttendance extends Component
// {
//     use WithPagination;
    

//     public $employees = [], $attendances = [];

//     public $month, $year, $days, $employee, $department;

//     public $addTitle = false;

//     public $edittitle = false;
    
//     public $user_id,$date,$punch_in,$punch_out;
//     public $created_id;

    
//     protected $rules = [
//         'date'=>'required',
        
//     ];
//     public function mount($created_id=null)
//     {
//         $this->created_id=$created_id;
        
//         $this->month = date('m');
//         $this->year = date('Y');

//         $this->employees = User::where('user_role', '!=', '0')->get();
//         $this->departments = Employeedepartment::get();
//     }

//     public function days_in_month($month, $year)
//     {
//         // calculate number of days in a month
//         return date('t', strtotime($this->year . '-' . $this->month . '-d'));
//     }

//     public function render()
//     {
//         if(!empty($this->created_id))
//         {
//             $q = User::where('_id',$this->created_id)->orderBy('date', 'desc');
//             $userData = $q->paginate(6);
//         }
//         else 
//         {
//             $q = User::orderBy('date', 'desc');
//             if ($this->employee != '' && $this->employee != 'all') {
//                 $q = $q->where('_id', $this->employee);
//             }
//             if ($this->department != '' && $this->department != 'all') {
//                 $q = $q->where('department', $this->department);
//             }
//             $role = Role::where('_id', Auth::user()->user_role)->first();
            
//             if (! empty($role) && $role->name == 'employee') {
//                 $q = $q->where('_id', Auth::user()->_id);
//             }
//             if(!empty($role)&&($role->name=='Management')){
//                 $userManager = User::where('reporting_manager',Auth::user()->_id)->get()->pluck('_id')->toArray();
//                 $q = $q->whereIn('_id', $userManager);
//             }
            
//             $userData = $q->paginate(6);
//         }
//         $this->days = $this->days_in_month($this->month, $this->year);
        
//         $user_data=[];
//         foreach($userData as $user)
//         {
//             $data['_id']=$user->_id;
//             $data['name']=$user->first_name.' '.$user->last_name;
//             $data['photo']=($user->photo)?$user->photo:asset('/images/user.png');
//             for($day=0;$day<$this->days;++$day)
//             {
//                 $day_=$day;
//                 $date = $this->year . '-' . $this->month . '-' . ++$day_;
//                 $attendance = UserAttendance::where('user_id', $user->_id)->where('date', strtotime($date))->count();
//                 $data['date'][$date]=! empty($attendance) ? 1 : 0;
//             }
//            $user_data[]=$data;
//         }


//         $employeecounting = $userData->total();
//         $count=UserAttendance::where('date',strtotime(date('Y-m-d')))->count();

//         return view('livewire.admin-attendance', compact('count', 'employeecounting', 'userData','user_data'));
//     }
//     public function getAttendance($id,$date)
//     {
//         $date = $this->year . '-' . $this->month . '-' . ++$day;
//         $attendance = UserAttendance::where('user_id', $id)->where('date', strtotime($date))->count();
//         return ! empty($attendance) ? 1 : 0;
//     }
    
//     public function addform()
//     {
//         $this->resetData();
//         $this->addTitle = true;
//         $this->edittitle = false;
       
//     }

//     public function resetData()
//     {
//         $this->user_id ='';
//         $this->date = '';
//         $this->punch_in = '';
//         $this->punch_out = '';
//     }
//     public function submit()
//     {
//        $this->validate();
//        $userAttendance = UserAttendance::where('user_id',$this->user_id)->where('date',strtotime($this->date))->first();
//        if(! empty($userAttendance)){
          
//        }else{
//            $attendance=UserAttendance::Create([ 
//                'user_id' => $this->user_id,
//                'date'=>strtotime($this->date),
//                'punch_in'=>! empty($this->punch_in) ? strtotime(date('Y-m-d H:i:s',strtotime($this->date.' '.$this->punch_in))) : "",
//                'punch_out'=>! empty($this->punch_out) ? strtotime(date('Y-m-d H:i:s',strtotime($this->date.' '.$this->punch_out))) : ""
//            ]);
//            UserAttendanceDetail::create([
//                'attendance_id' => $attendance->_id,
//                'date'=>strtotime($this->date),
//                'punch_in'=>! empty($this->punch_in) ? strtotime(date('Y-m-d H:i:s',strtotime($this->date.' '.$this->punch_in))) : "",
//                'punch_out'=>! empty($this->punch_out) ? strtotime(date('Y-m-d H:i:s',strtotime($this->date.' '.$this->punch_out))) : ""
//            ]);
//            $this->emit('userStore', 'attendanceModal');
//            $this->resetData();
//            return redirect('/admin-attendance');
           
//        }
//     }
//     public function editAttendance($id,$date)
//     {
//         $date=date('Y-m-d',strtotime(date($date)));
//         $this->user_id = $id;
//         $this->date = $date;
//         $this->edittitle = true;
//         $this->addtitle = false;
//     }

//     public function export()
//     {
//         $data = $this;
//         return Excel::download(new attendanceExport($data), 'attendance.xlsx');
//     }
// }
