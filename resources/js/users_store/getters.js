const getters = {
    ACTIVE_USERS (state) {
        return state.USERS_DATA.filter(user => user.deleted_at == null);
    },
    REGISTRARS_USERS_DATA (state, getters) {
        return getters.ACTIVE_USERS.filter(user => user.role == "Registrar");
    },
    PROFESSORS_USERS_DATA (state, getters) {
        return getters.ACTIVE_USERS.filter(user => user.role == "Professor");
    },
    STUDENT_USERS_DATA (state, getters) {
        return getters.ACTIVE_USERS.filter(user => user.role == "Student");
    },
    ADVISERS_USERS_DATA (state, getters) {
        return getters.ACTIVE_USERS.filter(user => user.role == "Adviser");
    },
}

export default getters;
