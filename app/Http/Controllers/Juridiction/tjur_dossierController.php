<?php

namespace App\Http\Controllers\Juridiction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Juridiction\{tjur_dossier};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

// 'id','id_user','id_juridiction','id_ville','author','refUser'
// tjur_dossier


class tjur_dossierController extends Controller
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
        $data = DB::table("tjur_dossier")
        ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  

        ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')

        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')

        ->select("tjur_dossier.id",'date_ouverture','objets_dossier','id_categorie_dossier',
        'id_plaignant','id_inculpe',"tjur_dossier.author","tjur_dossier.refUser",
        "tjur_dossier.created_at",
        //CATEGORIE DOSSIER
        "tjur_categorie_dossier.nom_categorie_dossier","code_categorie_dossier",
        'tjur_categorie_dossier.duree' 
        //PLAIGNANT 
        ,"tvente_fournisseur.noms as noms_fss","tvente_fournisseur.contact as contact_fss",
        "tvente_fournisseur.mail as mail_fss","tvente_fournisseur.adresse as adresse_fss",'refCategorieFss', 
        "tvente_categorie_fournisseur.nom_categoriefss"   
        //INCULPE
        ,'tvente_client.noms as noms_client','tvente_client.sexe as sexe_client',
        'tvente_client.contact as contact_client','tvente_client.mail as mail_client',
        'tvente_client.adresse as adresse_client','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
        ,"tvente_categorie_client.designation"
        );

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_client.noms', 'like', '%'.$query.'%')
            ->orWhere('tvente_fournisseur.noms', 'like', '%'.$query.'%')
            ->orderBy("tjur_dossier.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tjur_dossier_2()
    {
         $data = DB::table("tjur_dossier")
         ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
 
         ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')
 
         ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
         ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
 
         ->select("tjur_dossier.id",'date_ouverture','objets_dossier','id_categorie_dossier',
         'id_plaignant','id_inculpe',"tjur_dossier.author","tjur_dossier.refUser",
         "tjur_dossier.created_at",
         //CATEGORIE DOSSIER
         "tjur_categorie_dossier.nom_categorie_dossier","code_categorie_dossier",
         'tjur_categorie_dossier.duree' 
         //PLAIGNANT 
         ,"tvente_fournisseur.noms as noms_fss","tvente_fournisseur.contact as contact_fss",
         "tvente_fournisseur.mail as mail_fss","tvente_fournisseur.adresse as adresse_fss",'refCategorieFss', 
         "tvente_categorie_fournisseur.nom_categoriefss"   
         //INCULPE
         ,'tvente_client.noms as noms_client','tvente_client.sexe as sexe_client',
         'tvente_client.contact as contact_client','tvente_client.mail as mail_client',
         'tvente_client.adresse as adresse_client','pieceidentite','numeroPiece','dateLivrePiece',
         'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
         'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
         ,"tvente_categorie_client.designation")
         ->selectRaw("CONCAT('Plaignant : ',tvente_fournisseur.noms,' - Inculpé : ',tvente_client.noms,' Date Ouverture :',DATE_FORMAT(date_ouverture,'%d/%M/%Y')) as data_jur")
        ->get();
        
        return response()->json(['data' => $data]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     // tjur_dossier
// id_user
// active

    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tjur_dossier::where("id", $request->id)->update([
                'date_ouverture' =>  $request->date_ouverture,
                'objets_dossier' =>  $request->objets_dossier,
                'id_categorie_dossier' =>  $request->id_categorie_dossier,
                'id_plaignant' =>  $request->id_plaignant,
                'id_inculpe' =>  $request->id_inculpe,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tjur_dossier::create([
                'date_ouverture' =>  $request->date_ouverture,
                'objets_dossier' =>  $request->objets_dossier,
                'id_categorie_dossier' =>  $request->id_categorie_dossier,
                'id_plaignant' =>  $request->id_plaignant,
                'id_inculpe' =>  $request->id_inculpe,
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
        $data = DB::table("tjur_dossier")
        ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  

        ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')

        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')

        ->select("tjur_dossier.id",'date_ouverture','objets_dossier','id_categorie_dossier',
        'id_plaignant','id_inculpe',"tjur_dossier.author","tjur_dossier.refUser",
        "tjur_dossier.created_at",
        //CATEGORIE DOSSIER
        "tjur_categorie_dossier.nom_categorie_dossier","code_categorie_dossier",
        'tjur_categorie_dossier.duree' 
        //PLAIGNANT 
        ,"tvente_fournisseur.noms as noms_fss","tvente_fournisseur.contact as contact_fss",
        "tvente_fournisseur.mail as mail_fss","tvente_fournisseur.adresse as adresse_fss",'refCategorieFss', 
        "tvente_categorie_fournisseur.nom_categoriefss"   
        //INCULPE
        ,'tvente_client.noms as noms_client','tvente_client.sexe as sexe_client',
        'tvente_client.contact as contact_client','tvente_client.mail as mail_client',
        'tvente_client.adresse as adresse_client','pieceidentite','numeroPiece','dateLivrePiece',
        'lieulivraisonCarte','nationnalite','datenaissance','lieunaissance','profession','occupation',
        'nombreEnfant','dateArriverGoma','arriverPar','refCategieClient','photo','slug'
        ,"tvente_categorie_client.designation"
        )
        ->where('tjur_dossier.id', $id)
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
        $data = tjur_dossier::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
