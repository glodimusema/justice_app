<template>
    <v-layout>
      
      <v-flex md12>
        <v-flex md12>
          <!-- modal -->
          <v-dialog v-model="dialog" max-width="700px" background-color: white hide-overlay transition="dialog-bottom-transition">
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
                <v-card-text  >
                  <v-layout row wrap>
  
                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Dossier" prepend-inner-icon="home"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.attributionList"
                          item-text="data_jur" item-value="id" dense outlined v-model="svData.id_attribution_jur" chips clearable
                          >
                        </v-autocomplete>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field type="date" label="Date Arrestation" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.date_arretation"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-textarea
                            label="Motif Arrestation"
                            rows="4"
                            dense
                            :rules="[(v) => !!v || 'Ce champ est requis']"
                            outlined
                            v-model="svData.motif_arrestation">
                        </v-textarea>                       
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field label="Statut MAP" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.statut_map"></v-text-field>
                      </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field label="Statut ODP" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.statut_odp"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field type="number" label="OC1" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.oc1"></v-text-field>
                      </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field type="number" label="OC2" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.oc2"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field type="number" label="OC3" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.oc3"></v-text-field>
                      </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field type="date" label="Date relaxe" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.date_relaxe"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field type="date" label="Date requette libérté Provisoire" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.date_requete_liberte"></v-text-field>
                      </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field type="date" label="Date libérté Provisoire" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.date_liberte_provisoire"></v-text-field>
                      </div>
                    </v-flex>


                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field type="number" label="Montant libérté Provisoire" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.montant_liberte_prov"></v-text-field>
                      </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field label="N° Bordereau libérté Provisoire" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.bordereau_liberte_prov"></v-text-field>
                      </div>
                    </v-flex>


                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field type="date" label="Date Classement" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.date_classement"></v-text-field>
                      </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Motif de Classement" prepend-inner-icon="home"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.motifList"
                          item-text="nom_motif" item-value="nom_motif" dense outlined v-model="svData.motif_classement" chips clearable
                          >
                        </v-autocomplete>
                      </div>
                    </v-flex>


                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field type="date" label="Date envoie fixation" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.date_envoie_fixation"></v-text-field>
                      </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-select label="Statut arrestation" :items="[
                                { designation: 'Condamnation' },
                                { designation: 'Classement' },
                                ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                item-text="designation" item-value="designation" v-model="svData.statut_arrestation">
                            </v-select>
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
                      <th class="text-left">Magistrat</th>
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
                      <td>{{ item.name }}</td>  
                      <td>{{ item.noms_fss }}</td>
                      <td>{{ item.noms_client }}</td>
                      <td>{{ item.date_arretation }}</td>
                      <td>{{ item.nom_categorie_dossier }}</td>
                      <td>
                        {{ item.created_at | formatDate }}
                        {{ item.created_at | formatHour }}
                      </td>
  
                      <td>
                        <v-tooltip top color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="editData(item.id)" fab small><v-icon color="  blue">edit</v-icon></v-btn>
                            </span>
                          </template>
                          <span>Modifier</span>
                        </v-tooltip>
  
                        <v-tooltip top   color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="clearP(item.id)" fab small
                                  ><v-icon color="  red">delete</v-icon></v-btn
                                >
                              </span>
                            </template>
                            <span>Supprimer</span>
                          </v-tooltip>
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
      
    </v-layout>
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  export default {
    components: {},
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
        //'id','id_attribution_jur','date_arretation','motif_arrestation',
// 'statut_map','statut_odp','oc1','oc2','oc3','date_fin_oc1','date_fin_oc2','date_fin_oc3',
// 'date_relaxe','date_requete_liberte','date_liberte_provisoire','montant_liberte_prov',
// 'bordereau_liberte_prov','date_classement','motif_classement','date_envoie_fixation',
// 'statut_arrestation','author','refUser'
        svData: {
          id: "",
          id_attribution_jur: 0,             
          date_arretation : '',
          motif_arrestation : '',
          statut_map : '',
          statut_odp : '',
          oc1 : 0,
          oc2 : 0,
          oc3 : 0,
          date_relaxe:'',
          date_requete_liberte:'',
          date_liberte_provisoire : '',
          montant_liberte_prov : 0,
          bordereau_liberte_prov : '',
          date_classement : '',
          motif_classement : '',
          date_envoie_fixation : '',
          statut_arrestation: '',                   
          author: "",
          refUser : 0,    
        },
        fetchData: null,
        titreModal: "",
        stataData: {
          attributionList: [],
          motifList: [],
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
        this.titleComponent = "Ajout Arrestation";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification des donnees";
        } else {
          this.titleComponent = "Ajout Arrestation ";
        }
      },
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_jur_arrestation?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          this.svData.author = this.userData.name;
          this.svData.refUser = this.userData.id;
  
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_jur_arrestation`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_jur_arrestation/${id}`).then(
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
          this.delGlobal(`${this.apiBaseURL}/delete_jur_arrestation/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
      fetchListAttributionDossier() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tjur_attribution_dossier_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.attributionList = donnees;
            //motifList
          }
        );
      },
      fetchListMotifClassement() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tjur_motif_classement_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.motifList = donnees;
          }
        );
      },
  
  
    },
    created() {  
      this.testTitle();
      this.onPageChange();
      this.fetchListAttributionDossier();
      this.fetchListMotifClassement();
    },
  };
  </script>