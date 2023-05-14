<?php

namespace App\Http\Controllers\Settings\Attendance;

use App\Actions\Utility\Setting\GetAttendanceSettingMenu;
use App\Http\Controllers\AdminBaseController;
use App\Services\Settings\Attendance\AttendanceGeneralService;
use App\Services\Settings\Attendance\AttendanceService;
use Carbon\Carbon;
use Inertia\Inertia;

class AttendanceManagementController extends AdminBaseController
{
    public function __construct(
        GetAttendanceSettingMenu $getAttendanceSettingMenu,
        AttendanceGeneralService $attendanceGeneralService,
        AttendanceService $attendanceService
    ) {
        $this->getAttendanceSettingMenu = $getAttendanceSettingMenu;
        $this->attendanceGeneralService = $attendanceGeneralService;
        $this->attendanceService = $attendanceService;
    }

    public function attendanceGeneralSettingIndex()
    {
        return Inertia::render($this->source . 'settings/attendance/general/Index', [
            "title" => 'TrustHR | Setting General Attendance',
            "additional" => [
                'menu' => $this->getAttendanceSettingMenu->handle(),
                'data' => $this->attendanceGeneralService->getCloseBreakup()
            ]
        ]);
    }

    public function attendanceSettingIndex()
    {
        $data = $this->attendanceService->getData();
        if(isset($this->attendanceService->getData()['time_for_force_clockout_fixed'])){
            $data['time_for_force_clockout_fixed'] = [
                'hours' => Carbon::parse($this->attendanceService->getData()['time_for_force_clockout_fixed'])->format('H'),
                'minutes' => Carbon::parse($this->attendanceService->getData()['time_for_force_clockout_fixed'])->format('i')
            ];
        }
        return Inertia::render($this->source . 'settings/attendance/attendance/Index', [
            "title" => 'TrustHR | Setting Attendance',
            "additional" => [
                'menu' => $this->getAttendanceSettingMenu->handle(),
                'data' => $data
            ]
        ]);
    }

    public function holidayCalendarSettingIndex()
    {
        return Inertia::render($this->source . 'settings/attendance/holiday/Index', [
            "title" => 'TrustHR | Setting Holiday Calendar',
            "additional" => [
                'menu' => $this->getAttendanceSettingMenu->handle(),
            ]
        ]);
    }
}
