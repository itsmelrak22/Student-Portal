<template>
    <v-container fluid>
        <v-toolbar dense flat>
            <h1>Course</h1>
        </v-toolbar>
        <v-btn @click="toggleInsert" dark small color="primary"><v-icon>mdi-plus</v-icon></v-btn>
        <v-simple-table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Course</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in COURSES_DATA" :key="index">
                    <td>{{item.course_code}}</td>
                    <td>{{item.course_name}}</td>
                    <td>{{item.department_name}}</td>
                    <td>{{ item.created_at }}</td>
                    <td>
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
                            <span>CREATE COURSE ENTRY</span>
                        <v-spacer/>
                        <v-btn @click="insertDialog = false" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
                        </v-card-title>
                        <v-card-text>
                            <v-col cols="12" >
                                <v-text-field
                                    dense
                                    outlined
                                    label="COURSE CODE"
                                    :rules="rules.required"
                                    name="course_code"
                                ></v-text-field>

                                <v-text-field 
                                    dense 
                                    name="course_name" 
                                    label="COUSE NAME" 
                                    outlined
                                    :rules="rules.required"
                                ></v-text-field>

                                <v-autocomplete
                                    dense 
                                    name="department_id" 
                                    label="DEPARTMENT" 
                                    outlined
                                    :rules="rules.required"
                                    :items="DEPARTMENTS_DATA"
                                    chips
                                    small-chips
                                    item-text="name"
                                    item-value="id"
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
                            <span>UPDATE COURSES ENTRY</span>
                        <v-spacer/>
                        <v-btn @click="editDialog = false" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
                        </v-card-title>
                        <v-card-text>
                            <v-col cols="12" >
                                <v-text-field
                                    v-model="tempData.course_code"
                                    dense
                                    outlined
                                    label="COURSE CODE"
                                    :rules="rules.required"
                                    name="course_code"
                                ></v-text-field>

                                <v-text-field 
                                    v-model="tempData.course_name"
                                    dense 
                                    name="course_name" 
                                    label="COUSE NAME" 
                                    outlined
                                    :rules="rules.required"
                                ></v-text-field>

                                <v-autocomplete
                                    v-model="tempData.department_id"
                                    dense 
                                    name="department_id" 
                                    label="DEPARTMENT" 
                                    outlined
                                    :rules="rules.required"
                                    :items="DEPARTMENTS_DATA"
                                    chips
                                    small-chips
                                    item-text="name"
                                    item-value="id"
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
            'COURSES_DATA',
            'rules',
            'ROLES',
            'DEPARTMENTS_DATA'
        ]),
        ...mapGetters([
        ]),


      },


    methods: {
        ...mapActions([
            "GET_COURSES_DATA",
            "GET_DEPARTMENTS_DATA",
        ]),
        Edit(data){
            this.tempData = {...data};
            this.editDialog = true
        },


        Store(){
            if(this.$refs.Store.validate()){
                this.overlay = true;
                const myForm = document.getElementById('Store');
                const formdata = new FormData(myForm);

                axios({
                    method: 'POST',
                    url: '/api/course/store',
                    data: formdata
                }).then(async () => {
                    await this.$refs.Store.reset()
                    await this.GET_COURSES_DATA()
                    await this.GET_DEPARTMENTS_DATA()
                }).catch((err) => {
                    console.log("ERROR __")
                    console.err(err)
                })
                .finally(() => {
                    this.insertDialog = false

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
                    url: `/api/course/update/${this.tempData.id}`,
                    data: formdata
                }).then( async () => {
                    await this.GET_COURSES_DATA()
                    await this.GET_DEPARTMENTS_DATA()
                    await this.$refs.Update.reset()
                }).catch((err) => {
                    console.log("ERROR __")
                    console.err(err)
                })
                .finally(() => {
                    this.editDialog = false
                })
            }
        },




        dataDelete(){
            axios({
                method: 'post',
                url: `/api/course/delete/${this.deleteData.id}`,
            }).then(async () =>{
                await this.GET_COURSES_DATA()
                await this.GET_DEPARTMENTS_DATA()
            }).catch((err) => {
                console.log("ERROR __")
                console.err(err)
            })
            .finally(() => {
                this.deleteDialog = false
            })
        },


        toggleInsert(){
            this.insertDialog = true
        },
        toggleDelete(item){
            this.deleteData = item
            this.deleteDialog = true
        }
    },


      async mounted() {
        await this.GET_COURSES_DATA();
        await this.GET_DEPARTMENTS_DATA();

        console.log(this.COURSES_DATA);
      },
}
</script>