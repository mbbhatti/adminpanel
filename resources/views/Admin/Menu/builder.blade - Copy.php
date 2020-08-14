@extends('Layout.layout')

@section('title', 'Menu Builder')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-list"></i>Menu Builder ({{ $menu->name }})
        <div class="btn btn-success add_item"><i class="voyager-plus"></i> New Menu Item</div>
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


    <div class="modal modal-info fade" tabindex="-1" id="menu_item_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 id="m_hd_add" class="modal-title hidden"><i class="voyager-plus"></i> Create a New Menu Item</h4>
                    <h4 id="m_hd_edit" class="modal-title hidden"><i class="voyager-edit"></i> Edit Menu Item</h4>
                </div>
                <form action="" id="m_form" method="POST"
                      data-action-add="{{ route('menu.item.create', ['menu' => $menu->id]) }}"
                      data-action-update="{{ route('menu.item.edit', ['menu' => $menu->id, 'id' => $id ?? 0]) }}">

                    <input id="m_form_method" type="hidden" name="_method" value="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div>
                            <label for="name">Title</label>
                            <input type="text" class="form-control" id="m_title" name="title" placeholder="Title"><br>
                        </div>
                        <label for="type">Link Type</label>
                        <select id="m_link_type" class="form-control" name="type">
                            <option value="url" selected="selected">Static Url</option>
                            <option value="route">Dynamic Route</option>
                        </select><br>
                        <div id="m_url_type">
                            <label for="url">Url</label>
                            <input type="text" class="form-control" id="m_url" name="url" placeholder="Url"><br>
                        </div>
                        <div id="m_route_type">
                            <label for="route">Route</label>
                            <input type="text" class="form-control" id="m_route" name="route" placeholder="Route">
                        </div>
                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                        <input type="hidden" name="id" id="m_id" value="">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-success pull-right delete-confirm__" value="Update">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
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
             * Set Variables
             */
            let $m_modal       = $('#menu_item_modal'),
                $m_hd_add      = $('#m_hd_add').hide().removeClass('hidden'),
                $m_hd_edit     = $('#m_hd_edit').hide().removeClass('hidden'),
                $m_form        = $('#m_form'),
                $m_form_method = $('#m_form_method'),
                $m_title       = $('#m_title'),
                $m_url_type    = $('#m_url_type'),
                $m_url         = $('#m_url'),
                $m_link_type   = $('#m_link_type'),
                $m_route_type  = $('#m_route_type'),
                $m_route       = $('#m_route'),
                $m_id          = $('#m_id');

            /**
             * Add Menu
             */
            $('.add_item').click(function() {
                $m_form.trigger('reset');
                $m_form.find("input[type=submit]").val('Add');
                $m_modal.modal('show', {data: null});
            });

            /**
             * Edit Menu
             */
            $('.item_actions').on('click', '.edit', function (e) {
                $m_form.find("input[type=submit]").val('Update');
                $m_modal.modal('show', {data: $(e.currentTarget)});
            });

            /**
             * Menu Modal is Open
             */
            $m_modal.on('show.bs.modal', function(e, data) {
                let _adding = e.relatedTarget.data ? false : true;

                if (_adding) {
                    $m_form.attr('action', $m_form.data('action-add'));
                    $m_form_method.val('POST');
                    $m_hd_add.show();
                    $m_hd_edit.hide();
                    $m_link_type.val('url').change();
                    $m_url.val('');

                } else {
                    $m_form.attr('action', $m_form.data('action-update'));
                    $m_form_method.val('PUT');
                    $m_hd_add.hide();
                    $m_hd_edit.show();

                    var _src = e.relatedTarget.data, // the source
                        id   = _src.data('id');

                    $m_title.val(_src.data('title'));
                    $m_url.val(_src.data('url'));
                    $m_route.val(_src.data('route'));
                    $m_id.val(id);

                    if (_src.data('route') != "") {
                        $m_link_type.val('route').change();
                        $m_url_type.hide();
                    } else {
                        $m_link_type.val('url').change();
                        $m_route_type.hide();
                    }
                    if ($m_link_type.val() == 'route') {
                        $m_url_type.hide();
                        $m_route_type.show();
                    } else {
                        $m_route_type.hide();
                        $m_url_type.show();
                    }
                }
            });


            /**
             * Toggle Form Menu Type
             */
            $m_link_type.on('change', function (e) {
                if ($m_link_type.val() == 'route') {
                    $m_url_type.hide();
                    $m_route_type.show();
                } else {
                    $m_url_type.show();
                    $m_route_type.hide();
                }
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
