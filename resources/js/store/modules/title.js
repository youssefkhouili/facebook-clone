const state = {

}

const getters = {

}

const actions = {
    setPageTitle({commit, state}, title) {
        commit('setTitle', title)
    }
}

const mutations = {
    setTitle(state, title) {
        state.title = title

        document.title = title
    }
}

export default {
    state, getters, actions, mutations
}
