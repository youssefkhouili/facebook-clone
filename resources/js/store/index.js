import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)
import {User, Title, Profile} from './modules'
export default new Vuex.Store({
    modules: {
        User,
        Title,
        Profile
    }
})
