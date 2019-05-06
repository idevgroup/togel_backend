
<span class="dropdown">
    <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-portlet__nav-link m-dropdown__toggle  btn-secondary m-btn--pill" data-toggle="dropdown" aria-expanded="true"> 
        <i class="la la-ellipsis-h"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a class="dropdown-item" href="{{ url(_ADMIN_PREFIX_URL)}}/{{ $entity }}/{{ $id }}/edit">
            <i class="la la-edit"></i> Edit</a>
        <a class="dropdown-item delete_action" data-id="{{ $id }}" href="javascript:void(0);">
            <i class="la la-times-circle"></i>Delete
        </a>
        <a class="dropdown-item move-action" href="javascript:void(0);">
            <i class="la la-trash-o"></i>Trash
        </a>
    </div>
</span>


