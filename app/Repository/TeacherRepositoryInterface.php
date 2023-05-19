<?php

namespace App\Repository;

interface TeacherRepositoryInterface{

    public function getAllTeachers();
    public function getSpecialization();
    public function getGender();
    public function createTeacher();
    public function StoreTeachers($request);
    public function editTeacher($id);
    public function UpdateTeachers($request);
    public function DeleteTeachers($request);

}


