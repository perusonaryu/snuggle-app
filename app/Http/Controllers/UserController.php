<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Storage;

class UserController extends Controller
{
    public function update(Request $request){
        // リクエストを検証します。
        $this->validator($request->all())->validate();

        $user = User::find($request -> id);

        $user->name = $request->name;
        $user->introduction = $request->introduction;
        $user->region = $request->region;
        if(!is_string($request->image)){
            $path = '';
            if(app()->environment('local')){
                $pathdel = public_path().'/storage/userImages/'.$user->image;
                \File::delete($pathdel);
                $psth = $user->id.'-'.$request->image->getClientOriginalName();
                $request->image->storeAs('public/userImages',$path);
            }elseif(app()->environment('production')){
                $image_delete = Storage::disk('s3')->delete($user->image);
                $path = Storage::disk('s3')->put('/userImages', $request->image, 'public');
            }
            $user->image = $path;
        }

        $user->save();

        return json_encode(['user' => $user]);
    }

    public function detail($id){
        $posted_user = User::find($id,['name','region','introduction','image']);

        return json_encode(['postedUser' => $posted_user]);
    }

    

    //validation
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'region' => ['required','string'],
            'image' => ['required'],
        ]);
    }
}
