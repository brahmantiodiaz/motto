<?php

namespace App\Http\Controllers;

use App\Models\D_batch_student;
use App\Models\L_project_board;
use App\Models\M_story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\T_board_assignment;
use App\Models\T_project_board;


class ProjectBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //mengambil data user tersebut ada di batch berapa
        $batch = D_batch_student::whereBelongsTo(Auth::user())->first()->batch;
        //mengambil daata teman selain user dalam batch tersebut
        $d_batch_student = D_batch_student::where('batch_id', $batch->id)->where('user_id', '!=', Auth::user()->id)->get();
        //mengambil data assignment dalam batch tsb.
        $assignment = T_board_assignment::where('batch_id', $batch->id)
            ->join('m_story', 't_board_assignment.story_id', '=', 'm_story.id')
            ->orderBy('m_story.priority', 'desc')
            ->get();
        //data assignment yang sudah diambil oleh user.
        $project_board = T_project_board::whereBelongsTo(Auth::user())
            ->join('m_story', 't_project_board.story_id', '=', 'm_story.id')
            ->orderBy('m_story.priority', 'desc')
            ->get();
        //mengambil semua data assignment yang sudah di ambil oleh user dalam batch tsb.
        $cek_pb = T_project_board::where('batch_id', $batch->id)->get();

        //menfilter data assignment yg belum diambil
        $data_assignment = array();
        for ($i = 0; $i < count($assignment); $i++) {
            array_push($data_assignment, $assignment[$i]);
            for ($j = 0; $j < count(($cek_pb)); $j++) {
                if ($assignment[$i]->story_id === $cek_pb[$j]->story_id) {
                    array_pop($data_assignment);
                }
            }
        }

        //menfilter assignment sesuai dengan yang sudah diambil oleh teammate
        for ($i = 0; $i < count($d_batch_student); $i++) {
            $pb_teammate = T_project_board::where('user_id', $d_batch_student[$i]->user_id)
            ->join('m_story', 't_project_board.story_id', '=', 'm_story.id')
            ->orderBy('m_story.priority', 'desc')
            ->get();
            $d_batch_student[$i]->pb = $pb_teammate;
        }

        return view('projectBoard.index')->with([
            'batch' => $batch,
            'assignment' => $data_assignment,
            'project_board' => $project_board,
            'd_batch_student' => $d_batch_student
        ]);
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

        //mengambil batch dari user, serta cek apakah user sudah ambil storynya atau belum
        $batch = D_batch_student::whereBelongsTo(Auth::user())->first()->batch;
        $cek = T_project_board::find($request->id);
        $story = M_story::find($request->story_id);
        //log yang akan dibuat ketika memindahkan story
        if ($request->status == null) {
            $action = "picks " . $story->name;
        } elseif ($cek->status == "D" && $request->status == "O") {
            $action = "moves back " . $story->name . " to Development";
        } elseif ($request->status == "O") {
            $action = "starts development of " . $story->name;
        } elseif ($request->status == "D") {
            $action = "finished development of " . $story->name;
        }

        //melakukan create jika id T_project board belum ada
        $t_project_board = T_project_board::updateOrCreate(
            ['id' => $request->id],
            [
                'user_id' => Auth::user()->id,
                'batch_id' => $batch->id,
                'story_id' => $request->story_id,
                'status' => $request->status
            ]
        );

        //membuat log 
        $l_project_board = L_project_board::create([
            'project_board_id' => $t_project_board->id,
            'user_id' => Auth::user()->id,
            'action' => Auth::user()->username . " " . $action
        ]);

        return response()->json($t_project_board->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //menghapus myplan
        $t_project_board = T_project_board::find($id);
        $story = M_story::find($t_project_board->story_id);
        $l_project_board = L_project_board::create([
            'project_board_id' => $id,
            'user_id' => Auth::user()->id,
            'action' => Auth::user()->username . " cancels " . $story->name
        ]);
        $t_project_board->delete();

        return response()->json(['success' => 'Project Board delete successfully.']);
    }
}
