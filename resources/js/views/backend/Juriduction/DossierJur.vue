<template>
    <v-layout>
      <!-- <v-flex md2></v-flex> -->
      <v-flex md12>
        <v-flex md12>

          <AnnexeJur ref="AnnexeJur" />
          <ModelFournisseur ref="ModelFournisseur" />
          <ModelClient ref="ModelClient" />
          <!-- modal -->
          <v-dialog v-model="dialog" max-width="700px" scrollable transition="dialog-bottom-transition">
            <v-card :loading="loading">
              <v-form ref="form" lazy-validation>
                <v-card-title>
                  {{ titleComponent }} <v-spacer></v-spacer>
                  <v-tooltip bottom color="black">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-bind="attrs" v-on="on">
                        <v-btn @click="dialog = false" text fab depressed>
                          <v-icon>close</v-icon>
                        </v-btn>
                      </span>
                    </template>
                    <span>Fermer</span>
                  </v-tooltip></v-card-title>
                <v-card-text>
                  <v-layout row wrap>
  
                    <v-flex xs12 sm12 md10 lg10>
                      <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Plaignant" prepend-inner-icon="home"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.plaignantList"
                          item-text="noms" item-value="id" dense outlined v-model="svData.id_plaignant" chips clearable
                          >
                        </v-autocomplete>
                      </div>
                    </v-flex>
                    <v-flex xs1 sm1 md1 lg1>
                  <div class="mr-1">
                      <v-tooltip bottom color="black">
                          <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                  <v-btn @click="fetchListPlaignant" color="primary" :loading="loading"
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
                                            showFournisseur()
                                            " fab x-small color="primary" dark>
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Ajouter une Plaignant</span>
                            </v-tooltip>
                        </div>
                    </v-flex>





                    <v-flex xs12 sm12 md10 lg10>
                      <div class="mr-1">
                        <v-autocomplete label="Selectionnez l'Inculpé" prepend-inner-icon="home"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.inculpeList"
                          item-text="noms" item-value="id" dense outlined v-model="svData.id_inculpe" chips clearable
                          >
                        </v-autocomplete>
                      </div>
                    </v-flex>
                    <v-flex xs1 sm1 md1 lg1>
                    <div class="mr-1">
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="fetchListInculpe" color="primary" :loading="loading"
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



                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-autocomplete label="Selectionnez la Catégorie de Dossier" prepend-inner-icon="home"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.categoriedossierList"
                          item-text="nom_categorie_dossier" item-value="id" dense outlined v-model="svData.id_categorie_dossier" chips clearable
                          >
                        </v-autocomplete>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field type="date" label="Date Ouverture" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.date_ouverture"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-textarea
                            label="Objet du dossier"
                            rows="4"
                            dense
                            :rules="[(v) => !!v || 'Ce champ est requis']"
                            outlined
                            v-model="svData.objets_dossier">
                        </v-textarea>                       
                      </div>
                    </v-flex>
  
                  </v-layout>
  
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                  <v-btn color="  blue" dark :loading="loading" @click="validate">
                    {{ edit ? "Modifier" : "Ajouter" }}
                  </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
          <br /><br />
          <!-- fin modal -->
  
          <!-- bande -->
          <v-layout>
            <v-flex md1>
              <v-tooltip bottom>
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn :loading="loading" fab @click="onPageChange">
                      <v-icon>autorenew</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Initialiser</span>
              </v-tooltip>
            </v-flex>
            <v-flex md6>
              <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded hide-details
                v-model="query" @keyup="onPageChange" clearable></v-text-field>
            </v-flex>
  
            <v-flex md4></v-flex>
  
            <v-flex md1>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="showModal" fab color="  blue" dark>
                      <v-icon>add</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Ajouter une opération</span>
              </v-tooltip>
            </v-flex>
          </v-layout>
          <!-- bande -->
  
          <br />
          <v-card :loading="loading" :disabled="isloading">
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">Plaignant</th>
                      <th class="text-left">Inculpé</th>
                      <th class="text-left">DateOuverture</th>
                      <th class="text-left">CategorieDossier</th>
                      <th class="text-left">Mise à jour</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.noms_fss }}</td>
                      <td>{{ item.noms_client }}</td>
                      <td>{{ item.date_ouverture }}</td>
                      <td>{{ item.nom_categorie_dossier }}</td>
                      <td>
                        {{ item.created_at | formatDate }}
                        {{ item.created_at | formatHour }}
                      </td>
  
                      <td>
                        <v-menu bottom rounded offset-y transition="scale-transition">
                                <template v-slot:activator="{ on }">
                                  <v-btn icon v-on="on" small fab depressed text>
                                    <v-icon>more_vert</v-icon>
                                  </v-btn>
                                </template>
      
                                <v-list dense width="">
   
                                  <v-list-item link @click="showAnnexeJur(item.id, item.noms_client)">
                                    <v-list-item-icon>
                                      <v-icon>mdi-cart-outline</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Quelques Annexes
                                    </v-list-item-title>
                                  </v-list-item>    

      
                                  <v-list-item link @click="editData(item.id)">
                                    <v-list-item-icon>
                                      <v-icon color="blue">edit</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Modifier
                                    </v-list-item-title>
                                  </v-list-item>
      
                                  <v-list-item   link @click="clearP(item.id)">
                                  <v-list-item-icon>
                                    <v-icon color="red">delete</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Suppression
                                  </v-list-item-title>
                                </v-list-item>
      
                                </v-list>
                              </v-menu>
                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
              <hr />
  
              <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total" @input="onPageChange"
                :total-visible="7"></v-pagination>
            </v-card-text>
          </v-card>
          <!-- component -->
          <!-- fin component -->
        </v-flex>
      </v-flex>
      <!-- <v-flex md2></v-flex> -->
    </v-layout>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  import AnnexeJur from "./AnnexeJur.vue";
  import ModelFournisseur from "../Ventes/ModelFournisseur.vue";
  import ModelClient from "../Ventes/ModelClient.vue";
  
  
  export default {
    components: {
      AnnexeJur,
      ModelFournisseur,
      ModelClient
    },
    data() {
      return {
        title: "Categorie component",
        header: "Crud operation",
        titleComponent: "",
        query: "",
        dialog: false,
        loading: false,
        disabled: false,
        edit: false,
        //'id','date_ouverture','objets_dossier','id_categorie_dossier','id_plaignant','id_inculpe','author','refUser'
        svData: {
          id: "",
          date_ouverture : '',
          objets_dossier : '', 
          id_categorie_dossier: 0,             
          id_plaignant: 0,          
          id_inculpe : 0,
          author: "",
          refUser : 0,    
        },
        fetchData: null,
        titreModal: "",
        stataData: {
          plaignantList: [],
          categoriedossierList: [],
          inculpeList: []
        },
  
        inserer: '',
        modifier: '',
        supprimer: '',
        chargement: ''
      };
    },
    computed: {
      ...mapGetters(["roleList", "isloading"]),
    },
    methods: {
      ...mapActions(["getRole"]),
  
      showModal() {
        this.dialog = true;
        this.titleComponent = "Ajout Dossier";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification des donnees";
        } else {
          this.titleComponent = "Ajout Dossier ";
        }
      }
      ,
  
      //   searchMember: _.debounce(function () {
      //     this.onPageChange();
      //   }, 300),
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_jur_dossier?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          this.svData.author = this.userData.name;
          this.svData.refUser = this.userData.id;
  
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_jur_dossier`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.resetObj(this.svData);
              this.onPageChange();
  
              this.dialog = false;
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });
        }
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_jur_dossier/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.titleComponent = "modification de " + item.nom_jur;
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_jur_dossier/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
      fetchListPlaignant() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_fournisseur`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.plaignantList = donnees;
  
          }
        );
      },
      fetchListCategorieDossier() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tjur_categorie_dossier_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.categoriedossierList = donnees;
  
          }
        );
      },
      fetchListInculpe() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_client_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.inculpeList = donnees;
  
          }
        );
      },
          showAnnexeJur(id_dossier, name) {
      
            if (id_dossier != '') {
      
              this.$refs.AnnexeJur.$data.etatModal = true;
              this.$refs.AnnexeJur.$data.id_dossier = id_dossier;
              this.$refs.AnnexeJur.$data.svData.id_dossier = id_dossier;
              this.$refs.AnnexeJur.fetchDataList();
              this.fetchDataList();
      
              this.$refs.AnnexeJur.$data.titleComponent =
                "Annexe du dossier pour " + name;
      
            } else {
              this.showError("Personne n'a fait cette action");
            }
      
          },
          showFournisseur() {
            this.$refs.ModelFournisseur.$data.etatModal = true;
            this.$refs.ModelFournisseur.testTitle();
            this.$refs.ModelFournisseur.onPageChange();
            this.$refs.ModelFournisseur.fetchListCompte();
            this.fetchListFournisseur();

            this.$refs.ModelFournisseur.$data.titleComponentss =
              "Un nouveau Fournisseur";
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
  
  
    },
    created() {
  
      this.testTitle();
      this.onPageChange();
      this.fetchListPlaignant();
      this.fetchListCategorieDossier();
      this.fetchListInculpe();
    },
  };
  </script>
  