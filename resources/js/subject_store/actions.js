const actions = {
    GET_SUBJECTS_DATA({commit}, payload){
        axios({
            method: "GET",
            url: `api/subjects`,
        }).then((res) =>{
            commit('SET_SUBJECTS_DATA', res.data)
        })
    }
}

export default actions;
