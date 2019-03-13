@extends('layouts.main_layout')
@section('title', Helper::getProjectTitle($Prefix).Helper::languageTranslation('Manage Employee Pool'))
@section('content')
<?php
Helper::getPageTitleActionName('Manage Employee Pool', $ClientSession->id);
?>
<section class="content-header">
    <h1>
        {{Helper::languageTranslation('Manage Employee Pool')}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{URL::to($Prefix.'/dashboard')}}""><i class="fa fa-tachometer-alt"></i> {{Helper::languageTranslation('Dashboard')}} </a></li>
        <li class="active">{{Helper::languageTranslation('Manage Employee Pool')}}</li>
    </ol>
</section>
<section id="participantsContent" class="content employee-section units-section employee-unit-sectn pulse-unit-sectn">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <input type="hidden" name="action" value="/employee">
                <div class="box-header with-border employe-pool-cntnt">
                    <h3 class="box-title">
                        <span>{{Helper::languageTranslation('Employee Pool')}}  </span>
                        <a href="{{ url($Prefix.'/employee/create') }}" class="btn btn-primary add-client-btn">+{{Helper::languageTranslation('Add Employee')}}</a>
                        <?php
                        if (empty($ClientSession->usertype)) {
                            ?>
                            <a href="{{ url($Prefix.'/employee/excel') }}" class="btn btn-primary add-client-btn">
                                <i class="fa fa-upload"></i> {{Helper::languageTranslation('Edit Bulk Employees')}}
                            </a>                                                 
                            <?php
                        }
                        ?>
                    </h3>
                    <div class="inner-search-box">
                        <div class="input-group">
                            <form id="searchForm" method="GET" action="javascript:void(0);" accept-charset="UTF-8" role="search">
                                <input type="text" class="form-control input-md" name="search" placeholder="{{Helper::languageTranslation('Search')}} " value="{{ request('search') }}" autocomplete="off">
                                <input type="hidden" name="_token" value="{{csrf_token()}}"   />
                                <input type="hidden" name="type" id="type" value=""   />
                                <input type="hidden" name="custom_unit_id" id="customUnitId" value=""   />
                                <span class="input-group-btn">
                                    <button class="btn btn-info btn-md searchButton" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="action" value="/employee-pool"/>
                @include('elements.message')                
                <div class="grid-list-view-box">
                    <div class="grid-list-view">
                        <a id="tableView" class="view-change-btn active" href='javascript:void(0);' title="{{Helper::languageTranslation('Table View')}}"><i class="fas fa-align-justify"></i></a>
                        <a id="gridView" class="view-change-btn" href='javascript:void(0);' title="{{Helper::languageTranslation('Grid View')}}"><i class="fas fa-th"></i></a>
                    </div>
                </div>
                <div class="box-body manage-doc-list employee-pool-structure"  >
                    <div  id="dynamicContent" class="table-view">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>@sortablelink('firstname',Helper::languageTranslation('Name'),['_token'=>csrf_token(),'page'=>Request::get('page')],['class'=>'sortable'])</th>
                                        <th>@sortablelink('email',Helper::languageTranslation('Email'),['_token'=>csrf_token(),'page'=>Request::get('page')],['class'=>'sortable'])</th>
                                        <th>@sortablelink('phone_number',Helper::languageTranslation('Phone Number'),['_token'=>csrf_token(),'page'=>Request::get('page')],['class'=>'sortable'])</th>
                                        <th>{{Helper::languageTranslation('Action') }}<i aria-hidden="true"></i></th>
                                    </tr>   
                                </thead>
                                <tbody>
                                    @if(count($employees))
                                    @foreach($employees as $value)
                                    <tr>
                                        <td>{{ $value->firstname.' '.$value->lastname }}</td>
                                        <td>{{ $value->email }}</td>


                                        <td>{{ $value->phone_number }}
                                        <td>
                                            <a title="Edit" href="{{ url($Prefix.'/employee/edit',['id'=>$value->id]) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <?php
                                            $statusText = !empty($value->status) ? 'Deactivate' : 'Activate';
                                            $icon = !empty($value->status) ? 'fa fa-unlock' : 'fa fa-lock';
                                            ?>
                                            <a href="{{ url($Prefix.'/employee/status/'.$value->id) }}" title="<?php echo $statusText; ?>"><i class="<?php echo $icon; ?>"></i> </a>
                                            <a href="javascript:void(0);" data-attr-id="{{ $value->id }}" class="deleteRecord" title="Delete"><i onclick="return conf('Are you sure want to delete this Employee?', <?php echo $value->id; ?>)" class="fa fa-trash deleteStaff" aria-hidden="true"></i></a>
                                            <form id="deleteRec_{{ $value->id }}"  method="POST" action="{{ url($Prefix.'/employee/delete' . '/' . $value->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button  style="display: none;" type="submit " class="btn btn-danger btn-sm " title="Delete Client">{{Helper::languageTranslation('Delete') }}</button> 
                                            </form>
                                        </td>    
                                    </tr> 
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" class="text-center">{{Helper::languageTranslation('No employees found.') }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <?php
                        $direction = 'desc';
                        $sort = 'id';
                        if (Request::get('direction') and ! empty(Request::get('direction'))) {
                            $direction = Request::get('direction');
                            $sort = Request::get('sort');
                        }
                        ?>
                        <ul class="pagination">
                            {!! $employees->appends(['search' => Request::get('search'),'sort'=>$sort,'direction'=>$direction,'page'=>Request::get('page'),'_token'=>csrf_token()])->render() !!}
                        </ul>
                    </div>                   
                </div>
            </div>
        </div>
    </div>
    @include('units.employee_popup')
</section>
@endsection
