@extends('adminlte::page')

@section('title', 'Hostler Sys | Clients')

@section('content_header')

    <div class="header">
        <h1>Clients</h1>
        <x-adminlte-button label="New Client" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalClient"/>
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
        'Captação',
        'Name',
        'Company',
        'Email',
        'Phone',
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];

    function btnEdit($id) {
        return '<button class="btn btn-xs text-primary mx-1" title="Edit" id="edit_client" data-toggle="modal" data-target="#modalClient'.$id.'" data-id="'.$id.'">
                    <i class="fa fa-lg fa-fw fa-cogs"></i>
                </button>';
    }

    $config = ['data'=>[]];
    foreach ($clients as $key => $client) {
        $config['data'][$key][] = $client->id;
        $config['data'][$key][] = $client->captation;
        $config['data'][$key][] = $client->name;
        $config['data'][$key][] = $client->company;
        $config['data'][$key][] = $client->email;
        $config['data'][$key][] = $client->phone;
        $config['data'][$key][] = '<nobr>'.btnEdit($client->id).'</nobr>';
    }
    $config['order'] = [[2, 'asc']];
    $config['columns'] = [null, null, null, null, null, null, ['orderable' => false]];
    @endphp

    {{-- Table --}}
    <x-adminlte-datatable id="table2" :heads="$heads" :config="$config" hoverable bordered compressed with-buttons/>

    {{-- Add / Form Modal --}}
    <form action="{{ route('clients.store') }}" method="post">
        @csrf
        <x-adminlte-modal id="modalClient" title="New Client" size="lg" theme="primary" icon="fas fa-plus" v-centered static-backdrop scrollable>
            <div>
                <div class="row">
                    <x-adminlte-input type="text" name="name" label="Name" placeholder="Enter Name" fgroup-class="col-md-12" enable-old-support autofocus/>
                </div>
                <div class="row">
                    <x-adminlte-input type="text" name="captation" label="Captation" placeholder="Enter Captation" fgroup-class="col-md-6" enable-old-support/>
                    <x-adminlte-input type="text" name="company" label="Company" placeholder="Enter Company" fgroup-class="col-md-6" enable-old-support/>
                </div>
                <div class="row">
                    <x-adminlte-input type="text" name="phone" label="Phone" placeholder="Enter Phone" fgroup-class="col-md-6" enable-old-support/>
                    <x-adminlte-input type="email" name="email" label="Email" placeholder="Enter Email" fgroup-class="col-md-6" enable-old-support/>
                </div>
            </div>
            <x-slot name="footerSlot">
                <x-adminlte-button type="submit" label="Save" theme="success" class="mr-auto" icon="fas fa-lg fa-save"/>
                <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal"/>
            </x-slot>
        </x-adminlte-modal>
    </form>

    @foreach ($clients as $client)
        {{-- Edit Modal --}}
        <form action="{{ route('clients.update', ['id'=>$client->id]) }}" method="post">
            @method('PUT')
            @csrf
            <x-adminlte-modal id="modalClient{{$client->id}}" title="Edit Client" size="lg" theme="primary" icon="fas fa-edit" v-centered static-backdrop scrollable>
                <div>
                    <div class="row">
                        <x-adminlte-input type="text" name="name" value="{{$client->name}}" label="Name" placeholder="Enter Name" fgroup-class="col-md-12" error-key="false"/>
                    </div>
                    <div class="row">
                        <x-adminlte-input type="text" name="captation" value="{{$client->captation}}" label="Captation" placeholder="Enter Captation" fgroup-class="col-md-6" error-key="false"/>
                        <x-adminlte-input type="text" name="company" value="{{$client->company}}" label="Company" placeholder="Enter Company" fgroup-class="col-md-6" error-key="false"/>
                    </div>
                    <div class="row">
                        <x-adminlte-input type="text" name="phone" value="{{$client->phone}}" label="Phone" placeholder="Enter Phone" fgroup-class="col-md-6" error-key="false"/>
                        <x-adminlte-input type="email" name="email" value="{{$client->email}}" label="Email" placeholder="Enter Email" fgroup-class="col-md-6" error-key="false"/>
                    </div>
                </div>
                <x-slot name="footerSlot" class="d-flex justify-content-between">
                    <x-adminlte-button type="submit" label="Save" theme="success" class="mr-auto btn-save" icon="fas fa-lg fa-save"/>
                    <x-adminlte-button theme="danger" label="Dismiss" class="btn-dismiss" data-dismiss="modal"/>

        </form>
                    <form action="{{ route('clients.delete', ['id'=>$client->id]) }}" method="post" class="btn-delete d-flex justify-content-end">
                        @method('DELETE')
                        @csrf
                        <button onclick="return confirm('Watch out!!! Are you sure you want to delete this client permanently?');" class="btn btn-xs btn-default text-danger mx-1 p-2 shadow" title="Delete"><i class="fa fa-lg fa-fw fa-trash" style="font-size:24px;"></i></button>
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
