<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class MainController extends Controller
{
    public function index()
    {
        $students = Student::paginate(10);
        $data = compact('students');
        return view('index')->with($data);
    }
    public function store(Request $request)
    {

        if (!empty($request->id)) {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ]);
            $student = Student::find($request->id);
            $student->name = $request->name;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->address = $request->address;
            $student->update();
            session()->flash("success", "Saved Successfully");
            return redirect()->back();
        } else {
            try {
                $validatedData = $request->validate([
                    'name' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                ]);
                $student = new Student;
                $student->name = $request->name;
                $student->email = $request->email;
                $student->phone = $request->phone;
                $student->address = $request->address;
                $student->save();
                session()->flash("success", "Saved Successfully");
                return redirect()->back();
            } catch (\Exception $e) {
                $msg = $e->getMessage();
            }
        }

    }
    public function destory(Request $request)
    {
        $student = Student::findOrFail($request->id);
        $student->delete();
        return redirect()->back()->with('success', 'Student deleted successfully');
    }
}
