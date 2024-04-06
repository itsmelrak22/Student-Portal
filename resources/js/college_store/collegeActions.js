const collegeActions = {

    getCollegeData(context){
        axios({
            method: "GET",
            url: '/getCollegeData'
        }).then((res) =>{
            context.commit('getCollegeData', res.data)
        })
    },

  }
  
  export default collegeActions;
  