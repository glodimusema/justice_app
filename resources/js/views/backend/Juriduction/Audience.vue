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
                  <v-dialog v-model="dialog" max-width="600px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Details Audience <v-spacer></v-spacer>
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
                          <v-text-field type="date" label="Date audience " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_audience">
                          </v-text-field>

                          <v-textarea
                                label="Resumé de l'audience"
                                rows="4"
                                dense
                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                outlined
                                v-model="svData.resume_audience">
                          </v-textarea>
                          
                          <v-textarea
                                label="Décision de l'audience"
                                rows="4"
                                dense
                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                outlined
                                v-model="svData.decision_audience">
                          </v-textarea>

                          <v-textarea
                                label="Motif de remise de l'audience"
                                rows="4"
                                dense
                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                outlined
                                v-model="svData.motif_remise_audience">
                          </v-textarea>
    
  
    
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
                                  <th class="text-left">DateAudience</th>
                                  <th class="text-left">ResumeAudience</th>
                                  <th class="text-left">DecisionAudience</th>
                                  <th class="text-left">MotifRemise</th>
                                  <th class="text-left">Author</th>
                                  <th class="text-left">CreatedDate</th>
                                  <th class="text-left">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>{{ item.date_audience }}</td>
                                  <td>{{ item.resume_audience }}</td>
                                  <td>{{ item.decision_audience }}</td>
                                  <td>{{ item.motif_remise_audience }}</td>
                                  <td>{{ item.author }}</td>
                                  <td>
                                    {{ item.created_at | formatDate }}
                                    {{ item.created_at | formatHour }}
                                  </td>
                                  <!-- <td>                            
                                      <v-btn
                                        elevation="2"
                                        x-small
                                        class="white--text"
                                        :color="item.qte < item.stock_alerte ? '#F13D17' : item.qte > item.stock_alerte ? '#3DA60C' : item.qte = item.stock_alerte ? '#BFBF09' :'error'"
                                        depressed                            
                                        >
                                        {{ item.qte < item.stock_alerte ? 'Fin stock' : item.qte > item.stock_alerte ? 'Bon Etat' : item.qte = item.stock_alerte ? 'Stock Alerte' :'error' }}
                                      </v-btn> 
                                  </td> -->
                                  <td>

                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">                            

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
                                        <v-list-item-title style="margin-left: -20px">Supprimer
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
            //'id','id_suivi_tribunal','date_audience','resume_audience','decision_audience',
            // 'motif_remise_audience','author','refUser'
          id_suivi_tribunal: 0,
          svData: {
            id: '',
            id_suivi_tribunal: 0,
            date_audience: '',
            resume_audience: '',
            decision_audience : '',
            motif_remise_audience:'',       
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
                `${this.apiBaseURL}/insert_jur_audience_tribunal`,
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
                `${this.apiBaseURL}/insert_jur_audience_tribunal`,
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
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_jur_audience_tribunal/${id}`).then(
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
            this.delGlobal(`${this.apiBaseURL}/delete_jur_audience_tribunal/${id}`).then(
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
          this.fetch_data(`${this.apiBaseURL}/fetch_jur_audience_by_suivi_tribunal/${this.id_suivi_tribunal}?page=`);
        }
    
    
      },
      filters: {
    
      }
    }
    </script>
      
      