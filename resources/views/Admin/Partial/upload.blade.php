<iframe id="form_target" name="form_target" style="display:none"></iframe>
<form id="my_form" action="{{ route('upload') }}" target="form_target" method="POST" enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
    {{ csrf_field() }}
    <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
    <input type="hidden" name="type_slug" id="type_slug" value="{{ $slug }}">
</form>
