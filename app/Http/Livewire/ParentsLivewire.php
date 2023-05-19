<?php

namespace App\Http\Livewire;

use App\Models\Grade;
use App\Models\My_Parent;
use App\Models\Nationalitie;
use App\Models\ParentAttachment;
use App\Models\Religion;
use App\Models\Type_Blood;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class ParentsLivewire extends Component
{
    use WithFileUploads;

    public $successMessage = '', $catchError,$updateMode = false, $showTable = true, $currentStep = 1;
    public $photos, $Parent_id, $email, $password, $nameF_ar, $nameF_en,
        $National_ID_Father, $Passport_ID_Father, $Phone_Father, $Job_Father,
        $Job_Father_en, $Nationality_Father_id, $Blood_Type_Father_id,
        $Address_Father, $Religion_Father_id,
        $Name_Mother, $Name_Mother_en, $National_ID_Mother, $Passport_ID_Mother
        ,$Phone_Mother, $Job_Mother, $Job_Mother_en, $Nationality_Mother_id, $Blood_Type_Mother_id, $Address_Mother, $Religion_Mother_id;

    // index :
    public function render()
    {
        $data=['Nationalities' => Nationalitie::all(),
               'Type_Bloods' => Type_Blood::all(),
               'Religions' => Religion::all(),
               'parents' => My_Parent::all(), ];
        return view('livewire.parents-livewire', $data);
    }

    // Run Time Validation :
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'email' => 'required|email',
            'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'Passport_ID_Father' => 'min:10|max:10',
            'Phone_Father' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'National_ID_Mother' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
            'Passport_ID_Mother' => 'min:10|max:10',
            'Phone_Mother' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
        ]);
    }

    // controller view elements
    public function hideTable()
    {
        $this->successMessage ='';
        $this->showTable = false;
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }

    // controller of create
    public function firstStepSubmit()
    {
        $this->validate([
            'email' => 'required|unique:my__parents,Email',
            'password' => 'required',
            'nameF_ar' => 'required',
            'nameF_en' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'National_ID_Father' => 'required|unique:my__parents,National_ID_Father',
            'Passport_ID_Father' => 'required|unique:my__parents,Passport_ID_Father',
            'Phone_Father' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Father_id' => 'required',
            'Blood_Type_Father_id' => 'required',
            'Religion_Father_id' => 'required',
            'Address_Father' => 'required',
        ]);
        $this->currentStep = 2;
    }

    public function secondStepSubmit()
    {
        $this->validate([
            'Name_Mother' => 'required',
            'Name_Mother_en' => 'required',
            'National_ID_Mother' => 'required|unique:my__parents,National_ID_Mother',
            'Passport_ID_Mother' => 'required|unique:my__parents,Passport_ID_Mother',
            'Phone_Mother' => 'required',
            'Job_Mother' => 'required',
            'Job_Mother_en' => 'required',
            'Nationality_Mother_id' => 'required',
            'Blood_Type_Mother_id' => 'required',
            'Religion_Mother_id' => 'required',
            'Address_Mother' => 'required',
        ]);
        $this->currentStep = 3;
    }

    public function submitForm()
    {
        try{
            $parent = new My_Parent();
            // Father_INPUTS
            $parent->Email = $this->email;
            $parent->Password = Hash::make($this->password);
            $parent->Name_Father = ['en' => $this->nameF_en, 'ar' => $this->nameF_ar];
            $parent->National_ID_Father = $this->National_ID_Father;
            $parent->Passport_ID_Father = $this->Passport_ID_Father;
            $parent->Phone_Father = $this->Phone_Father;
            $parent->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
            $parent->Passport_ID_Father = $this->Passport_ID_Father;
            $parent->Nationality_Father_id = $this->Nationality_Father_id;
            $parent->Blood_Type_Father_id = $this->Blood_Type_Father_id;
            $parent->Religion_Father_id = $this->Religion_Father_id;
            $parent->Address_Father = $this->Address_Father;

            // Mother_INPUTS
            $parent->Name_Mother = ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother];
            $parent->National_ID_Mother = $this->National_ID_Mother;
            $parent->Passport_ID_Mother = $this->Passport_ID_Mother;
            $parent->Phone_Mother = $this->Phone_Mother;
            $parent->Job_Mother = ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother];
            $parent->Passport_ID_Mother = $this->Passport_ID_Mother;
            $parent->Nationality_Mother_id = $this->Nationality_Mother_id;
            $parent->Blood_Type_Mother_id = $this->Blood_Type_Mother_id;
            $parent->Religion_Mother_id = $this->Religion_Mother_id;
            $parent->Address_Mother = $this->Address_Mother;
            $parent->save();

            if (!empty($this->photos)) {
                foreach ($this->photos as $photo) {
                    $photo->storeAs($this->National_ID_Father, $photo->getClientOriginalName(), $disk = 'parent_attachments');
                    ParentAttachment::create([
                        'file_name' => $photo->getClientOriginalName(),
                        'parent_id' => My_Parent::latest()->first()->id,
                    ]);
                }
            }
            $this->reset();
            $this->successMessage = trans('messages.success');
            $this->currentStep = 1;
            $this->showTable=true;
        } catch (\Exception $e) {
            $this->catchError = $e->getMessage();
        }
    }

    // controller of update
    public function editMode($id)
    {
        $this->showTable = false;
        $this->successMessage ='';
        $this->updateMode = true;
        $parent = My_Parent::where('id', $id)->first();
        $this->Parent_id = $id;
        $this->email = $parent->Email;
        $this->password = $parent->Password;
        $this->nameF_ar = $parent->getTranslation('Name_Father', 'ar');
        $this->nameF_en = $parent->getTranslation('Name_Father', 'en');
        $this->Job_Father = $parent->getTranslation('Job_Father', 'ar');;
        $this->Job_Father_en = $parent->getTranslation('Job_Father', 'en');
        $this->National_ID_Father = $parent->National_ID_Father;
        $this->Passport_ID_Father = $parent->Passport_ID_Father;
        $this->Phone_Father = $parent->Phone_Father;
        $this->Nationality_Father_id = $parent->Nationality_Father_id;
        $this->Blood_Type_Father_id = $parent->Blood_Type_Father_id;
        $this->Address_Father = $parent->Address_Father;
        $this->Religion_Father_id = $parent->Religion_Father_id;

        $this->Name_Mother = $parent->getTranslation('Name_Mother', 'ar');
        $this->Name_Mother_en = $parent->getTranslation('Name_Father', 'en');
        $this->Job_Mother = $parent->getTranslation('Job_Mother', 'ar');;
        $this->Job_Mother_en = $parent->getTranslation('Job_Mother', 'en');
        $this->National_ID_Mother = $parent->National_ID_Mother;
        $this->Passport_ID_Mother = $parent->Passport_ID_Mother;
        $this->Phone_Mother = $parent->Phone_Mother;
        $this->Nationality_Mother_id = $parent->Nationality_Mother_id;
        $this->Blood_Type_Mother_id = $parent->Blood_Type_Mother_id;
        $this->Address_Mother = $parent->Address_Mother;
        $this->Religion_Mother_id = $parent->Religion_Mother_id;
    }

    public function firstStepSubmit_edit()
    {
        $this->validate([
            'email' => 'required|unique:my__parents,Email,'.$this->Parent_id,
            'password' => 'required',
            'nameF_ar' => 'required',
            'nameF_en' => 'required',
            'Job_Father' => 'required',
            'Job_Father_en' => 'required',
            'National_ID_Father' => 'required|unique:my__parents,National_ID_Father,' . $this->Parent_id,
            'Passport_ID_Father' => 'required|unique:my__parents,Passport_ID_Father,' . $this->Parent_id,
            'Phone_Father' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'Nationality_Father_id' => 'required',
            'Blood_Type_Father_id' => 'required',
            'Religion_Father_id' => 'required',
            'Address_Father' => 'required',
        ]);
        $this->updateMode = true;
        $this->currentStep = 2;
    }

    public function secondStepSubmit_edit()
    {
        $this->validate([
            'Name_Mother' => 'required',
            'Name_Mother_en' => 'required',
            'National_ID_Mother' => 'required|unique:my__parents,National_ID_Mother,' . $this->Parent_id,
            'Passport_ID_Mother' => 'required|unique:my__parents,Passport_ID_Mother,' . $this->Parent_id,
            'Phone_Mother' => 'required',
            'Job_Mother' => 'required',
            'Job_Mother_en' => 'required',
            'Nationality_Mother_id' => 'required',
            'Blood_Type_Mother_id' => 'required',
            'Religion_Mother_id' => 'required',
            'Address_Mother' => 'required',
        ]);
        $this->updateMode = true;
        $this->currentStep = 3;
    }

    public function submitForm_edit()
    {
        try {
            if ($this->Parent_id) {
                $parent = My_Parent::find($this->Parent_id);
                // Father_INPUTS
                $parent->Email = $this->email;
                $parent->Password = Hash::make($this->password);
                $parent->Name_Father = ['en' => $this->nameF_en, 'ar' => $this->nameF_ar];
                $parent->National_ID_Father = $this->National_ID_Father;
                $parent->Passport_ID_Father = $this->Passport_ID_Father;
                $parent->Phone_Father = $this->Phone_Father;
                $parent->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
                $parent->Passport_ID_Father = $this->Passport_ID_Father;
                $parent->Nationality_Father_id = $this->Nationality_Father_id;
                $parent->Blood_Type_Father_id = $this->Blood_Type_Father_id;
                $parent->Religion_Father_id = $this->Religion_Father_id;
                $parent->Address_Father = $this->Address_Father;

                // Mother_INPUTS
                $parent->Name_Mother = ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother];
                $parent->National_ID_Mother = $this->National_ID_Mother;
                $parent->Passport_ID_Mother = $this->Passport_ID_Mother;
                $parent->Phone_Mother = $this->Phone_Mother;
                $parent->Job_Mother = ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother];
                $parent->Passport_ID_Mother = $this->Passport_ID_Mother;
                $parent->Nationality_Mother_id = $this->Nationality_Mother_id;
                $parent->Blood_Type_Mother_id = $this->Blood_Type_Mother_id;
                $parent->Religion_Mother_id = $this->Religion_Mother_id;
                $parent->Address_Mother = $this->Address_Mother;
                $parent->save();

                if (!empty($this->photos)) {
                    foreach ($this->photos as $photo) {
                        $photo->storeAs($this->National_ID_Father, $photo->getClientOriginalName(), $disk = 'parent_attachments');
                        ParentAttachment::create([
                            'file_name' => $photo->getClientOriginalName(),
                            'parent_id' => My_Parent::latest()->first()->id,
                        ]);
                    }
                }
                $this->reset();
                $this->successMessage = trans('messages.success');
                $this->currentStep = 1;
                $this->showTable = true;
            }
        } catch (\Exception $e) {
            $this->catchError = $e->getMessage();
        }
    }

    public function delete($id)
    {
        My_Parent::findOrFail($id)->delete();
        return redirect()->route('parents.index');
    }

}
