<template>
    
    <v-layout>
        <v-flex md12>

            <VenteDetailCuisine ref="VenteDetailCuisine" />
            <CommandeCusisine ref="CommandeCusisine" />
            <ModelClient ref="ModelClient" />

            <v-dialog v-model="dialog2" max-width="600px" persistent>
                <v-card :loading="loading">
                <v-form ref="form" lazy-validation>
                    <v-card-title>
                    La Reservation de la Chambre <v-spacer></v-spacer>
                    <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                            <v-btn @click="dialog2 = false" text fab depressed>
                            <v-icon>close</v-icon>
                            </v-btn>
                        </span>
                        </template>
                        <span>Fermer</span>
                    </v-tooltip>
                    </v-card-title>
                    <v-card-text> 

                    <v-autocomplete label="Selectionnez la Resérvation de la Chambre" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="chambreList" item-text="designationReservation"
                        item-value="id" dense outlined v-model="svData.refReservation" chips clearable>
                    </v-autocomplete>

                    </v-card-text>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
                    <v-btn color="  blue" dark :loading="loading" @click="validateRes">
                        {{ edit ? "Modifier" : "Ajouter" }}
                    </v-btn>
                    </v-card-actions>
                </v-form>
                </v-card>
            </v-dialog>

            <v-form ref="form" v-model="valid" lazy-validation>

            <v-layout row wrap>                
                <v-flex xs12 sm12 md4 lg4>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Client" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="clientList" item-text="noms"
                            item-value="id" outlined dense v-model="svData.refClient">
                        </v-autocomplete>
                    </div>
                </v-flex> 
                <v-flex xs1 sm1 md1 lg1>
                    <div class="mr-1">
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="refreshData()" color="primary" :loading="loading"
                                        dark x-small fab depressed>
                                        <v-icon dark>refresh</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Recharger la liste</span>
                        </v-tooltip>

                    </div>
              </v-flex>
              <v-flex xs1 sm1 md1 lg1>
                    <div class="mr-1">
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="
                                        showClient()
                                        " fab x-small color="primary" dark>
                                        <v-icon>add</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Ajouter une Client</span>
                        </v-tooltip>
                    </div>
              </v-flex> 

                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                            item-value="refService" dense outlined v-model="svData.refService" chips clearable 
                             @change="get_produit_for_service(svData.refService)">
                        </v-autocomplete>
                    </div>
                </v-flex>


                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-text-field type="date" label="Date Vente" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateVente">
                        </v-text-field>
                    </div>
                </v-flex>
                <!-- <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-text-field label="Libellé" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle">
                        </v-text-field>
                    </div>
                </v-flex> -->

                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez la Devise" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="deviseList" item-text="designation"
                            item-value="designation" dense outlined v-model="svData.devise" chips clearable>
                        </v-autocomplete>
                    </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Serveur" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="serveurList" item-text="noms_agent"
                            item-value="id" dense outlined v-model="svData.serveur_id" chips clearable>
                        </v-autocomplete>
                    </div>
                </v-flex>


                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez la Table" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="tableList" item-text="nom_table"
                            item-value="id" dense outlined v-model="svData.table_id" chips clearable>
                        </v-autocomplete>
                    </div>
                </v-flex>
                <!-- <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-select label="Etat de Facture" :items="[
                            // { designation: 'Cash' },
                            // { designation: 'Compte Maison' },
                            // { designation: 'Chambre' },
                            { designation: 'Crédit' },
                            // { designation: 'Location' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            item-text="designation" item-value="designation" v-model="svData.estServie">
                        </v-select>
                    </div>
                </v-flex> -->
                

            </v-layout>

            <v-simple-table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Unité</th>
                        <th>Qté Dispo</th>
                        <th>Qté</th>
                        <th>Pu</th>
                        <th>Reduction</th>
                        <th>TVA</th>
                        <th>PT</th>
                        <th>TVA(%)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in svData.detailData" :key="index">
                        <td class="long-cell">
                            <v-autocomplete v-model="item.idStockService" :items="produitList"
                                label="Selectionnez le Produit" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="designation" item-value="id"
                                @change="updateUnite(index)"></v-autocomplete>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.nom_unite" label="Unité" readonly></v-text-field>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.qteDisponible" label="Qté Dispo" readonly></v-text-field>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.qteVente" type="number" label="Qté" :rules="[rules.required]"
                                required></v-text-field>
                        </td>
                        <td class="short-cell">
                            <v-text-field v-model="item.puVente" type="number" label="PU" :rules="[rules.required]"
                                required ></v-text-field>
                        </td>                      
                        <td class="short-cell">
                            <v-text-field v-model="item.montantreduction" type="number" label="Reduction"
                                :rules="[rules.required]" required></v-text-field>
                        </td>
                        <td class="medium-cell">
                            <v-autocomplete v-model="item.id_tva" :items="item.tvaList"
                                label="Selectionnez la TVA" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="libelle_tva" item-value="id" @change="updateTVA(index)"
                            ></v-autocomplete>                            
                        </td>
                        <td>{{ item.pt }}</td>
                        <td>{{ item.tva }}</td>
                        <td>
                            <v-btn @click="removeItem(index)" icon>
                                <v-icon color="red">mdi-delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-simple-table>

            <v-btn @click="addItem()" color="primary">Ajouter<v-icon color="white">mdi-cart-plus</v-icon></v-btn>
            <div style="text-align: right; margin-top: 20px;"><strong>Total HT : {{ svData.totalInvoice }} $</strong></div>
            <div style="text-align: right; margin-top: 20px;"><strong>TVA(%) : {{ svData.totalTVA }} $</strong></div>
            <div style="text-align: right; margin-top: 20px;"><strong>Total TTC : {{ svData.totalTTC }} $</strong></div>
            

            <table>
              <tr>
                  <td>
                      <!-- <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div> -->
                  </td>
                  <td>
                    <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div>
                    <v-progress-linear v-if="loadings" :value="progress" indeterminate color="green"></v-progress-linear>                    
                  </td>
              </tr>
          </table>
           
            

            <v-flex md12>
                <!-- <v-layout>
                    <v-flex md6>
                    <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                        rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                    </v-flex>
                    <v-flex md5>


                    </v-flex>
                    <v-flex md1>
                    <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                            <v-btn @click="dialog = true" fab color="  blue" dark>
                            <v-icon>add</v-icon>
                            </v-btn>
                        </span>
                        </template>
                        <span>Ajouter un Produit</span>
                    </v-tooltip>
                    </v-flex>
                </v-layout> -->
                <br />
                <v-card>
                    <v-card-text>
                    <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">Action</th>
                            <th class="text-left">N°Cmd</th>
                            <th class="text-left">DateCmdCuisine</th>
                            <th class="text-left">Service</th>
                            <th class="text-left">Client</th>
                            <th class="text-left">Téléphone</th>
                            <th class="text-left">Libellé</th>
                            <!-- <th class="text-left">Solde</th> -->
                            <th class="text-left">EstServie</th>
                            <th class="text-left">Author</th>
                            <th class="text-left">Created_at</th>                          
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                            <td>

                            <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                                </v-btn>
                            </template>

                            <v-list dense width="">                               

                                <v-list-item link @click="showDetailCuisine(item.id, item.noms,item.refService)">
                                <v-list-item-icon>
                                    <v-icon>mdi-cart-outline</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail Commande Cuisine
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="showCommande(item.id,item.noms,'Cuisine')">
                                <v-list-item-icon>
                                    <v-icon color="blue">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer le bon de Commande
                                </v-list-item-title>
                                </v-list-item> 
                                
                                <v-list-item link @click="editDataRes(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Affecter Reservation Chambre
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="editData(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="blue">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                                </v-list-item>

                                <v-list-item   
                                link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                    <v-icon color="  red">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Annuler la Facture
                                </v-list-item-title>
                                </v-list-item>

                            </v-list>
                            </v-menu>
                            </td>
                            <td>{{ item.id }}</td>
                            <td>{{ item.dateVente | formatDate }}</td>
                            <td>{{ item.nom_service }}</td>
                            <td>{{ item.noms }}</td>
                            <td>{{ item.contact }}</td>
                            <td>{{ item.libelle }}</td>
                            <!-- <td>{{ item.RestePaie }}$</td> -->
                            <td>{{ item.estServie }}</td>
                            <td>{{ item.author }}</td>
                            <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                            </td>                           
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>
                    <hr />

                    <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
                        @input="fetchDataList"></v-pagination>
                    </v-card-text>
                </v-card>
                </v-flex>

            </v-form>
        </v-flex>
    </v-layout>   
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import CommandeCusisine from '../Rapports/Finances/CommandeCusisine.vue';
import VenteDetailCuisine from './VenteDetailCuisine.vue';
import ModelClient from './ModelClient.vue';

