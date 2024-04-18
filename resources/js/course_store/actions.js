const actions = {
    GET_COURSES_DATA({commit}, payload){
        axios({
            method: "GET",
            url: `api/course`,
        }).then((res) =>{
            commit('SET_COURSES_DATA', res.data)
        })
    }
}

export default actions;
