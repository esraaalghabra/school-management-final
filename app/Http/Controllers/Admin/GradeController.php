<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

use App\Http\Requests\StoreGrades;
use App\Models\Grade;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        $Grades = Grade::all();
        return view('admin.grades', compact('Grades'));
    }

    public function store(StoreGrades $request)
    {
        try {
            $request->validated();
            $grade = new Grade();
            /*
            $translations = [
                'en' => $request->Name_en,
                'ar' => $request->Name
            ];
            $Grade->setTranslations('Name', $translations);
            */
            $grade->Name = ['en' => $request->Name_en, 'ar' => $request->Name];
            $grade->Notes = $request->Notes;
            $grade->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('Grades.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(StoreGrades $request)
    {
        try {
            $request->validated();
            $grades = Grade::findOrFail($request->id);
            $grades->update([
                $grades->Name = ['ar' => $request->Name, 'en' => $request->Name_en],
                $grades->Notes = $request->Notes,
            ]);
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Grades.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        $classrooms = Classroom::where('Grade_id', $request->id)->pluck('Grade_id');
        if ($classrooms->count() == 0) {
            Grade::findOrFail($request->id)->delete();
            toastr()->success(trans('messages.Delete'));
        } else {
            toastr()->error(trans('Grades_trans.delete_Grade_Error'));
        }
        return redirect()->route('Grades.index');
    }
}

?>
