<?php

namespace App\Http\Controllers;

use App\app;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Http;
use Validator;
use App\User;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $id = 123;
        $name = $req->session()->get('username');
        return view('home.home',compact('id', 'name'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userlist(){
        $users  = App::all();
        return view('home.userlist')->with('users', $users);
    }
    public function pdf(){
        $users  = App::get();
        
        $filename = 'userlist.pdf';
        $mpdf = new \Mpdf\Mpdf([
            'margin-left' => 10
        ]);
        $html = \View::make('home.userpdf')->with('users', $users);
        $html = $html->render();
        $mpdf->WriteHtml($html);
        $mpdf->Output($filename,'I');
        
    }
    public function create()
    {
        return view('home.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        
                $user = new app();
                $user->username     = $request->username;
                $user->password     = $request->password;
                $user->name         = $request->name;
                $user->type         = $request->type;
                if($user->type =="admin")
                {
                if($user->save()){
                    return redirect()->route('home.userlist');
                }else{
                    return $error->flash('err', 'must be admin');
                }
            }
            else{
                return back();
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\app  $app
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\app  $app
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = app::find($id);       
        return view('home.edit', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\app  $app
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $req)
    {
        $user = app::find($id); 
        $user->username     = $req->username;
        $user->password     = $req->password;
        $user->name         = $req->name;
        $user->type         = $req->type;
        $user->save();

        return redirect()->route('home.userlist');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\app  $app
     * @return \Illuminate\Http\Response
     */
    public function delete($id){
        
        $user = app::find($id);

        $user->delete();

        return redirect()->route('home.userlist');
    }
    public function index2()
    {
     return view('home.users');
    }
    public function search(Request $request)
    {
      
       if($request->ajax()){
    
         $output="";
         $products = app::where('username','LIKE','%'.$request->search."%")
         ->orWhere('id', 'LIKE','%'.$request->search."%")
         ->orWhere('name','LIKE','%'.$request->search."%")
         ->orWhere('type', 'LIKE','%'.$request->search."%")
         ->get();
         
         if($products){
      
            foreach ($products as  $product) {
            
             $output.='<tr>'.
             
             '<td>'.$product->id.'</td>'.
             
             '<td>'.$product->username.'</td>'.
             
             '<td>'.$product->type.'</td>'.
             
             '<td>'.$product->name.'</td>'.
             
             '</tr>';
         
            }
            return $output;  
 
         }
   
       }
 
    }
    public function salarylist(){
        
       return show(); 

    }
    public function show(){
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', 'http://localhost:3000/adminhome/userlist');
        
        return redirect()->route('home.show')->response()->getBody(); 

    }
    

}
