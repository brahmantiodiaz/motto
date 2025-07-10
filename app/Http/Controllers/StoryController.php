<?php

namespace App\Http\Controllers;

use App\Models\D_story_sow;
use App\Models\M_sow;
use App\Models\M_story;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //mengmabil semua story
        $story = M_story::all();
        //mengambil sow untuk di form
        $sow = M_sow::all();
        //membuat tampilan data sow, dan attachment
        for ($i = 0; $i < count($story); $i++) {
            $story[$i]->description = '<div style="height: 100px; overflow:auto;">' . $story[$i]->description . '</div>';
            $story[$i]->scope = '<ul>';
            for ($j = 0; $j < count($story[$i]->sow); $j++) {
                $story[$i]->scope .= '<li>' . $story[$i]->sow[$j]->M_sow->sow . '</li>';
            }
            $story[$i]->scope .= '</ul>';
            $story[$i]->attachment = '<div style="height: 100px; overflow:auto;">';
            for ($k = 0; $k < count($story[$i]->att); $k++) {
                if (pathinfo(storage_path() . $story[$i]->att[$k]->attachment, PATHINFO_EXTENSION) == 'pdf') {
                    $story[$i]->attachment .= '
               
                    <a href="/download/'.$story[$i]->att[$k]->attachment.'">'.$story[$i]->att[$k]->attachment.'<a>
               
                <br>';
                }else{
                    $story[$i]->attachment .= '<a href="'.$story[$i]->att[$k]->attachment.'"
                    onclick="window.open(this.href,' ."'_blank'".",'left=20,top=20,width=500,height=500,toolbar=1,resizable=0'".'); return false;">
                    '.basename($story[$i]->att[$k]->attachment).'
                </a>
                <br>';
                }
            }
            $story[$i]->attachment .= '</div">';
        }
        //membuat datatables
        if ($request->ajax()) {
            return Datatables::of($story)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editStory">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteStory">Delete</a>';

                    $btn = $btn . ' <a href="attachment/'. $row->id .'" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Attachment" class="btn btn-success btn-sm attachmentStory">Attachment</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'description', 'scope','attachment'])
                ->make(true);
        }


        return view('story.index', compact('story', 'sow'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sow = M_sow::all();
        //membuat atau update data jika ada IDnya
        $story = M_story::updateOrCreate(
            ['id' => $request->id],
            [
                'name' => $request->name,
                'type' => $request->type,
                'score' => $request->score,
                'description' => $request->description,
                'priority' => $request->priority
            ]
        );
        //menghapus semua D_story_sow sesuai story ID
        D_story_sow::where('story_id', $story->id)->delete();
        //membuat D_story_sow
        for ($i = 0; $i < count($sow); $i++) {
            if (isset($request->sow[$i])) {
                $d_story_sow = D_story_sow::create([
                    'story_id' => $story->id,
                    'sow_id' => $request->sow[$i]
                ]);
            }
        }

        return response()->json(['success' => 'Story saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //memunculkan data untuk edit
        $story = M_story::find($id);
        $story->sow = $story->sow;
        return response()->json($story);
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
        //hapus story
        M_story::find($id)->delete();

        return response()->json(['success' => 'Story deleted successfully.']);
    }
}
