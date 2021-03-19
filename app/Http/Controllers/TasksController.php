<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task; //追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //一覧取得
        $tasks= Task::all();
        $data = [];
        if(\Auth::check()) {
            $user = \Auth::user();
            $tasks = $user->tasks()->orderBy("created_at","desc")->paginate(10);
            
            $data =[
                "user" => $user,
                "tasks" => $tasks,
                ];
        
        //一覧で表示
        return view("tasks.index", [
            "tasks" =>$tasks,
        ]);
    }else{
        return view("welcome");
    }
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        //タスク作成ビューを表示
        
        return view("tasks.create",[
            "task" => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //バリデーション
        $request->validate([
            
            "status" => "required|max:10",
            "content" => "required",
        ]);
        $user =\Auth::user();
        $user->tasks()->create([
        "status" =>$request->status,
        "content" => $request->content,
        
        ]);
       
         
        
        
        
        
        //トップページへリダイレクト
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
        //タスク詳細ビューでそれを表示
        return view("tasks.show",[
            "task" =>$task,
        ]);
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //タスク編集ビューでそれを表示
        return view("tasks.edit",[
            "task" => $task,
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            
            "status"=> "required|max:10",
            "content"=> "required",
        ]);
        //idの値でタスクを検索して取得
        $task= Task::findOrFail($id);
        // タスクを更新
        $user=\Auth::user();
        $user->tasks()->create([
            "status"=>$request->status,
            "content"=>$request->content,
        ]);
        
        // トップページへリダイレクトさせる
        return redirect("/");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
         // メッセージを削除
         if(\Auth::id() === $task->user_id) {
             $task->delete();
         }
         
         
         // トップページへリダイレクトさせる
         return redirect("/");
    }
}

       
