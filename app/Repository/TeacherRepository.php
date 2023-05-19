<?php

namespace App\Repository;

use App\Models\Gender;
use App\Models\Specialization;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherRepository implements TeacherRepositoryInterface
{
    public function getAllTeachers(){
        $Teachers = Teacher::all();
        return view('admin.teachers.teachers', compact('Teachers'));
    }

    public function getSpecialization(){
        return specialization::all();
    }

    public function getGender(){
        return Gender::all();
    }

    public function createTeacher(){
        $specializations = $this->getSpecialization();
        $genders = $this->getGender();
        return view('admin.teachers.create', compact('specializations', 'genders'));
    }
    public function StoreTeachers($request){
        try {
            $Teachers = new Teacher();
            $Teachers->Email = $request->Email;
            $Teachers->Password = Hash::make($request->Password);
            $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('teachers.create');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function editTeacher($id){
        $Teachers=Teacher::findOrFail($id);
        $specializations = $this->getSpecialization();
        $genders = $this->getGender();
        return view('admin.teachers.edit', compact('Teachers', 'specializations', 'genders'));
    }


    public function UpdateTeachers($request)
    {
        try {
            $Teachers = Teacher::findOrFail($request->id);
            $Teachers->Email = $request->Email;
            $Teachers->Password = Hash::make($request->Password);
            $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('teachers.index');
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }


    public function DeleteTeachers($request)
    {
        Teacher::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('teachers.index');
    }


}
