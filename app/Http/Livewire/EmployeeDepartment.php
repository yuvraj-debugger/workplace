<?php
namespace App\Http\Livewire;

use App\Models\Employeedepartment as ModelsEmployeedepartment;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\Validation\Rule;

class EmployeeDepartment extends Component
{
    use WithPagination;

    public $title;

    public $department_id;

    public $search_department;

    public $checked = [];

    public $ids = [];

    public $allids = [];

    public $selectAll = false;

    public $selectPage = false;

    public $hideaddtitle = false;

    public $hideedittitle = false;

    public $employee_departments = [];

    public $employee_departmentArray = [];

    public function edit($department_id)
    {
        $departments = ModelsEmployeedepartment::where('_id', $department_id)->first();
        $this->department_id = $departments->id;
        $this->title = $departments->title;
        $this->hideedittitle = true;
        $this->hideaddtitle = false;
    }

    public function render()
    {
        $employee_department = ModelsEmployeedepartment::orderBy('title','ASC')->paginate(10);
        $department = ModelsEmployeedepartment::orderBy('title','ASC');
        $q = ModelsEmployeedepartment::orderBy('title','ASC');
        if ($this->search_department != 'all' && $this->search_department != '') {
            $department->where('_id', $this->search_department);
            $q->where('_id', $this->search_department);
        }
        $this->allids = $q->pluck('_id')->toArray();

        $this->ids = $department->paginate(10)->toArray();

        return view('livewire.employee-department', [
            'departments' => $department->paginate(10),
            'employee_department' => $employee_department
        ]);
    }
    public function submit()
    {
        
        $departments = ModelsEmployeedepartment::find($this->department_id);
        if (! empty($departments)) {
            $data = $this->validate([
                'title' => 'required'
            ]);
            $departments->update([
                'title' => $this->title
            ]);
            $this->dispatchBrowserEvent('closeServiceModal');
            $this->dispatchBrowserEvent('success',['message'=>'Department updated  Successfully!']);
        } else {
            $data = $this->validate([
                'title' => 'required'
            ]);
            ModelsEmployeedepartment::Create([
                'title' => $this->title
            ]);
            $this->dispatchBrowserEvent('closeServiceModal');
            $this->dispatchBrowserEvent('success',['message'=>'Department added Successfully!']);
        }
        $this->employee_departmentArray = ModelsEmployeedepartment::get()->toArray();
    }

    public function delete($department_id)
    {
        $count = User::where('department', $department_id)->count();
        if ($count > 0) {
            $this->dispatchBrowserEvent('error',['message'=>'You cannot delete this as some employees are linked with this department!']);
        } else {
            $user = ModelsEmployeedepartment::findOrFail($department_id);
            $user->delete();
            $this->search_department = '';
            $this->dispatchBrowserEvent('warning',['message'=>'Department Deleted Successfully!']);
            $this->employee_departmentArray = ModelsEmployeedepartment::get()->toArray();
        }
    }

    public function addform()
    {
        $this->resetData();
        $this->hideedittitle = false;
        $this->hideaddtitle = true;
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->allids;
    }

    public function resetData()
    {
        $this->title = '';
    }

    public function closeModal()
    {
        $this->resetData();
    }

    public function deleteRecords()
    {
        $userDepartments = User::whereIn('department', $this->checked)->groupBy('department')
            ->pluck('department')
            ->toArray();
        $this->checked = array_diff($this->checked, $userDepartments);

        ModelsEmployeedepartment::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;

        $this->employee_departmentArray = ModelsEmployeedepartment::get()->toArray();
        if (! empty($userDepartments)) {
            $this->dispatchBrowserEvent('error',['message'=>'Designations linked with employee cannot be deleted!']);
        } else {
            $this->dispatchBrowserEvent('warning',['message'=>'Department Deleted Successfully!']);
            
        }
    }

    public function deleteRecord($user_id)
    {
        $user = ModelsEmployeedepartment::findOrFail($user_id);
        $user->delete();
        $this->checked = array_diff($this->checked, [
            $user_id
        ]);
        $this->dispatchBrowserEvent('warning',['message'=>'Department Deleted Successfully!']);
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $ids = collect($this->ids['data'])->map(function ($item) {
                return $item['_id'];
            });
            $d = ModelsEmployeedepartment::pluck('_id');
            $idsData = [];
            foreach ((array) $ids as $key => $id) {
                if (is_array($id)) {
                    foreach ($id as $i) {

                        $idata = $i;

                        $idsData[] = $i;
                    }
                }
            }
            // dd($idsData);

            $this->checked = $idsData;
            // dd($this->checked);
        } else {
            $this->checked = [];
        }
    }

    public function isChecked($department_id)
    {
        return in_array($department_id, $this->checked);
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
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
            return ModelsEmployeedepartment::orderBy('id', 'Desc')->get();
        }, now()->addMinutes(50));

        $columns = array(
            'title'
        );
        $callback = function () use ($query, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($query as $task) {
                $row = array(
                    $task->title
                );
                fputcsv($file, $row);
            }
        };
        return response()->stream($callback, 200, $headers);
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
