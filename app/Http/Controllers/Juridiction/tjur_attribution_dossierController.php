<?php

namespace App\Http\Controllers\Juridiction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Juridiction\{tjur_attribution_dossier};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

// 'id','id_dossier','id_affectation_jur','date_map',
 //    'avocat_plaignant','avocat_inculpe','rapport_enquete','decision_statut','author','refUser'
//tjur_attribution_dossier


class tjur_attribution_dossierController extends Controller
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
        $data = DB::table("tjur_attribution_dossier")

        ->join('tjur_dossier','tjur_dossier.id','=','tjur_attribution_dossier.id_dossier')

        ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  

        ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')

        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')

        ->join('tjur_affect_juridiction','tjur_affect_juridiction.id','=','tjur_attribution_dossier.id_affectation_jur')

        ->join('users','users.id','=','tjur_affect_juridiction.id_user')
         ->join('roles','users.id_role','=','roles.id')
 
         ->join('villes','villes.id','=','tjur_affect_juridiction.id_ville')
         ->join('provinces','provinces.id','=','villes.idProvince')
         ->join('pays','pays.id','=','provinces.idPays')
         
         ->join('tjur_juridiction','tjur_juridiction.id','=','tjur_affect_juridiction.id_juridiction')
         ->join('tjur_type_juridiction','tjur_type_juridiction.id','=','tjur_juridiction.id_type_jur')
         ->join('tjur_categorie_juridiction','tjur_categorie_juridiction.id','=','tjur_juridiction.id_categorie_jur')

        ->select("tjur_attribution_dossier.id",'id_dossier','id_affectation_jur','date_map',
        'avocat_plaignant','avocat_inculpe','rapport_enquete','decision_statut',
        'tjur_attribution_dossier.author','tjur_attribution_dossier.refUser',
        "tjur_attribution_dossier.created_at",
        //LE DOSSIER
        'date_ouverture','objets_dossier','id_categorie_dossier','id_plaignant','id_inculpe',        
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

        //AFFECTATION JURIDICTION
        , "tjur_affect_juridiction.id_user",
         "tjur_affect_juridiction.id_juridiction",'tjur_affect_juridiction.id_ville',         
         //USER
         'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
         'users.sexe','users.telephone','users.adresse','users.active',
         //VILLE
         'villes.nomVille','villes.idProvince','provinces.nomProvince','provinces.idPays','pays.nomPays'
         //JURIDICTION
         , "tjur_juridiction.nom_jur","tjur_juridiction.code_jur",'tjur_juridiction.id_type_jur',
         "tjur_juridiction.id_categorie_jur"
         
         ,"tjur_type_juridiction.nom_type_jur", "tjur_categorie_juridiction.nom_categorie_jur"
        );

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_client.noms', 'like', '%'.$query.'%')
            ->orWhere('tvente_fournisseur.noms', 'like', '%'.$query.'%')
            ->orWhere('tjur_juridiction.nom_jur', 'like', '%'.$query.'%')
            ->orderBy("tjur_attribution_dossier.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tjur_attribution_dossier_2()
    {
         $data = DB::table("tjur_attribution_dossier")

         ->join('tjur_dossier','tjur_dossier.id','=','tjur_attribution_dossier.id_dossier')
 
         ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
 
         ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')
 
         ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
         ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
 
         ->join('tjur_affect_juridiction','tjur_affect_juridiction.id','=','tjur_attribution_dossier.id_affectation_jur')
 
         ->join('users','users.id','=','tjur_affect_juridiction.id_user')
          ->join('roles','users.id_role','=','roles.id')
  
          ->join('villes','villes.id','=','tjur_affect_juridiction.id_ville')
          ->join('provinces','provinces.id','=','villes.idProvince')
          ->join('pays','pays.id','=','provinces.idPays')
          
          ->join('tjur_juridiction','tjur_juridiction.id','=','tjur_affect_juridiction.id_juridiction')
          ->join('tjur_type_juridiction','tjur_type_juridiction.id','=','tjur_juridiction.id_type_jur')
          ->join('tjur_categorie_juridiction','tjur_categorie_juridiction.id','=','tjur_juridiction.id_categorie_jur')
 
         ->select("tjur_attribution_dossier.id",'id_dossier','id_affectation_jur','date_map',
         'avocat_plaignant','avocat_inculpe','rapport_enquete','decision_statut',
         'tjur_attribution_dossier.author','tjur_attribution_dossier.refUser',
         "tjur_attribution_dossier.created_at",
         //LE DOSSIER
         'date_ouverture','objets_dossier','id_categorie_dossier','id_plaignant','id_inculpe',        
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
 
         //AFFECTATION JURIDICTION
         , "tjur_affect_juridiction.id_user",
          "tjur_affect_juridiction.id_juridiction",'tjur_affect_juridiction.id_ville',         
          //USER
          'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
          'users.sexe','users.telephone','users.adresse','users.active',
          //VILLE
          'villes.nomVille','villes.idProvince','provinces.nomProvince','provinces.idPays','pays.nomPays'
          //JURIDICTION
          , "tjur_juridiction.nom_jur","tjur_juridiction.code_jur",'tjur_juridiction.id_type_jur',
          "tjur_juridiction.id_categorie_jur"
          
          ,"tjur_type_juridiction.nom_type_jur", "tjur_categorie_juridiction.nom_categorie_jur"
         )
         ->selectRaw("CONCAT('Plaignant : ',tvente_fournisseur.noms,' - Inculpé : ',tvente_client.noms,' Date Ouverture :',DATE_FORMAT(date_ouverture,'%d/%M/%Y'), 'Majustrat Affecté : ',users.name) as data_jur")
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

            // 'id','id_dossier','id_affectation_jur','date_map',
    // 'avocat_plaignant','avocat_inculpe','rapport_enquete','decision_statut','author','refUser'
            # code...
            // update 
            $data = tjur_attribution_dossier::where("id", $request->id)->update([
                'id_dossier' =>  $request->id_dossier,
                'id_affectation_jur' =>  $request->id_affectation_jur,
                'date_map' =>  $request->date_map,
                'avocat_plaignant' =>  $request->avocat_plaignant,
                'avocat_inculpe' =>  $request->avocat_inculpe,
                'rapport_enquete' =>  $request->rapport_enquete,
                'decision_statut' =>  $request->decision_statut,
                'author' =>  $request->author,
                'refUser' =>  $request->refUser
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tjur_attribution_dossier::create([
                'id_dossier' =>  $request->id_dossier,
                'id_affectation_jur' =>  $request->id_affectation_jur,
                'date_map' =>  $request->date_map,
                'avocat_plaignant' =>  $request->avocat_plaignant,
                'avocat_inculpe' =>  $request->avocat_inculpe,
                'rapport_enquete' =>  $request->rapport_enquete,
                'decision_statut' =>  $request->decision_statut,
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
        $data = DB::table("tjur_attribution_dossier")

        ->join('tjur_dossier','tjur_dossier.id','=','tjur_attribution_dossier.id_dossier')

        ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  

        ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')

        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')

        ->join('tjur_affect_juridiction','tjur_affect_juridiction.id','=','tjur_attribution_dossier.id_affectation_jur')

        ->join('users','users.id','=','tjur_affect_juridiction.id_user')
         ->join('roles','users.id_role','=','roles.id')
 
         ->join('villes','villes.id','=','tjur_affect_juridiction.id_ville')
         ->join('provinces','provinces.id','=','villes.idProvince')
         ->join('pays','pays.id','=','provinces.idPays')
         
         ->join('tjur_juridiction','tjur_juridiction.id','=','tjur_affect_juridiction.id_juridiction')
         ->join('tjur_type_juridiction','tjur_type_juridiction.id','=','tjur_juridiction.id_type_jur')
         ->join('tjur_categorie_juridiction','tjur_categorie_juridiction.id','=','tjur_juridiction.id_categorie_jur')

        ->select("tjur_attribution_dossier.id",'id_dossier','id_affectation_jur','date_map',
        'avocat_plaignant','avocat_inculpe','rapport_enquete','decision_statut',
        'tjur_attribution_dossier.author','tjur_attribution_dossier.refUser',
        "tjur_attribution_dossier.created_at",
        //LE DOSSIER
        'date_ouverture','objets_dossier','id_categorie_dossier','id_plaignant','id_inculpe',        
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

        //AFFECTATION JURIDICTION
        , "tjur_affect_juridiction.id_user",
         "tjur_affect_juridiction.id_juridiction",'tjur_affect_juridiction.id_ville',         
         //USER
         'users.avatar','users.name','users.email','users.id_role','roles.nom as role_name',
         'users.sexe','users.telephone','users.adresse','users.active',
         //VILLE
         'villes.nomVille','villes.idProvince','provinces.nomProvince','provinces.idPays','pays.nomPays'
         //JURIDICTION
         , "tjur_juridiction.nom_jur","tjur_juridiction.code_jur",'tjur_juridiction.id_type_jur',
         "tjur_juridiction.id_categorie_jur"
         
         ,"tjur_type_juridiction.nom_type_jur", "tjur_categorie_juridiction.nom_categorie_jur"
        )
        ->where('tjur_attribution_dossier.id', $id)->get();
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
        $data = tjur_attribution_dossier::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
