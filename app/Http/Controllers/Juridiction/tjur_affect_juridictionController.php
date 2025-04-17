<?php

namespace App\Http\Controllers\Juridiction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Juridiction\{tjur_affect_juridiction};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

// 'id','id_user','id_juridiction','id_ville','author','refUser'
// tjur_affect_juridiction


class tjur_affect_juridictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;


    // 'id','id_user','id_juridiction','id_ville','author','refUser'



    public function index(Request $request)
    {
        $data = DB::table("tjur_affect_juridiction")
        ->join('users','users.id','=','tjur_affect_juridiction.id_user')
        ->join('roles','users.id_role','=','roles.id')

        ->join('villes','villes.id','=','tjur_affect_juridiction.id_ville')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->join('tjur_juridiction','tjur_juridiction.id','=','tjur_affect_juridiction.id_juridiction')
        ->join('tjur_type_juridiction','tjur_type_juridiction.id','=','tjur_juridiction.id_type_jur')
        ->join('tjur_categorie_juridiction','tjur_categorie_juridiction.id','=','tjur_juridiction.id_categorie_jur')

        ->select("tjur_affect_juridiction.id", "tjur_affect_juridiction.id_user",
        "tjur_affect_juridiction.id_juridiction",'tjur_affect_juridiction.id_ville',
        "tjur_affect_juridiction.author","tjur_affect_juridiction.refUser",
        "tjur_affect_juridiction.created_at",
        //USER
        'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
        'users.sexe','users.telephone','users.adresse','users.active',
        //VILLE
        'villes.nomVille','villes.idProvince','provinces.nomProvince','provinces.idPays','pays.nomPays'
        //JURIDICTION
        , "tjur_juridiction.nom_jur","tjur_juridiction.code_jur",'tjur_juridiction.id_type_jur',
        "tjur_juridiction.id_categorie_jur"
        
        ,"tjur_type_juridiction.nom_type_jur", "tjur_categorie_juridiction.nom_categorie_jur");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tjur_juridiction.nom_jur', 'like', '%'.$query.'%')
            ->orWhere('users.name', 'like', '%'.$query.'%')
            ->orWhere('villes.nomVille', 'like', '%'.$query.'%')
            ->orderBy("tjur_affect_juridiction.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tjur_affect_juridiction_2()
    {
         $data = DB::table("tjur_affect_juridiction")
         ->join('users','users.id','=','tjur_affect_juridiction.id_user')
         ->join('roles','users.id_role','=','roles.id')
 
         ->join('villes','villes.id','=','tjur_affect_juridiction.id_ville')
         ->join('provinces','provinces.id','=','villes.idProvince')
         ->join('pays','pays.id','=','provinces.idPays')
         
         ->join('tjur_juridiction','tjur_juridiction.id','=','tjur_affect_juridiction.id_juridiction')
         ->join('tjur_type_juridiction','tjur_type_juridiction.id','=','tjur_juridiction.id_type_jur')
         ->join('tjur_categorie_juridiction','tjur_categorie_juridiction.id','=','tjur_juridiction.id_categorie_jur')
 
         ->select("tjur_affect_juridiction.id", "tjur_affect_juridiction.id_user",
         "tjur_affect_juridiction.id_juridiction",'tjur_affect_juridiction.id_ville',
         "tjur_affect_juridiction.author","tjur_affect_juridiction.refUser",
         "tjur_affect_juridiction.created_at",
         //USER
         'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
         'users.sexe','users.telephone','users.adresse','users.active',
         //VILLE
         'villes.nomVille','villes.idProvince','provinces.nomProvince','provinces.idPays','pays.nomPays'
         //JURIDICTION
         , "tjur_juridiction.nom_jur","tjur_juridiction.code_jur",'tjur_juridiction.id_type_jur',
         "tjur_juridiction.id_categorie_jur"
         
         ,"tjur_type_juridiction.nom_type_jur", "tjur_categorie_juridiction.nom_categorie_jur")
         ->selectRaw("CONCAT(users.name,' - ',tjur_juridiction.nom_jur,' :',villes.nomVille) as data_jur")
        //  ->selectRaw("CONCAT(users.name,' - ',tjur_juridiction.nom_jur,' :',DATE_FORMAT(dateMouvement,'%d/%M/%Y'), '(' , ttypemouvement_malade.designation,')') as data_malade")
        ->get();
        
        return response()->json(['data' => $data]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     // tjur_affect_juridiction
// id_user
// active

    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            // 'id','id_user','id_juridiction','id_ville','',''
            # code...
            // update 
            $data = tjur_affect_juridiction::where("id", $request->id)->update([
                'id_user' =>  $request->id_user,
                'id_juridiction' =>  $request->id_juridiction,
                'id_ville' =>  $request->id_ville,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tjur_affect_juridiction::create([
                'id_user' =>  $request->id_user,
                'id_juridiction' =>  $request->id_juridiction,
                'id_ville' =>  $request->id_ville,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser
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
        $data = DB::table("tjur_affect_juridiction")
        ->join('users','users.id','=','tjur_affect_juridiction.id_user')
        ->join('roles','users.id_role','=','roles.id')

        ->join('villes','villes.id','=','tjur_affect_juridiction.id_ville')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->join('tjur_juridiction','tjur_juridiction.id','=','tjur_affect_juridiction.id_juridiction')
        ->join('tjur_type_juridiction','tjur_type_juridiction.id','=','tjur_juridiction.id_type_jur')
        ->join('tjur_categorie_juridiction','tjur_categorie_juridiction.id','=','tjur_juridiction.id_categorie_jur')

        ->select("tjur_affect_juridiction.id", "tjur_affect_juridiction.id_user",
        "tjur_affect_juridiction.id_juridiction",'tjur_affect_juridiction.id_ville',
        "tjur_affect_juridiction.author","tjur_affect_juridiction.refUser",
        "tjur_affect_juridiction.created_at",
        //USER
        'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
        'users.sexe','users.telephone','users.adresse','users.active',
        //VILLE
        'villes.nomVille','villes.idProvince','provinces.nomProvince','provinces.idPays','pays.nomPays'
        //JURIDICTION
        , "tjur_juridiction.nom_jur","tjur_juridiction.code_jur",'tjur_juridiction.id_type_jur',
        "tjur_juridiction.id_categorie_jur"
        
        ,"tjur_type_juridiction.nom_type_jur", "tjur_categorie_juridiction.nom_categorie_jur")
        ->where('tjur_affect_juridiction.id', $id)
        ->get();
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
        $data = tjur_affect_juridiction::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
