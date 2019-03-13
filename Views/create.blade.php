@extends('layouts.main_layout')
@section('title', Helper::getProjectTitle($Prefix).Helper::languageTranslation('Add Employee'))
@section('content')
<?php
    Helper::getPageTitleActionName('Add Employee', $ClientSession->id);
?>
<section class="content-header">
    <h1>
        {{Helper::languageTranslation('Manage Employee Pool')}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::to($Prefix.'/dashboard')}}"><i class="fa fa-tachometer-alt"></i> {{Helper::languageTranslation('Dashboard')}} </a></li>
        <li> <a href="{{URL::to($Prefix.'/employee')}}">{{Helper::languageTranslation('Manage Employee Pool')}}</a></li>
       <li class="active">{{Helper::languageTranslation('Add Employee')}}</li>
    </ol>
</section>
<section class="content staff-section employee-section">
    <div class="row add-staff">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{{Helper::languageTranslation('Add Employee')}} </h3>
                </div>
                <form role="form" id="addEmployee"  accept-charset="UTF-8"  method="POST" action="{{ url($Prefix.'/employee/create') }}">
                    {{ csrf_field() }}
                    @include ('employee_pool.form')
                </form>
            </div>
        </div>
    </div>
</section>    
@endsection