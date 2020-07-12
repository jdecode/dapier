<template>
    <div class="w-9/12 z-10 mx-auto flex-row pt-1">
        <div>
            <ul class="flex flex-row-reverse">
                <li v-if="auth" class="w-8 h-8 flex items-center cursor-pointer">
                    <span @click="logout()" class="text-2xl mx-auto" title="Logout">
                        <i class="fa fa-sign-out"></i>
                    </span>
                </li>
                <li class="w-8 h-8 flex items-center cursor-pointer mx-4">
                    <router-link to="/login" class="text-2xl mx-auto" v-if="!auth">
                        <i class="fa fa-user"></i>
                    </router-link>
                    <router-link to="/profile" class="text-2xl mx-auto" v-if="auth">
                        <img
                            :src="user.photo"
                            :alt="user.name"
                            :title="user.name" />
                    </router-link>
                </li>
            </ul>
        </div>
        <div>
            <router-view class=""></router-view>
        </div>
    </div>
</template>
<script>
    export default {
        computed: {
            auth() {
                return this.$store.getters.AUTH
            },
            user() {
                return this.$store.getters.USER
            }
        },
        methods: {
            logout () {
                this.$store.dispatch("LOGOUT").then();
            }
        }
    };
</script>
