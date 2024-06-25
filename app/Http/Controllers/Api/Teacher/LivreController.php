<?php

namespace App\Http\Controllers\Api\Teacher;
use App\Http\Controllers\ExtendedController;
use App\Http\Resources\LivreResource;
use App\Models\Domaine;
use App\Models\Livre;
use Illuminate\Support\Facades\Storage;

class LivreController extends ExtendedController
{

    public function index(){
        $items = Livre::all();
        $items = LivreResource::collection($items);
        return response()->json($items);
    }

    public function store(){
        $data = json_decode(request()->livre,true);
        $file = request()->file;
        $token = sha1(time());
        $data['token'] = $token;
        $data['user_id'] = auth()->user()->id;
        if($file){
            $ext = $file->getClientOriginalExtension();
            $doc_path = "livres/".$token.'.'.$ext;
            $storage = Storage::disk('public');
            $img = new \Imagick;
            $storage->put($doc_path, file_get_contents($file));
            $img->readImageBlob($storage->get($doc_path));
            $img->setIteratorIndex(0);
            $img->setImageFormat('jpeg');
            $img_path = "livres/". $token.'.jpeg';
            $storage->put($img_path,$img->getImageBlob());
            $data['image_uri'] = $img_path;
            $data['doc_uri'] = $doc_path;
            $item = Livre::create($data);
            return response()->json('ok');
        }
        return response()->json('aucun fichier',500);
    }

    public function create(){
        $domaines = Domaine::all();

        return response()->json([
            'domaines'=>$domaines,
        ]);
    }
}
