@extends('Layout.layout')

@section('title', 'Menus')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-list"></i> Menus
        </h1>
        <a href="{{ route('menu.create') }}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Add New</span>
        </a>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        @if(count($menus) > 0)
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                    <tr>
                                        @foreach($keys as $key)
                                            @if ($key !== 'id')
                                                <th>{{ ucfirst($key) }}</th>
                                            @endif
                                        @endforeach
                                        <th class="actions text-right">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($menus as $menu)
                                        <tr>
                                            @foreach($menu as $key => $data)
                                                @if ($key !== 'id')
                                                    <td>
                                                        {{ $data }}
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td class="no-sort no-click bread-actions">
                                                <a href="javascript:;" title="Delete" class="btn btn-sm btn-danger pull-right delete" data-id="{{$menu['id']}}" id="delete-{{$menu['id']}}">
                                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Delete</span>
                                                </a>
                                                <a href="{{ route('menu.edit', ['id' => $menu['id']]) }}" title="Edit" class="btn btn-sm btn-primary pull-right edit">
                                                    <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Edit</span>
                                                </a>
                                                <a href="{{ route('menu.items', ['menu' => $menu['id']]) }}" title="Edit" class="btn btn-sm btn-success pull-right">
                                                    <i class="voyager-list"></i> <span class="hidden-xs hidden-sm">Builder</span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    @include('Admin/Partial/single-delete')
@stop

@section('javascript')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#dataTable').DataTable( {
                "order": [],
                "columnDefs" : [{'targets' : [0, -1], 'searchable' :  false, 'orderable' : false }]
            });

            $('#search-input select').select2({
                minimumResultsForSearch: Infinity
            });

            $('.delete').on('click', function (e) {
                $('#delete_form')[0].action = '{{ route('menu.delete', '__id') }}'.replace('__id', $(this).data('id'));
                $('#delete_modal #record_for').text('Helper.php');
                $('#delete_modal').modal('show');
            });
        });
    </script>
@stop
