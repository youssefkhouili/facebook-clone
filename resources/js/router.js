import Vue from "vue"
import VueRouter from "vue-router"
import {NewsFeed} from "./views";

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'news-feed',
            component: NewsFeed
        }
    ]
})
