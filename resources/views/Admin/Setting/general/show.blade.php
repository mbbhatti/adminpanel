@extends('Layout.layout')

@section('title', 'General Settings')

@section('css')
    <link href="{{ asset('assets/css/setting.css') }}" rel="stylesheet" type="text/css">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-settings"></i> General Settings
    </h1>
@stop

@section('content')
    @include('Admin/Partial/alerts')
    <div class="container-fluid">
        <div class="alert alert-info">
            <strong>How To Use::</strong>
            You can get the value of each setting anywhere on your site by calling
            <code>setting('site.key')</code>
        </div>
    </div>

    <div class="page-content settings container-fluid">
        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
            {{ method_field("PUT") }}
            {{ csrf_field() }}
            <input type="hidden" name="setting_tab" class="setting_tab" value="{{ $active }}" />
            <div class="panel">

                <div class="page-content settings container-fluid">
                    <ul class="nav nav-tabs">
                        @foreach($settings as $group => $setting)
                            <li @if($group == $active) class="active" @endif>
                                <a data-toggle="tab" href="#{{ \Illuminate\Support\Str::slug($group) }}">{{ $group }}</a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($settings as $group => $group_settings)
                            <div id="{{ \Illuminate\Support\Str::slug($group) }}" class="tab-pane fade in @if($group == $active) active @endif">
                                @foreach($group_settings as $setting)
                                    <div class="panel-heading">
                                        <h3 class="panel-title">
                                            {{ $setting->display_name }} <code>setting('{{ $setting->key }}')</code>
                                        </h3>
                                        <div class="panel-actions">
                                            <a href="{{ route('settings.move.up', $setting->id) }}">
                                                <i class="sort-icons voyager-sort-asc"></i>
                                            </a>
                                            <a href="{{ route('settings.move.down', $setting->id) }}">
                                                <i class="sort-icons voyager-sort-desc"></i>
                                            </a>
                                                <i class="voyager-trash"
                                                   data-id="{{ $setting->id }}"
                                                   data-display-key="{{ $setting->key }}"
                                                   data-display-name="{{ $setting->display_name }}">
                                                </i>
                                        </div>
                                    </div>

                                    <div class="panel-body no-padding-left-right">
                                        <div class="col-md-10 no-padding-left-right">
                                            @if ($setting->type == "text")
                                                <input type="text" class="form-control" name="{{ $setting->key }}" value="{{ $setting->value }}">
                                            @elseif($setting->type == "text_area")
                                                <textarea class="form-control" name="{{ $setting->key }}">{{ $setting->value ?? '' }}</textarea>
                                            @elseif($setting->type == "rich_text_box")
                                                <textarea class="form-control richTextBox" name="{{ $setting->key }}">{{ $setting->value ?? '' }}</textarea>
                                            @elseif($setting->type == "code_editor")
                                                <?php $options = json_decode($setting->details); ?>
                                                <div id="{{ $setting->key }}" data-theme="{{ @$options->theme }}" data-language="{{ @$options->language }}" class="ace_editor min_height_400" name="{{ $setting->key }}">{{ $setting->value ?? '' }}</div>
                                                <textarea name="{{ $setting->key }}" id="{{ $setting->key }}_textarea" class="hidden">{{ $setting->value ?? '' }}</textarea>
                                            @elseif($setting->type == "image" || $setting->type == "file")
                                                @if(isset( $setting->value ) && !empty( $setting->value ) && Storage::disk(config('storage.disk'))->exists($setting->value))
                                                    <div class="img_settings_container">
                                                        <a href="{{ route('settings.delete.value', $setting->id) }}" class="voyager-x delete_value"></a>
                                                        <img src="{{ Storage::disk(config('storage.disk'))->url($setting->value) }}" style="width:200px; height:auto; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                                    </div>
                                                    <div class="clearfix"></div>
                                                @elseif($setting->type == "file" && isset( $setting->value ))
                                                    @if(json_decode($setting->value) !== null)
                                                        @foreach(json_decode($setting->value) as $file)
                                                            <div class="fileType">
                                                                <a class="fileType" target="_blank" href="{{ Storage::disk(config('storage.disk'))->url($file->download_link) }}">
                                                                    {{ $file->original_name }}
                                                                </a>
                                                                <a href="{{ route('settings.delete.value', $setting->id) }}" class="voyager-x delete_value"></a>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                @endif
                                                <input type="file" name="{{ $setting->key }}">
                                            @elseif($setting->type == "select_dropdown")
                                                <?php $options = json_decode($setting->details); ?>
                                                <?php $selected_value = (isset($setting->value) && !empty($setting->value)) ? $setting->value : NULL; ?>
                                                <select class="form-control" name="{{ $setting->key }}">
                                                    <?php $default = (isset($options->default)) ? $options->default : NULL; ?>
                                                    @if(isset($options->options))
                                                        @foreach($options->options as $index => $option)
                                                            <option value="{{ $index }}" @if($default == $index && $selected_value === NULL) selected="selected" @endif @if($selected_value == $index) selected="selected" @endif>{{ $option }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            @elseif($setting->type == "radio_btn")
                                                <?php $options = json_decode($setting->details); ?>
                                                <?php $selected_value = (isset($setting->value) && !empty($setting->value)) ? $setting->value : NULL; ?>
                                                <?php $default = (isset($options->default)) ? $options->default : NULL; ?>
                                                <ul class="radio">
                                                    @if(isset($options->options))
                                                        @foreach($options->options as $index => $option)
                                                            <li>
                                                                <input type="radio" id="option-{{ $index }}" name="{{ $setting->key }}"
                                                                       value="{{ $index }}" @if($default == $index && $selected_value === NULL) checked @endif @if($selected_value == $index) checked @endif>
                                                                <label for="option-{{ $index }}">{{ $option }}</label>
                                                                <div class="check"></div>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            @elseif($setting->type == "checkbox")
                                                <?php $options = json_decode($setting->details); ?>
                                                <?php $checked = (isset($setting->value) && $setting->value == 1) ? true : false; ?>
                                                @if (isset($options->on) && isset($options->off))
                                                    <input type="checkbox" name="{{ $setting->key }}" class="toggleswitch" @if($checked) checked @endif data-on="{{ $options->on }}" data-off="{{ $options->off }}">
                                                @else
                                                    <input type="checkbox" name="{{ $setting->key }}" @if($checked) checked @endif class="toggleswitch">
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-md-2 no-padding-left-right">
                                            <select class="form-control group_select" name="{{ $setting->key }}_group">
                                                @foreach($groups as $group)
                                                    <option value="{{ $group }}" {!! $setting->group == $group ? 'selected' : '' !!}>{{ $group }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if(!$loop->last)
                                        <hr>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-primary pull-right">Save</button>
        </form>

        <div style="clear:both"></div>

        {{-- Create setting modal --}}
        @include('Admin.Setting.general.create')

    </div>

    {{-- Single delete modal --}}
    @include('Admin.Setting.general.delete')

    {{-- Tinymce content image upload --}}
    @include('Admin.Partial.upload', ['slug' => 'settings'])

@stop

@section('javascript')
    <script src="{{ asset('assets/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/tinymce_config.js') }}"></script>
    <script src="{{ asset('assets/js/setting.js') }}"></script>
    <script type="text/javascript">
        $('document').ready(function () {
            $('.panel-actions .voyager-trash').click(function () {
                let display = $(this).data('display-name') + '/' + $(this).data('display-key');

                $('#delete_setting_title').text(display);

                $('#delete_form')[0].action = '{{ route('settings.delete', [ 'id' => '__id' ]) }}'.replace('__id', $(this).data('id'));
                $('#delete_modal').modal('show');
            });
        });
    </script>
@stop
