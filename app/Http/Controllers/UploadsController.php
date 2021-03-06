<?php namespace siprotec\Http\Controllers;

use siprotec\Http\Requests;
use siprotec\Http\Controllers\Controller;

use Illuminate\Http\Request;

class UploadsController extends Controller {

    public function getIndex()
    {
        return view("newmeta");
    }

    public function postSave()
    {
        if(!\Input::file("file"))
        {
            return redirect('uploads')->with('error-message', 'File has required field');
        }

        $mime = \Input::file('file')->getMimeType();
        $extension = strtolower(\Input::file('file')->getClientOriginalExtension());
        $fileName = uniqid().'.'.$extension;
        $path = "files_uploaded";

        switch ($mime)
        {
            case "image/jpeg":
            case "image/png":
            case "image/gif":
            case "application/pdf":
                if (\Request::file('file')->isValid())
                {
                    \Request::file('file')->move($path, $fileName);
                    $upload = new Upload();
                    $upload->filename = $fileName;
                    if($upload->save())
                    {
                        return redirect('uploads')->with('success-message', 'File has been uploaded');
                    }
                    else
                    {
                        \File::delete($path."/".$fileName);
                        return redirect('uploads')->with('error-message', 'An error ocurred saving data into database');
                    }
                }
                break;
            default:
                return redirect('uploads')->with('error-message', 'Extension file is not valid');
        }
    }
}
