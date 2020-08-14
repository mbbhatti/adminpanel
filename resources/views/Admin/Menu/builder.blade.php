@extends('Layout.layout')

@section('title', 'Menu Builder')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list"></i>Menu Builder ({{ $menu->name }})
        <a href="{{ route('menu.item.create', ['menu' => $menu->id]) }}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>New Menu Item</span>
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-heading">
                        <p class="panel-title" style="color:#777">Reorder menu items</p>
                    </div>

                    @if(!empty($child))
                        <div class="panel-body" style="padding:30px;">
                            <div class="dd">
                                <ol class="dd-list">
                                    {!! $child !!}
                                </ol>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Are you sure you want to delete this menu item?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field("DELETE") }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="Yes, Delete this menu item!">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dd').nestable({
                expandBtnHTML: '',
                collapseBtnHTML: ''
            });

            /**
             * Edit Menu
             */
            $('.edit').on('click', function (e) {
                let id = $(e.currentTarget).data('id');
                window.location.href = '{{ route('menu.item.edit', ['menu' => $menu->id, 'id' => '__id']) }}'.replace('__id', id);
            });

            /**
             * Delete menu item
             */
            $('.item_actions').on('click', '.delete', function (e) {
                let id = $(e.currentTarget).data('id');
                $('#delete_form')[0].action = '{{ route('menu.item.delete', ['menu' => $menu->id, 'id' => '__id']) }}'.replace('__id', id);
                $('#delete_modal').modal('show');
            });


            /**
             * Reorder items
             */
            $('.dd').on('change', function (e) {
                $.post('{{ route('menu.items.order',['menu' => $menu->id]) }}', {
                    order: JSON.stringify($('.dd').nestable('serialize')),
                    _token: '{{ csrf_token() }}'
                }, function (data) {
                    toastr.success("Order updated successfully");
                });
            });
        });
    </script>
@stop
