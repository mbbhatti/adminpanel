@extends('Layout.layout')

@section('title', 'Users')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-person"></i> Users
        </h1>
        <a href="{{ route('user.create') }}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>Add New</span>
        </a>
        @include('Admin/Partial/bulk-delete')
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
                        @if(count($users) > 0)
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover" data-for="users" data-delete-url="{{route('user.bulk.delete')}}">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="select_all">
                                        </th>
                                        @foreach($keys as $key)
                                            @if ($key !== 'id')
                                                <th>{{ $key }}</th>
                                            @endif
                                        @endforeach
                                        <th class="actions text-right">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            @foreach($user as $key => $data)
                                                @if ($key === 'id')
                                                    <td>
                                                        <input type="checkbox" name="row_id" id="checkbox_{{ $data }}" value="{{ $data}}">
                                                    </td>
                                                @elseif ($key === 'Avatar')
                                                    <td>
                                                        <img src="{{ ($data !== null) ? Storage::disk(config('storage.disk'))->url($data) : Storage::disk(config('storage.disk'))->url('users/default.png') }}" style="width:50px">
                                                    </td>
                                                @elseif ($key === 'Role')
                                                    <td>
                                                        {{ ($data !== null) ? $data : 'No Role' }}
                                                    </td>
                                                @else
                                                    <td>
                                                        {{ $data }}
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td class="no-sort no-click bread-actions">
                                                @if (Auth::user()->id !== $user['id'])
                                                <a href="javascript:;" title="Delete" class="btn btn-sm btn-danger pull-right delete" data-id="{{$user['id']}}" id="delete-{{$user['id']}}">
                                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Delete</span>
                                                </a>
                                                @endif
                                                <a href="{{ route('user.edit', ['id' => $user['id']]) }}" title="Edit" class="btn btn-sm btn-primary pull-right edit">
                                                    <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Edit</span>
                                                </a>
                                                <a href="{{ route('user.view', ['id' => $user['id']]) }}" title="View" class="btn btn-sm btn-warning pull-right view">
                                                    <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">View</span>
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

            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });

            $('.delete').on('click', function (e) {
                $('#delete_form')[0].action = '{{ route('user.delete', '__id') }}'.replace('__id', $(this).data('id'));
                $('#delete_modal #record_for').text('user');
                $('#delete_modal').modal('show');
            });
        });
    </script>
@stop
