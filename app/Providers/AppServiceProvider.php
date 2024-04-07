<?php

namespace App\Providers;

use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // どのページを表示するにしても、ここを通過させて、共通化したい部品を描画させるようにする！
        View::composer("*", function ($view) {
            $user = \Auth::user();

            $memoModel = new Memo;
            $memos = $memoModel->myMemos(\Auth::id());
            $deleted_memos = $memoModel->myDeletedMemos(\Auth::id());;

            $tagModel = new Tag;
            $tags = $tagModel->where('user_id', \Auth::id())->get();

            $view->with('user', $user)
                ->with('memos', $memos)
                ->with('tags', $tags)
                ->with('deleted_memos', $deleted_memos);
        });
    }
}
