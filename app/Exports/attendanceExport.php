<?php
namespace App\Exports;

use App\Models\UserAttendance;
use Maatwebsite\Excel\Concerns\FromCollection;

class attendanceExport implements FromCollection
{

    /**
     *
     * @return \Illuminate\Support\Collection
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $data = $this->data;
        $ad['employee'] = 'Employee';
        for ($d = 1; $d <= $data->days; $d ++) {
            $ad['d' . $d] = $d;
        }
        $returnData[] = $ad;
        foreach ($data->attendances as $key => $attendance) {
            $ad['employee'] = $attendance['name'];
            for ($d = 0; $d < $data->days; $d ++) {
                if ($attendance[$d]['attendance_status'] == '1') {
                    $ad['d' . $d] = 'P';
                } else {
                    $ad['d' . $d] = 'A';
                }
            }
            $returnData[] = $ad;
        }
        return collect($returnData);
    }
}
