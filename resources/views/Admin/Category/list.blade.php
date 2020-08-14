@extends('Layout.layout')

@section('title', 'Categories')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-categories"></i> Categories
        </h1>
        <a href="{{ route('category.create') }}" class="btn btn-success btn-add-new">
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
                        @if(count($categories) > 0)
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover" data-for="categories" data-delete-url="{{route('category.bulk.delete')}}">
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
                                    @foreach($categories as $category)
                                        <tr>
                                            @foreach($category as $key => $data)
                                                @if ($key === 'id')
                                                    <td>
                                                        <input type="checkbox" name="row_id" id="checkbox_{{ $data }}" value="{{ $data}}">
                                                    </td>
                                                @else
                                                    <td>
                                                        {{ $data }}
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td class="no-sort no-click bread-actions">
                                                <a href="javascript:;" title="Delete" class="btn btn-sm btn-danger pull-right delete" data-id="{{$category['id']}}" id="delete-{{$category['id']}}">
                                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Delete</span>
                                                </a>
                                                <a href="{{ route('category.edit', ['id' => $category['id']]) }}" title="Edit" class="btn btn-sm btn-primary pull-right edit">
                                                    <i class="voyager-edit"></i> <span class="hidden-xs hidden-sm">Edit</span>
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
                $('#delete_form')[0].action = '{{ route('category.delete', '__id') }}'.replace('__id', $(this).data('id'));
                $('#delete_modal #record_for').text('category');
                $('#delete_modal').modal('show');
            });
        });
    </script>
@stop
