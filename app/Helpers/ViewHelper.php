<?php
/**
 * Get application setting value by keys
 *
 * @param string   $key  To find specific property value
 * @return string
 */
if (!function_exists('setting')) {
    function setting(string $key): string
    {
        $setting =  App\Setting::where('key', $key)->first();

        return $setting->value;
    }
}

/**
 * Get filename only
 *
 * @param string $name
 * @return string
 */
if (!function_exists('get_file_name')) {
    function get_file_name(string $name): string
    {
        preg_match('/(_)([0-9])+$/', $name, $matches);
        if (count($matches) == 3) {
            return Illuminate\Support\Str::replaceLast($matches[0], '', $name).'_'.(intval($matches[2]) + 1);
        } else {
            return $name.'_1';
        }
    }
}

/**
 * Get user count
 *
 * @return int
 */
if (!function_exists('getTotalUsers')) {
    function getTotalUsers(): int
    {
        return App\User::count();
    }
}

/**
 * Get post count
 *
 * @return int
 */
if (!function_exists('getTotalPost')) {
    function getTotalPost(): int
    {
        return App\Post::count();
    }
}

/**
 * Get category count
 *
 * @return int
 */
if (!function_exists('getTotalCategories')) {
    function getTotalCategories(): int
    {
        return App\Category::count();
    }
}

/**
 * Get product count
 *
 * @return int
 */
if (!function_exists('getTotalProducts')) {
    function getTotalProducts(): int
    {
        return App\Product::count();
    }
}

/**
 * Get last three posts only
 *
 * @return object
 */
if (!function_exists('getPosts')) {
    function getPosts(): object
    {
        return App\Post::select('title', 'excerpt')
            ->orderBy('id', 'DESC')
            ->offset(0)
            ->limit(3)
            ->get();
    }
}

/**
 * Get last six month products
 *
 * @return array
 */
if (!function_exists('getSixMonthProducts')) {
    function getSixMonthProducts(): array
    {
        $products = App\Product::selectRaw(
            'COUNT(*) AS total, 
            MONTHNAME(created_at) as month,
            DATE_FORMAT(created_At,"%Y-%m-%d") AS date'
        )
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->offset(0)
            ->limit(6)
            ->get();

        $response = [];
        $counts = '';
        $months = '';
        foreach ($products as $product) {
            $counts .= $product->total . ',';
            $months .= "'" . $product->month . "',";
        }

        $response['counts'] = substr($counts, 0, -1);
        $response['months'] = substr($months, 0, -1);

        return $response;
    }
}

/**
 * Mail setting by admin panel
 */
if (!function_exists('emailSetting')) {
    function emailSetting()
    {
        // Update environment variable
        putenv("MAIL_FROM_ADDRESS=admin@hungry.com");
        putenv('MAIL_FROM_NAME=admin');

        // Update mail configuration
        config(['mail.mailers.smtp.host' => setting('mail.server')]);
        config(['mail.mailers.smtp.port' => setting('mail.port')]);
        config(['mail.mailers.smtp.username' => setting('mail.login')]);
        config(['mail.mailers.smtp.password' => setting('mail.password')]);
    }
}

/**
 * Get latest users
 *
 * @return array
 */
if (!function_exists('getLatestUsers')) {
    function getLatestUsers(): array
    {
        $userRepository = new App\Repositories\UserRepository();
        $users = $userRepository->getLatestUsers();
        $list = [];
        foreach ($users as $user) {
            $date = date('Y-m-d', strtotime($user['date']));
            if ($date === date('Y-m-d', strtotime("today"))) {
                $date = 'Today';
            } elseif ($date === date('Y-m-d',strtotime("yesterday"))) {
                $date = 'Yesterday';
            } else {
                $date = date('j M, Y',strtotime($user['date']));
            }

            $user['date'] = $date;
            $list[] = $user;
        }

        return $list;
    }
}

/**
 * Find user latitude and longitude
 *
 * @return array
 */
if (!function_exists('getUserLatLng')) {
    function getUserLatLng(): array
    {
        // Find user ip address
        if (!empty($_SERVER['HTTP_CLIENT_IP']))  { //whether ip is from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //whether ip is from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else { //whether ip is from remote address
            $ip = $_SERVER['REMOTE_ADDR'];
            if($ip === '127.0.0.1' || $ip === 'localhost') {
                //$ip = getHostByName(getHostName());
                $ip = '88.130.56.199';
            }
        }

        // Get Lat and Lng based on user ip address
        $urlTemplate = 'https://api.ip2location.com/v2/?' . 'ip=%s&key=demo' . '&package=WS24&format=json';
        $urlToCall = sprintf( $urlTemplate, $ip); // replace the "%s" with real IP address
        $rawJson = file_get_contents( $urlToCall );

        return json_decode( $rawJson, true );
    }
}

/**
 * Get user location
 *
 * @return false|string
 */
if (!function_exists('getAllUserLatLng')) {
    function getAllUserLatLng()
    {
        $userPlaceRepository = new App\Repositories\UserPlaceRepository();
        $users = $userPlaceRepository->getAll();
        $markers = [];
        foreach ($users as $user) {
            $markers[] = ['latLng' => [$user['latitude'], $user['longitude']], 'name' => $user['name']];
        }

        return json_encode($markers);
    }
}

