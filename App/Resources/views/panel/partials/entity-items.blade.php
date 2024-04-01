@if($data['items']->total())
    @foreach($data['items'] as $item)
        <div class="item-block card">
            <div class="card-header">
                <span class="title">#{{$item->id}}: {{ $item->name }}</span>
            </div>
            <div class="card-body">
                @if($item->updated_at)
                    <span>@lang('admin::main.updated_at') {{$item->updated_at}}</span>
                @endif
                @if($item->updated_by)
                    <span>@lang('admin::main.updated_by') {{$item->updated_by}}</span>
                @endif
                <div class="badges">
                    @if($item->default)
                        <span class="badge badge-primary">@lang('admin::main.badges.default')</span>
                    @endif
                    @if($item->active)
                        <span class="badge badge-success">@lang('admin::main.badges.active')</span>
                    @else
                        <span class="badge badge-danger">@lang('admin::main.badges.inactive')</span>
                    @endif
                </div>
            </div>
            @include('admin::panel.partials.crud-operations')
        </div>
    @endforeach
@else
    <p class="title">@lang('admin::main.not_found')</p>
@endif
