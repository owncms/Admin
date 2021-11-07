@extends('admin::layouts.default')
@section('admin::main')
    <div class="page-content__top">
        <div class="container-fluid page-content__top-content">
            <div class="page-content__top-details">
                <a href="{{ build_crud_route('index') }}" class="return-back"><i
                        class="fas fa-long-arrow-alt-left"></i> Roles</a>
                @if(isset($item) && $item->id)
                    <h2 class="font-weight-bold">#{{ $item->id }} {{ $item->name }}</h2>
                @else
                    <h2>@module_lang('title.type.' . get_current_method())</h2>
                @endif
            </div>
            <div class="page-content__top-buttons d-flex">
                @if(isset($edit) && $edit == 1)
                    <button type="submit" class="btn btn--delete" form="roleForm">@lang('admin::main.delete')</button>
                    <button type="submit" class="btn btn--edit" form="roleForm">@lang('admin::main.update')</button>
                @elseif(!isset($item))
                    <button type="submit" class="btn btn--create" form="roleForm">@lang('admin::main.save')</button>
                @else
                    <a class="btn btn--edit" href="{{ build_crud_route('edit', $item) }}">@lang('admin::main.edit')</a>
                @endif
            </div>
        </div>
    </div>
    <div class="page-content__container">
        <div class="container-fluid">
            <div class="card card-custom">
                <div class="card-header card-tabs">
                    <div class="card-title card-columns">
                        <div class="card-description h-100">
                            <ul class="nav nav-pills h-100" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-general-tab" data-toggle="pill" href="#general"
                                       role="tab"
                                       aria-controls="pills-general" aria-selected="true">General</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-abilities-tab" data-toggle="pill" href="#abilities"
                                       role="tab"
                                       aria-controls="pills-abilities" aria-selected="false">Abilities</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(\Session::has('success'))
                        <div class="alert alert-success">
                            <p>{!! \Session::get('success') !!}</p>
                        </div>
                    @endif
                    <div class="container-fluid">
                        {!! form_start($form, ['id' => 'roleForm']) !!}
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="general" role="tabpanel"
                                 aria-labelledby="pills-general-tab">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        {!! form_row($form->name) !!}
                                        {!! form_row($form->title) !!}

                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="abilities" role="tabpanel"
                                 aria-labelledby="pills-general-tab">
                                <div class="row text-center">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">Index</div>
                                    <div class="col-md-2">Create</div>
                                    <div class="col-md-2">Show</div>
                                    <div class="col-md-2">Update</div>
                                    <div class="col-md-2">Delete</div>
                                </div>
                                @foreach($modules as $moduleName => $module)
                                    <div class="row mt-2">
                                        <div class="col-md-12 title">{{ $moduleName }}</div>
                                    </div>
                                    @foreach($module as $namespace => $data)
                                        <div class="row text-center mb-1">
                                            <div class="col-md-2 text-left"><span
                                                    class="pl-3">{{ ucfirst(str_plural($data['translation'])) }}</span>
                                            </div>
                                            @foreach($data['crud'] as $option => $status)
                                                <div class="col-md-2">
                                                    {{Form::hidden("abilities[" .$data['model'] ."][$option]", 0)}}
                                                    {{ Form::checkbox("abilities[" .$data['model'] ."][$option]", 1, $status, ((isset($edit) && $edit == 0) ? ['disabled'] : [])) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        {!! form_end($form, false) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
