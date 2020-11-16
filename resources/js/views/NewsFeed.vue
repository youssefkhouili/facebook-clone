<template>
    <div class="flex flex-col items-center py-4">
        <NewPost />
        <span v-if="loading" class="mt-2">The posts is loading</span>
        <Post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post"/>
    </div>
</template>

<script>

import {NewPost, Post} from "../components"
export default {
    components: {
        NewPost,
        Post
    },
    data() {
        return {
            posts: null,
            loading: true
        }
    },
    mounted() {
        axios.get('/api/posts').then((response) => {

            this.posts = response.data

            this.loading = false

        }).catch((error) => {

            console.log(error)

        });
    }
}
</script>
