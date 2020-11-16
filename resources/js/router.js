import Vue from "vue"
import VueRouter from "vue-router"
import {NewsFeed} from "./views";
import {UserShow} from "./views/Users";

Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'news-feed',
            component: NewsFeed
        },
        {
            path: '/users/:userId',
            name: 'user.show',
            component: UserShow
        },
    ]
})
