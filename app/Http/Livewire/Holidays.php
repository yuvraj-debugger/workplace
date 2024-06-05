<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Holiday;
use Livewire\WithPagination;
use App\Models\UserAttendanceDetail;

class Holidays extends Component
{
    use WithPagination;

    public $title;

    public $date, $holidayId = '', $month, $year;

    public $showModal = false;

    public $default = [];

    public $defaultModal;

    public $checked = [];

    public $inputs = [];

    public $selectAll = false;

    public $selectPage = false;

    public $ids = [];

    public $allids = [];

    // public $holidays = [];

    // protected $rules = [
    // 'title' => 'required|regex:/^[a-zA-Z ]*$/',
    // 'date' => 'required',
    // ];
    public function mount()
    {
        $this->addNew();

        $this->defaultModal = false;
        $this->month = '';
        $this->year = '';
    }
    public function resetData()
    {
        $this->date ='';
        $this->title='';
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->allids;
    }

    public function render()
    {
        $startDate='';
        $endDate='';
        $q = Holiday::orderBy('date', 'ASC');
        if ($this->month != '' && $this->year != '') {
            $startDate = $this->year . '-' . $this->month . '-01';
            $endDate = date("Y-m-t", strtotime($startDate));
            $startDate = strtotime($startDate);
            $endDate = strtotime($endDate);

            $q->whereBetween('date', [
                $startDate,
                $endDate
            ]);
           
        }
        $this->allids =  $q->paginate(10)->toArray();
        $this->ids = $q->orderBy('_id','ASC')->paginate(10)->toArray();
        $holidays = $q->paginate(10);
        return view('livewire.holidays',compact('holidays'));
    }

    public function edit($id)
    {
        $this->inputs = Holiday::where('_id', $id)->get()->toArray();
        if (@$this->inputs[0]['date'] != '') {
            $this->inputs[0]['date'] = date('Y-m-d', (int) $this->inputs[0]['date']);
        }
        $this->holidayId = $id;
    }

    public function submit()
    {
        $this->validate([
            'inputs.*.date' => 'required',
            'inputs.*.title' => 'required|regex:/^[a-zA-Z ]*$/|max:90'
        ], [
            'inputs.*.title.required' => 'The occasion field is required!',
            'inputs.*.title.regex' => 'The occasion format is invalid!',
            'inputs.*.date.required' => 'The date field is required!',
            'inputs.*.title.max' => 'The occasion field must not be greater than 90 characters!'
        ]);
        foreach ($this->inputs as $input) {
            if (! empty($input['_id'])) {
                $input['date'] = $input['date'] != '' ? strtotime($input['date']) : '';
                Holiday::find($input['_id'])->update($input);
                $this->alertSuccess('Holiday Data Updated Successfully!');
                
            } else {
                $input['date'] = $input['date'] != '' ? strtotime($input['date']) : '';
                Holiday::create($input);
                $this->alertSuccess('Holiday Add Successfully!');
                
                
            }
        }
        $this->resetData();

        // $holiday=Holiday::find($this->holidayId);
        // if(!empty($holiday)){
        // $holiday->update([
        // 'title' => $this->title,
        // 'date' => strtotime($this->date)
        // ]);
        // $this->alertSuccess('Holiday Updated Successfully!');

        // }else{

        // Holiday::Create(
        // ['title' => $this->title, 'date' => strtotime($this->date)]
        // );
        // $this->alertSuccess('Holiday Created Successfully!');

        // }
        $this->emit('submitted', 'leaveModal');
        return redirect('/holidays');
    }

    public function getAllDaysInAMonth($year, $month, $day = 'Monday', $daysError = 3)
    {
        $dateString = 'first ' . $day . ' of ' . $year . '-' . $month;

        if (! strtotime($dateString)) {
            throw new \Exception('"' . $dateString . '" is not a valid strtotime');
        }

        $startDay = new \DateTime($dateString);

        if ($startDay->format('j') > $daysError) {
            $startDay->modify('- 7 days');
        }

        $days = array();

        while ($startDay->format('Y-m') <= $year . '-' . str_pad($month, 2, 0, STR_PAD_LEFT)) {
            $days[] = clone ($startDay);
            $startDay->modify('+ 7 days');
        }

        return $days;
    }

    public function submitDefaultHolidays()
    {
        $this->validate([
            'default' => 'required'
        ]);
        $this->emit('submitted', 'defaultHolidayModal');
        $this->defaultModal = true;
    }

    public function cancel()
    {
        $this->default = [];
        $this->defaultModal = false;
    }

    public function markDefault()
    {
        foreach ($this->default as $default) {
            for ($i_month = 1; $i_month <= 12; $i_month ++) {
                $month = sprintf('%02d', $i_month);
                foreach ($this->getAllDaysInAMonth(date('Y'), $month, ucwords($default)) as $day) {
                    $selecteddate = $day->format('Y-m-d');

                    $count = Holiday::where([
                        'title' => $day->format('l'),
                        'date' => strtotime($selecteddate)
                    ])->count();
                    if ($count == 0) {
                        Holiday::Create([
                            'title' => $day->format('l'),
                            'date' => strtotime($selecteddate)
                        ]);
                    }
                }
            }
        }
        $this->alertSuccess('Default Holidays Created Successfully');
        $this->default = [];
        $this->defaultModal = false;

        // dd($this->default);
    }

    public function delete($id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();
        $this->alertSuccess('Holiday deleted Successfully');
    }

    public function deleteRecords()
    {
        Holiday::whereKey($this->checked)->delete();
        $this->checked = [];
        $this->selectAll = false;
        $this->selectPage = false;
        $this->alertInfo('Selected Records were deleted Successfully');
    }

    public function isChecked($department_id)
    {
        return in_array($department_id, $this->checked);
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            $ids = collect($this->ids['data'])->map(function ($item) {
                return $item['_id'];
            });
            $d = Holiday::pluck('_id');
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

    public function allHoliday()
    {
        Holiday::truncate();
    }
    public function allAttendance()
    {
        UserAttendanceDetail::truncate();
    }
    public function addNew()
    {
        $this->inputs[] = [];
    }

    public function remove($index)
    {
        // UserEducationInfo::where('_id', @$this->inputs[$index]['_id'])->delete();
        unset($this->inputs[$index]);
        $this->inputs = array_values($this->inputs);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
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
