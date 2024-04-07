const scheduleActions = {

    getScheduleData(context){
        axios({
            method: "GET",
            url: '/api/schedules'
        }).then((res) =>{
            context.commit('getScheduleData', res.data)
        })
    },

    GET_SCHEDULE_STUDENTS({commit}, payload){
        axios({
            method: "GET",
            url: `/api/schedules/${payload}/students`
        }).then((res) =>{
            commit('SET_SCHEDULE_STUDENTS', res.data)
        })
    }

  }
  
  export default scheduleActions;
  