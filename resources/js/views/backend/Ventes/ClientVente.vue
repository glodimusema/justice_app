<template>
    <v-layout>
        <v-flex md12>

            <avatarAvatar ref="avatarAvatar" />
            <AvatarProfil ref="avatarPhoto" />
            <ReservationSalle ref="ReservationSalle" />
            <Billard ref="Billard" />
            <ModelCategorieClient ref="ModelCategorieClient" />
            <!-- ModelCategorieClient -->

            <v-dialog v-model="dialog" max-width="1058px" hide-overlay transition="dialog-bottom-transition">
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
                            </v-tooltip>
                        </v-card-title>
                        <v-card-text max-height="1500px" background-color: white>
                            <v-layout row wrap>

                                <v-flex xs10 sm10 md10 lg10>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la Catégorie du Client" prepend-inner-icon="mdi-map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList"
                                            item-text="designation" item-value="id" dense outlined v-model="svData.refCategieClient"
                                            chips clearable>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                                <v-flex xs1 sm1 md1 lg1>
                                <div class="mr-1">
                                    <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                        <v-btn @click="fetchListCategorie" color="primary" :loading="loading" dark x-small fab depressed>
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
                                            showCategorieClient()
                                            " fab x-small color="primary" dark>
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                        </span>
                                    </template>
                                    <span>Ajouter une categorie</span>
                                    </v-tooltip>
                                </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Nom complet" prepend-inner-icon="draw" dense
                                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                        v-model="svData.noms"></v-text-field>
                                    </div>                                    
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-select label="Sexe *" :items="[
                                            { designation: 'Homme' },
                                            { designation: 'Femme' }
                                        ]" prepend-inner-icon="extension"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.sexe"></v-select>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-text-field label="Adresse Complète" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.adresse">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="N° de Téléphone" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.contact">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="E-mail" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.mail">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Pièce d'Indentité" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.pieceidentite">
                                        </v-text-field>
                                    </div>
                                </v-flex>
                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="N° Pièce d'Indentité" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.numeroPiece">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6 class="mb-2">
                                    <div class="mr-1">
                                        <input class="form-control" type="file" id="photo_input" @change="onImageChange"
                                            required />
                                        <br />
                                        <img :style="{ height: style.height }" id="output" />
                                    </div>
                                </v-flex> 


                            </v-layout>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                            <v-btn color="blue" dark :loading="loading" @click="validate">
                                {{ edit ? "Modifier" : "Ajouter" }}
                            </v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-dialog>
            <br /><br />
            <v-layout>
                <v-layout>

                    <v-flex md12></v-flex>

                </v-layout>

                <v-flex md12>
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
                        <v-flex md4>
                            <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded
                                hide-details v-model="query" @keyup="onPageChange" clearable></v-text-field>
                        </v-flex>

                        <v-flex md6></v-flex>

                        <v-flex md1>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showModal" fab color="blue" dark>
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Ajouter une opération</span>
                            </v-tooltip>
                        </v-flex>
                    </v-layout>
                    <!-- bande  -->

                    <br />
                    <v-card :loading="loading" :disabled="isloading">
                        <v-card-text>
                            <v-simple-table>
                                <template v-slot:default>
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th class="text-left">Nom</th>
                                            <th class="text-left">Sexe</th>
                                            <th class="text-left">Age</th>
                                            <th class="text-left">Contact</th>
                                            <th class="text-left">E-mail</th>
                                            <th class="text-left">PièceIdent.</th>
                                            <th class="text-left">N°PièceIdent.</th>
                                            <th class="text-left">Catégorie</th>
                                            <th>Mise à jour</th>

                                            <th class="text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in fetchData" :key="item.id">
                                            <td>

                                                <!-- image  -->
                                                <img style="border-radius: 50px; width: 50px; height: 50px" :src="item.photo_profil == null
                                                    ? `${baseURL}/fichier/avatar.png`
                                                    : `${baseURL}/fichier/` + item.photo_profil
                                                    " />
                                                <!-- images -->
                                            </td>
                                            <td>{{ item.noms }}</td>
                                            <td>{{ item.sexe }}</td>
                                            <td>{{ item.age_profil }}</td>
                                            <td>{{ item.contact }}</td>
                                            <td>{{ item.mail }}</td>
                                            <td>{{ item.pieceidentite }}</td>
                                            <td>{{ item.numeroPiece }}</td>
                                            <td>{{ item.designation }}</td>
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

                                                        <v-list-item  link @click="editData(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="blue">edit</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title
                                                                style="margin-left: -20px">Modifier</v-list-item-title>
                                                        </v-list-item>

                                                        <!-- <v-list-item  link @click="clearP(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="red">delete</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title
                                                                style="margin-left: -20px">Supprimer</v-list-item-title>
                                                        </v-list-item> -->
