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