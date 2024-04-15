<template>
    <v-container fluid>
        <v-toolbar dense flat>
            <h1>Adviser</h1>
        </v-toolbar>
        <v-btn @click="toggleInsert(true)" dark small color="primary"><v-icon>mdi-plus</v-icon></v-btn>
        <v-simple-table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in ADVISERS_USERS_DATA" :key="index">
                    <td>{{item.name}}</td>
                    <td>{{item.email}}</td>
                    <td>{{item.username}}</td>
                    <td>{{ item.created_at }}</td>
                    <td>
                        <!-- <v-btn @click="viewData(item.id)" icon dark small color="success"><v-icon>mdi-view-module</v-icon></v-btn> -->
                        <v-btn @click="Edit(item)" icon dark small color="success"><v-icon>mdi-pencil</v-icon></v-btn>
                        <v-btn @click="toggleDelete(item)" icon dark small color="error"><v-icon>mdi-delete</v-icon></v-btn>
                    </td>
                </tr>
            </tbody>
        </v-simple-table>

         
        <v-row>
            <v-dialog width="400" min-width="400" max-width="600" v-model="insertDialog" persistent>
                <!-- <v-form id="Insert" ref="Insert"> -->
                <v-form id="Store" ref="Store" @submit.prevent="Store">
                    <v-card>
                        <v-card-title>
                            <span>CREATE PROFESSOR ENTRY</span>
                        <v-spacer/>
                        <v-btn @click="toggleInsert(false)" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
                        </v-card-title>
                        <v-card-text>
                            <v-col cols="12" >
                                <v-text-field
                                    autocomplete="off"
                                    dense
                                    outlined
                                    label="Adviser CODE"
                                    prefix="A_"
                                    :rules="rules.required"
                                    :value="newCode"
                                    name="adviser_code"
                                    readonly
                                ></v-text-field>

                                <v-autocomplete
                                    v-model="tempData.college_id"
                                    dense 
                                    name="college_id" 
                                    label="COLLEGES" 
                                    outlined
                                    :rules="rules.required"
                                    :items="COLLEGES"
                                    chips
                                    small-chips
                                    item-value="id"
                                    autocomplete="off"
                                    item-text="name"
                                ></v-autocomplete>

                                <v-autocomplete
                                    v-model="tempData.department_id"
                                    dense 
                                    name="department_id" 
                                    label="DEPARTMENT" 
                                    outlined
                                    :rules="rules.required"
                                    :items="DEPARTMENTS"
                                    chips
                                    small-chips
                                    item-value="id"
                                    autocomplete="off"
                                    item-text="name"
                                ></v-autocomplete>

                                <v-text-field 
                                    dense 
                                    name="name" 
                                    label="FULLNAME" 
                                    outlined
                                    autocomplete="off"
                                    :rules="rules.required"
                                ></v-text-field>

                                <v-text-field 
                                    dense 
                                    name="email" 
                                    label="EMAIL" 
                                    :rules="[...rules.required, ...rules.email, ...rules.uniqueEmail(ADVISERS_USERS_DATA)]"
                                    autocomplete="off"
                                    outlined
                                ></v-text-field>

                                <v-autocomplete
                                    dense 
                                    name="role" 
                                    label="ROLE" 
                                    outlined
                                    :rules="rules.required"
                                    :items="ROLES"
                                    chips
                                    small-chips
                                    value="Adviser"
                                    autocomplete="off"
                                    readonly
                                ></v-autocomplete>
                            </v-col>
                            
                        </v-card-text>
                        <v-card-actions>
                            <v-btn type="submit" block dark small color="success"><v-icon>mdi-content-save-outline</v-icon>Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-row>

        <v-row>
            <v-dialog width="400" min-width="400" max-width="600" v-model="editDialog" persistent>
                <!-- <v-form id="Insert" ref="Insert"> -->
                <v-form id="Update" ref="Update" @submit.prevent="Update">
                    <v-card>
                        <v-card-title>
                            <span>UPDATE PROFESSOR ENTRY</span>
                        <v-spacer/>
                        <v-btn @click="toggleEdit(false)" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
                        </v-card-title>
                        <v-card-text>
                            <v-col cols="12" >
                                <v-text-field
                                    v-model="tempData.adviser_code"
                                    dense
                                    outlined
                                    label="Adviser CODE"
                                    prefix="A_"
                                    :rules="rules.required"
                                    :value="newCode"
                                    name="adviser_code"
                                    autocomplete="off"
                                    readonly
                                ></v-text-field>

                                <v-autocomplete
                                    v-model="tempData.college_id"
                                    dense 
                                    name="college_id" 
                                    label="COLLEGES" 
                                    outlined
                                    :rules="rules.required"
                                    :items="COLLEGES"
                                    chips
                                    small-chips
                                    autocomplete="off"
                                    item-value="id"
                                    item-text="name"
                                ></v-autocomplete>

                                <v-autocomplete
                                    v-model="tempData.department_id"
                                    dense 
                                    name="department_id" 
                                    label="DEPARTMENT" 
                                    outlined
                                    :rules="rules.required"
                                    :items="DEPARTMENTS"
                                    chips
                                    small-chips
                                    item-value="id"
                                    autocomplete="off"
                                    item-text="name"
                                ></v-autocomplete>

                                <v-text-field 
                                    v-model="tempData.name"
                                    dense 
                                    name="name" 
                                    label="FULLNAME" 
                                    outlined
                                    :rules="rules.required"
                                    autocomplete="off"
                                   
                                ></v-text-field>

                                <v-text-field 
                                    v-model="tempData.email"
                                    dense 
                                    name="email" 
                                    label="EMAIL" 
                                    :rules="[...rules.required, ...rules.email, ...rules.uniqueDataEdit(ADVISERS_USERS_DATA, tempData.currentEmail, 'email')]"
                                    autocomplete="off"
                                    outlined
                                ></v-text-field>

                                <v-autocomplete
                                    v-model="tempData.role"
                                    dense 
                                    name="role" 
                                    label="ROLE" 
                                    outlined
                                    :rules="rules.required"
                                    :items="ROLES"
                                    chips
                                    small-chips
                                    value="Adviser"
                                    autocomplete="off"
                                    readonly
                                ></v-autocomplete>
                            </v-col>
                            
                        </v-card-text>
                        <v-card-actions>
                            <v-btn type="submit" block dark small color="success"><v-icon>mdi-content-save-outline</v-icon>Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-row>
        <!-- <v-row>
            <v-dialog width="600" v-model="viewDialog">
                <v-card>
                    <v-card-title>View Adviser Schedules</v-card-title>
                    <v-simple-table>
                        <thead>
                            <tr>
                                <th>Schedule Code</th>
                                <th>Schedule Name</th>
                                <th>Adviser</th>
                                <th>Subject</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in ADVISER_SCHEDULE_DATA.schedules" :key="index">
                                <td>{{ item.sched_code }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ ADVISER_SCHEDULE_DATA.name }}</td>
                                <td>{{ item.subject_name }}</td>
                            </tr>
                        </tbody>
                    </v-simple-table>
                </v-card>
            </v-dialog>
        </v-row> -->
        <v-dialog width="300" v-model="deleteDialog" persistent>
                <v-card>
                    <v-card-title >
                        <span class="headline">Delete this Record?</span>
                        <v-spacer/>
                        <v-btn @click="deleteDialog = false" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
                    </v-card-title>
                    <v-card-actions>
                        <v-spacer/>
                        <v-btn @click="dataDelete()"  dark small color="success"><v-icon>mdi-delete</v-icon>Yes</v-btn>
                        <v-btn @click="deleteDialog = false"  dark small color="success"><v-icon></v-icon>No</v-btn>
                    </v-card-actions>
                </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import axios from 'axios';
