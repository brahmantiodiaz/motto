<?php

namespace App\Http\Controllers;

use App\Models\D_story_att;
use App\Models\M_story;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\File;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //attachment dari story yang dipilih
        $att = D_story_att::where('story_id', $request->id)->get();
        //menampilkan data 
        $attachment = '<div class="row"><div class="col-md-12" style="overflow-x: scroll; white-space: nowrap;">';
        for ($k = 0; $k < count($att); $k++) {
            if (pathinfo(storage_path() . $att[$k]->attachment, PATHINFO_EXTENSION) == 'pdf') {
                $attachment .= '
                    <div style="display: inline-block!important;
                    margin-right: 3rem!important;">
                <span>
                    <a href="/download/' . $att[$k]->attachment . '" style="padding-left: 25px"><img src="/images/pdf.png" height="150" width="100">' . $att[$k]->attachment . '<a>
                </span>
                <br>
                <button type="button" class="btn btn-link remove_image" id="' . $att[$k]->id . '">Remove</button>
                </div>';
            } else {
                $attachment .= '<div style="display: inline-block!important;
                margin-right: 3rem!important;">
                    <a href="' . $att[$k]->attachment . '"
                    onclick="window.open(this.href,' . "'_blank'" . ",'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'" . '); return false;">
                    <img src="' . $att[$k]->attachment . '" height="150" width="250">
                </a>
                <br>
                <button type="button" class="btn btn-link remove_image" id="' . $att[$k]->id . '">Remove</button>
                </div>';
            }
        }
        $attachment .= '</div">';
        return $attachment;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //upload data ke storage public
        if ($request->hasFIle('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . $filename;
            if ($extension == 'pdf') {
                $attachment = $path;
                $file->move(public_path('docs'), $path);
                $t_board = D_story_att::create([
                    'story_id' => $request->id,
                    'attachment' => $attachment
                ]);
                return response()->json(['success' => $path]);
                
            } else {
                $attachment = '/images/'.$path;
                $file->move(public_path('images'), $path);
                $t_board = D_story_att::create([
                    'story_id' => $request->id,
                    'attachment' => $attachment
                ]);
                return response()->json(['success' => $path]);
            }
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //menampilkan view attachment untuk story yang dipilih
        $story = M_story::find($id);
        return view('story.attachment', compact('story'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //hapus attachment 
        $att=D_story_att::find($id);
        if (pathinfo(storage_path() . $att->attachment, PATHINFO_EXTENSION) == 'pdf') {
            File::delete(public_path('docs/' . $att->attachment));
        }else {
            File::delete(public_path($att->attachment));
        }
        $att->delete();
        return response()->json(['success' => 'Delete deleted successfully.']);

    }
}
