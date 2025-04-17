<template>
    <v-layout>
      
      <v-flex md12>
        <v-flex md12>
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
  
                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-autocomplete label="Selectionnez l'Arrestation" prepend-inner-icon="home"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.arrestationList"
                          item-text="data_jur" item-value="id" dense outlined v-model="svData.id_arrestation" chips clearable
                          >
                        </v-autocomplete>
                      </div>
                    </v-flex>


                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-autocomplete label="Selectionnez le President" prepend-inner-icon="home"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.userList"
                          item-text="name" item-value="id" dense outlined v-model="svData.id_president" chips clearable
                          >
                        </v-autocomplete>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-autocomplete label="Accompagnement 1" prepend-inner-icon="home"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.userList"
                          item-text="name" item-value="name" dense outlined v-model="svData.accompagne1" chips clearable
                          >
                        </v-autocomplete>
                      </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field label="Fonction 1" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.fonction1"></v-text-field>
                      </div>
                    </v-flex>


                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-autocomplete label="Accompagnement 2" prepend-inner-icon="home"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.userList"
                          item-text="name" item-value="name" dense outlined v-model="svData.accompagne2" chips clearable
                          >
                        </v-autocomplete>                        
                      </div>
                    </v-flex>
                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field label="Fonction 2" prepend-inner-icon="extension" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                          v-model="svData.fonction2"></v-text-field>
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
                      <th class="text-left">President</th>
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
                      <td>{{ item.name_president }}</td> 
                      <td>{{ item.name_juge }}</td>  
                      <td>{{ item.noms_fss }}</td>
                      <td>{{ item.noms_client }}</td>
                      <td>{{ item.accompagne1 }}</td>
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
        //'id','id_president','id_arrestation','accompagne1','fonction1',
    //'accompagne2','fonction2','author','refUser'
        svData: {
          id: "",
          id_arrestation: 0,
          id_president: 0,             
          accompagne1 : '',
          fonction1 : '',
          accompagne2 : '',
          fonction2 : '',
          author: "",
          refUser : 0,    
        },
        fetchData: null,
        titreModal: "",
        stataData: {
          arrestationList: [],
          userList: [],
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
        this.titleComponent = "Ajout Tribunal";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification des donnees";
        } else {
          this.titleComponent = "Ajout Tribunal ";
        }
      },
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_jur_tribunal?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
  
          this.svData.author = this.userData.name;
          this.svData.refUser = this.userData.id;
  
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_jur_tribunal`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_jur_tribunal/${id}`).then(
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
          this.delGlobal(`${this.apiBaseURL}/delete_jur_tribunal/${id}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
      fetchListArrestation() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_tjur_arrestation_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.arrestationList = donnees;
            //userList
          }
        );
      },
      fetchListUser() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_user_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.userList = donnees;
          }
        );
      },
  
  
    },
    created() {  
      this.testTitle();
      this.onPageChange();
      this.fetchListArrestation();
      this.fetchListUser();
    },
  };
  </script>