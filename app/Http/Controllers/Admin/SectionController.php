<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSections;

class SectionController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['Sections'])->get();
        $teachers = Teacher::all();
        return view('admin.sections', compact('grades', 'teachers'));
    }

    public function store(StoreSections $request)
    {
        try {
            $request->validated();
            $sections = new Section();
            $sections->Name_Section = ['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_En];
            $sections->Grade_id = $request->Grade_id;
            $sections->Class_id = $request->Class_id;
            $sections->Status = 1;
            $sections->save();
            $sections->teachers()->attach($request->teacher_id);
            toastr()->success(trans('messages.success'));
            return redirect()->route('Sections.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function update(StoreSections $request)
    {
        try {
            $request->validated();
            $sections = Section::findOrFail($request->id);
            $sections->Name_Section = ['ar' => $request->Name_Section_Ar, 'en' => $request->Name_Section_En];
            $sections->Grade_id = $request->Grade_id;
            $sections->Class_id = $request->Class_id;
            $sections->Status = isset($request->Status) ? 1 : 2;
            if (isset($request->teacher_id))
                $sections->teachers()->sync($request->teacher_id);
            else
                $sections->teachers()->sync(array());
            $sections->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Sections.index');
        } catch
        (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(request $request)
    {
        Section::findOrFail($request->id)->delete();
        toastr()->error(trans('messages.Delete'));
        return redirect()->route('Sections.index');
    }

    public function getClassrooms($gradeID)
    {
        return Classroom::where('Grade_id', $gradeID)->pluck('Name_Class', 'id');
    }
}

?>
