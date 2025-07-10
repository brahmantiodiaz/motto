<?php

namespace App\Http\Controllers;

use App\Models\M_batch;
use App\Models\M_technology;
use App\Models\M_trainer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get all data batch
        $batch = M_batch::all();
        //technology dan trainer untuk di form add
        $technology = M_technology::all();
        $trainer = M_trainer::all();
        //untuk nama teknoloi dan trainer
        for ($i = 0; $i < count($batch); $i++) {
            $batch[$i]->technologyname = $batch[$i]->technology->name;
            $batch[$i]->trainername = $batch[$i]->trainer->name;
        }
        //jika ada ajax maka akan membuat datatables
        if ($request->ajax()) {
            return Datatables::of($batch)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editStory">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteStory">Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action', 'description','scope'])
                ->make(true);
        }


        return view('batch.index', compact('batch', 'technology','trainer'));
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
        //create atau update
        M_batch::updateOrCreate(
            ['id' => $request->id],
            [
                'batch_no' => '#'.$request->batch_no,
                'technology_id'=>$request->technology,
                'trainer_id'=>$request->trainer,
                'status'=>$request->status

            ]
        );

        return response()->json(['success' => 'Batch saved successfully.']);
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
        //data untuk memunculkan modal edit
        $batch = M_batch::find($id);
        return response()->json($batch);
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
        //delete batch
        M_batch::find($id)->delete();

        return response()->json(['success' => 'Batch deleted successfully.']);
    }
}
