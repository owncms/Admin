@if($group->shouldShowHeading())
{{--    <span class="module-title">{{ $group->getName() }}</span>--}}
    @foreach($items as $item)
        {!! $item !!}
    @endforeach
@endif

