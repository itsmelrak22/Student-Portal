<template>
    <v-container fluid>
        <v-toolbar dense flat>
            <h1>College</h1>
        </v-toolbar>
        <v-btn @click="toggleInsert" dark small color="primary"><v-icon>mdi-plus</v-icon></v-btn>
        <v-simple-table>
            <thead>
                <tr>
                    <th>College Code</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in COLLEGES_DATA" :key="index">
                    <td>{{item.college_code}}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.created_at }}</td>
                    <td>
                        <v-btn @click="Edit(item)" icon dark small color="success"><v-icon>mdi-pencil</v-icon></v-btn>
                        <v-btn @click="toggleDelete(item)" icon dark small color="error"><v-icon>mdi-delete</v-icon></v-btn>
                    </td>
                </tr>
            </tbody>
        </v-simple-table>
        <v-dialog width="500" v-model="insertDialog" persistent>
            <v-form id="Insert" ref="Insert">
                <v-card>
                    <v-card-title>
                        Insert
                        <v-spacer/>
                        <v-btn @click="insertDialog = false" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field dense name="name" label="name" outlined></v-text-field>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn @click="saveData" block dark small color="success"><v-icon>mdi-content-save-outline</v-icon>Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <v-dialog width="500" v-model="editDialog" persistent>
            <v-form id="Edit" ref="Edit">
                <v-card>
                    <v-card-title>
                        Edit
                        <v-spacer/>
                        <v-btn @click="editDialog = false" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field v-model="tempName" name="name" label="name" outlined></v-text-field>
                        <input type="hidden" name="id" :value="editData.id">
                    </v-card-text>
                    <v-card-actions>
                        <v-btn @click="updateData" block dark small color="success"><v-icon>mdi-content-save-outline</v-icon>Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
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
import {mapState, mapActions} from 'vuex';
export default {
    data() {
        return {
            insertDialog: false,
            editDialog: false,
            deleteDialog: false,
            tempName: null,
            tempCollegeCode: null,
            editData: [],
            deleteData:[],
        }
    },

    methods: {
        ...mapActions([
            'GET_COLLEGES_DATA'
        ]),

        dataDelete(){
            axios({
                method: 'post',
                url: 'api/college/delete',
                data: {id: this.deleteData.id}
            }).then(() =>{
                this.deleteDialog = false
                this.GET_COLLEGES_DATA()
            })
        },

        updateData(){
            if(this.$refs.Edit.validate()){
                var myform = document.getElementById('Edit');
                var formdata = new FormData(myform);
                axios({
                    method: 'post',
                    url: 'api/college/update',
                    data: formdata
                }).then(() =>{
                    this.editDialog = false
                    this.GET_COLLEGES_DATA()
                })
            }

        },

        Edit(data){
            // console.log(data)
            this.editData = data
            this.tempCollegeCode = data.college_code
            this.tempName = data.name
            this.editDialog = true
        },

        saveData(){
            if(this.$refs.Insert.validate()){
                var myForm = document.getElementById('Insert')
                var formData = new FormData(myForm)

                axios({
                    method: 'post',
                    url: 'api/college/insert',
                    data: formData
                }).then(() =>{
                    this.insertDialog = false
                    this.$refs.Insert.reset()
                    this.GET_COLLEGES_DATA()
                })
            }
        },

        toggleInsert(){
            this.insertDialog = true
        },
        toggleDelete(item){
            this.deleteData = item
            this.deleteDialog = true
        }
    },

    computed: {
        ...mapState([
            'COLLEGES_DATA',
        ]),
      },

      mounted() {
        this.GET_COLLEGES_DATA()
      },
}
</script>