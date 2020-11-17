const state = {
    user: null,
    userStatus: null
}
const getters = {
    authUser: state => state.user
}
const mutations = {
    setAuthUser(state, user) {
        state.user = user
    }
}
const actions = {
    fetchAuthUser({commit, state}) {
        axios.get('/api/auth-user').then(({data}) => {
            commit('setAuthUser', data)
        }).catch(error => {
            console.log('Can not load any user');
        })
    }
}

export default {
    state, getters, mutations, actions
}
