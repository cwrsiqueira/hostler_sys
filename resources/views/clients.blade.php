@extends('adminlte::page')

@section('title', 'Hostler Sys | Clients')

@section('content_header')
    <div class="header">
        <h1>Clients</h1>
        <x-adminlte-button label="New Client" theme="primary" icon="fas fa-plus" data-toggle="modal" data-target="#modalCustom"/>
    </div>
@stop

@section('content')
    {{-- Setup data for datatables --}}
    @php
    $heads = [
        'ID',
        'Name',
        ['label' => 'Phone', 'width' => 40],
        ['label' => 'Actions', 'no-export' => true, 'width' => 5],
    ];

    $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                </button>';
    $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                </button>';
    $btnDetails = '<button class="btn btn-xs btn-default text-teal mx-1 shadow" title="Details">
                    <i class="fa fa-lg fa-fw fa-eye"></i>
                </button>';

    $config = [
        'data' => [
            [22, 'John Bender', '+02 (123) 123456789', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
            [19, 'Sophia Clemens', '+99 (987) 987654321', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
            [3, 'Peter Sousa', '+69 (555) 12367345243', '<nobr>'.$btnEdit.$btnDelete.$btnDetails.'</nobr>'],
        ],
        'order' => [[1, 'asc']],
        'columns' => [null, null, null, ['orderable' => false]],
    ];
    @endphp

    {{-- Minimal example / fill data using the component slot --}}
    <x-adminlte-datatable id="table1" :heads="$heads">
        @foreach($config['data'] as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{!! $cell !!}</td>
                @endforeach
            </tr>
        @endforeach
    </x-adminlte-datatable>

    {{-- Custom --}}
        <form action="{{ route('projects.create') }}" method="post">
            @csrf
            <x-adminlte-modal id="modalCustom" title="New Client" size="lg" theme="primary" icon="fas fa-plus" v-centered static-backdrop scrollable>
                    <div>
                        <div class="row">
                            <x-adminlte-input type="text" name="name" label="Name" placeholder="Enter Name" fgroup-class="col-md-6" disable-feedback/>
                            <x-adminlte-input type="text" name="company" label="Company" placeholder="Enter Company" fgroup-class="col-md-6" disable-feedback/>
                        </div>
                        <div class="row">
                            <x-adminlte-input type="text" name="phone" label="Phone" placeholder="Enter Phone" fgroup-class="col-md-6" disable-feedback error-key/>
                            <x-adminlte-input type="email" name="email" label="Email" placeholder="Enter Email" fgroup-class="col-md-6" disable-feedback/>
                        </div>
                    </div>
                    <x-slot name="footerSlot">
                        <x-adminlte-button type="submit" label="Save" theme="success" class="mr-auto" icon="fas fa-lg fa-save"/>
                        <x-adminlte-button theme="danger" label="Dismiss" data-dismiss="modal"/>
                    </x-slot>
            </x-adminlte-modal>
        </form>


@stop
