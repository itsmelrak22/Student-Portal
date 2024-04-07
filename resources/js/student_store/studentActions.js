const studentActions = {

    GET_STUDENTS_DATA(context){
        axios({
            method: "GET",
            url: '/api/students'
        }).then((res) =>{
            context.commit('SET_STUDENTS_DATA', res.data)
        })
    },

    GET_STUDENT_SUBJECTS({commit}, payload){
        axios({
            method: "GET",
            url: `/api/users/students/${payload}/schedules`
        }).then((res) =>{
            context.commit('GET_STUDENT_SUBJECTS', res.data)
        })
    }

  }
  
  export default studentActions;
  