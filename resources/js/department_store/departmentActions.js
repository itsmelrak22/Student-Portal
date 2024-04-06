const departmentActions = {

    getDepartmentData(context){
        axios({
            method: "GET",
            url: '/getDepartmentData'
        }).then((res) =>{
            context.commit('getDepartmentData', res.data)
        })
    },

  }
  
  export default departmentActions;
  