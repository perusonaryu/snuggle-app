<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Cat;
use App\Like;
use Illuminate\Support\Facades\Storage;

class CatController extends Controller
{
    public function register(Request $request){

        $this->validator($request->all())->validate();

        if($request->image){
            // $file_name = $request->userId.'-'.$request->image->getClientOriginalName();
            // $request->image->storeAs('public/catImages',$file_name);
            
            $path = Storage::disk('s3')->put('/catImages', $request->image, 'public');

            Cat::create([
                'name' => $request->name,
                'age' => $request->age,
                'personality' => $request->personality,
                'background' => $request->background,
                'gender' => $request->gender,
                'image' => $path,
                'user_id' => $request->userId,
                'region' => $request->region,
                'castration_surgery' => $request->castrationSurgery,
                'vaccine' => $request->vaccine,
            ]);

            return json_encode(['success' => '猫を登録しました!']);
        }
    }

    public function detail($id){
        $cat_data = Cat::where('id',$id)->get();
        return json_encode(['catData' => $cat_data]);
    }

    public function get(){
        $cats =  Cat::orderBy('created_at', 'desc')->get();

        return json_encode(['catsData' => $cats]);
    }

    public function topGet(){
        $cats =  Cat::take(9)->orderBy('created_at', 'desc')->get();

        return json_encode(['catsData' => $cats]);
    }

    public function catslistget($id){
        $mycatslist = Cat::where('user_id',$id)->get();

        return json_encode(['myCatsList' => $mycatslist]);
    }

    public function edit($id){
        $cat_data = Cat::where('id',$id)->get();

        return json_encode(['catData'=>$cat_data]);
    }

    public function update(Request $request){

        $this->updatevalidator($request->all())->validate();
        $cat = Cat::find($request->id);
        $cat->name = $request->name;
        $cat->age = $request->age;
        $cat->personality = $request->personality;
        $cat->background = $request->background;
        $cat->gender = $request->gender;
        $cat->region = $request->region;
        $cat->castration_surgery = $request->castrationSurgery;
        $cat->vaccine = $request->vaccine;
        if(!is_string($request->image)){
            
            $image_delete = Storage::disk('s3')->delete($request->image);
            // $pathdel = public_path().'/storage/catImages/'.$cat->image;
            // \File::delete($pathdel);

            // $file_name = $cat->user_id.'-'.$request->image->getClientOriginalName();
            // $request->image->storeAs('public/catImages',$file_name);
            $path = Storage::disk('s3')->put('/catImages', $request->image, 'public');

            $cat->image = $path;
        }

        $cat->save();

        return json_encode(['catData' => $cat]);

    }


    //県名での検索
    public function search(Request $request){        
        $searched_cats_data = Cat::where('region','like', '%'.$request[0].'%')
            ->orderBy('created_at', 'desc')
            ->get();
        return json_encode(['searchedCatsData' => $searched_cats_data]);
    }

    //お気に入りの猫だけを取得
    public function favoriteCatsGet($id){
        $favolit_cats = Cat::select('cats.*')->join('likes','cats.id', '=' , 'likes.cat_id')->where('likes.user_id',$id)->get();

        
        return json_encode(['favolitCatsData' => $favolit_cats]);
    }

    //猫削除
    public function delete($cat_id){
        $cat_data = Cat::find($cat_id);
        $pathdel = public_path().'/storage/catImages/'.$cat_data->image;
        \File::delete($pathdel);

        $cat_data->delete();

        return json_encode(['delete' => '削除成功しました！']);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['string','max:255'],
            'personality' => ['required','string'],
            'background' => ['required','string'],
            'gender' => ['required','string'],
            'image' => ['required','image'],
            'region' => ['required','string'],
            'castrationSurgery' => ['required','string'],
            'vaccine' => ['required','string'],
        ]);
    }

    protected function updatevalidator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['string','max:255'],
            'personality' => ['required','string'],
            'background' => ['required','string'],
            'image' => ['required'],
            'gender' => ['required'],
            'region' => ['required','string'],
            'castrationSurgery' => ['required','string'],
            'vaccine' => ['required','string'],
        ]);
    }
}
