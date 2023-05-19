<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTeachers;
use Illuminate\Http\Request;
use App\Repository\TeacherRepositoryInterface;

class TeacherController extends Controller{
    public function index(){
        return $this->Teacher->getAllTeachers();
    }
    public function create(){
        return $this->Teacher->createTeacher();
    }
    public function store(StoreTeachers $request){
        return $this->Teacher->StoreTeachers($request);
    }
    public function show($id){

    }
    public function edit($id){
        return $this->Teacher->editTeacher($id);
    }
    public function update(Request $request){
        return $this->Teacher->UpdateTeachers($request);
    }
    public function destroy(Request $request){
        return $this->Teacher->DeleteTeachers($request);
    }
}