import { nextTick } from 'vue';
import {mapState, mapActions, mapGetters} from 'vuex';
export default {
    data() {
        return {
            insertDialog: false,
            editDialog: false,
            deleteDialog: false,
            tempName: null,
            editData: [],
            deleteData:[],
            tempData: {}
        }
    },
    computed: {
        ...mapState([
            "USERS_DATA",
            'rules',
            'ROLES',
            "COLLEGES_DATA",
            "DEPARTMENTS_DATA",
            // 'ADVISER_SCHEDULE_DATA'
        ]),
        ...mapGetters([
            "ADVISERS_USERS_DATA",
        ]),

        newCode(){ 
            let id = this.USERS_DATA.reduce((max, obj) => Math.max(max, obj.id), 0) + 1;
            let paddedId = String(id).padStart(5, '0');
            return `${new Date().getFullYear() }${paddedId}`;
        },

        COLLEGES(){
            return this.COLLEGES_DATA;
        },

        DEPARTMENTS(){
            return this.DEPARTMENTS_DATA.filter( dept => dept.college_id == this.tempData.college_id );
        }

      },


    methods: {
        ...mapActions([
            "GET_USERS_DATA",
            "GET_COLLEGES_DATA",
            "GET_DEPARTMENTS_DATA",
            // 'GET_ADVISER_SCHEDULE_DATA',
        ]),


        Edit(data){
            this.tempData = {...data};
            this.tempData.currentEmail = data.email
            this.tempData.adviser_code = this.tempData.username.split('_')[1];
            this.editDialog = true
        },


        Store(){
            if(this.$refs.Store.validate()){
                this.overlay = true;
                const myForm = document.getElementById('Store');
                const formdata = new FormData(myForm);

                formdata.set("username", `A_${this.newCode}`)

                axios({
                    method: 'POST',
                    url: '/api/users/account/store',
                    data: formdata
                }).then(async () => {
                    // await this.$refs.Store.reset()
                    await this.GET_USERS_DATA()
                }).catch((err) => {
                    console.log("ERROR __")
                    console.err(err)
                })
                .finally(() => {
                    // this.insertDialog = false
                    this.toggleInsert(false);

                })
            }
        },

        Update(){
            if(this.$refs.Update.validate()){
                this.overlay = true;
                const myForm = document.getElementById('Update');
                const formdata = new FormData(myForm);

                axios({
                    method: 'POST',
                    url: `/api/users/account/update/${this.tempData.id}`,
                    data: formdata
                }).then( async () => {
                    await this.GET_USERS_DATA()
                    // await this.$refs.Update.reset()
                }).catch((err) => {
                    console.log("ERROR __")
                    console.err(err)
                })
                .finally(() => {
                    this.toggleEdit(false);
                    // this.editDialog = false
                })
            }
        },




        dataDelete(){
            axios({
                method: 'post',
                url: `/api/users/account/delete/${this.deleteData.id}`,
            }).then(async () =>{
                await this.GET_USERS_DATA()
            }).catch((err) => {
                console.log("ERROR __")
                console.err(err)
            })
            .finally(() => {
                this.deleteDialog = false
            })
        },


        toggleInsert(value){
            if(value){
                this.insertDialog = true
            }else{
                this.$refs.Store.reset();
                this.insertDialog =false;
            }
        },
        toggleDelete(item){
            this.deleteData = item
            this.deleteDialog = true
        },
        toggleEdit(value){
            if(value){
                this.editDialog =true;
            }else{
                this.$nextTick(() =>{
                    this.$refs.Update.reset();
                    // this.$refs.Store.reset();
                    this.editDialog =false;
                })
            }
        }
    },


      async mounted() {
        await this.GET_USERS_DATA("Adviser");
        await this.GET_COLLEGES_DATA();
        await this.GET_DEPARTMENTS_DATA();
        // await this.GET_ADVISER_SCHEDULE_DATA();
      },
}
</script>