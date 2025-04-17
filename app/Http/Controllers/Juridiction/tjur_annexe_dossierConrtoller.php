<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Personnel\tjur_annexe_dossier;  
use App\Traits\{GlobalMethod,Slug};
use DB;

class tjur_annexe_dossierConrtoller extends Controller
{
    use GlobalMethod, Slug  ;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    {    
        if (!is_null($request->get('query'))) {
            # code..s.
            //'id','noms_annexe','id_dossier','annexe','author'
            $query = $this->Gquery($request);
            $data = DB::table('tjur_annexe_dossier')
            ->join('tjur_dossier','tjur_dossier.id','=','tjur_annexe_dossier.id_dossier')
            ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
            ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
    
            ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')
    
            ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
            ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
            
            ->select("tjur_annexe_dossier.id","noms_annexe","id_dossier","annexe","tjur_annexe_dossier.author"
                //DOSSIER
                ,'date_ouverture','objets_dossier','id_categorie_dossier',
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
            ->where([
                ['noms_annexe', 'like', '%'.$query.'%']
            ])               
            ->orderBy("tjur_annexe_dossier.id", "desc")          
            ->paginate(10);

            return response($data, 200);
           

        }
        else{
            $data = DB::table('tjur_annexe_dossier')
            ->join('tjur_dossier','tjur_dossier.id','=','tjur_annexe_dossier.id_dossier')
            ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
            ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
    
            ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')
    
            ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
            ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
            
            ->select("tjur_annexe_dossier.id","noms_annexe","id_dossier","annexe","tjur_annexe_dossier.author"
                //DOSSIER
                ,'date_ouverture','objets_dossier','id_categorie_dossier',
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
            ->orderBy("tjur_annexe_dossier.id", "desc")          
            ->paginate(10);


            return response($data, 200);
        }

    }


    public function fetch_annexe_data(Request $request,$id_dossier)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tjur_annexe_dossier')
            ->join('tjur_dossier','tjur_dossier.id','=','tjur_annexe_dossier.id_dossier')
            ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
            ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
    
            ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')
    
            ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
            ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
            
            ->select("tjur_annexe_dossier.id","noms_annexe","id_dossier","annexe","tjur_annexe_dossier.author"
                //DOSSIER
                ,'date_ouverture','objets_dossier','id_categorie_dossier',
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
            ->where([
                ['noms_annexe', 'like', '%'.$query.'%'],
                ['id_dossier',$id_dossier]
            ])                    
            ->orderBy("tjur_annexe_dossier.id", "desc")
            ->paginate(10);

            return response($data, 200);          

        }
        else{
      
            $data = DB::table('tjur_annexe_dossier')
            ->join('tjur_dossier','tjur_dossier.id','=','tjur_annexe_dossier.id_dossier')
            ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
            ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  
    
            ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')
    
            ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
            ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
            
            ->select("tjur_annexe_dossier.id","noms_annexe","id_dossier","annexe","tjur_annexe_dossier.author"
                //DOSSIER
                ,'date_ouverture','objets_dossier','id_categorie_dossier',
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
            ->Where('tjur_annexe_dossier.id_dossier',$id_dossier)    
            ->orderBy("tjur_annexe_dossier.id", "desc")
            ->paginate(10);

            return response($data, 200);          
 
        }

    } 
    

    function fetch_single($id)
    {

        $data = DB::table('tjur_annexe_dossier')
        ->join('tjur_dossier','tjur_dossier.id','=','tjur_annexe_dossier.id_dossier')
        ->join('tvente_client','tvente_client.id','=','tjur_dossier.id_inculpe')
        ->join('tvente_categorie_client','tvente_categorie_client.id','=','tvente_client.refCategieClient')  

        ->join('tjur_categorie_dossier','tjur_categorie_dossier.id','=','tjur_dossier.id_categorie_dossier')

        ->join('tvente_fournisseur','tvente_fournisseur.id','=','tjur_dossier.id_plaignant')
        ->join('tvente_categorie_fournisseur','tvente_categorie_fournisseur.id','=','tvente_fournisseur.refCategorieFss')
        
        ->select("tjur_annexe_dossier.id","noms_annexe","id_dossier","annexe","tjur_annexe_dossier.author"
            //DOSSIER
            ,'date_ouverture','objets_dossier','id_categorie_dossier',
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
        ->where('tjur_annexe_dossier.id', $id)
        ->get();

        return response()->json([
            'data'  => $data
        ]);
    }



    function insert_data(Request $request)
    {
        ////'id','noms_annexe','id_dossier','annexe','author'
        if (!is_null($request->image)) 
        {
           $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName); 

  
            $data= tjur_annexe_dossier::create([
                'noms_annexe'       =>  $formData->noms_annexe,
                'id_dossier'       =>  $formData->id_dossier,
                'annexe'    =>  $imageName,
                'author'  =>  $formData->author        
            ]);
   
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
        }
        else{
           $formData = json_decode($_POST['data']);
           $data= tjur_annexe_dossier::create([
                'noms_annexe'       =>  $formData->noms_annexe,
                'id_dossier'       =>  $formData->id_dossier,
                'annexe'    =>  'avatar.png',
                'author'  =>  $formData->author        
           ]);
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
   
        }

    }


    function update_data(Request $request, $id)
    {
        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName);
         
           $data= tjur_annexe_dossier::where('id',$formData->id)->update([
                'noms_annexe'       =>  $formData->noms_annexe,
                'id_dossier'       =>  $formData->id_dossier,
                'annexe'    =>  $imageName,
                'author'  =>  $formData->author       
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
        }
        else{
            $formData = json_decode($_POST['data']);
            $data= tjur_annexe_dossier::where('id',$formData->id)->update([
                'noms_annexe'       =>  $formData->noms_annexe,
                'id_dossier'       =>  $formData->id_dossier,
                'annexe'    =>  'avatar.png',
                'author'  =>  $formData->author 
            ]);
   
            return response()->json([
               'data'  =>  "Modification avec succès!!",
           ]);
    
   
        }
       }


    function delete_data($id)
    {
        $data = tjur_annexe_dossier::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
