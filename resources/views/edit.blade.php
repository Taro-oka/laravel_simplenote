@extends('layouts.app')

@section('content')
    <div class="card h-100">
        <div class="card-header d-flex justify-content-between">
            メモ編集
            <form method="POST" action="/delete/{{ $memo['id'] }}" id="delete-form">
                @csrf
                <button><i id="delete-button" class="fas fa-trash"></i></button>
            </form>
        </div>
        <div class="card-body">
            <form method='POST' action="{{  route('update', ['id'=>$memo['id']]) }}">
                @csrf
                <input type='hidden' name='user_id' value="{{ $user['id'] }}">
                <div class="form-group">
                     <textarea name='content' class="form-control mb-3" rows="10">{{ $memo['content'] }}</textarea>
                </div>
                <div class="form-group mb-3">
                    <select name="tag_id" id="tag_id" class="form-control">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag['id'] }}" {{ $tag['id'] === $memo['tag_id'] ? 'selected' : "" }}>
                                {{ $tag['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type='submit' class="btn btn-primary btn-lg">更新</button>
            </form>
        </div>
    </div>
@endsection