<template>
    <div>
  
      <v-layout>
         
         <v-flex md12>
          <v-dialog v-model="dialog" max-width="400px" persistent>
            <v-card :loading="loading">
              <v-form ref="form" lazy-validation>
                <v-card-title>
                  Ajouter Service <v-spacer></v-spacer>
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

                  <v-text-field
                    label="Designation"
                    prepend-inner-icon="extension"
                    :rules="[(v) => !!v || 'Ce champ est requis']"
                    outlined
                    v-model="svData.designation"
                  ></v-text-field>

                  <v-text-field type="number" label="Prix Unitaire" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pu">
                  </v-text-field>

                  <v-autocomplete label="Device" :items="[
                        { designation: 'USD' }, 
                        { designation: 'FC' },                                       
                        ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                           item-text="designation" item-value="designation"
                           v-model="svData.devise"></v-autocomplete>

                  <v-select label="Unité" :items="[
                        { designation: 'KG' }, 
                        { designation: 'Tonne' },
                        { designation: 'Litre' },
                        { designation: 'Pièce' },                                        
                        ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                           item-text="designation" item-value="designation"
                           v-model="svData.unite"></v-select>
              
                              

                 
  
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
             
             <v-flex md12>
              <v-layout>
                <v-flex md6>
                  <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                    outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
              </v-layout>
              <br />
              <v-card>
                <v-card-text>
                  <v-simple-table>
                    <template v-slot:default>
                      <thead>
                        <tr>
                          <th class="text-left">Designation</th>
                          <th class="text-left">PU</th>
                          <th class="text-left">Devise</th>
                          <th class="text-left">Qté</th>
                          <th class="text-left">Unité</th>
                          <th class="text-left">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in fetchData" :key="item.id">
                          <td>{{ item.designation }}</td>
                          <td>{{ item.pu}}</td>
                          <td>{{ item.devise}}</td>
                          <td>{{ item.qte}}</td>
                          <td>{{ item.unite}}</td>
                          <td>
                            <v-tooltip  top color="black">
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="editData(item.id)" fab small>
                                    <v-icon color="  blue">edit</v-icon>
                                  </v-btn>
                                </span>
                              </template>
                              <span>Modifier</span>
                            </v-tooltip>
  
                            <!-- <v-tooltip top   color="black">
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="deleteData(item.id)" fab small>
                                    <v-icon color="  red">delete</v-icon>
                                  </v-btn>
                                </span>
                              </template>
                              <span>Suppression</span>
                            </v-tooltip>  -->

                           
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
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  export default {
    data() {
      return {
  
        title: "Liste des Produits",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
  
        svData: {
          id: '',    
          designation: "",
          pu: 0,
          devise:"",          
          unite: "",
          author:""           
        },
        fetchData: [],
        query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''
  
      }
    },
    created() {
       
      this.fetchDataList();    
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
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_produit_salon`,
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
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_produit_salon`,
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
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_produit_salon/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
  
              this.svData.id = item.id;
              this.svData.designation = item.designation;
              this.svData.pu = item.pu;
              this.svData.unite = item.unite;
              this.svData.author = item.author;        
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_produit_salon/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_produit_salon?page=`);
      }
  
    },
    filters: {
  
    }
  }
  </script>
  
  