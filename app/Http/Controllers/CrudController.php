<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CrudController extends Controller
{
    public function index()
    {
        $Arr['data'] = DB::table('forms')->get();
        return view('index', $Arr);
    }

    public function manage(Request $request)
    {
        $id = $request->id;
        $email = $request->post('email');
        $password = $request->post('password');
        
        $image_name = array();
        $imageArray = $request->file('images');
        $count = 0;

        if ($id > 0) {
            DB::table('forms')->where(['id' => $id])->update([
                'email' => $email,
                'password' => $password
            ]);

            $msg = "Data updated";

        } else {

            if($request->has('images')) {
                foreach ($imageArray as $image) {
                    $image_name[] = $image->getClientOriginalName();
                    $image->storeAs('public/media/', $image_name[$count]);
                    // Storage::disk('local')->put($image_name[$count], 'public/media/');
                    $count++;
                }
            }

            DB::table('forms')->insert(array([
                'email' => $email,
                'password' => $password,
                'images' => implode(',', $image_name)
            ]));

            $msg = "Data inserted";
        }

        return $msg;
    }

    public function edit(Request $request, $id)
    {
        $Arr['row'] = DB::table('forms')->where('id', $id)->get();
        $Arr['data'] = DB::table('forms')->get();
        return view('index', $Arr);
    }

    public function delete(Request $request, $id)
    {
        $row = DB::table('forms')->where(['id' => $id])->get();
        $imageArr = explode(',', $row[0]->images);

        foreach($imageArr as $image)
        {
            if(Storage::exists('public/media/'.$image))
            {
                Storage::delete('public/media/'.$image);
            } else {
                Storage::delete('public/media/'.$image);
            }
        }

        $row = DB::table('forms')->where(['id' => $id])->delete();
        return redirect('/');
    }
}

function prx($arr)
{
    echo "<pre>";
    print_r($arr);
    die();
}
