<div class="col-sm-4 col-lg-4">
    <div class="card card-min-height">
        <div class="card-header">
            Latest Users
        </div>
        <div class="card-body" style="padding: 5px;">
            <?php
            $userList = getLatestUsers();
            ?>
            <ul class="users-list clearfix">
                @foreach($userList as $user)
                    <li>
                        <img src="{{ ($user['avatar'] !== null) ?
                                        Storage::disk(config('storage.disk'))->url($user['avatar']) :
                                        Storage::disk(config('storage.disk'))->url('users/default.png') }}" alt="User Image">
                        <a class="users-list-name" href="{{ route('user.view', ['id' => $user['id']]) }}">{{ $user['name'] }}</a>
                        <span class="users-list-date">{{ $user['date'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer">
            <a href="{{ route('users') }}" class="uppercase">View All Users</a>
        </div>
    </div>
</div>
