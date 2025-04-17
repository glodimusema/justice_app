<template>

    <v-row justify="center">
        <v-dialog v-model="etatModal" persistent max-width="1500px">
          <v-card>
            <!-- container -->
    
            <v-card-title class="primary">
              {{ titleComponent }} <v-spacer></v-spacer>
              <v-btn depressed text small fab @click="etatModal = false">
                <v-icon>close</v-icon>
              </v-btn>
            </v-card-title>
            <v-card-text>
              <!-- layout -->
    
              <div>
              
              <v-layout>
                
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="700px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Condamnation Penale <v-spacer></v-spacer>
                          <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="dialog = false" text fab depressed>
                                  <v-icon>close</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Fermer</span>
                          </v-tooltip>
                        </v-card-title>
                        <v-card-text> 
                            
                            <v-layout row wrap>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="number" label="Durée SP" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.SP_duree">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="number" label="Montant Amande" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.montant_amende">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="number" label="Montant SPS" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.montant_SPS">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="number" label="Durée CPC" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.CPC_duree">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="number" label="Montant domage" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.montant_domage">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Signification" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_signification">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Recquisition Fin" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.requisition_fin">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Recquisition Emprisinnement" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.req_emprisonnement">
                                        </v-text-field>
                                    </div>
                                </v-flex>



                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Mandat prise de corps" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.mandat_prise_corps">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Commandement" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.commandement">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="number" label="Montant commandement" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.montant_cmd">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="N° Bordereau Commandement" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numero_bordereau_cmd">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Opposition" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_opposition">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Appel" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_appel">
                                        </v-text-field>
                                    </div>
                                </v-flex>



                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Revision" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_revision">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Prise de Partie" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_prise_partie">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                            </v-layout>

                          

                          <!-- <v-textarea
                                label="Resumé de l'audience"
                                rows="4"
                                dense
                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                outlined
                                v-model="svData.resume_audience">
                          </v-textarea> -->
                          

    
  
    
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
                  <v-layout>
                    <!--   -->
                    <v-flex md12>
                      <v-layout>
                        <v-flex md6>
                          <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                            outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                        </v-flex>
                        <v-flex md5>
                          <div>
                            <!-- {{ this.don }} -->
                          </div>
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
                            <span>Ajouter le Detail</span>
                          </v-tooltip>
                        </v-flex>
                      </v-layout>
                      <br />
                      <v-card>
                        <v-card-text>
                          <v-simple-table>
                            <template v-slot:default>
                              <thead>
                                <tr>
                                    <th class="text-left">Durée_SP</th>
                                    <th class="text-left">MontantAmande</th>
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
                                    <td>{{ item.SP_duree }}</td>
                                    <td>{{ item.montant_amende }}</td>
                                    <td>{{ item.name_president }}</td> 
                                    <td>{{ item.name_juge }}</td>  
                                    <td>{{ item.noms_fss }}</td>
                                    <td>{{ item.noms_client }}</td>
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
    
                          <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
                            @input="fetchDataList"></v-pagination>
                        </v-card-text>
                      </v-card>
                    </v-flex>
                    
                  </v-layout>
                </v-flex>
                
              </v-layout>
    
              </div>
            
    
              <!-- fin -->
            </v-card-text>
    
            <!-- container -->
          </v-card>
        </v-dialog>
      </v-row>
    
    
    
    
    </template>
    <script>
    import { mapGetters, mapActions } from "vuex";
    
    export default {
      components :{
        
      },
      data() {
        return {
    
          title: "Liste des Details",
          dialog: false,
          edit: false,
          loading: false,
          disabled: false,
          etatModal: false,
          titleComponent: '',
            //'id_suivi_tribunal','SP_duree','montant_amende','montant_SPS',
            // 'CPC_duree','montant_domage','date_signification','requisition_fin','req_emprisonnement',
            // 'mandat_prise_corps','commandement','montant_cmd','numero_bordereau_cmd','date_opposition',
            // 'date_appel','date_revision','date_prise_partie','author','refUser'
          id_suivi_tribunal: 0,
          svData: {
            id: '',
            id_suivi_tribunal: 0,
            SP_duree : 0,
            montant_amende : 0,
            montant_SPS : 0,
            CPC_duree : 0,
            montant_domage : 0,
            date_signification : '',
            requisition_fin : '',
            req_emprisonnement : '',
            mandat_prise_corps : '',
            commandement : '',
            montant_cmd : 0,
            numero_bordereau_cmd : '',
            date_opposition : '',
            date_appel : '', 
            date_revision : '',
            date_prise_partie : '',    
            author: "",
            refUser : 0
          },
          fetchData: [],
          don: [],
          query: ""
    
        }
      },
      created() {         
        // this.fetchDataList();
      },
      computed: {
        ...mapGetters(["categoryList", "isloading"]),
      },
      methods: {
    
        ...mapActions(["getCategory"]),
    
        validate() {
          if (this.$refs.form.validate()) {
            this.isLoading(true);
            if (this.edit) {
              this.svData.id_suivi_tribunal = this.id_suivi_tribunal;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_jur_condamnation_penale`,
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
              this.svData.id_suivi_tribunal = this.id_suivi_tribunal;
              this.svData.author = this.userData.name;
              this.svData.refUser = this.userData.id;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_jur_condamnation_penale`,
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
    
          }
        },
    
        // s'id','refProduit','refProduit','pu','qte','author'
        //   this.fetchDataList();
        // }, 300),
    
        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_jur_condamnation_penale/${id}`).then(
            ({ data }) => {
  
              // this.titleComponent = "modification de données";
  
              this.getSvData(this.svData, data.data[0]);
              this.edit = true;
              this.dialog = true;
            }
          );
        },
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_jur_condamnation_penale/${id}`).then(
              ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
              }
            );
          });
        },
    
        printBill(id) {
          window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
        },
        fetchDataList() {
          this.fetch_data(`${this.apiBaseURL}/fetch_jur_condamnation_penale_by_suivi_tribunal/${this.id_suivi_tribunal}?page=`);
        }
    
    
      },
      filters: {
    
      }
    }
    </script>
      
      