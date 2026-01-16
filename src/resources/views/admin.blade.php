@extends('layouts.app_admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <div class="admin__content">
        <div class="admin__heading">
            <h2>Admin</h2>
        </div>

        <form class="search-form" action="/search" method="get">
            @csrf
            <input class="search-form__item-input" type="text" name="keyword" value="{{ request('keyword') }}"
                placeholder="名前やメールアドレスを入力してください">

            <select class="search-form__item-gender" name="gender">
                <option value="">性別</option>
                <option value="all" {{ request('gender') == 'all' ? 'selected' : '' }}>全て</option>
                <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
            </select>

            <select class="search-form__item-category" name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach ($categories as $category)
                    <option value="{{ $category['id'] }}" {{ request('category_id') == $category['id'] ? 'selected' : '' }}>
                        {{ $category['content'] }}</option>
                @endforeach
            </select>

            <input class="search-form__date" type="date" name="updated_at"
                value="{{ request('updated_at') }}">

            <button class="search-form__button" type="submit">検索</button>

            <a href="/admin" class="reset__button">リセット</a>
        </form>

        <div class="table__nav">
            <div class="export button">
                <a href="{{ url('/export') }}?{{ http_build_query(request()->query()) }}" class="export-button-link">
                    エクスポート
                </a>
            </div>
            <div class="pagination">
                {{ $contacts->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>

        <div class="contact-table">
            <table class="contact-table__inner">
                <tr class="contact-table__row">
                    <th>お名前</th>
                    <th>性別</th>
                    <th>メールアドレス</th>
                    <th>お問い合わせの種類</th>
                    <th></th>
                </tr>
                @foreach ($contacts as $contact)
                    <tr class="contact-table__row">
                        <td>{{ $contact['last_name'] . '　' . $contact['first_name'] }}</td>
                        <td>
                            @if ($contact['gender'] == 1)
                                男性
                            @elseif($contact['gender'] == 2)
                                女性
                            @else
                                その他
                            @endif
                        </td>
                        <td>{{ $contact['email'] }}</td>
                        <td>{{ $contact['category']['content'] }}</td>
                        <td><a href="#modal-{{ $contact['id'] }}" class="detail-button">詳細</a></td>
                    </tr>
                @endforeach
            </table>
        </div>

        @foreach ($contacts as $contact)
            <div id="modal-{{ $contact['id'] }}" class="modal-overlay">
                <div class="modal-window">
                    <div class="modal-content">
                        <a href="#" class="modal-close">×</a>
                        <table class="modal-detail-table">
                            <tr>
                                <th>お名前</th>
                                <td>{{ $contact['last_name'] . '　' . $contact['first_name'] }}</td>
                            </tr>
                            <tr>
                                <th>性別</th>
                                <td>{{ $contact['gender'] == 1 ? '男性' : ($contact['gender'] == 2 ? '女性' : 'その他') }}
                                </td>
                            </tr>
                            <tr>
                                <th>メールアドレス</th>
                                <td>{{ $contact['email'] }}</td>
                            </tr>
                            <tr>
                                <th>電話番号</th>
                                <td>{{ $contact['tel'] }}</td>
                            </tr>
                            <tr>
                                <th>住所</th>
                                <td>{{ $contact['address'] }}</td>
                            </tr>
                            <tr>
                                <th>建物名</th>
                                <td>{{ $contact['building'] }}</td>
                            </tr>
                            <tr>
                                <th>お問い合わせの種類</th>
                                <td>{{ $contact['category']['content'] }}</td>
                            </tr>
                            <tr>
                                <th>お問い合わせ内容</th>
                                <td>{{ $contact['detail'] }}</td>
                            </tr>
                        </table>
                        <form action="/delete" method="POST">
                            @method('delete')
                            @csrf
                            <input type="hidden" name="id" value="{{ $contact['id'] }}">
                            <button type="submit" class="delete-button">削除</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
