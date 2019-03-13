@extends('layouts.main_layout')
@section('title', Helper::getProjectTitle($Prefix).Helper::languageTranslation('Edit Employee'))
@section('content')
<?php
    Helper::getPageTitleActionName('Edit Employee', $ClientSession->id);
?>
	<section class="content-header">
        <h1>{{Helper::languageTranslation('Manage Employee Pool')}}</h1>
        <ol class="breadcrumb">
            <li><a href="{{URL::to($Prefix.'/dashboard')}}"><i class="fa fa-tachometer-alt"></i> {{Helper::languageTranslation('Dashboard')}} </a></li>
            <li><a href="{{URL::to($Prefix.'/employee')}}">{{Helper::languageTranslation('Manage Employee Pool')}}</a></li>
            <li class="active"> {{Helper::languageTranslation('Edit Employee')}} </li>
        </ol>
    </section>
    <section class="content employee-section">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{Helper::languageTranslation('Edit Employee')}} </h3>
                    </div>
                    <form role="form"  accept-charset="UTF-8"  id="addEmployee" method="post" action="{{ url($Prefix.'/employee/edit/'.base64_encode($employee->id)) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="patch">
                        @include ('employee_pool.form')
                    </form>
                </div>             
            </div>
         </div>
    </section>
@endsection