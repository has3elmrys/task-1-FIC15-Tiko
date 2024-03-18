<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function index(Request $request){
        $doctors = DB::table('doctors')->
        when($request->input('name'), function ($query, $doctor_name){
            return $query->where('doctor_name','like', '%' .$doctor_name . '%');
        }) ->orderBy('id', 'desc')
        ->paginate(10);

        return view('pages.doctors.index', compact ('doctors'));
    }

    //create
    public function create() {
        return view('pages.doctors.create
        ');
    }

    //store
    public function store (Request $request) {
        $request->validate([
            'doctor_name'=>'required',
            'doctor_specialist'=>'required',
            'doctor_email'=>'required',
            'doctor_phone'=>'required',
            'doctor_address'=>'required',
            'shift'=>'required',
            'photo'=>'image|max:2048',  // validate the photo input
        ]);
    
        $photo = $request->file('photo');
        $photo_name = time().'.'.$photo->getClientOriginalExtension();
        $photo->move(public_path('images'), $photo_name);
            
      

        DB::table('doctors')->insert([
            'doctor_name'=>$request->doctor_name,
            'doctor_specialist'=>$request->doctor_specialist,
            'doctor_email'=>$request->doctor_email,
            'doctor_phone'=>$request->doctor_phone,
            'doctor_address'=>$request->doctor_address,
            'shift'=>$request->shift,
            'photo'=>$photo_name
            // 'photo'=>NULL,  // explicitly set 'photo' as NULL
        ]);

        return redirect()->route('doctors.index')->with('success','Doctor created succesffully.');
    }

    //show
    public function show($id){
       $doctor= DB::table('doctors')
                ->where('id',$id)
                ->first();
       return view('pages.doctors.view',compact('doctor'));
   }

   //edit
   public function edit($id){
    $doctor = DB::table('doctors')->where('id', $id)->first();
    return view('pages.doctors.edit', compact('doctor'));
}

//update
public function update(Request $request, $id){
    $request->validate([
        'doctor_name'=>'required',
        'doctor_specialist'=>'required',
        'doctor_email'=>'required',
        'doctor_phone'=>'required',
        'shift'=>'required',
    ]);
    DB::table('doctors')->where('id', $id)->update([
        'doctor_name'=>$request->doctor_name,
        'doctor_specialist'=>$request->doctor_specialist,
        'doctor_email'=>$request->doctor_email,
        'doctor_phone'=>$request->doctor_phone,
        'shift'=>$request->shift,
    ]);
    return redirect()->route('doctors.index')->with('success','Doctor updated succesffully.');
}

//destroy
public function destroy($id){
    DB::table('doctors')->where('id', $id)->delete();
    return redirect()->route('doctors.index')->with('success', 'Doctor deleted succesfully');
  }
}
