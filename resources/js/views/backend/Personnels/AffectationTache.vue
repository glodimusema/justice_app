<template>
  <v-row justify="center">


    <v-dialog v-model="etatModal" persistent max-width="1500px">
      <v-card>
        <!-- DetailAffectationRubrique -->

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
                        Affectation des Taches du Projet <v-spacer></v-spacer>
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

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez l'Agent" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList" item-text="noms_agent"
                                item-value="id" dense outlined v-model="svData.affectation_id" chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date affectation" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.date_affect_tache">
                              </v-text-field>
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
                <v-layout>
                  <!--   -->
                  <v-flex md12>
                    <v-layout>
                      <v-flex md6>
                        <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                          solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                          clearable></v-text-field>
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
                              <!-- //  id','activite_id', 'affectation_id', 'date_affect_tache', 'author' -->
                              <tr>
                                <th class="text-left">Agent</th>
                                <th class="text-left">DateDebutContrat</th>
                                <th class="text-left">DateFinContrat</th>
                                <th class="text-left">Tache</th>
                                <th class="text-left">Projet</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms_agent }}</td>
                                <td>{{ item.dateAffectation | formatDate}}</td>
                                <td>{{ item.dateFin | formatDate}}</td>
                                <td>{{ item.description_tache }}</td>
                                <td>{{ item.description_projet }}</td>
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
                                          <v-icon color="  blue">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="deleteData(item.id)">
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
  components: {

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
      activite_id: 0,
      //  id','activite_id', 'affectation_id', 'date_affect_tache', 'author'

      svData: {
        id: '',
        activite_id: 0,
        affectation_id: 0,
        date_affect_tache: '',
        author: "Admin",
      },
      fetchData: [],
      agentList: [],

      don: [],
      query: "",

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''

    }
  },
  created() {
    //this.fetchDataList();
    //this.fetchListAgent();
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
          this.svData.activite_id = this.activite_id;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_perso_affectation_tache/${this.svData.id}`,
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
          this.svData.activite_id = this.activite_id;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_perso_affectation_tache`,
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
    fetchListAgent() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_affectation_agent`).then(
        ({ data }) => {
          var donnees = data.data;
          this.agentList = donnees;
        }
      );
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_perso_affectation_tache/${id}`).then(
        ({ data }) => {
          // var donnees = data.data;
          // // donnees.map((item) => {
          this.titleComponent = "modification des informations";
          // // });

          this.getSvData(this.svData, data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_perso_affectation_tache/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_perso_affectation_tache/${this.activite_id}?page=`);
    },
    desactiverData(valeurs, user_created, date_entree, noms) {
      //
      var tables = 'tclient';
      var user_name = this.userData.name;
      var user_id = this.userData.id;
      var detail_information = "Suppression d'un patient au nom de : " + noms + " par l'utilisateur " + user_name + "";

      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.onPageChange();
          }
        );
      });
    }

    //fetchListCategorie
  },
  filters: {

  }
}
</script>