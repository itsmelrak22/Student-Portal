const scheduleMutations = {
  
    getScheduleData(state, payload){
        state.schedData = payload
    },

    SET_SCHEDULE_STUDENTS(state, payload){
        state.SCHEDULE_STUDENTS.length = 0
        state.SCHEDULE_STUDENTS = payload
    },
}

export default scheduleMutations;
