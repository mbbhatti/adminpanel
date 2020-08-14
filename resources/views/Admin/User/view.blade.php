@extends('Layout.layout')

@section('title', 'View User')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-person"></i> Viewing User &nbsp;

        <a href="{{ route('user.edit', ['id' => $id]) }}" class="btn btn-info">
            <span class="glyphicon glyphicon-pencil"></span>&nbsp;Edit
        </a>
        @if (Auth::user()->id !== $id)
        <a href="javascript:;" title="Delete" class="btn btn-danger delete" data-id="{{$id}}" id="delete-{{$id}}">
            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Delete</span>
        </a>
        @endif

        <a href="{{ route('users') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;Return to List
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    @foreach($users as $key => $data)
                        @if ($key !== 'id')
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">{{ $key }}</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                @if ($key === 'Avatar')
                                    <img class="img-responsive" src="{{ ($data !== null) ? Storage::disk(config('storage.disk'))->url($data) : Storage::disk(config('storage.disk'))->url('users/default.png') }}" style="width: 50px;">
                                @else
                                    <p>{{ $data }}</p>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    @include('Admin/Partial/single-delete')
@stop

@section('javascript')
    <script type="text/javascript">
        $('.delete').on('click', function (e) {
            $('#delete_form')[0].action = '{{ route('user.delete', '__id') }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });
    </script>
@stop
