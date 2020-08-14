@extends('Layout.layout')

@section('title', 'Products')

@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-news"></i> Products
        </h1>
        <a href="{{ route('product.create') }}" class="btn btn-success btn-add-new">
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
                        @if(count($products) > 0)
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-hover" data-for="products" data-delete-url="{{route('product.bulk.delete')}}">
                                    <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="select_all">
                                        </th>
                                        @foreach($keys as $key)
                                            @if ($key !== 'id')
                                                <th>{{ ucfirst($key) }}</th>
                                            @endif
                                        @endforeach
                                        <th class="actions text-right">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            @foreach($product as $key => $data)
                                                @if ($key === 'id')
                                                    <td>
                                                        <input type="checkbox" name="row_id" id="checkbox_{{ $data }}" value="{{ $data}}">
                                                    </td>
                                                @elseif ($key === 'image')
                                                    <td>
                                                        <img src="{{ ($data !== null) ? Storage::disk(config('storage.disk'))->url($data) : asset('posts/voyager-character.png') }}" style="width:50px">
                                                    </td>
                                                @else
                                                    <td>
                                                        {{ $data }}
                                                    </td>
                                                @endif
                                            @endforeach
                                            <td class="no-sort no-click bread-actions">
                                                <a href="javascript:;" title="Delete" class="btn btn-sm btn-danger pull-right delete" data-id="{{$product['id']}}" id="delete-{{$product['id']}}">
                                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Delete</span>
                                                </a>
                                                <a href="{{ route('product.edit', ['id' => $product['id']]) }}" title="Edit" class="btn btn-sm btn-primary pull-right edit">
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
                $('#delete_form')[0].action = '{{ route('product.delete', '__id') }}'.replace('__id', $(this).data('id'));
                $('#delete_modal #record_for').text('product');
                $('#delete_modal').modal('show');
            });
        });
    </script>
@stop
