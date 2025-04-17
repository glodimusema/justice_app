<?php

namespace App\Http\Controllers\Juridiction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Juridiction\{tjur_categorie_juridiction};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;


class tjur_categorie_juridictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;



    public function index(Request $request)
    {
        $data = DB::table("tjur_categorie_juridiction")
        ->select("tjur_categorie_juridiction.id", "tjur_categorie_juridiction.nom_categorie_jur",
        "tjur_categorie_juridiction.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tjur_categorie_juridiction.nom_categorie_jur', 'like', '%'.$query.'%')
            ->orderBy("tjur_categorie_juridiction.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tjur_categorie_juridiction_2()
    {
         $data = DB::table("tjur_categorie_juridiction")
         ->select("tjur_categorie_juridiction.id", "tjur_categorie_juridiction.nom_categorie_jur",
         "tjur_categorie_juridiction.created_at")
        ->get();
        
        return response()->json(['data' => $data]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     // tjur_categorie_juridiction
// nom_categorie_jur
// active

    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tjur_categorie_juridiction::where("id", $request->id)->update([
                'nom_categorie_jur' =>  $request->nom_categorie_jur
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tjur_categorie_juridiction::create([
                'nom_categorie_jur' =>  $request->nom_categorie_jur
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
        $data = tjur_categorie_juridiction::where('id', $id)->get();
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
        $data = tjur_categorie_juridiction::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
