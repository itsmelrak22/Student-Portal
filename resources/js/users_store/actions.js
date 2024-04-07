const actions = {
    GET_USERS_DATA({commit}, payload){
        axios({
            method: "GET",
            url: `api/users/${payload}`,
        }).then((res) =>{
            commit('SET_USERS_DATA', res.data)
        })
    },

    GET_PROFESSOR_SCHEDULE_DATA({commit}, payload){
        console.log(payload)
        axios({
            method: "GET",
            url: `api/users/professor/${payload}`,
        }).then((res) =>{
            commit('SET_PROFESSOR_SCHEDULE_DATA', res.data)
        })
    },
}

export default actions;