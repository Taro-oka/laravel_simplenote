<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;
use App\Models\Tag;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('create');
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        // dd($data);

        $existing_tag = Tag::where('user_id', '=', $data['user_id'])
            ->where('name', '=', $data['tag'])
            ->first();

        $tag_id = "";
        if (empty($existing_tag)) {
            $tag_id = Tag::insertGetId([
                'user_id' => $data['user_id'],
                'name' => $data['tag'],
            ]);
        } else {
            $tag_id = $existing_tag['id'];
        }

        $memo_id = Memo::insertGetId([
            'content' => $data['content'],
            'user_id' => $data['user_id'],
            'tag_id' => $tag_id,
            'status' => 1
        ]);

        // リダイレクト処理
        return redirect()->route('home');
    }

    public function edit($id)
    {
        $memo = Memo::where('user_id', '=', \Auth::id())
            ->where('id', '=', $id)
            ->where('status', '=', 1)
            ->first();
        return view('edit', compact('memo'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        // dd($data);
        $content = $request['content'];
        $tag_id = $request['tag_id'];
        Memo::where('id', '=', $id)->update(['content' => $content, 'tag_id' => $tag_id]);
        return redirect()->route('home');
    }

    public function delete(Request $request, $id)
    {
        // $data = $request->all();
        // dd($data);
        Memo::where('id', '=', $id)->update(['status' => 2]);
        return redirect()->route('home')->with('success', '削除が完了しました。');
    }
}
