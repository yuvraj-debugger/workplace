<?php
namespace App\Http\Livewire;

use App\Models\Employeedesignation as ModelsEmployeedesignation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class EmployeeDesignation extends Component
{
    use WithPagination;

    public $title;

    public $designations_id;

    public $search_designation;

    public $checked = [];

    public $ids = [];

    public $allids = [];

    public $selectAll = false;

    public $selectPage = false;

    public $hideaddtitle = false;

    public $hideedittitle = false;

    public $employee_designation = [];

    public $employee_designationsArray = [];

    public function edit($designation_id)
    {
        $designations = ModelsEmployeedesignation::where('_id', $designation_id)->first();
        $this->designations_id = $designations->id;
        $this->title = $designations->title;
        $this->hideedittitle = true;
        $this->hideaddtitle = false;
    }

    public function render()
    {
        $employee_designations = ModelsEmployeedesignation::orderBy('title','ASC')->get();
        $designation = ModelsEmployeedesignation::orderBy('title','ASC');
        $q = ModelsEmployeedesignation::orderBy('title','ASC');
        if ($this->search_designation != 'all' && $this->search_designation != '') {
            $q = $q->where('_id', $this->search_designation);
            $designation->where('_id', $this->search_designation);
        }
        $this->allids = $q->pluck('_id')->toArray();
        $this->ids = $designation->paginate(10)->toArray();
        return view('livewire.employee-designation', [
            'designations' => $designation->paginate(10),
            'employee_designations' => $employee_designations
        ]);
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->allids;
    }

    public function submit()
    {
      
        $designations = ModelsEmployeedesignation::find($this->designations_id);
        if (! empty($designations)) {
            $data = $this->validate([
                'title' => 'required'
            ]);
            
            $designations->update([
                'title' => $this->title
            ]);
            $this->dispatchBrowserEvent('success',['message'=>'Designation updated Successfully!']);
            $this->dispatchBrowserEvent('closeServiceModal');
            
        } else {
            $data = $this->validate([
                'title' => 'required'
            ]);
            ModelsEmployeedesignation::Create([
                'title' => $this->title
            ]);
            $this->dispatchBrowserEvent('success',['message'=>'Designation added Successfully!']);
            $this->dispatchBrowserEvent('closeServiceModal');
            
        }
        return redirect('/employee-designation');
        $this->employee_designationsArray = ModelsEmployeedesignation::get()->toArray();
        
    }

    public function addform()
    {
        $this->resetData();
        $this->hideedittitle = false;
        $this->hideaddtitle = true;
    }

    public function resetData()
    {
        $this->title = '';
    }

    public function delete($designation_id)
    {
        $count = User::where('designation', $designation_id)->count();
        if ($count > 0) {
            $this->dispatchBrowserEvent('error',['message'=>'You cannot delete this as some employees are linked with this designation!']);
        } else {
            $user = ModelsEmployeedesignation::findOrFail($designation_id);
            $user->delete();
            $this->search_designation = 'all';

            $this->dispatchBrowserEvent('warning',['message'=>'Designation Deleted Successfully!']);
            $this->employee_designationsArray = ModelsEmployeedesignation::get()->toArray();
            
        }
    }

    public function deleteRecords()
    {
        $userDesignations = User::whereIn('designation', $this->checked)->groupBy('designation')
            ->pluck('designation')
            ->toArray();
        $this->checked = array_diff($this->checked, $userDesignations);

        ModelsEmployeedesignation::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        $this->employee_designationsArray = ModelsEmployeedesignation::get()->toArray();
        if (! empty($userDesignations)) {
            $this->dispatchBrowserEvent('error',['message'=>'Designations linked with employee cannot be deleted!']);
        } else {
            $this->dispatchBrowserEvent('warning',['message'=>'Designation Deleted Successfully!']);
            
        }
    }

    public function deleteRecord($user_id)
    {
        $user = ModelsEmployeedesignation::findOrFail($user_id);
        $user->delete();
        $this->checked = array_diff($this->checked, [
            $user_id
        ]);
        $this->dispatchBrowserEvent('warning',['message'=>'Designation Deleted Successfully!']);
        
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $ids = collect($this->ids['data'])->map(function ($item) {
                return $item['_id'];
            });
            $d = ModelsEmployeedesignation::pluck('_id');
            $idsData = [];
            foreach ((array) $ids as $key => $id) {
                if (is_array($id)) {
                    foreach ($id as $i) {
                        $idata = $i;
                        $idsData[] = $i;
                    }
                }
            }
            $this->checked = $idsData;
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
            return ModelsEmployeedesignation::orderBy('id', 'Desc')->get();
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
