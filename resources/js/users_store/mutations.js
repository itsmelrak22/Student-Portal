const mutations = {
    SET_USERS_DATA(state, payload){
        state.USERS_DATA = [...payload]
    },

    SET_PROFESSOR_SCHEDULE_DATA(state, payload){
        state.PROFESSOR_SCHEDULE_DATA = payload
    }
}

export default mutations;
