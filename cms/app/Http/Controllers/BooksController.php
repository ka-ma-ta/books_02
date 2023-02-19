<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//
use App\Book;
use Validator;
use Auth;
//

class BooksController extends Controller
{
    //
    
    //ログイン認証
    public function __construct(){
        $this->middleware('auth');
    }
    
    //
    
    
    //ダッシュボード表示　課題2.1
     public function index() {
        $books = Book::where('user_id',Auth::user()->id)
        ->orderBy('created_at', 'asc')
        ->paginate(5);
        
        //デバック!!!
        //ddd($books);
        
        return view('books', [
            'books' => $books
        ]);
    }
    //
    
    //更新画面　課題2.2
    public function edit($book_id){
        $books = Book::where('user_id',Auth::user()->id)->find($book_id);
        return view('booksedit', [
            'book' => $books
        ]);
    }
    
    //
    
    //更新処理
    public function update(Request $request){
        //
        //バリデーション
        $validator = Validator::make($request->all(), [
            //
            'id' => 'required',
            'item_name' => 'required|max:255|min:3',  //ルールの追加ここ！パイプライン書いて追加していく！
            'item_number' => 'required|min:1|max:3',
            'item_amount' => 'required|max:6',
            'published' => 'required',
            //
            
        ]);
        //
        //バリデーション:エラー 
        if ($validator->fails()) {
            return redirect('/')  //セッションに値を保存→指定urlへ飛ばす
                ->withInput()  //値をフラッシュデータとして保存
                ->withErrors($validator);  //$errorsとしてアクセスできるようにする。
        }
        //
        //更新
        $books = Book::where('user_id',Auth::user()->id)->find($request->id);
        $books->item_name = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->published = $request->published;
        $books->save(); 
        return redirect('/');
        //
    }
    //
    
    //登録処理
    public function store(Request $request){
        //
        //バリデーション
        $validator = Validator::make($request->all(), [
            //課題1.1
            'item_name' => 'required|min:3|max:255',
            'item_number' => 'required | min:1 | max:3',
            'item_amount' => 'required | max:6',
             'published'   => 'required',
        ]);
    
        //バリデーション:エラー 
        if ($validator->fails()) {
            return redirect('/')  //セッションに値を保存→指定urlへ飛ばす
                ->withInput()  //値をフラッシュデータとして保存
                ->withErrors($validator);  //$errorsとしてアクセスできるようにする。
        }
        //
        
        //add
        $file = $request->file('item_img'); //file取得
        if( !empty($file) ){                //fileが空かチェック
            $filename = $file->getClientOriginalName();   //ファイル名を取得
            $move = $file->move('../upload/',$filename);  //ファイルを移動：パスが“./upload/”の場合もあるCloud9
        }else{
            $filename = "";
      }
        //
        
        //課題1.2
        // Eloquentモデル（登録処理）
        $books = new Book;
        
        //add
        $books->user_id  = Auth::user()->id;
        
        $books->item_name =    $request->item_name;
        $books->item_number =  $request->item_number;
        $books->item_amount =  $request->item_amount;
        
        //add
        $books->item_img = $filename;
        
        $books->published =    $request->published;
        $books->save(); 
        return redirect('/')->with('message', '本登録が完了しました');
        //
    }
    //
    
    //削除処理　課題2.3
    public function destroy(Book $book){
        $book->delete();
        return redirect('/');
    }
    //
    
    //
}
