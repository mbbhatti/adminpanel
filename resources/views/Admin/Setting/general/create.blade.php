<div class="panel" style="margin-top:10px;">
    <div class="panel-heading new-setting">
        <hr>
        <h3 class="panel-title"><i class="voyager-plus"></i> New Setting</h3>
    </div>
    <div class="panel-body">
        {{ Form::open([
            'url' => route('settings.create'),
            'method' => 'POST',
            'autocomplete' => 'off'
            ])
        }}
        {{ csrf_field() }}
        <input type="hidden" name="setting_tab" class="setting_tab" value="{{ $active }}" />
        <div class="col-md-3">
            {{ Form::label('display_name', 'Name') }}
            {{ Form::text('display_name', '', array('class' => 'form-control', 'placeholder' => 'Setting Name', 'required' => 'required')) }}
        </div>
        <div class="col-md-3">
            {{ Form::label('key', 'Key') }}
            {{ Form::text('key', '', array('class' => 'form-control', 'placeholder' => 'Setting Key', 'required' => 'required')) }}
        </div>
        <div class="col-md-3">
            {{ Form::label('type', 'Type') }}
            {{ Form::select('type', $types, '', array('class' => 'form-control group_select', 'required' => 'required')) }}
        </div>
        <div class="col-md-3">
            {{ Form::label('group', 'Group') }}
            {{ Form::select('group', $groups, '', array('class' => 'form-control group_select group_select_new', 'required' => 'required')) }}
        </div>
        <div style="clear:both"></div>
        <button type="submit" class="btn btn-primary pull-right new-setting-btn">
            <i class="voyager-plus"></i> Add New Setting
        </button>
        <div style="clear:both"></div>
        {{ Form::close() }}
    </div>
</div>
