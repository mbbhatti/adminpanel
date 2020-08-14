<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 text-white bg-primary">
            <div class="card-body">
                <div class="text-value">{{ $users }}</div>
                <div>Registered users</div>
                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $users }}%" aria-valuenow="{{ $users }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">Try to make more users.</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 text-white bg-success">
            <div class="card-body">
                <div class="text-value">{{ $posts }}</div>
                <div>Posts</div>
                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $posts }}%" aria-valuenow="{{ $posts }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">Great! Don't stop.</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 text-white bg-warning">
            <div class="card-body">
                <div class="text-value">{{ $categories }}</div>
                <div>Categories</div>
                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $categories }}%" aria-valuenow="{{ $categories }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">Add more categories.</small>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 text-white bg-dark">
            <div class="card-body">
                <div class="text-value">{{ $products }}</div>
                <div>Products.</div>
                <div class="progress progress-white progress-xs my-2">
                    <div class="progress-bar" role="progressbar" style="width: {{ $products }}%" aria-valuenow="{{ $products }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <small class="text-muted">Need to increase your products.</small>
            </div>
        </div>
    </div>
</div>
