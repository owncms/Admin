@extends('admin::layouts.default')
@section('admin::main')
    <div class="page-content__top">
        <div class="container-fluid page-content__top-content">
            <div class="page-content__top-details">
                <a href="{{ build_crud_route('index') }}" class="return-back"><i
                        class="fas fa-long-arrow-alt-left"></i> Admins</a>
                @if($item->id)
                    <h2 class="font-weight-bold">{{ $item->name }}, {{ $item->email }}</h2>
                    <span>Rank: {{ $item->getRoles()->first() }}</span>
                @else
                    <h2>@module_lang('title.type.' . get_current_method())</h2>
                @endif
            </div>
            <div class="page-content__top-buttons d-flex">
                @if(isset($edit) && $edit == 1)
                    <button type="submit" class="btn btn--delete" form="adminForm">@lang('admin::main.delete')</button>
                    <button type="submit" class="btn btn--edit" form="adminForm">@lang('admin::main.update')</button>
                @elseif(!$item->id)
                    <button type="submit" class="btn btn--create" form="adminForm">@lang('admin::main.save')</button>
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
                    {!! form_start($form, ['id' => 'adminForm']) !!}
                    <div class="container-fluid">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="general" role="tabpanel"
                                 aria-labelledby="pills-general-tab">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        {!! form_row($form->name) !!}
                                        {!! form_row($form->last_name) !!}
                                        {!! form_row($form->login) !!}
                                        {!! form_row($form->email) !!}
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        {!! form_row($form->role_id) !!}
                                        {!! form_row($form->password) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! form_end($form, false) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
