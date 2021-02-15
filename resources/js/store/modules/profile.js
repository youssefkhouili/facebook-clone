const state = {
    user: null,
    userStatus: null
}
const getters = {
    user: state => state.user
}
const mutations = {
    setUser(state, user) {
        state.user = user
    },
    setUserStatus(state, status) {
        state.userStatus = status
    }
}
const actions = {
    fetchUser({commit, state}, userId) {
        commit('setUserStatus', 'loading');
        axios.get('/api/users/' + userId).then(({data}) => {
            commit('setUser', data);
            commit('setUserStatus', 'success');
        }).catch((error) => {
            commit('setUserStatus', 'error');
        })
    }
}

export default {
    state, getters, mutations, actions
}
