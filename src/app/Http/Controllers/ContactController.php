<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ContactRequest;
use App\Models\User;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Http\Responses\RegisterResponse;

class ContactController extends Controller
{
    // ログイン処理
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }
        throw ValidationException::withMessages([
            'password' => [' ログイン情報が登録されていません'],
        ]);
    }

    // 新規登録処理
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return app(RegisterResponse::class);
    }

    // 管理者画面処理
    public function admin(Request $request)
    {
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    // モーダル画面での削除処理
    public function delete(Request $request)
    {
        Contact::find($request->id)->delete();
        return redirect('/admin');
    }

    // 検索処理
    public function search(Request $request)
    {
        $contacts = Contact::with('category')
            ->keywordSearch($request->keyword)
            ->genderSearch($request->gender)
            ->categorySearch($request->category_id)
            ->dateSearch($request->updated_at)
            ->paginate(7);
        $categories = Category::all();
        return view('admin', compact('contacts', 'categories'));
    }

    // CSVへの書き出し処理
    public function export(Request $request)
    {
        $contacts = Contact::with('category')
            ->keywordSearch($request->keyword)
            ->genderSearch($request->gender)
            ->categorySearch($request->category_id)
            ->dateSearch($request->updated_at)
            ->get();
        $csvHeader = ['お名前', '性別', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', 'お問い合わせ内容'];
        $csvData = [];
        $csvData[] = $csvHeader;
        foreach ($contacts as $contact) {
            $gender = ($contact->gender == 1) ? '男性' : (($contact->gender == 2) ? '女性' : 'その他');
            $csvData[] = [
                $contact->last_name . ' ' . $contact->first_name,
                $gender,
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->category->content,
                $contact->detail,
            ];
        }
        $filename = 'contacts_' . date('YmdHis') . '.csv';
        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');

            // 1. 文字化け対策のBOMを書き込む（これは fputs でOK）
            fputs($file, "\xEF\xBB\xBF");

            // 2. データを1行ずつ取り出して書き込む
            foreach ($csvData as $row) {
                // $row が配列であることを確認して書き込む
                fputcsv($file, $row);
            }
            fclose($file);
        };
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];
        return response()->stream($callback, 200, $headers);
    }

    // お問い合わせ画面処理
    public function contact()
    {
        $categories = Category::all();
        return view('contact', compact('categories'));
    }

    // お問い合わせ確認画面処理
    public function confirm(ContactRequest $request)
    {
        $tel = $request->tel1 . $request->tel2 . $request->tel3;

        $contact = $request->only([
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel1',
            'tel2',
            'tel3',
            'address',
            'building',
            'category_id',
            'detail',
        ]);
        $contact['tel'] = $tel;
        $category = Category::find($request->category_id);

        return view('confirm', compact('contact', 'category'));
    }

    // 確認画面から修正ボタン押下時の処理
    public function modify(Request $request)
    {
        return redirect('/')->withInput();
    }

    // サンクス画面＋データ保存処理
    public function thanks(Request $request)
    {
        $contact = $request->only([
            'first_name',
            'last_name',
            'gender',
            'email',
            'tel',
            'address',
            'building',
            'category_id',
            'detail',
        ]);
        Contact::create($contact);
        return view('thanks');
    }
}
