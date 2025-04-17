<?php

namespace App\Http\Controllers\Juridiction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Juridiction\{tjur_suivi_tribunal};
use App\Traits\{GlobalMethod,Slug};
use DB;
use Illuminate\Support\Facades\Type;
use Carbon\Carbon;

use App\User;
use App\Message;


class tjur_suivi_tribunalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;

    //'id','id_tribunal','date_liberte','date_prononce','author','refUser' tjur_suivi_tribunal

    public function index(Request $request)
    {
        $data = DB::table("tjur_suivi_tribunal")
        ->join('tjur_tribunal','tjur_tribunal.id','=','tjur_suivi_tribunal.id_tribunal')
        ->join('users as user_president','user_president.id','=','tjur_tribunal.id_president')
        ->join('tjur_arrestation','tjur_arrestation.id','=','tjur_tribunal.id_arrestation')
        ->join('tjur_attribution_dossier','tjur_attribution_dossier.id','=','tjur_arrestation.id_attribution_jur')

        ->join('tjur_dossier','tjur_dossier.id','=','tjur_attribution_dossier.id_dossier')

        ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  

        ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')

        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')

        ->join('tjur_affect_juridiction','tjur_affect_juridiction.id','=','tjur_attribution_dossier.id_affectation_jur')

        ->join('users as user_juge','user_juge.id','=','tjur_affect_juridiction.id_user')
          
         ->join('villes','villes.id','=','tjur_affect_juridiction.id_ville')
         ->join('provinces','provinces.id','=','villes.idProvince')
         ->join('pays','pays.id','=','provinces.idPays')
         
         ->join('tjur_juridiction','tjur_juridiction.id','=','tjur_affect_juridiction.id_juridiction')
         ->join('tjur_type_juridiction','tjur_type_juridiction.id','=','tjur_juridiction.id_type_jur')
         ->join('tjur_categorie_juridiction','tjur_categorie_juridiction.id','=','tjur_juridiction.id_categorie_jur')

        ->select("tjur_suivi_tribunal.id",'id_tribunal','date_liberte','date_prononce',
        'tjur_suivi_tribunal.author','tjur_suivi_tribunal.refUser','tjur_suivi_tribunal.created_at',
        //TRIBUNAL
        'id_president','id_arrestation','accompagne1','fonction1','accompagne2','fonction2',
        //ARRESTATION
        'id_attribution_jur','date_arretation','motif_arrestation',
        'statut_map','statut_odp','oc1','oc2','oc3','date_fin_oc1','date_fin_oc2','date_fin_oc3',
        'date_relaxe','date_requete_liberte','date_liberte_provisoire','montant_liberte_prov',
        'bordereau_liberte_prov','date_classement','motif_classement','date_envoie_fixation',
        'statut_arrestation',        
        //ATTRIBUTION DOSSIER
        'id_dossier','id_affectation_jur','date_map',
        'avocat_plaignant','avocat_inculpe','rapport_enquete','decision_statut',
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
         //USER juge
         'user_juge.avatar as avatar_juge','user_juge.name as name_juge','user_juge.email as email_juge',
         'user_juge.id_role as id_role_juge','user_juge.sexe as sexe_juge',
         'user_juge.telephone as telephone_juge','user_juge.adresse as adresse_juge',
         'user_juge.active as active_juge',
          //USER PRESIDENT
          'user_president.avatar as avatar_president','user_president.name as name_president',
          'user_president.email as email_president','user_president.id_role as id_role_president',
          'user_president.sexe as sexe_president','user_president.telephone as telephone_president',
          'user_president.adresse as adresse_president','user_president.active as active_president',
         //VILLE
         'villes.nomVille','villes.idProvince','provinces.nomProvince','provinces.idPays','pays.nomPays'
         //JURIDICTION
         , "tjur_juridiction.nom_jur","tjur_juridiction.code_jur",'tjur_juridiction.id_type_jur',
         "tjur_juridiction.id_categorie_jur"
         
         ,"tjur_type_juridiction.nom_type_jur", "tjur_categorie_juridiction.nom_categorie_jur");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tvente_client.noms', 'like', '%'.$query.'%')
            ->orWhere('tvente_fournisseur.noms', 'like', '%'.$query.'%')
            ->orWhere('tjur_juridiction.nom_jur', 'like', '%'.$query.'%')
            ->orderBy("tjur_suivi_tribunal.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }


    function fetch_tjur_suivi_tribunal_2()
    {
         $data = DB::table("tjur_suivi_tribunal")
         ->join('tjur_tribunal','tjur_tribunal.id','=','tjur_suivi_tribunal.id_tribunal')
         ->join('users as user_president','user_president.id','=','tjur_tribunal.id_president')
         ->join('tjur_arrestation','tjur_arrestation.id','=','tjur_tribunal.id_arrestation')
         ->join('tjur_attribution_dossier','tjur_attribution_dossier.id','=','tjur_arrestation.id_attribution_jur')
 
         ->join('tjur_dossier','tjur_dossier.id','=','tjur_attribution_dossier.id_dossier')
 
         ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
         ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
 
         ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')
 
         ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
         ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
 
         ->join('tjur_affect_juridiction','tjur_affect_juridiction.id','=','tjur_attribution_dossier.id_affectation_jur')
 
         ->join('users as user_juge','user_juge.id','=','tjur_affect_juridiction.id_user')
           
          ->join('villes','villes.id','=','tjur_affect_juridiction.id_ville')
          ->join('provinces','provinces.id','=','villes.idProvince')
          ->join('pays','pays.id','=','provinces.idPays')
          
          ->join('tjur_juridiction','tjur_juridiction.id','=','tjur_affect_juridiction.id_juridiction')
          ->join('tjur_type_juridiction','tjur_type_juridiction.id','=','tjur_juridiction.id_type_jur')
          ->join('tjur_categorie_juridiction','tjur_categorie_juridiction.id','=','tjur_juridiction.id_categorie_jur')
 
         ->select("tjur_suivi_tribunal.id",'id_tribunal','date_liberte','date_prononce',
         'tjur_suivi_tribunal.author','tjur_suivi_tribunal.refUser','tjur_suivi_tribunal.created_at',
         //TRIBUNAL
         'id_president','id_arrestation','accompagne1','fonction1','accompagne2','fonction2',
         //ARRESTATION
         'id_attribution_jur','date_arretation','motif_arrestation',
         'statut_map','statut_odp','oc1','oc2','oc3','date_fin_oc1','date_fin_oc2','date_fin_oc3',
         'date_relaxe','date_requete_liberte','date_liberte_provisoire','montant_liberte_prov',
         'bordereau_liberte_prov','date_classement','motif_classement','date_envoie_fixation',
         'statut_arrestation',        
         //ATTRIBUTION DOSSIER
         'id_dossier','id_affectation_jur','date_map',
         'avocat_plaignant','avocat_inculpe','rapport_enquete','decision_statut',
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
          //USER juge
          'user_juge.avatar as avatar_juge','user_juge.name as name_juge','user_juge.email as email_juge',
          'user_juge.id_role as id_role_juge','user_juge.sexe as sexe_juge',
          'user_juge.telephone as telephone_juge','user_juge.adresse as adresse_juge',
          'user_juge.active as active_juge',
           //USER PRESIDENT
           'user_president.avatar as avatar_president','user_president.name as name_president',
           'user_president.email as email_president','user_president.id_role as id_role_president',
           'user_president.sexe as sexe_president','user_president.telephone as telephone_president',
           'user_president.adresse as adresse_president','user_president.active as active_president',
          //VILLE
          'villes.nomVille','villes.idProvince','provinces.nomProvince','provinces.idPays','pays.nomPays'
          //JURIDICTION
          , "tjur_juridiction.nom_jur","tjur_juridiction.code_jur",'tjur_juridiction.id_type_jur',
          "tjur_juridiction.id_categorie_jur"
          
          ,"tjur_type_juridiction.nom_type_jur", "tjur_categorie_juridiction.nom_categorie_jur")
          ->selectRaw("CONCAT('Plaignant : ',tvente_fournisseur.noms,' - Inculpé : ',tvente_client.noms,' Date Arrestation :',DATE_FORMAT(date_arretation,'%d/%M/%Y'), 'Majustrat Affecté : ',user_juge.name,'President Affecté',user_president.name,'Date liberté',DATE_FORMAT(date_liberte,'%d/%M/%Y')) as data_jur")
          ->get();
        
        return response()->json(['data' => $data]);

    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if ($request->id !='') 
        {           
            # code...
            // update 
            $data = tjur_suivi_tribunal::where("id", $request->id)->update([
                'id_tribunal'=>  $request->id_tribunal,
                'date_liberte'=>  $request->date_liberte,
                'date_prononce'=>  $request->date_prononce,
                'author'=>  $request->author,
                'refUser' =>  $request->refUser
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tjur_suivi_tribunal::create([
                'id_tribunal'=>  $request->id_tribunal,
                'date_liberte'=>  $request->date_liberte,
                'date_prononce'=>  $request->date_prononce,
                'author'=>  $request->author,
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
        $data = DB::table("tjur_suivi_tribunal")
        ->join('tjur_tribunal','tjur_tribunal.id','=','tjur_suivi_tribunal.id_tribunal')
        ->join('users as user_president','user_president.id','=','tjur_tribunal.id_president')
        ->join('tjur_arrestation','tjur_arrestation.id','=','tjur_tribunal.id_arrestation')
        ->join('tjur_attribution_dossier','tjur_attribution_dossier.id','=','tjur_arrestation.id_attribution_jur')

        ->join('tjur_dossier','tjur_dossier.id','=','tjur_attribution_dossier.id_dossier')

        ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  

        ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')

        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')

        ->join('tjur_affect_juridiction','tjur_affect_juridiction.id','=','tjur_attribution_dossier.id_affectation_jur')

        ->join('users as user_juge','user_juge.id','=','tjur_affect_juridiction.id_user')
          
         ->join('villes','villes.id','=','tjur_affect_juridiction.id_ville')
         ->join('provinces','provinces.id','=','villes.idProvince')
         ->join('pays','pays.id','=','provinces.idPays')
         
         ->join('tjur_juridiction','tjur_juridiction.id','=','tjur_affect_juridiction.id_juridiction')
         ->join('tjur_type_juridiction','tjur_type_juridiction.id','=','tjur_juridiction.id_type_jur')
         ->join('tjur_categorie_juridiction','tjur_categorie_juridiction.id','=','tjur_juridiction.id_categorie_jur')

        ->select("tjur_suivi_tribunal.id",'id_tribunal','date_liberte','date_prononce',
        'tjur_suivi_tribunal.author','tjur_suivi_tribunal.refUser','tjur_suivi_tribunal.created_at',
        //TRIBUNAL
        'id_president','id_arrestation','accompagne1','fonction1','accompagne2','fonction2',
        //ARRESTATION
        'id_attribution_jur','date_arretation','motif_arrestation',
        'statut_map','statut_odp','oc1','oc2','oc3','date_fin_oc1','date_fin_oc2','date_fin_oc3',
        'date_relaxe','date_requete_liberte','date_liberte_provisoire','montant_liberte_prov',
        'bordereau_liberte_prov','date_classement','motif_classement','date_envoie_fixation',
        'statut_arrestation',        
        //ATTRIBUTION DOSSIER
        'id_dossier','id_affectation_jur','date_map',
        'avocat_plaignant','avocat_inculpe','rapport_enquete','decision_statut',
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
         //USER juge
         'user_juge.avatar as avatar_juge','user_juge.name as name_juge','user_juge.email as email_juge',
         'user_juge.id_role as id_role_juge','user_juge.sexe as sexe_juge',
         'user_juge.telephone as telephone_juge','user_juge.adresse as adresse_juge',
         'user_juge.active as active_juge',
          //USER PRESIDENT
          'user_president.avatar as avatar_president','user_president.name as name_president',
          'user_president.email as email_president','user_president.id_role as id_role_president',
          'user_president.sexe as sexe_president','user_president.telephone as telephone_president',
          'user_president.adresse as adresse_president','user_president.active as active_president',
         //VILLE
         'villes.nomVille','villes.idProvince','provinces.nomProvince','provinces.idPays','pays.nomPays'
         //JURIDICTION
         , "tjur_juridiction.nom_jur","tjur_juridiction.code_jur",'tjur_juridiction.id_type_jur',
         "tjur_juridiction.id_categorie_jur"
         
         ,"tjur_type_juridiction.nom_type_jur", "tjur_categorie_juridiction.nom_categorie_jur")
         ->where('tjur_suivi_tribunal.id', $id)
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
        $data = tjur_suivi_tribunal::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
