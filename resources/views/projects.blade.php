@extends('adminlte::page')

@section('title', 'Hostler Sys | Projects')

@section('content_header')

    <div class="header">
        <h1>Projects</h1>
        <x-adminlte-button label="New Project" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalProject"/>
    </div>

    @if ($errors->any())
        <hr>
        <x-adminlte-alert theme="danger" title="Error" dismissable>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-adminlte-alert>
    @endif

    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(session($msg))
            <hr>
            <div class="alert alert-{{ $msg }}" role="alert">
                @switch($msg)
                    @case('danger')
                        <i class="icon fas fa-ban"></i>
                        Error!!!
                        @break
                    @case('warning')
                        <i class="fas fa-exclamation-triangle"></i>
                        Atention!!!
                        @break
                    @case('success')
                        <i class="fas fa-thumbs-up"></i>
                        Success!!!
                        @break
                    @case('info')
                        <i class="fas fa-info-circle"></i>
                        Information!!!
                        @break
                    @default
                @endswitch
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {!! session($msg) !!}
            </div>
        @endif
    @endforeach
@stop

@section('content')
    {{-- Setup data for datatables --}}
    @php
    $heads = [
        'ID',
        'Name',
        'Created at',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];

    function btnEdit($id) {
        return '<button class="btn btn-xs text-primary mx-1" title="Edit" id="edit_project" data-toggle="modal" data-target="#modalProject'.$id.'" data-id="'.$id.'">
                    <i class="fa fa-lg fa-fw fa-cogs"></i>
                </button>';
    }

    $config = ['data'=>[]];
    foreach ($projects as $key => $project) {
        $config['data'][$key][] = $project->id;
        $config['data'][$key][] = $project->name;
        $config['data'][$key][] = date('Y-m-d', strtotime($project->created_at));
        $config['data'][$key][] = '<nobr>'.btnEdit($project->id).'</nobr>';
    }
    $config['order'] = [[0, 'asc']];
    $config['columns'] = [null, null, null, ['orderable' => false]];
    @endphp

    {{-- Table --}}
    <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" hoverable bordered compressed with-buttons/>

    {{-- Add / Form Modal --}}
    <form action="{{ route('projects.store') }}" method="post">
        @csrf
        <x-adminlte-modal id="modalProject" title="New Project" size="lg" theme="primary" icon="fas fa-plus" v-centered static-backdrop scrollable>
            <div>
                <div class="row">
                    <x-adminlte-input type="text" name="name" label="Name" placeholder="Enter Name" fgroup-class="col-md-9" enable-old-support autofocus/>
                    <x-adminlte-input type="date" name="created_at" label="Created At" value="{{date('Y-m-d')}}" placeholder="Enter Created At" fgroup-class="col-md-3" enable-old-support autofocus/>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button type="submit" label="Save" theme="success" class="mr-auto" icon="fas fa-lg fa-save"/>
                <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal"/>
            </x-slot>
        </x-adminlte-modal>
    </form>

    @foreach ($projects as $project)
        {{-- Edit Modal --}}
        <form action="{{ route('projects.update', ['id'=>$project->id]) }}" method="post">
            @method('PUT')
            @csrf
            <x-adminlte-modal id="modalProject{{$project->id}}" title="Edit Project" size="lg" theme="primary" icon="fas fa-edit" v-centered static-backdrop scrollable>
                <div>
                    <div class="row">
                        <x-adminlte-input type="text" name="name" value="{{$project->name}}" label="Name" placeholder="Enter Name" fgroup-class="col-md-9" error-key="false"/>
                        <x-adminlte-input type="date" name="created_at" value="{{date('Y-m-d', strtotime($project->created_at))}}" label="Created At" placeholder="Enter Created At" fgroup-class="col-md-3" error-key="false"/>
                    </div>
                </div>
                <x-slot name="footerSlot" class="d-flex justify-content-between">
                    <x-adminlte-button type="submit" label="Save" theme="success" class="mr-auto btn-save" icon="fas fa-lg fa-save"/>
                    <x-adminlte-button theme="danger" label="Dismiss" class="btn-dismiss" data-dismiss="modal"/>

        </form>
                    <form action="{{ route('projects.delete', ['id'=>$project->id]) }}" method="post" class="btn-delete d-flex justify-content-end">
                        @method('DELETE')
                        @csrf
                        <button onclick="return confirm('Watch out!!! Are you sure you want to delete this Project permanently?');" class="btn btn-xs btn-default text-danger mx-1 p-2 shadow" title="Delete"><i class="fa fa-lg fa-fw fa-trash" style="font-size:24px;"></i></button>
                    </form>
                </x-slot>
            </x-adminlte-modal>
    @endforeach

@stop

@section('css')
        <style>
            .dataTables_filter {
                text-align: right;
            }
            .dataTables_filter label {
                text-align: left;
            }
            ul.pagination {
                justify-content: right;
            }
            .btn-delete {
                flex: 2;
            }
            td:last-child {
                text-align: center;
            }
        </style>
@endsection

@section('js')
        <script>

        </script>
@endsection
