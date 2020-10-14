<?php

namespace App\Http\Controllers;

use App\NewsLabel;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use TCG\Voyager\Models\MenuItem;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        View::share('topmenu', MenuItem::where('menu_id', 2)->orderBy('order', 'asc')->get());
        $top_labels = NewsLabel::select('label_id')->whereDate('created_at','>=', Carbon::now()->subDays(2))->with('label')->groupBy('label_id')->orderBy(\DB::raw('count(label_id)'), 'DESC')->take(10)->get();
        View::share('toplabels', $top_labels);
        $badges = [
            'badge-primary', 'badge-secondary', 'badge-success', 'badge-danger','badge-warning', 'badge-info','badge-light','badge-dark'
        ];
        View::share('badges', $badges);
    }

}