export default {
    components:{
    VenteDetailCuisine,
    CommandeCusisine,
    ModelClient
  },
    data() {
        return {

            title: "Liste des Requisitions",
            dialog: false,
            dialog2: false,
            edit: false,
            loading: false,
            disabled: false,


            loadings: false,
            progress: 0,

            svData: {
                id: '',
                refClient: 0,
                refService: 0,
                dateVente: "",
                libelle: "",
                author: "",
                refUser: 0,
                totalInvoice:0,
                totalTVA:0,
                totalTTC:0,
                indexEncours:0,
                devise: "",
                serveur_id : 0,
                table_id : 0,
                estServie : "",

                refReservation:0,

                detailData: [{
                    qteDisponible: 0,
                    qteVente: 0,
                    puVente: 0,                    
                    montantreduction: 0,
                    pt:0,
                    tva:0,
                    montant_tva:0,
                    idStockService : 0,
                    nom_unite : '',
                    
                    uniteList: [],
                    tvaList: [],
                }],                
            },
            fetchData: [],
            produitList: [],
            clientList: [],
            moduleList: [],
            serviceList: [],
            CmdList: [],  
            deviseList: [],
            serveurList: [],
            chambreList: [],
            tableList: [],          

            query: "",

            valid: false,
            customerName: '',
            items: [{ name: '', description: '', quantity: 1, price: 0 }],            
            rules: {
                required: value => !!value || 'Required.',
            },
        };
    },
    created() {
        this.fetchDataList();
        this.fetchListClient();
        this.fetchListModule();
        this.fetchListService();
        this.fetchListDevise();
        this.fetchListTVA();
        this.fetchListServeur();
        this.fetchListTable();
        this.fetchListChambre();
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),   
    },
    methods: {
        addItem() {  
            this.updateTotal();         
            this.svData.detailData.push({                
                qteDisponible: 0,
                qteVente: 0,
                puVente: 0,
                devise: "",
                montantreduction: 0,
                idStockService : 0,
                pt:0,
                tva:0,
                montant_tva:0,
                id_tva:0,
                nom_unite : '',

                uniteList: [],
                tvaList: [],
            });
            this.fetchListTVA();
        },
       refreshData()
        {
            this.fetchListClient();
            this.get_produit_for_service(this.svData.refService);
        },
        async get_produit_for_service(refService) {
          this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/fetch_stock_data_byservice/${refService}`)
                .then((res) => {
                var chart = res.data.data;
                if (chart) {
                    this.produitList = chart;
                } else {
                    this.produitList = [];
                }
                this.isLoading(false);
                })
                .catch((err) => {
                this.errMsg();
                this.makeFalse();
                reject(err);
                });
        },
        async updateUnite(index) { 
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_service_stock/${this.svData.detailData[index].idStockService}`);
                    // Extract data from the response
                    const donnees = response.data.data;
                    // Assuming you want to get the first item
                    if (donnees.length > 0) {
                        this.svData.detailData[index].nom_unite = donnees[0].uniteBase; // Update price per unit
                        this.svData.detailData[index].puVente = donnees[0].cmup; // Update price per unit
                        this.svData.detailData[index].qteDisponible = donnees[0].qte; // Update available quantity
                    } else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                } 
        },
        async updateTVA(index)
            {
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_tva/${this.svData.detailData[index].id_tva}`);
                    // Extract data from the response
                    const donnees = response.data.data;
                    // Assuming you want to get the first item
                    if (donnees.length > 0) {
                        this.svData.detailData[index].montant_tva = donnees[0].montant_tva; // Update price per unit
                        this.svData.detailData[index].pt = ((this.svData.detailData[index].puVente *this.svData.detailData[index].qteVente) - this.svData.detailData[index].montantreduction); // Dummy price
                        this.svData.detailData[index].tva= ((this.svData.detailData[index].pt * this.svData.detailData[index].montant_tva)/100)
                    } else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                    // console.error('Error updating unit:', error);
                    // Handle error appropriately, e.g., show a notification
                } 
        },
        updatePT(index) {
            this.updateTVA(index);
            this.svData.detailData[index].pt = ((this.svData.detailData[index].puVente *this.svData.detailData[index].qteVente) - this.svData.detailData[index].montantreduction); // Dummy price
            this.svData.detailData[index].tva= ((this.svData.detailData[index].pt * this.svData.detailData[index].montant_tva)/100);

            // this.updateTotal(index);
        },
        updateTotal() {          

            this.svData.totalInvoice = this.svData.detailData.reduce((accumulator, current) => {
                return accumulator + current.pt;
            }, 0);

            this.svData.totalTVA = this.svData.detailData.reduce((accumulator, current) => {
                return accumulator + current.tva;
            }, 0);

            this.svData.totalTTC = this.svData.totalInvoice + this.svData.totalTVA;           
        },
        removeItem(index) {
            this.svData.totalInvoice = this.svData.totalInvoice - this.svData.detailData[index].pt;
            this.svData.totalTVA = this.svData.totalTVA - this.svData.detailData[index].tva;
            this.svData.totalTTC = this.svData.totalTTC - this.svData.detailData[index].pt - this.svData.detailData[index].tva;
            this.indexEncours = this.indexEncours - index;

            this.svData.detailData.splice(index, 1);
        },
        resetForm() {
                this.svData.detailData = [{
                    qteDisponible: 0,
                    qteVente: 0,
                    puVente: 0,                    
                    montantreduction: 0,
                    pt:0,
                    tva:0,
                    montant_tva:0,
                    idStockService : 0,
                    nom_unite : '',
            }];
            this.$refs.form.reset(); // Reset the form validation state            
            this.fetchListTVA();
        },
        validate() {


            try
            {
                this.loadings = true;
                this.progress = 0;

                // Simuler un processus d'enregistrement
                if (this.$refs.form.validate()) {
                this.isLoading(true);
                    this.svData.author = this.userData.name;
                    this.svData.refUser = this.userData.id;
                    this.insertOrUpdate(
                    `${this.apiBaseURL}/insert_vente_global_cuisine`,
                    JSON.stringify(this.svData)
                    )
                    .then(({ data }) => {
                        this.showMsg(data.data);
                        this.isLoading(false);
                        this.edit = false;
                        this.dialog = false;
                        this.resetObj(this.svData);
                        this.fetchDataList();
                        this.resetForm();
                    })
                    .catch((err) => {
                        this.svErr(), this.isLoading(false);
                    });
        
                }
                //fin processus
                const interval = setInterval(() => {
                    if (this.progress < 100) {
                    this.progress += 10; // Augmentez la progression
                    } else {
                    clearInterval(interval);
                    this.loadings = false; // Arrêtez le chargement lorsque terminé
                    this.progress = 0; // Réinitialisez la progression si nécessaire
                    }
                }, 100); // Ajustez le délai selon vos besoins

            }
            catch (error) {
                // Bloc 5 : Gestion des erreurs
                console.error(`Erreur lors de enregistrement:,`);
                this.loadings = false; // Arrêtez le chargement en cas d'erreur
            }



        },
        fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_data_encours_cuisine?page=`);
        },
        fetchListModule() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_module_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.moduleList = donnees;
                }
            );
        },
        fetchListService() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_service_pointvente_user_by_user/${this.userData.id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.serviceList = donnees;
                }
            );
        },
        fetchListDevise() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_devise_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.deviseList = donnees;
                }
            );
        },
        fetchListClient() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_client_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.clientList = donnees;
                }
            );
        },
        fetchListTVA() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_tva_2`).then(
                ({ data }) => {
                    const donnees = data.data;
                    this.svData.detailData = this.svData.detailData.map(item => ({
                        ...item, // Spread existing properties
                        tvaList: donnees // Update 
                    }));
                }
            );
        },
        fetchListServeur() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.serveurList = donnees;
                }
            );
        },
        fetchListTable() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_tables_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.tableList = donnees;
                }
            );
        },
        editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_cuisine/${id}`).then(
            ({ data }) => {

            this.titleComponent = "modification des informations";

            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
            }
        );
        },
        deleteData(id) {
        this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_vente_entete_cuisine/${id}`).then(
            ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
            }
            );
        });
        },
        showDetailCuisine(refEnteteVente, name, refService) {

        if (refEnteteVente != '') { 

            this.$refs.VenteDetailCuisine.$data.etatModal = true;
            this.$refs.VenteDetailCuisine.$data.refEnteteVente = refEnteteVente;
            this.$refs.VenteDetailCuisine.$data.refService = refService;
            this.$refs.VenteDetailCuisine.$data.svData.refEnteteVente = refEnteteVente;
            this.$refs.VenteDetailCuisine.fetchDataList();
            this.$refs.VenteDetailCuisine.fetchListDevise();
            this.$refs.VenteDetailCuisine.get_produit_for_service(refService);
            this.$refs.VenteDetailCuisine.fetchListTVA();
            this.fetchDataList();

            this.$refs.VenteDetailCuisine.$data.titleComponent =
            "Detail commande de la cuisine pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }
        // 

        },
        showCommande(refEnteteVente, name,ServiceData) {

        if (refEnteteVente != '') {

            this.$refs.CommandeCusisine.$data.dialog2 = true;
            this.$refs.CommandeCusisine.$data.refEnteteSortie = refEnteteVente;
            this.$refs.CommandeCusisine.$data.ServiceData = ServiceData;
            this.$refs.CommandeCusisine.showModel(refEnteteVente);
            this.fetchDataList();

            this.$refs.CommandeCusisine.$data.titleComponent =
            "La Commande de la cuisisne pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }

        },
        editDataRes(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_entete_cuisine/${id}`).then(
            ({ data }) => {

            this.titleComponent = "modification des informations";

            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog2 = true;
            }
        );
        },
        validateRes() {
        if (this.$refs.form.validate()) {
            this.isLoading(true);
            if (this.edit) {
            this.svData.author = this.userData.name;
            this.svData.refUser = this.userData.id;
            this.svData.libelle= "Commandes de la cuisine";
            this.insertOrUpdate(
                `${this.apiBaseURL}/affecter_reservation_cuisine/${this.svData.id}`,
                JSON.stringify(this.svData)
            )
                .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;
                this.dialog = false;
                this.resetObj(this.svData);
                this.fetchDataList();
                })
                .catch((err) => {
                this.svErr(), this.isLoading(false);
                });

            }
            else {
            }

        }
        },
        fetchListChambre() {
            //deviseList
            this.editOrFetch(`${this.apiBaseURL}/fetch_hotel_reservation_search`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.chambreList = donnees;
                }
            );
        },
        showClient() {
            this.$refs.ModelClient.$data.etatModal = true;
            this.$refs.ModelClient.testTitle();
            this.$refs.ModelClient.onPageChange();
            this.$refs.ModelClient.fetchListCompte();
            this.fetchListClient();
        this.$refs.ModelClient.$data.titleComponentss =
            "Un nouveau Client";

        },


        // VISUALISATION DES DONNEES DES COMMANDES============================================================



    },
};
</script>

<style scoped>
/* Add any necessary styles here */
.short-cell {
        width: 100px;
    }

    .medium-cell {
        width: 150px;
    }

    .long-cell {
        width: 400px;
    }

    table {
        table-layout: auto;
        width: 100%;
    }

    td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>