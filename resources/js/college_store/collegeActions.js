const collegeActions = {

    GET_COLLEGES_DATA(context){
        axios({
            method: "GET",
            url: '/api/colleges'
        }).then((res) =>{
            context.commit('SET_COLLEGES_DATA', res.data)
        })
    },

  }
  
  export default collegeActions;
  