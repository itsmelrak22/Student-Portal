const actions = {
    GET_EVENTS_DATA({commit}, payload){
        axios({
            method: "GET",
            url: `api/events`,
        }).then((res) =>{
            commit('SET_EVENTS_DATA', res.data)
        })
    }
}

export default actions;
