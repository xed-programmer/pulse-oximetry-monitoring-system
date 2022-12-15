<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\QueuePulseReportEmail;
use App\Models\Device;
use App\Models\Patient;
use App\Models\Pulse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PulseController extends Controller
{
    private $api_key_value = 'tPmAT5Ab3j7F9';
        
    public function index(Request $request)
    {
        // ITO YUNG PROCESS NG PAG SEND NG DATA NG
        // PULSE SENSOR TO WEB SERVER
        $request->validate([
            'api_key' => 'required',
            'id' => ['required', 'exists:devices,machine_number'],
            'hr' => 'required',
            'spo2' => 'required'
        ]);

        $hr = $request->hr;
        $spo2 = $request->spo2;

        if ($request->api_key != $this->api_key_value) {
            echo "api is invalid";
        }

        $device = Device::where('machine_number', $request->id)->firstOrFail();
        Pulse::create([
            'device_id' => $device->id,
            'patient_id' => $device->patient_id,
            'hr' => $hr,
            'spo2' => $spo2
        ]);

        if ($spo2 < 90) {
            echo "sending email";
            $details = (object) array();

            $users = User::whereHas('patients', function ($q) use ($device) {
                $q->where('patient_id', $device->patient_id);
            })->get();

            foreach ($users as $user) {
                $currentTime = now();
                if (empty($user->email_sent) || $currentTime->diffInMinutes($user->email_sent) > 3) {
                    $details->user = $user;
                    $details->hr = $hr;
                    $details->spo2 = $spo2;
                    $details->spo2_limit = 90;
                    
                    // PulseReportSendEmail::dispatch($details);
                    Mail::to($details->user->email)
                    ->send(new QueuePulseReportEmail($details));
                    $user->email_sent = $currentTime;
                    $user->save();
                }
            }
        }
        echo "ok";
    }

    public function getPatientPulse()
    {
        // KINUKUHA YUNG PULSES NG PATIENTS
        $devices = Device::all();
        $array_pulse = array();

        foreach ($devices as $d) {
            $pulse = Pulse::with(['patient'])
                ->where('patient_id', $d['patient_id'])
                ->where('device_id', $d['id'])
                ->latest()
                ->limit(10)
                ->get()
                ->groupBy('device_id');
            // $array_pulse = $pulse;
            array_push($array_pulse, $pulse);
        }
        echo json_encode($array_pulse);
    }
    
    public function getLatestPatientPulse(Request $request)
    {
        // KINUKUHA YUNG LATEST PULSE NG PATIENT        

        $patients = Patient::with(['pulses'=>function($q){
            $q->latest()->limit(1);
        }])->whereHas('users', function($q) use($request){
            $q->where('user_id', $request->id);
        })->get();
        
        echo json_encode($patients);
    }

    public function getUserPatientPulse($id)
    {
        $pulse = Pulse::with(['patient'])
            ->where('patient_id', $id)
            ->latest()
            ->limit(10)
            ->get();
        echo json_encode($pulse);
    }
}
