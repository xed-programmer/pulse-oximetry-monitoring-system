<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DeviceController extends Controller
{
    // ANG CONTROLLER NA TO AT PARA SA PAGMANIPULATE NG DATA NG DEVICE
    public function index()
    {
        $user_id = auth()->id();
        $patients = Patient::whereHas('users', function($q) use($user_id){
            $q->where('user_id', $user_id);
        })->get();
        return view('user.device.index')->with(['patients'=>$patients]);
    }


    // ANG FUNCTION NA TO AY PARA I-STORE AND NEW DEVICE SA DATABASE
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required'],
            'machine_number'=>['required','unique:devices,machine_number']
        ]);        

        $device = Device::create($request->only(['name','machine_number']));        
        $user = User::find(auth()->id());
        $user->devices()->attach($device->id);
        return back();
    }

    // FUNCTION PARA KUNIN ANG DATA NG DEVICE NA IEEDIT
    public function edit(Request $request)
    {        
        $request->validate([
            'id'=>['required']
        ]);
        $device = Device::with('patient')
        ->where('id',$request->id)
        ->firstOrFail();
        return Response::json($device);
    }

    // FUNCTION PARA I-UPDATE ANG DEVICE DATA
    public function update(Request $request)
    {        
        $request->validate([
            'id' => ['required'],
            'name' => ['required'],
            'machine_number' => ['required', 'unique:devices,machine_number,'.$request->id.',id'],            
        ]);
        
        $device = Device::find($request->id);

        $device->name = $request->name;
        $device->machine_number = $request->machine_number;
        $device->patient_id = $request->patient;

        if ($device->save()) {
            $request->session()->flash('message', 'Device Data Updated Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'Device Data Updated Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('user.device.index');
    }

    // FUNCTION PARA I-DELETE ANG DEVICE DATA
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:devices,id']
        ]);
        
        $device = Device::find($request->id);
        if ($device->delete()) {
            $request->session()->flash('message', 'Device Data Deleted Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'Device Data Deleted Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('user.device.index');
    }
}
