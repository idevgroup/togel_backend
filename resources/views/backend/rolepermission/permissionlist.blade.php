@php $is_admin =($getRole->name == 'Admin')?'disabled':'';  @endphp
<table class="col-6 table table-bordered m-table">
    <thead>
        <tr>
            <th>{{ trans('labels.permission')}}</th>
            <th><label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable" id="perm-view" {{$is_admin}}> <span></span>
                        {{trans('labels.view')}} </label></th>
            <th><label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable" id="perm-add" {{$is_admin}}> <span></span>
                        {{trans('labels.add')}}</label></th>
                    <th><label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable" id="perm-edit" {{$is_admin}}> <span></span>
                        {{trans('labels.edit')}} </label></th>
                    <th><label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand m-checkbox--state-danger"> <input type="checkbox" value="" class="m-group-checkable" id="perm-delete" {{$is_admin}}> <span></span>
                        {{trans('labels.delete')}} </label></th>
        </tr>
    </thead>
    <tbody id="tbody-perm">
        
        @foreach($arrPermission as $perm => $subarr)
        <tr>
            @if($subarr->count() > 0)
            <td>{{$perm}}</td>
            @foreach($subarr as $key => $value)
            @php 
            $v = explode('_',$value);
            $arrPerm[$v[0]] = [$key,$value];  
            @endphp
            @endforeach
            <td>
                @if(isset($arrPerm['view']))
                @php($perm_found = $getRole->hasPermissionTo($arrPerm['view'][1]))
                <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                     {!! Form::checkbox("permissions[]", $arrPerm['view'][1], $perm_found,['class' => 'view-checkbox',$is_admin]) !!} 
                    <span></span>
                </label>
                @endif
            </td>
            <td>
                @if(isset($arrPerm['add']))
                @php($perm_found = $getRole->hasPermissionTo($arrPerm['add'][1]))
                <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                      {!! Form::checkbox("permissions[]", $arrPerm['add'][1], $perm_found,['class' => 'add-checkbox',$is_admin]) !!} 
                    <span></span>
                </label>
                @endif
            </td>
            <td>
                @if(isset($arrPerm['edit']))
                 @php($perm_found = $getRole->hasPermissionTo($arrPerm['edit'][1]))
                <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-success">
                     {!! Form::checkbox("permissions[]", $arrPerm['edit'][1], $perm_found,['class' => 'edit-checkbox',$is_admin]) !!} 
                    <span></span>
                </label>
                @endif
            </td>
            <td>
                @if(isset($arrPerm['delete']))
                 @php($perm_found = $getRole->hasPermissionTo($arrPerm['delete'][1]))
                <label class="m-checkbox m-checkbox--check-bold m-checkbox--state-danger">
                    {!! Form::checkbox("permissions[]", $arrPerm['delete'][1], $perm_found,['class' => 'delete-checkbox',$is_admin]) !!} 
                    <span></span>
                </label>
                @endif
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>