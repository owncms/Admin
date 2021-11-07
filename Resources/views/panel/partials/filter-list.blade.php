@if($filter_list = $data['filter_list'])
    @php
        $currUrl = urldecode(request()->fullUrl());
    @endphp
    @foreach($filter_list['data'] as $type => $filter)
        @php
            $url = $filter_list['urls'][$type];
        @endphp
        <a href="{{ $url != $currUrl ? $url : '#' }}"
           class="item-filter items-{{$type}} @if($url == $currUrl) active @endif">
            @lang('admin::filter_list.type.'.$type) <span
                class="badge badge-pill @if(isset($filter['badge']))badge-{{$filter['badge']}}@endif float-right">{{$filter['count']}}</span>
        </a>
    @endforeach
@endif
