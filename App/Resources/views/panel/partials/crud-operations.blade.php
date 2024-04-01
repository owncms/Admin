<div class="item-block-operations">
    @can('show', $item)
        <a href="{{ build_crud_route('show', $item->id) }}" class="show"><i class="fas fa-eye"></i></a>
    @endcan
    @can('edit', $item)
        <a href="{{ build_crud_route('edit', $item->id) }}" class="edit"><i class="fas fa-edit"></i></a>
    @endcan
    @can('delete', $item)
        <a href="{{ build_crud_route('destroy', $item->id) }}" class="remove"><i class="fas fa-trash-alt"></i></a>
    @endcan
</div>
