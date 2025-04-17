<?php

namespace App\Http\Controllers\Juridiction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Juridiction\{tjur_motif_classement};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

// tjur_motif_classement
// nom_motif
// active


class tjur_motif_classementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;


    //'id','nom_motif','','duree'



    public function index(Request $request)
    {
        $data = DB::table("tjur_motif_classement")
        ->select("tjur_motif_classement.id", "tjur_motif_classement.nom_motif",
        "tjur_motif_classement.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tjur_motif_classement.nom_motif', 'like', '%'.$query.'%')
            ->orderBy("tjur_motif_classement.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tjur_motif_classement_2()
    {
         $data = DB::table("tjur_motif_classement")
         ->select("tjur_motif_classement.id", "tjur_motif_classement.nom_motif",
         "tjur_motif_classement.created_at")
        ->get();
        
        return response()->json(['data' => $data]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     // tjur_motif_classement
// nom_motif
// active

    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tjur_motif_classement::where("id", $request->id)->update([
                'nom_motif' =>  $request->nom_motif
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tjur_motif_classement::create([
                'nom_motif' =>  $request->nom_motif
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
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
        $data = tjur_motif_classement::where('id', $id)->get();
        return response()->json(['data' => $data]);
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = tjur_motif_classement::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
