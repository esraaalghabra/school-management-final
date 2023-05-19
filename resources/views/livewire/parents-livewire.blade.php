<div>
    @if (!empty($successMessage))
        <div class="alert alert-success" id="success-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{ $successMessage }}
        </div>
    @endif
    @if ($catchError)
        <div class="alert alert-danger" id="success-danger">
            <button type="button" class="close" data-dismiss="alert">x</button>
            {{ $catchError }}
        </div>
    @endif
    @if($showTable)
        <button class="btn btn-success btn-sm btn-lg pull-right" wire:click="hideTable"
                type="button">{{ trans('Parent_trans.add_parent') }}</button><br><br>
        <div class="table-responsive">
            <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                   style="text-align: center">
                <thead>
                <tr class="table-success">
                    <th>#</th>
                    <th>{{ trans('Parent_trans.Email') }}</th>
                    <th>{{ trans('Parent_trans.Name_Father') }}</th>
                    <th>{{ trans('Parent_trans.National_ID_Father') }}</th>
                    <th>{{ trans('Parent_trans.Passport_ID_Father') }}</th>
                    <th>{{ trans('Parent_trans.Phone_Father') }}</th>
                    <th>{{ trans('Parent_trans.Job_Father') }}</th>
                    <th>{{ trans('Parent_trans.Processes') }}</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                @foreach ($parents as $parent)
                    <tr>
                        <?php $i++; ?>
                        <td>{{ $i }}</td>
                        <td>{{ $parent->Email }}</td>
                        <td>{{ $parent->Name_Father }}</td>
                        <td>{{ $parent->National_ID_Father }}</td>
                        <td>{{ $parent->Passport_ID_Father }}</td>
                        <td>{{ $parent->Phone_Father }}</td>
                        <td>{{ $parent->Job_Father }}</td>
                        <td>
                            <button wire:click="editMode({{ $parent->id }})" title="{{ trans('Grades_trans.Edit') }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                            <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="delete({{ $parent->id }})"
                                    title="{{ trans('Grades_trans.Delete') }}"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <a href="#step-1" type="button"
                       class="btn btn-circle {{ $currentStep != 1 ? 'btn-default' : 'btn-success' }}">1</a>
                    <p>{{ trans('Parent_trans.Step1') }}</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-2" type="button"
                       class="btn btn-circle {{ $currentStep != 2 ? 'btn-default' : 'btn-success' }}">2</a>
                    <p>{{ trans('Parent_trans.Step2') }}</p>
                </div>
                <div class="stepwizard-step">
                    <a href="#step-3" type="button"
                       class="btn btn-circle {{ $currentStep != 3 ? 'btn-default' : 'btn-success' }}"
                       disabled="disabled">3</a>
                    <p>{{ trans('Parent_trans.Step3') }}</p>
                </div>
            </div>
        </div>

        <div class="col-xs-12" @if ($currentStep != 1) style="display: none" @endif>
            <div class="col-md-12"><br>
                <div class="form-row">
                    <div class="col">
                        <label for="title">{{trans('Parent_trans.Email')}}</label>
                        <input type="email" wire:model="email" class="form-control">
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="title">{{trans('Parent_trans.Password')}}</label>
                        <input type="password" wire:model="password" class="form-control">
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <label for="title">{{trans('Parent_trans.Name_Father')}}</label>
                        <input type="text" wire:model="nameF_ar" class="form-control">
                        @error('nameF_ar')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="title">{{trans('Parent_trans.Name_Father_en')}}</label>
                        <input type="text" wire:model="nameF_en" class="form-control">
                        @error('nameF_en')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <label for="title">{{trans('Parent_trans.Job_Father')}}</label>
                        <input type="text" wire:model="Job_Father" class="form-control">
                        @error('Job_Father')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="title">{{trans('Parent_trans.Job_Father_en')}}</label>
                        <input type="text" wire:model="Job_Father_en" class="form-control">
                        @error('Job_Father_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="title">{{trans('Parent_trans.National_ID_Father')}}</label>
                        <input type="number" wire:model="National_ID_Father" class="form-control">
                        @error('National_ID_Father')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="title">{{trans('Parent_trans.Passport_ID_Father')}}</label>
                        <input type="number" wire:model="Passport_ID_Father" class="form-control">
                        @error('Passport_ID_Father')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="title">{{trans('Parent_trans.Phone_Father')}}</label>
                        <input type="text" wire:model="Phone_Father" class="form-control">
                        @error('Phone_Father')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">{{trans('Parent_trans.Nationality_Father_id')}}</label>
                        <select class="custom-select my-1 mr-sm-2" wire:model="Nationality_Father_id">
                            <option selected>{{trans('Parent_trans.Choose')}}...</option>
                            @foreach($Nationalities as $National)
                                <option value="{{$National->id}}">{{$National->Name}}</option>
                            @endforeach
                        </select>
                        @error('Nationality_Father_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="inputState">{{trans('Parent_trans.Blood_Type_Father_id')}}</label>
                        <select class="custom-select my-1 mr-sm-2" wire:model="Blood_Type_Father_id">
                            <option selected>{{trans('Parent_trans.Choose')}}...</option>
                            @foreach($Type_Bloods as $Type_Blood)
                                <option value="{{$Type_Blood->id}}">{{$Type_Blood->Name}}</option>
                            @endforeach
                        </select>
                        @error('Blood_Type_Father_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="inputZip">{{trans('Parent_trans.Religion_Father_id')}}</label>
                        <select class="custom-select my-1 mr-sm-2" wire:model="Religion_Father_id">
                            <option selected>{{trans('Parent_trans.Choose')}}...</option>
                            @foreach($Religions as $Religion)
                                <option value="{{$Religion->id}}">{{$Religion->Name}}</option>
                            @endforeach
                        </select>
                        @error('Religion_Father_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">{{trans('Parent_trans.Address_Father')}}</label>
                    <textarea class="form-control" wire:model="Address_Father" id="exampleFormControlTextarea1"
                              rows="4"></textarea>
                    @error('Address_Father')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                @if($updateMode)
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" wire:click="firstStepSubmit_edit"
                            type="button">{{trans('Parent_trans.Next')}}
                    </button>
                @else
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" wire:click="firstStepSubmit"
                            type="button">{{trans('Parent_trans.Next')}}
                    </button>
                @endif
            </div>
        </div>

        <div class="col-xs-12" @if ($currentStep != 2) style="display: none" @endif>
            <div class="col-md-12"><br>
                <div class="form-row">
                    <div class="col">
                        <label for="title">{{trans('Parent_trans.Name_Mother')}}</label>
                        <input type="text" wire:model="Name_Mother" class="form-control">
                        @error('Name_Mother')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="title">{{trans('Parent_trans.Name_Mother_en')}}</label>
                        <input type="text" wire:model="Name_Mother_en" class="form-control">
                        @error('Name_Mother_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3">
                        <label for="title">{{trans('Parent_trans.Job_Mother')}}</label>
                        <input type="text" wire:model="Job_Mother" class="form-control">
                        @error('Job_Mother')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="title">{{trans('Parent_trans.Job_Mother_en')}}</label>
                        <input type="text" wire:model="Job_Mother_en" class="form-control">
                        @error('Job_Mother_en')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="title">{{trans('Parent_trans.National_ID_Mother')}}</label>
                        <input type="number" wire:model="National_ID_Mother" class="form-control">
                        @error('National_ID_Mother')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <label for="title">{{trans('Parent_trans.Passport_ID_Mother')}}</label>
                        <input type="number" wire:model="Passport_ID_Mother" class="form-control">
                        @error('Passport_ID_Mother')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col">
                        <label for="title">{{trans('Parent_trans.Phone_Mother')}}</label>
                        <input type="text" wire:model="Phone_Mother" class="form-control">
                        @error('Phone_Mother')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">{{trans('Parent_trans.Nationality_Father_id')}}</label>
                        <select class="custom-select my-1 mr-sm-2" wire:model="Nationality_Mother_id">
                            <option selected>{{trans('Parent_trans.Choose')}}...</option>
                            @foreach($Nationalities as $National)
                                <option value="{{$National->id}}">{{$National->Name}}</option>
                            @endforeach
                        </select>
                        @error('Nationality_Mother_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="inputState">{{trans('Parent_trans.Blood_Type_Father_id')}}</label>
                        <select class="custom-select my-1 mr-sm-2" wire:model="Blood_Type_Mother_id">
                            <option selected>{{trans('Parent_trans.Choose')}}...</option>
                            @foreach($Type_Bloods as $Type_Blood)
                                <option value="{{$Type_Blood->id}}">{{$Type_Blood->Name}}</option>
                            @endforeach
                        </select>
                        @error('Blood_Type_Mother_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col">
                        <label for="inputZip">{{trans('Parent_trans.Religion_Father_id')}}</label>
                        <select class="custom-select my-1 mr-sm-2" wire:model="Religion_Mother_id">
                            <option selected>{{trans('Parent_trans.Choose')}}...</option>
                            @foreach($Religions as $Religion)
                                <option value="{{$Religion->id}}">{{$Religion->Name}}</option>
                            @endforeach
                        </select>
                        @error('Religion_Mother_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">{{trans('Parent_trans.Address_Mother')}}</label>
                    <textarea class="form-control" wire:model="Address_Mother" id="exampleFormControlTextarea1"
                              rows="4"></textarea>
                    @error('Address_Mother')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-danger btn-sm nextBtn btn-lg pull-right" type="button" wire:click="back(1)">
                    {{trans('Parent_trans.Back')}}
                </button>
                @if($updateMode)
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" wire:click="secondStepSubmit_edit"
                            type="button">{{trans('Parent_trans.Next')}}
                    </button>
                @else
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="button"
                            wire:click="secondStepSubmit">{{trans('Parent_trans.Next')}}</button>
                @endif
            </div>
        </div>

        <div class="row setup-content {{ $currentStep != 3 ? 'displayNone' : '' }}" id="step-3">
            <div class="col-xs-12" @if ($currentStep != 3) style="display: none" @endif>
                <div class="col-md-12"><br>
                    <label style="color: red">{{trans('Parent_trans.Attachments')}}</label>
                    <div class="form-group">
                        <input type="file" wire:model="photos" accept="image/*" multiple>
                    </div>
                    <br>
                    <input type="hidden" wire:model="Parent_id">
                    <button class="btn btn-danger btn-sm nextBtn btn-lg pull-right" type="button"
                            wire:click="back(2)">{{ trans('Parent_trans.Back') }}</button>
                    @if($updateMode)
                        <button class="btn btn-success btn-sm nextBtn btn-lg pull-right"
                                wire:click="submitForm_edit"
                                type="button">{{trans('Parent_trans.Finish')}}
                        </button>
                    @else
                        <button class="btn btn-success btn-sm btn-lg pull-right" wire:click="submitForm"
                                type="button">{{ trans('Parent_trans.Finish') }}</button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