<!-- 
                                                        <v-list-item link @click="printBill(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="blue">print</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Imprimer Carte
                                                                Medicale</v-list-item-title>
                                                        </v-list-item> -->

                                                        <v-divider></v-divider>
                                                        <v-subheader>Deroulement</v-subheader>
                                                        <v-divider></v-divider>

                                                        <v-list-item link
                                                            @click="showBillard(item.id, item.noms)">
                                                            <v-list-item-icon>
                                                                <v-icon color="blue">mdi-account-star</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Paiement Billards
                                                            </v-list-item-title>
                                                        </v-list-item>
                                                        <v-list-item link
                                                            @click="showReservationSalle(item.id, item.noms)">
                                                            <v-list-item-icon>
                                                                <v-icon color="blue">mdi-account-star</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Résérvation Salle
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

                            <v-pagination color="blue" v-model="pagination.current" :length="pagination.total"
                                :total-visible="7" @input="onPageChange"></v-pagination>
                        </v-card-text>
                    </v-card>
                    <!-- les composants -->

                    <!-- fin des composants -->
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</template>
    
<script>
import { mapGetters, mapActions } from "vuex";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import uploadImage from '../admin/photo.vue';
import avatarAvatar from '../Patients/AvatarAction.vue';
import AvatarProfil from "../Patients/AvatarProfil.vue"

import ReservationSalle from "../Hotel/ReservationSalle.vue";
import Billard from '../Hotel/Billard.vue';
import ModelCategorieClient from "./ModelCategorieClient.vue";



//import uploadImage from "./photo";

