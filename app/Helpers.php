<?php

namespace App;

use App\Models\Image;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class Helpers
{
    public $status_button = [
        'active' => 'bg-green-400 text-gray-100 hover:bg-green-500 focus:ring-offset-green-100 focus:ring-green-500 border-green-300',
        'approved' => 'bg-blue-400 text-gray-100 hover:bg-blue-500 focus:ring-offset-blue-100 focus:ring-blue-500 border-blue-300',
        'blocked' => 'bg-black text-gray-200 hover:text-gray-100 focus:ring-offset-black focus:ring-black border-black',
        'canceled' => 'bg-rose-400 text-gray-100 hover:bg-rose-500 focus:ring-offset-rose-100 focus:ring-rose-500 border-rose-300',
        'completed' => 'bg-green-400 text-gray-100 hover:bg-green-500 focus:ring-offset-green-100 focus:ring-green-500 border-green-300',
        'in' => 'bg-green-400 text-gray-100 hover:bg-green-500 focus:ring-offset-green-100 focus:ring-green-500 border-green-300',
        'inactive' => 'bg-rose-400 text-gray-100 hover:bg-rose-500 focus:ring-offset-rose-100 focus:ring-rose-500 border-rose-300',
        'out' => 'bg-rose-400 text-gray-100 hover:bg-rose-500 focus:ring-offset-rose-100 focus:ring-rose-500 border-rose-300',
        'pending' => 'bg-yellow-400 text-gray-800 hover:bg-yellow-500 focus:ring-offset-yellow-100 focus:ring-yellow-500 border-yellow-300',
        'processing' => 'bg-blue-400 text-gray-100 hover:bg-blue-500 focus:ring-offset-blue-100 focus:ring-blue-500 border-blue-300',
        'received' => 'bg-green-400 text-gray-100 hover:bg-green-500 focus:ring-offset-green-100 focus:ring-green-500 border-green-300',
        'suspended' => 'bg-rose-400 text-gray-100 hover:bg-rose-500 focus:ring-offset-rose-100 focus:ring-rose-500 border-rose-300',
        'unworkable' => 'bg-rose-400 text-gray-100 hover:bg-rose-500 focus:ring-offset-rose-100 focus:ring-rose-500 border-rose-300',
        'workable' => 'bg-green-400 text-gray-100 hover:bg-green-500 focus:ring-offset-green-100 focus:ring-green-500 border-green-300',
    ];

    public $status_label = [
        'active' => 'bg-green-100 hover:bg-green-200 text-green-700',
        'approved' => 'bg-blue-100 hover:bg-blue-200 text-blue-700',
        'blocked' => 'bg-gray-100 hover:bg-gray-200 text-gray-700',
        'canceled' => 'bg-rose-100 hover:bg-rose-200 text-rose-700',
        'completed' => 'bg-green-100 hover:bg-green-200 text-green-700',
        'in' => 'bg-green-100 hover:bg-green-200 text-green-700',
        'inactive' => 'bg-rose-100 hover:bg-rose-200 text-rose-700',
        'out' => 'bg-rose-100 hover:bg-rose-200 text-rose-700',
        'pending' => 'bg-yellow-100 hover:bg-yellow-200 text-yellow-700',
        'processing' => 'bg-blue-100 hover:bg-blue-200 text-blue-700',
        'received' => 'bg-green-100 hover:bg-green-200 text-green-700',
        'suspended' => 'bg-rose-100 hover:bg-rose-200 text-rose-700',
        'unworkable' => 'bg-rose-100 hover:bg-rose-200 text-rose-700',
        'workable' => 'bg-green-100 hover:bg-green-200 text-green-700',
    ];

    public static function greeting()
    {
        $hours = date('H');

        $greeting = $hours < '12' ? 'Good Morning' : '';
        $greeting .= $hours >= '12' && $hours < '15' ? 'Good Moon' : '';
        $greeting .= $hours >= '15' && $hours < '17' ? 'Good Afternoon' : '';
        $greeting .= $hours >= '17' && $hours < '19' ? 'Good Evening' : '';
        $greeting .= $hours >= '19' ? 'Good Night' : '';

        return $greeting;
    }

    public static function navigation()
    {
        $navigation = [];

        $navigation = array_map(function ($nav) {
            return array_map(function ($box) {
                if (isset($box['items'])) {
                    $box['items'] = array_map(function ($item) {
                        $item = array_merge($item, ['current' => request()->route()->named($item['valid'])]);

                        return $item;
                    }, $box['items']);
                } else {
                    $box = array_merge($box, ['current' => request()->route()->named($box['valid'])]);
                }

                return $box;
            }, $nav);
        }, config('menu'));

        return $navigation;
    }

    public static function isRouteValid($route_ref = null)
    {
        $user = Auth::guard('web')->user();

        if ($user->is_admin || strtolower(request()->method()) == 'get') {
            return true;
        }

        $valid_routes = [
            'dashboard',
            'profile.*',
            'load.*',
        ];

        if ($user->status == 'active' && ! empty($user->role?->permissions)) {
            $permissions = json_decode($user->role?->permissions, true);

            foreach (config('permission') as $name => $items) {
                foreach ($items as $item => $route) {
                    if (isset($permissions[$name]) && isset($permissions[$name][$item]) && $permissions[$name][$item] == 'on') {
                        if (is_array($route)) {
                            $route = array_values($route);
                            $valid_routes = array_merge($valid_routes, $route);
                        } else {
                            $valid_routes[] = $route;
                        }
                    }
                }
            }
        }

        if (empty($route_ref)) {
            $route_ref = request()->route()->getName();
        }

        return in_array($route_ref, $valid_routes);
    }

    // public static function getRouteSlugs()
    // {
    //     $slugs  = [];
    //     $routes = Route::getRoutes();

    //     foreach ($routes as $route) {
    //         $slugs[] = explode('/', $route->uri())[0];
    //     }

    //     return array_unique($slugs);
    // }

    // public static function urlValidity($slug, $user_id)
    // {
    //     $routes = static::getRouteSlugs();

    //     if (!preg_match('/^[a-z0-9.]+$/i', $slug)) {
    //         return [
    //             'status' => false,
    //             'message' => __('Invalid characters.')
    //         ];
    //     }
    //     if (strlen($slug) <= 4) {
    //         return [
    //             'status' => false,
    //             'message' => __('Must be greater or equal to 5 characters.')
    //         ];
    //     }
    //     if (in_array($slug, $routes)) {
    //         return [
    //             'status' => false,
    //             'message' => __('Invalid name.')
    //         ];
    //     }
    //     if (User::where('slug', $slug)->where('id', '!=', $user_id)->first()) {
    //         return [
    //             'status' => false,
    //             'message' => __('already exists.')
    //         ];
    //     }
    //     return [
    //         'status' => true,
    //     ];
    // }

    // public static function generateSlug($name)
    // {
    //     $slug = Str::slug($name);
    //     while (User::where('slug', $slug)->first()) {
    //         $slug = Str::slug($name . ' ' . Str::random(3));
    //     }
    //     return $slug;
    // }

    public static function imageUpload($request, $extended_name, $object)
    {
        $relative_path = 'images';
        $relative_thumbnail = 'thumbnails/'.$relative_path;

        Storage::makeDirectory($relative_path);
        Storage::makeDirectory($relative_thumbnail);

        $original_path = Storage::path($relative_path);
        $original_thumbnail = Storage::path($relative_thumbnail);

        if ($request->photo_file) {
            if ($request->hasFile('photo_file')) {
                if ($request->file('photo_file')->isValid()) {
                    $extension = $request->photo_file->extension();
                    $file_name = $object->id.'-'.$object->name.$extended_name.$extension;
                    $image_path = $request->photo_file->storeAs($relative_path, $file_name, 'public');

                    $thumbnail_file_path = $original_thumbnail.'/'.$file_name;

                    $manager = new ImageManager(config('image.driver'));
                    $image_mng = $manager->make(Storage::path($image_path));
                    $image_mng->scale(width: 134);
                    $image_mng->toPng()->save($thumbnail_file_path);

                    $image = new Image(['path' => $image_path]);

                    if (! ($object->images()->save($image))) {
                        return back()->with('success', Str::of($extended_name)->replace('-', ' ')->ucfirst().' updating failed!.');
                    }
                }
            }
        } else {
            if ($object->latest_image && $request->photo_removed) {
                foreach ($object->images as $image) {
                    if (Storage::exists($image->path)) {
                        unlink(Storage::path($image->path));
                    }
                    if (Storage::exists('thumbnails/'.$image->path)) {
                        unlink(Storage::path('thumbnails/'.$image->path));
                    }
                    $image->delete();
                }
            }
        }
    }

    public static function getSettingValueOf($item, $isPlural = false)
    {
        $settings = Setting::pluck('value', 'name')->toArray();

        return $isPlural ? Str::plural($settings[$item]) : $settings[$item];
    }

    public static function getStatusObject($model)
    {
        $statuses = $model->statuses ?? [];

        foreach (self::$status_button as $status => $class) {
            if (! in_array($status, $statuses)) {
                unset(self::$status_button[$status]);
            }
        }

        $class = self::$status_button[$model->status];
        unset(self::$status_button[$model->status]);

        return [
            'status' => ucfirst($model->status),
            'class' => $class,
            'options' => self::$status_button,
        ];
    }

    public static function toAmount($number, $format = 'bn')
    {
        // if($format != 'bn') {
        //     return number_format($number, 2);
        // }
        // $number = self::numberFormat($number, 2);
        // return $number;

        return number_format($number, 2);
    }

    public static function toNumber($unfiltered_number)
    {
        return filter_var($unfiltered_number, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    public static function toQuantity($number)
    {
        return substr(self::toAmount($number), 0, -3);
    }

    public static function asText($text)
    {
        return ucwords(str_replace('_', '-', str_replace('-', ' ', $text)));
    }

    public static function asValue($text)
    {
        return strtolower(str_replace(' ', '-', str_replace('-', '_', $text)));
    }

    public static function asValueRev($text)
    {
        return str_replace('_', '-', str_replace('-', ' ', $text));
    }

    public static function toWords($main_price)
    {
        $string = '';
        $price = intval($main_price);
        $length = strlen((string) $price);

        if ($length > 7) {
            $string .= intval($price / 10000000) > 0 ? self::numberToWords(intval($price / 10000000)).' '.__('Crore').' ' : '';
            $price = $price % 10000000;

            $length = strlen((string) $price);
            $price = floatval($price);
        }

        if ($length > 5) {
            $string .= intval($price / 100000) > 0 ? self::numberToWords(intval($price / 100000)).' '.__('Lac').' ' : '';
            $price = $price % 100000;

            $length = strlen((string) $price);
            $price = floatval($price);
        }

        if ($length > 3) {
            $string .= intval($price / 1000) > 0 ? self::numberToWords(intval($price / 1000)).' '.__('Thousand').' ' : '';
            $price = $price % 1000;
        }

        if ($length > 2) {
            $string .= intval($price / 100) > 0 ? self::numberToWords(intval($price / 100)).' '.__('Hundred').' ' : '';
            $price = $price % 100;
        }

        $string .= self::numberToWords($price);
        $string .= ' Taka ';

        $amount = explode('.', $main_price);
        if (count($amount) > 1 && floatval($amount[1]) > 0) {
            $string .= ' & ';
            $string .= self::numberToWords($amount[1]);
            $string .= ' Paisa ';
        }

        $string .= ' Only';

        return trim($string);
    }

    public static function numberToWords($price)
    {
        $ones = [0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen'];
        $tens = [0 => '', 1 => '', 2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty', 6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety'];

        $string = '';
        $value = floatval($price);
        if ($value > 19) {
            $string .= $value / 10 > 1 ? $tens[intval($value / 10)].' ' : '';
            $value = $value % 10;
        } else {
            $string .= $value / 10 > 0 ? $ones[intval($value / 1)].' ' : '';
            $value = $value > 0 ? $value % $value : 0;
        }
        $string .= $ones[intval($value / 1)];

        return $string;
    }
}
