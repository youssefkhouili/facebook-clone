<template>
    <div class="flex flex-col flex-1 h-screen overflow-y-hidden">
        <AppNav />
        <div class="flex overflow-y-hidden flex1">
            <AppSidebar />
            <div class="overflow-x-hidden w-2/3">
                <router-view :key="$route.fullPath"></router-view>
            </div>
        </div>
    </div>
</template>

<script>
import {Nav, Sidebar} from "./components"
export default {
    components: {
        AppNav:Nav,
        AppSidebar:Sidebar,
    },
    mounted() {
        this.$store.dispatch('fetchAuthUser')
    },
    created() {
        this.$store.dispatch('setPageTitle', this.$route.meta.title)
    },
    watch: {
        $route(to, from) {
            this.$store.dispatch('setPageTitle', to.meta.title)
        }
    }
}
</script>
