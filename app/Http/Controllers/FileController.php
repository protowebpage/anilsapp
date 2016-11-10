<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;

class FileController extends Controller
{
	public function temporary(Request $request, $type)
	{
		// different upload types not implemented yet
		return $this->temporaryCustomerDesign($request);
	}

	private function temporaryCustomerDesign(Request $request){
		
		if (!$request->hasFile('file')){
			return ['no input file given'];
		}

		$data = [
			'filenameOriginal' => $request->file->getClientOriginalName(),
			'filenameTmp' => $this->getTmpFilename($request->file)
		];

		Storage::put('uploads/temporary/' . $data['filenameTmp'], file_get_contents($request->file));

		$request->session()->put('order.filenameOriginal', $data['filenameOriginal']);
		$request->session()->put('order.filenameTmp', $data['filenameTmp']);

		return $data;

	}

	private function getTmpFilename($file)
	{
		return session()->getId() . '_' . time() . '_' . $file->getClientOriginalName();
	}


}
