<template>
    <div class="flex flex-col items-center">
        <div class="relative">
            <span v-if="user_loading">Loading User page</span>
            <div class="w-100 h-64 overflow-hidden z-1" v-else>
                <img src="/img/background-profile.jpg" class="object-cover w-full" alt="background-profile">
            </div>
            <div class="ml-6 absolute flex items-center bottom-0 left-0 -mb-8 z-2">
                <div class="w-32">
                    <img src="/img/profile.jpg" class="object-cover border-4 border-gray-200 w-32 rounded-full shadow-lg" alt="user profile image">
                </div>
                <span class="ml-4 tracking-wider text-3xl text-gray-100">{{ user.data.attributes.name | capitalize }}</span>
            </div>
            <div class="ml-6 absolute flex items-center bottom-0 right-0 mb-4 mr-12 z-2">
                <button class="py-1 px-3 bg-gray-400 rounded">Add Friend</button>
            </div>

        </div>
        <span v-if="post_loading" class="mt-2">The posts is loading</span>
        <Post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post"/>
        <span class="text-2xl mt-8" v-if="!post_loading && posts.data.length < 1">User Has no Posts</span>
    </div>
</template>

<script>
import {Post} from '../../components';
import { mapGetters } from 'vuex';
export default {
    data() {
        return {
            posts: null,
            post_loading: true
        }
    },
    components: {
        Post
    },
    mounted() {
        this.$store.dispatch('fetchUser', this.$route.params.userId);
        axios.get('/api/users/' + this.$route.params.userId + '/posts').then(({data}) => {
            this.posts = data
        }).catch((error) => {
            console.log('Sorry theres no post to see!')
        }).finally(() => {
            this.post_loading = false
        })
    },
    computed:{
        ...mapGetters({
            user: 'user'
        })
    }
}
</script>
