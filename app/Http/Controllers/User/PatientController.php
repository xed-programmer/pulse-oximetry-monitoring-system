<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PatientController extends Controller
{

    // FUNCTION PARA I-VIEW ANG PATIENT TAB
    public function index()
    {        
        $patients = Patient::whereHas('users', function($q){
            $q->where('user_id', auth()->id());
        })->get();
        // dd($patients);
        return view('user.patient.index')->with([
            'patients'=>$patients
        ]);
    }

    // FUNCTION PARA ISHOW ANG PULSES DATA NG PATIENT
    public function show(Request $request)
    {
        $request->validate(['id'=>['required', 'exists:patients,id']]);        
        return view('user.patient.show')->with(['patient_id'=>$request->id]);
    }

    // FUNCTION PARA MAG ADD NG NEW PATIENT
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','max:255'],
        ]);

        $unique_id = null;
        do {
            $unique_id = uniqid('P-');
            $unique_id = strtoupper($unique_id);
            $patient = Patient::where('patient_number', $unique_id)->get();
        } while ($patient->count()>0);
        
        $patient = Patient::create([
            'name' => $request->name,            
            'patient_number' => $unique_id
        ]);

        $user = User::find(auth()->id());
        $user->patients()->attach($patient->id);

        if ($patient) {
            $request->session()->flash('message', 'Patient Data Added Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'Patient Data Added Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('user.patient.index');
    }

    // FUNCTION PARA KUNIN ANG DATA NG PATIENT NA IEEDIT
    public function edit(Request $request)
    {
        $request->validate(['id'=>['required']]);
        $patient = Patient::find($request->id);
        return Response::json($patient);
    }

    // FUNCTION PARA I-UPDATE ANG DATA NG PATIENT
    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'exists:patients,id'],
            'name'=>['required','max:255'],            
        ]);

        $patient = Patient::find($request->id);
        $patient->name = $request->name;        
        if ($patient->save()) {
            $request->session()->flash('message', 'Patient Data Updated Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'Patient Data Updated Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('user.patient.index');
    }

    // FUNCTION PARA I-DELETE ANG DATA NG PATIENT
    public function destroy(Request $request)    
    {
        $request->validate([
            'id' => ['required','exists:patients,id']
        ]);
        $patient = Patient::find($request->id);
        if ($patient->delete()) {
            $request->session()->flash('message', 'Patient Data Deleted Successfully');
            $request->session()->flash('result', 'success');
        } else {
            $request->session()->flash('message', 'Patient Data Deleted Unsuccessfully!');
            $request->session()->flash('result', 'error');
        }
        return redirect()->route('user.patient.index');
    }
}