<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ExtendedController;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostCategory;
use App\Services\OneSignalNotification;

class PostController extends ExtendedController
{

    public function index(){
        $items = Post::orderBy('created_at','DESC')->get();
        return response()->json(PostResource::collection($items));
    }

    public function store(){
        $data = json_decode(request()->post,true);
        $photo = request()->photo;
        //dd($photo);
        $token = sha1(time().auth()->user()->id);
        $data['token'] = $token;
        if($photo){
            $data['image_uri'] = $this->entityImgCreate($photo,'posts',$token);
        }
        if(request()->doc){
            $data['doc_uri'] = $this->entityDocumentCreate(request()->doc,'posts',$token);
        }
        unset($data['photo']);
        unset($data['doc']);
        $item = Post::create($data);
        $data['content'] = new PostResource($item);
        $fields['include_external_user_ids'] = ['90239328327837'];
        $fields['channel_for_external_user_ids'] = "push";
        $fields['data'] = $data;
        $message = $item->name;
        $response = OneSignalNotification::send($fields,$message);
        return response()->json($response);
    }

    public function create(){
        $categories = PostCategory::where('active',1)->get();

        return response()->json([
            'categories'=>$categories,
        ]);
    }
}
