<template>
    <v-container fluid>
        <v-toolbar dense flat>
            <h1>Schedule</h1>
        </v-toolbar>
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
                        <v-btn @click="viewData(item.id)" icon dark small color="success"><v-icon>mdi-account-plus</v-icon></v-btn>
                        <v-btn @click="Edit(item)" icon dark small color="success"><v-icon>mdi-pencil</v-icon></v-btn>
                        <v-btn @click="toggleDelete(item)" icon dark small color="error"><v-icon>mdi-delete</v-icon></v-btn>
                    </td>
                </tr>
            </tbody>
        </v-simple-table>
        <v-dialog width="500" v-model="insertDialog" persistent>
            <!-- <v-form id="Insert" ref="Insert"> -->
            <v-form id="Store" ref="Store" @submit.prevent="Store">
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
                            :items="COLLEGES_DATA"
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
                            @change="clearid('scheduleData',[ 'subject_id', 'professor_id'])"
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
                            @change="clearid('scheduleData',[ 'professor_id'])"
                        ></v-autocomplete>
                       
                        <v-autocomplete 
                            v-model="scheduleData.professor_id"
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
                        <v-btn type="submit" block dark small color="success"><v-icon>mdi-content-save-outline</v-icon>Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <v-dialog width="500" v-model="editDialog" persistent>
            <!-- <v-form id="Edit" ref="Edit"> -->
            <v-form id="Update" ref="Update" @submit.prevent="Update">
                <v-card>
                    <v-card-title>
                        Edit
                        <v-spacer/>
                        <v-btn @click="toggleEditDialog(false)" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field dense v-model="scheduleData.sched_code" name="sched_code" label="Schedule Code" outlined></v-text-field>
                        <v-autocomplete 
                            v-model="scheduleData.college_id"
                            dense
                            name="college" 
                            label="College" 
                            outlined
                            :items="COLLEGES_DATA"
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
                            @change="clearid('scheduleData',[ 'subject_id', 'professor_id'])"
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
                            @change="clearid('scheduleData',[ 'professor_id'])"
                        ></v-autocomplete>
                       
                        <v-autocomplete 
                            v-model="scheduleData.professor_id"
                            dense
                            name="professor" 
                            label="Professor" 
                            outlined
                            :items="filteredProfessorData"
                            item-text="name"
                            item-value="id"
                            :disabled="!scheduleData.subject_id"
                        ></v-autocomplete>
                        <v-text-field v-model="scheduleData.name" dense name="name" label="Name" outlined></v-text-field>
                        <input type="hidden" name="id" :value="editData.id">
                    </v-card-text>
                    <v-card-actions>
                        <v-btn type="submit" block dark small color="success"><v-icon>mdi-content-save-outline</v-icon>Update</v-btn>
                    </v-card-actions>
                </v-card>
            </v-form>
        </v-dialog>
        <v-row>
            <v-dialog width="600" v-model="viewDialog">
                <v-card>
                    <v-card-title>
                        Add Student to this schedule
                        
                    </v-card-title>
                    <v-card-text>
                        <v-form id="StoreStudentSched" ref="StoreStudentSched" @submit.prevent="StoreStudentSched">
                            <div>
                                <input type="hidden" name="sched_id" :value="SCHEDULE_STUDENTS.id">
                                <p>SCHEDULE CODE : <span>{{ SCHEDULE_STUDENTS.sched_code }}</span></p>
                                <p>SUBJECT CODE : <span >{{ SCHEDULE_STUDENTS.subject_code }}</span></p>
                                <p>SUBJECT NAME : <span>{{ SCHEDULE_STUDENTS.subject_name }}</span></p>
                            </div>

                            <div>
                                <v-autocomplete 
                                    dense
                                    name="student_id"
                                    label="Student Code" 
                                    outlined
                                    :items="filterStudentsForSchedule"
                                    item-text="username"
                                    item-value="id"
                                ></v-autocomplete>
                                <v-spacer></v-spacer>
                            </div>
                            <v-btn type="submit" dark small color="success"><v-icon>mdi-content-save-outline</v-icon>Submit</v-btn>

                        </v-form>
                    </v-card-text>
                    <v-card-text>
                        <v-simple-table>
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Schedule Code</th>
                                    <th>Schedule Name</th>
                                    <th>Professor</th>
                                    <th>Subject</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(student, index) in SCHEDULE_STUDENTS.students" :key="index + 'student'">
                                    <td>{{ student.student_name }}</td>
                                    <td>{{ SCHEDULE_STUDENTS.sched_code }}</td>
                                    <td>{{ SCHEDULE_STUDENTS.name }}</td>
                                    <td>{{ SCHEDULE_STUDENTS.prof_name }}</td>
                                    <td>{{ SCHEDULE_STUDENTS.subject_name }}</td>
                                </tr>
                            </tbody>
                        </v-simple-table>
                    </v-card-text>
                </v-card>
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
import studentData from './student_props/studentData';
import studentMethods from './student_props/studentMethods';
export default {
    data() {
        return {
            ...studentData,
            insertDialog: false,
            editDialog: false,
            deleteDialog: false,
            tempName: null,
            tempCode: null,
            tempSubject: null,
            tempProf: null,
            editData: [],
            deleteData:[],
            tempData:{},
            scheduleData :{
                college_id: null,
                subject_id: null,
                department_id: null,
                professor_id: null,
                name: null,
                sched_code: null,
            },
            selectedScheduleId: 0,
        }
    },

    computed: {
        ...mapState([
            'SUBJECTS_DATA',
            // 'professorData',
            'DEPARTMENTS_DATA',
            'schedData',
            'COLLEGES_DATA',
            'SCHEDULE_STUDENTS',
        ]),

        ...mapGetters([
            "PROFESSORS_USERS_DATA",
            "STUDENT_USERS_DATA",
        ]),

        filteredDepartment(){
            const filtered = [...this.DEPARTMENTS_DATA];
            const test = filtered.filter(res => res.college_id == this.scheduleData.college_id);
            return test;
        },
        filteredSubject(){
            const filtered = [...this.SUBJECTS_DATA];
            const test =  filtered.filter(res => res.department_id == this.scheduleData.department_id);
            return test;
        },

        filteredProfessorData(){
            const filtered = [...this.PROFESSORS_USERS_DATA];
            return filtered.filter(res => res.department_id == this.scheduleData.department_id);
        },
        
        filterStudentsForSchedule(){
            const filtered = [...this.STUDENT_USERS_DATA];

            console.log('filtered', filtered)
            return filtered.filter(res => res.department_id == this.scheduleData.department_id);

        }
      },

    methods: {
        ...mapActions([
            'GET_SUBJECTS_DATA',
            // 'getProfessorData',
            'GET_DEPARTMENTS_DATA',
            'getScheduleData',
            'GET_COLLEGES_DATA',
            'GET_USERS_DATA',
            'GET_SCHEDULE_STUDENTS',
            
        ]),

        // ...studentMethods,

        StoreStudentSched(){
            if(this.$refs.StoreStudentSched.validate()){
                // this.overlay = true;
                const myForm = document.getElementById('StoreStudentSched');
                const formdata = new FormData(myForm);

                axios({
                    method: 'post',
                    url: 'api/student_schedule/insert',
                    data: formdata,
                }).then(async () => {
                    await this.$refs.StoreStudentSched.reset()
                    await this.GET_SCHEDULE_STUDENTS(this.selectedScheduleId)

                }).catch((err) => {
                    console.log("ERROR __")
                    console.err(err)
                }).finally(() => {
                })
            }
        },

        async viewData(id){
            console.log(id)
            this.selectedScheduleId = id
            await this.GET_SCHEDULE_STUDENTS(id)
            this.viewDialog = true

        },


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

        Update(){
            if(this.$refs.Update.validate()){
                // this.overlay = true;
                const myForm = document.getElementById('Update');
                const formdata = new FormData(myForm);

                axios({
                    method: 'post',
                    url: 'api/schedule/update',
                    data: formdata
                }).then( async () => {
                    await this.getScheduleData()
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

        Store(){
            if(this.$refs.Store.validate()){
                // this.overlay = true;
                const myForm = document.getElementById('Store');
                const formdata = new FormData(myForm);

                axios({
                    method: 'post',
                    url: 'api/schedule/insert',
                    data: formdata
                }).then(async () => {
                    await this.$refs.Store.reset()
                    await this.getScheduleData()
                }).catch((err) => {
                    console.log("ERROR __")
                    console.err(err)
                })
                .finally(() => {
                    this.insertDialog = false

                })
            }
        },

        Edit(data){
            this.editData = data
            // this.tempName = data.name
            // this.tempCode = data.sched_code
            // this.tempSubject = data.subject_id
            // this.tempProf = data.professor_id
            this.scheduleData = {...data};
            console.log(`this.scheduleData : ${this.scheduleData.professor_id}`)

            this.editDialog = true
        },
        toggleEditDialog(data){
            if(data){
                this.editDialog = true
            }else{
                this.$refs.Update.reset();
                this.editDialog = false
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



      async mounted() {
        // await this.getProfessorData()
        await this.GET_USERS_DATA("Professor");
        await this.GET_USERS_DATA("Student");
        await this.GET_DEPARTMENTS_DATA()
        await this.getScheduleData()
        await this.GET_SUBJECTS_DATA()
        await this.GET_COLLEGES_DATA()

        // alert(this.testString)
      },
}
</script>