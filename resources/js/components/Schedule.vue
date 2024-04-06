<template>
    <v-container fluid>
        <v-btn @click="toggleInsert" dark small color="primary"><v-icon>mdi-plus</v-icon></v-btn>
        <v-simple-table>
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Subject</th>
                    <th>Professor</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in schedData" :key="index">
                    <td>{{item.sched_code}}</td>
                    <td>{{item.subject_name}}</td>
                    <td>{{item.prof_name}}</td>
                    <td>{{item.name}}</td>
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
                        <v-text-field dense name="sched_code" label="Schedule Code" outlined></v-text-field>
                        <v-autocomplete 
                            v-model="scheduleData.college_id"
                            dense
                            name="college" 
                            label="College" 
                            outlined
                            :items="collegeData"
                            item-text="name"
                            item-value="id"
                            @change="clearid('scheduleData',['department_id', 'subject_id', 'prof_id'])"
                        ></v-autocomplete>

                        <v-autocomplete 
                            v-model="scheduleData.department_id"
                            dense
                            name="department" 
                            label="Department" 
                            outlined
                            :items="filteredDepartment"
                            item-text="name"
                            item-value="id"
                            @change="clearid('scheduleData',[ 'subject_id', 'prof_id'])"
                        ></v-autocomplete>

                        <v-autocomplete 
                            v-model="scheduleData.subject_id"
                            dense
                            name="subject" 
                            label="Subject" 
                            outlined
                            :items="filteredSubject"
                            item-text="name"
                            item-value="id"
                            @change="clearid('scheduleData',[ 'prof_id'])"
                        ></v-autocomplete>
                       
                        <v-autocomplete 
                            v-model="scheduleData.prof_id"
                            dense
                            name="professor" 
                            label="Professor" 
                            outlined
                            :items="filteredProfessorData"
                            item-text="name"
                            item-value="id"
                            :disabled="!scheduleData.subject_id"
                        ></v-autocomplete>
                        <v-text-field dense name="name" label="Name" outlined></v-text-field>
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
                        <v-text-field dense v-model="tempCode" name="sched_code" label="Schedule Code" outlined></v-text-field>
                        <v-autocomplete 
                            v-model="tempSubject"
                            dense
                            name="subject" 
                            label="Subject" 
                            outlined
                            :items="subjectData"
                            item-text="name"
                            item-value="id"
                        ></v-autocomplete>
                        <v-autocomplete 
                            v-model="tempProf"
                            dense
                            name="professor" 
                            label="Professor" 
                            outlined
                            :items="filteredProfessorData"
                            item-text="name"
                            item-value="id"
                        ></v-autocomplete>
                        <v-text-field v-model="tempName" dense name="name" label="Name" outlined></v-text-field>
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
            tempCode: null,
            tempSubject: null,
            tempProf: null,
            editData: [],
            deleteData:[],
            scheduleData :{
                college_id: null,
                subject_id: null,
                department_id: null,
                prof_id: null
            }
        }
    },

    methods: {
        ...mapActions([
            'getSubjectData',
            'getProfessorData',
            'getDepartmentData',
            'getScheduleData',
            'getCollegeData',
        ]),

        clearid(prop,array){
            console.log(prop, array)
            array.forEach(el => {
                this[`${prop}`][el] = null
            });
        },

        dataDelete(){
            axios({
                method: 'post',
                url: 'api/schedule/delete',
                data: {id: this.deleteData.id}
            }).then(() =>{
                this.deleteDialog = false
                this.getScheduleData()
            })
        },

        updateData(){
            if(this.$refs.Edit.validate()){
                var myform = document.getElementById('Edit');
                var formdata = new FormData(myform);
                axios({
                    method: 'post',
                    url: 'api/scheule/update',
                    data: formdata
                }).then(() =>{
                    this.editDialog = false
                    this.getScheduleData()
                })
            }

        },

        saveData(){
            if(this.$refs.Insert.validate()){
                var myForm = document.getElementById('Insert')
                var formData = new FormData(myForm)

                axios({
                    method: 'post',
                    url: 'api/schedule/insert',
                    data: formData
                }).then(() =>{
                    this.insertDialog = false
                    this.$refs.Insert.reset()
                    this.getScheduleData()
                })
            }
        },

        Edit(data){
            console.log(data)
            this.editData = data
            this.tempName = data.name
            this.tempCode = data.sched_code
            this.tempSubject = data.subject_id
            this.tempProf = data.professor_id
            this.editDialog = true
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
            'subjectData',
            'professorData',
            'departmentData',
            'schedData',
            'collegeData',
        ]),


        filteredDepartment(){
            const filtered = [...this.departmentData];
            const test = filtered.filter(res => res.college_id == this.scheduleData.college_id);
            console.log("filteredDepartment", test)
            console.log("this.scheduleData", this.scheduleData)
            return test;
        },
        filteredSubject(){
            const filtered = [...this.subjectData];
            const test =  filtered.filter(res => res.department_id == this.scheduleData.department_id);
            console.log("this.scheduleData", this.scheduleData)
            console.log("filteredSubject", test)
            return test;
        },

        filteredProfessorData(){
            const filtered = [...this.professorData];
            return filtered.filter(res => res.department_id == this.scheduleData.department_id);
        },
      },

      async mounted() {
        await this.getProfessorData()
        await this.getDepartmentData()
        await this.getScheduleData()
        await this.getSubjectData()
        await this.getCollegeData()

        // alert(this.testString)
      },
}
</script>