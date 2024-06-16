<?php

namespace App\Http\Controllers;

use App\Models\Annee;

//use Illuminate\Http\Request;

class ExtendedController extends Controller
{
    //
	protected function authExtensions(){
		return array('jpg','png','jpeg','gif','GIF','PNG','JPG','JPEG','pdf','PDF','Pdf','doc','docx','DOC','DOCX');
	}

    protected function docExtensions(){
		return array('pdf','PDF','Pdf','doc','docx','DOC','DOCX');
	}

    public function getAnneeId(){
        $annee = Annee::where('active',1)->first();
        return $annee->id;
    }

	protected function entityImgCreate($file,$entity,$name_without_extension){

		$ext = $file->getClientOriginalExtension();
		$arr_ext = $this->authExtensions();

		if (!file_exists(public_path('img') . '/'.$entity)) {
			mkdir(public_path('img') . '/'.$entity,0777,true);
		}
		if(in_array($ext,$arr_ext)) {
			$name_with_extension = $name_without_extension . '.' . $ext;
			if (file_exists(public_path('img') . '/' . $entity . '/' . $name_with_extension)) {
				unlink(public_path('img') . '/' . $entity . '/' . $name_with_extension);
			}
			$imageUri = $entity.'/'.$name_with_extension;
			$file->move(public_path('img/' . $entity), $name_with_extension);
			return $imageUri;
		}

		return null;
	}

	protected function entityDocumentCreate($file,$entity,$name_without_extension){

		$ext = $file->getClientOriginalExtension();
		$arr_ext = $this->docExtensions();

		if (!file_exists(public_path('files'))) {
			mkdir(public_path('files'));
		}

		if (!file_exists(public_path('files') . '/'.$entity)) {
			mkdir(public_path('files') . '/'.$entity);
		}
		if(in_array($ext,$arr_ext)) {
			$name_with_extension = $name_without_extension . '.' . $ext;

			if (file_exists(public_path('files') . '/' . $entity . '/' . $name_with_extension)) {
				unlink(public_path('files') . '/' . $entity . '/' . $name_with_extension);
			}
			$imageUri = $entity.'/'.$name_with_extension;
			$file->move(public_path('files/' . $entity), $name_with_extension);
			return $imageUri;
		}else{
			//dd('ok');
			request()->session()->flash('warning',' Impossible d\'enregistrer le fichier, le format n\'est pas correct !!!');
		}


		return null;
	}
}
