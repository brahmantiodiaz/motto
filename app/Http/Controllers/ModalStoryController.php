<?php

namespace App\Http\Controllers;

use App\Models\D_story_att;
use App\Models\D_story_sow;
use App\Models\M_story;
use App\Models\M_sow;
use Illuminate\Http\Request;
use PDF;

class ModalStoryController extends Controller
{
    //
    public function index($id)
    {
        $data = M_story::orderBy('id')->where('id', $id)->get();
        // $data2 = DB::select('SELECT(SELECT sow FROM m_sow WHERE id=dss.sow_id) as sow FROM d_story_sow dss WHERE dss.story_id = "' . $id . '"');
        $data2 = D_story_sow::where('story_id', $id)->get();
        $data_images = D_story_att::where('story_id', $id)->where('attachment', 'LIKE', '/images/%')->get();
        $data_pdf = D_story_att::where('story_id', $id)->where('attachment', 'LIKE', '%pdf')->get();
        // return $data2[0]->M_sow;
        return view('projectBoard.modalstory', ['data' => $data, 'data2' => $data2, 'data_images' => $data_images, 'data_pdf' => $data_pdf, 'id' => $id]);
    }

    public function download($file)
    {
        return response()->download('docs/' . $file);
    }
}
