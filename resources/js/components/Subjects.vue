<template>
    <v-container fluid>
        <v-toolbar dense flat>
            <h1>Subjects</h1>
        </v-toolbar>
        <v-btn @click="toggleInsert(true)" dark small color="primary"><v-icon>mdi-plus</v-icon></v-btn>
        <v-simple-table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in SUBJECTS_DATA" :key="index">
                    <td>{{item.name}}</td>
                    <td>{{item.dept_name}}</td>
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
                        <v-btn @click="toggleInsert(false)" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field 
                            :rules="rules.required" 
                            dense 
                            name="subject_code" 
                            label="CODE" 
                            outlined
                        ></v-text-field>

                        <v-text-field 
                            :rules="rules.required" 
                            dense 
                            name="name" 
                            label="NAME" 
                            outlined
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
                            item-value="id"
                            autocomplete="off"
                            item-text="name"
                        ></v-autocomplete>

                        
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
                        <v-btn @click="toggleEdit(false)" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field :rules="rules.required" v-model="tempData.subject_code" name="subject_code" label="CODE" outlined></v-text-field>
                        <v-text-field :rules="rules.required" v-model="tempData.name" name="name" label="NAME" outlined></v-text-field>
                        <v-autocomplete
                            v-model="tempData.department_id" 
                            dense
                            name="dept_id" 
                            label="Department" 
                            outlined
                            :items="DEPARTMENTS_DATA"
                            item-text="name"
                            item-value="id"
                            :rules="rules.required"
                        ></v-autocomplete>
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
            tempData: {},
            // tempName: null,
            // tempCode: null,
            // tempDepartment: null,
            // tempCollege: null,
            editData: [],
            deleteData:[],
        }
    },

    methods: {
        ...mapActions([
            'GET_SUBJECTS_DATA',
            'GET_DEPARTMENTS_DATA',
        ]),

        dataDelete(){
            axios({
                method: 'post',
                url: 'api/subject/delete',
                data: {id: this.deleteData.id}
            }).then(() =>{
                this.deleteDialog = false
                this.GET_SUBJECTS_DATA()
            })
        },

        updateData(){
            if(this.$refs.Edit.validate()){
                var myform = document.getElementById('Edit');
                var formdata = new FormData(myform);
                axios({
                    method: 'post',
                    url: 'api/subject/update',
                    data: formdata
                }).then(() =>{
                    this.editDialog = false
                    this.GET_SUBJECTS_DATA()
                })
            }

        },

        Edit(data){
            console.log(data)
            this.editData = data
            this.tempData = {...data}
            // this.tempName = data.name
            // this.tempCode = data.subject_code
            // this.tempDepartment = data.department_id
            this.editDialog = true
        },

        saveData(){
            if(this.$refs.Insert.validate()){
                var myForm = document.getElementById('Insert')
                var formData = new FormData(myForm)

                axios({
                    method: 'post',
                    url: 'api/subject/insert',
                    data: formData
                }).then(() =>{
                    this.insertDialog = false
                    this.$refs.Insert.reset()
                    this.GET_SUBJECTS_DATA()
                })
            }
        },

        toggleInsert(value){
            if(value){
                this.insertDialog = true
            }else{
                this.$refs.Insert.reset();
                this.insertDialog = false
            }
        },
        toggleEdit(value){
            if(value){
                this.editDialog = true
            }else{
                this.$refs.Edit.reset();
                this.editDialog = false
            }
        },
        toggleDelete(item){
            this.deleteData = item
            this.deleteDialog = true
        }
    },

    computed: {
        ...mapState([
            'SUBJECTS_DATA',
            'DEPARTMENTS_DATA',
            'rules',
        ]),

        COLLEGES(){
            return this.COLLEGES_DATA;
        },

        DEPARTMENTS(){
            return this.DEPARTMENTS_DATA.filter( dept => dept.college_id == this.tempData.college_id );
        }
      },

      mounted() {
        this.GET_SUBJECTS_DATA()
        this.GET_DEPARTMENTS_DATA()
      },
}
</script>