export default {
    components: {
        uploadImage,
        AvatarProfil,
        avatarAvatar,
        ReservationSalle,
        Billard,
        ModelCategorieClient
    },
    data() {
        return {
            header: "crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,

            isCameraOpen: false,
            isPhotoTaken: false,
            isShotPhoto: false,
            isLoading2: false,
            link: '#',

            style: {
                height: "0px",
            },

            svData: {
                id: "",
                noms: "",
                sexe: "",
                contact: "",
                mail: "",
                adresse:"",
                pieceidentite:"",
                numeroPiece:"",
                refCategieClient:0,
                dateLivrePiece:"2000-01-01",
                lieulivraisonCarte:"Attente",
                nationnalite:"Attente",
                datenaissance: "Attente",
                lieunaissance:"Attente",
                profession:"Attente",
                occupation:"Attente",
                nombreEnfant:0,
                dateArriverGoma:"2000-01-01",
                arriverPar:"Atente",                
                author:"admin"              
                
            },
            fetchData: null,
            titreModal: "",
            image: "",
            clientList: [],
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
                //  toolbar: [ 'bold', 'italic', '|', 'link' ]
            },
            maladeList: [],
            categorieList: [],
            etatSearch: false,
        };
    },

    computed: {
        ...mapGetters(["basicList", "paysList",
            "provinceList", "ListeEdition", "entrepriseList", "isloading"]),
    },
    methods: {
        ...mapActions(["getBasic", "getEntrepriseList", "getMyEntrepriseList"]),
        showModal() {
            this.dialog = true;
            this.titleComponent = "Enregistrement du Client ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        onPageTexteSearch(text) {
            if (text != "") {

                this.editOrFetch(`${this.apiBaseURL}/searchMaladeTeste?query=${text}`).then(
                    ({ data }) => {
                        var donnees = data.data;
                        this.maladeList = donnees;

                        this.etatSearch = true;

                    }
                );

            } else {

            }

        },

        setNom(text) {
            this.svData.noms = text;
            this.etatSearch = false;

        },

        fetchListCategorie() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tvente_categorie_client_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.categorieList = donnees;

                }
            );

        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "Modification du Malade ";
                this.style.height = "0px";
            } else {
                this.titleComponent = "Paramètrage du Client ";
                this.style.height = "0px";
            }
        },
        onPageChange() {
            //var connected = this.userData.id;
            this.fetch_data(`${this.apiBaseURL}/fetch_vente_client?page=`);
        },

        onImageChange(e) {
            this.image = e.target.files[0];
            let output = document.getElementById("output");
            output.src = URL.createObjectURL(e.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src);
                this.style.height = "240px"; // free memory
            };
        },
        updatePhoto() {
            const config = {
                headers: { "content-type": "multipart/form-data" },
            };

            let formData = new FormData();
            
            this.svData.author=this.userData.name;
            this.svData.dateLivrePiece="2000-01-01";
            this.svData.lieulivraisonCarte="Attente";
            this.svData.nationnalite="Attente";
            this.svData.datenaissance= "Attente";
            this.svData.lieunaissance="Attente";
            this.svData.profession="Attente";
            this.svData.occupation="Attente";
            this.svData.nombreEnfant=0;
            this.svData.dateArriverGoma="2000-01-01";
            this.svData.arriverPar="Atente"; 
            this.svData.refUser = this.userData.id;

            formData.append("data", JSON.stringify(this.svData));
            formData.append("image", this.image);


            if (this.edit == true) {
                
                axios
                    .post(`${this.apiBaseURL}/update_vente_client`, formData, config)
                    .then(({ data }) => {
                        this.image = "";
                        this.showMsg(data.data);

                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.onPageChange();

                        this.dialog = false;

                        // setTimeout(() => window.location.reload(), 2000);
                        document.getElementById("photo_input").value = "";
                        document.getElementById("output").src = "";
                    })
                    .catch((err) => this.svErr());
            } else {
                axios
                    .post(`${this.apiBaseURL}/insert_vente_client`, formData, config)
                    .then(({ data }) => {
                        this.image = "";
                        this.showMsg(data.data);

                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.onPageChange();
                        this.dialog = false;

                        // setTimeout(() => window.location.reload(), 2000);
                        document.getElementById("photo_input").value = "";
                        document.getElementById("output").src = "";
                    })
                    .catch((err) => {
                        this.svErr()
                    });
            }
        },

        validate() {
            if (this.$refs.form.validate()) {
                // this.isLoading(true);

                if (this.edit) {
                    this.updatePhoto();
                } else {
                    this.updatePhoto();
                }
            }
        },
        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_client/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;


                    donnees.map((item) => {
                        this.svData.id = item.id;
                        this.titleComponent = "modification de  du Patient ";
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                var connected = this.userData.id;
                this.delGlobal(`${this.apiBaseURL}/delete_vente_client/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        editTitleModal(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_vente_client/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.titleComponent = "modification de  client de l'entreprise";
                    });
                }
            );
        },

        initialisation() {
            this.fetch_province_2();
        },

        showProfileModal(id, name, created) {

            if (id != null) {

                this.$refs.avatarPhoto.$data.dialog = true;
                this.$refs.avatarPhoto.$data.svData.id = id;
                this.$refs.avatarPhoto.$data.svData.created = created;
                this.$refs.avatarPhoto.display_profile(id);

                this.$refs.avatarPhoto.$data.titleComponent =
                    "Détail du Profile  ";

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },

        printBill(id) {
            window.open(`${this.apiBaseURL}/pdf_carte_medicale?id=` + id);
        },

        showProfileModal(id, name, created) {

            if (id != null) {

                this.$refs.avatarPhoto.$data.dialog = true;
                this.$refs.avatarPhoto.$data.svData.id = id;
                this.$refs.avatarPhoto.$data.svData.created = created;
                this.$refs.avatarPhoto.display_profile(id);

                this.$refs.avatarPhoto.$data.titleComponent =
                    "Détail du Profile  ";

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },
        toggleCamera() {
            if (this.isCameraOpen) {
                this.isCameraOpen = false;
                this.isPhotoTaken = false;
                this.isShotPhoto = false;
                this.stopCameraStream();
            } else {
                this.isCameraOpen = true;
                this.createCameraElement();
            }
        },

        createCameraElement() {
            this.isLoading2 = true;

            const constraints = (window.constraints = {
                audio: false,
                video: true
            });


            navigator.mediaDevices
                .getUserMedia(constraints)
                .then(stream => {
                    this.isLoading2 = false;
                    this.$refs.camera.srcObject = stream;
                })
                .catch(error => {
                    this.isLoading2 = false;
                    alert("May the browser didn't support or there is some errors.");
                });
        },

        stopCameraStream() {
            let tracks = this.$refs.camera.srcObject.getTracks();

            tracks.forEach(track => {
                track.stop();
            });
        },

        takePhoto() {
            if (!this.isPhotoTaken) {
                this.isShotPhoto = true;

                const FLASH_TIMEOUT = 50;

                setTimeout(() => {
                    this.isShotPhoto = false;
                }, FLASH_TIMEOUT);
            }

            this.isPhotoTaken = !this.isPhotoTaken;

            const context = this.$refs.canvas.getContext('2d');
            context.drawImage(this.$refs.camera, 0, 0, 450, 337.5);
        },
        downloadImage() {
            const download = document.getElementById("downloadPhoto");
            const canvas = document.getElementById("photoTaken").toDataURL("image/jpeg")
                .replace("image/jpeg", "image/octet-stream");
            download.setAttribute("href", canvas);
        },
    showReservationSalle(refClient, name) {

      if (refClient != '') {

        this.$refs.ReservationSalle.$data.etatModal = true;
        this.$refs.ReservationSalle.$data.refClient = refClient;
        this.$refs.ReservationSalle.$data.svData.refClient = refClient;
        this.$refs.ReservationSalle.fetchDataList();
        this.$refs.ReservationSalle.fetchListSalle();
        this.onPageChange();

        this.$refs.ReservationSalle.$data.titleComponent =
          "Reservation de la Salle pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showBillard(refClient, name) {

      if (refClient != '') {

        this.$refs.Billard.$data.etatModal = true;
        this.$refs.Billard.$data.refClient = refClient;
        this.$refs.Billard.$data.svData.refClient = refClient;
        this.$refs.Billard.fetchDataList();
        this.$refs.Billard.get_mode_Paiement();
        this.onPageChange();

        this.$refs.Billard.$data.titleComponent =
          "Paiement Billard pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showCategorieClient() {
      this.$refs.ModelCategorieClient.$data.etatModal = true;
      this.$refs.ModelCategorieClient.testTitle();
      this.$refs.ModelCategorieClient.onPageChange();
      this.$refs.ModelCategorieClient.fetchListCompte();
      this.fetchListCategorie();

      this.$refs.ModelCategorieClient.$data.titleComponents =
        "Une nouvelle Categorie Fournisseur";

    }


    },
    created() {

        this.onPageChange();
        this.testTitle();
        this.fetchListCategorie();
    },
};
</script>
<style lang="scss">   //  @import url('../../cssimage/image.scss');
</style>  
<style scoped>
.mb-2 {
    margin-top: 10px;
}

.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out
}

#etatSearch {
    width: 100%;
    height: 250px;
    max-height: 250vh;
    border: 1px bisque;
    border-radius: 20%;
}
</style>