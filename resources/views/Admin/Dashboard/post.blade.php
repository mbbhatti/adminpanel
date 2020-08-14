<div class="row">
    <?php $list = getPosts(); ?>
    @foreach($list as $post)
        <div class="col-sm-6 col-md-4">
            <div class="card card-post-min-height">
                <div class="card-header">{!! $post->title !!}</div>
                <div class="card-body">{!! Str::words($post->excerpt, 50, '') !!}</div>
            </div>
        </div>
    @endforeach
</div>
