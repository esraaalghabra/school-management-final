@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <livewire:parents-livewire />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')

@stop

@section('title')
    {{trans('main_trans.List_Parents')}}
@stop

@section('page-header')
@stop

@section('PageTitle')
    {{trans('main_trans.List_Parents')}}
@stop
@section('js')
    @livewireScripts
@endsection
