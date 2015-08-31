<?php namespace siprotec\Http\Controllers;

use siprotec\Http\Requests;
use siprotec\Http\Controllers\Controller;

use Illuminate\Http\Request;
use siprotec\Upload;

class StorageController extends Controller {



	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return \View::make('new');
	}

    /**
     * Guarda un archivo en nuestro directorio local.
     *
     * @return Response
     */
    public function save(Request $request)
    {
        if(!\Input::file("file"))
        {
            return redirect('uploads')->with('error-message', 'File has required field');
        }

        $mime = \Input::file('file')->getMimeType();
        $extension = strtolower(\Input::file('file')->getClientOriginalExtension());
        $fileName = \Input::file('file')->getClientOriginalName().'.'.$extension;
        $path = "storage";

        switch ($mime)
        {
            case "image/jpeg":
            case "image/png":
            case "image/gif":
            case "application/pdf":
                if (\Request::file('file')->isValid())
                {
                    \Request::file('file')->move($path, $fileName);
                    chmod($path."/".$fileName, 0777);
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



    public function add(Request $request) {

        $file = \Input::file('file');
        $extension = $file->getClientOriginalExtension();
        $path = "storage";
        $fileName = \Request::file('file')->getClientOriginalName().'.'.$extension;
        \Request::file('file')->move($path, $fileName);

        //return redirect('fileentry');
        return "archivo guardado";

    }



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
