const departmentActions = {

    GET_DEPARTMENTS_DATA(context){
        axios({
            method: "GET",
            url: '/api/departments'
        }).then((res) =>{
            context.commit('SET_DEPARTMENTS_DATA', res.data)
        })
    },

  }
  
  export default departmentActions;
  