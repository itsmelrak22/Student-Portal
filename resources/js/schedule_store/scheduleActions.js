const scheduleActions = {

    getScheduleData(context){
        axios({
            method: "GET",
            url: '/getScheduleData'
        }).then((res) =>{
            context.commit('getScheduleData', res.data)
        })
    },

  }
  
  export default scheduleActions;
  