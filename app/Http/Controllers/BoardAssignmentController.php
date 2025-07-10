<?php

namespace App\Http\Controllers;

use App\Models\M_batch;
use App\Models\M_story;
use App\Models\T_board_assignment;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;

class BoardAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all data batch
        $batch = M_batch::all();
        return view('boardAssignment.index', compact('batch'));
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
        $save = $request->save;
        $del = $request->del;
        $batch_id = $request->batch_id;
        //jika ada data yang disave melakukan cek terlebih dahulu agar tidak jadi double
        if (isset($save)) {
            for ($i = 0; $i < count($save); $i++) {
                $cek = T_board_assignment::where('batch_id', $batch_id)->where('story_id', $save[$i])->get();
                if (count($cek) === 0) {
                    $t_board = T_board_assignment::create([
                        'batch_id' => $request->batch_id,
                        'story_id' => $save[$i]
                    ]);
                }
            }
        }

        //jika ada data yang akan di delete dan data tersebut ada maka akan di delete
        if (isset($del)) {
            for ($j = 0; $j < count($del); $j++) {
                $cek = T_board_assignment::where('batch_id', $batch_id)->where('story_id', $del[$j])->first();
                if ($cek != null) {
                    T_board_assignment::destroy($cek->id);
                }
            }
        }
        return $batch_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dapatkan data batch yang dipilih
        $data = M_batch::find($id);
        //dapatkan data assignment untuk batch yg dipilih dan diurutkan berdasarkan priority story
        $assignment = T_board_assignment::where('batch_id', $id)
            ->join('m_story', 't_board_assignment.story_id', '=', 'm_story.id')
            ->orderBy('m_story.priority', 'desc')
            ->get();
        $data->technology = $data->technology->name;
        //cekapakah batch tersebut Done atau tidak
        if ($data->status == "D") {
            $disabled = "disabled";
        } else {
            $disabled = "";
        }
        //merapikan data yang akan dikirim ke view
        if (count($assignment) != 0) {
            $board = "";
            for ($i = 0; $i < count($assignment); $i++) {
                $name = $assignment[$i]->story->name;
                $type = $assignment[$i]->story->type;
                $score = score_story($assignment[$i]->story->score);
                $board .= "<div class='card card-assigment-isi'>
            <div class='card-body text-center'>
                <p class='m-auto' style='color: var(--white);'>[$type$score]$name</p>
            </div>
        </div>";
            }
            $data->board = $board;
        } else {
            $data->board = '<span class="m-auto" style="color: var(--orange);">No Assignment</span>';
        }
        //mengirim html untuk btn
        $data->btn = "<button class='btn btn-lg m-auto btn-add-ass' type='button' onClick='Add($data->id)' name='card-btn' $disabled>Add/Edit Assigment</button>
        <button class='btn btn-lg m-auto btn-copy' type='button' onClick='Copy($data->id)' name='card-btn' $disabled>Copy from Batch</button>
        <button class='btn btn-lg m-auto btn-drop' type='button' onClick='Drop($data->id)' name='card-btn' $disabled>Drop Assigment</button>";

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //mengambil semua data story
        $story = M_story::orderBy('priority','DESC')->get();
        //dapatkan data assignment untuk batch yg dipilih dan diurutkan berdasarkan priority story
        $assignment = T_board_assignment::where('batch_id', $id)
            ->join('m_story', 't_board_assignment.story_id', '=', 'm_story.id')
            ->orderBy('m_story.priority', 'desc')
            ->get();
        $data_story = array();
        //mapping assignment yang sudah ada untuk view
        if (count($assignment) != 0) {
            for ($i = 0; $i < count($assignment); $i++) {
                $name = $assignment[$i]->story->name;
                $type = $assignment[$i]->story->type;
                $score = score_story($assignment[$i]->story->score);
                $assignment[$i]->storyname = "[$type$score]$name";
            }
        }
        //menampilkan data story yang belum dipilih
        for ($i = 0; $i < count($story); $i++) {
            array_push($data_story, $story[$i]);
            for ($j = 0; $j < count(($assignment)); $j++) {
                if ($story[$i]->id === $assignment[$j]->story_id) {
                    array_pop($data_story);
                }
            }
        }
        return view('boardAssignment.edit')->with([
            'data_story' => $data_story,
            'assignment' => $assignment,
            'batch_id' => $id
        ]);
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
        //menghapus semua assignment sesuai batch yg dipilih
        T_board_assignment::where('batch_id', $id)->delete();
        return $id;
    }

    public function copy($id)
    {
        //ambil semua batch yang bisa dicopy kecuali batch yang diselect
        $batch = M_batch::all()->except($id);;
        return view('boardAssignment.copy')->with([
            'data' => $batch
        ]);
    }

    public function savecopy(Request $request)
    {
       
        //delete dulu semua data dalam batch yg dipilih
        T_board_assignment::where('batch_id', $request->select)->delete();
         //menyimpan semua data yang di copy dari batch lain
        $assignment_cp = T_board_assignment::where('batch_id', $request->copy)->get();
        if (count($assignment_cp)) {
            for ($i = 0; $i < count($assignment_cp); $i++) {
                $t_board = T_board_assignment::create([
                    'batch_id' => $request->select,
                    'story_id' => $assignment_cp[$i]->story_id
                ]);
            }
        }
    }

    public function drop($id)
    {
        //memunculkan modal untuk drop
        $data = M_batch::find($id);
        return view('boardAssignment.drop')->with([
            'data' => $data
        ]);
    }
}
