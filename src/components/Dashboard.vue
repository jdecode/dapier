<template>
    <div class="w-4/5 mt-2">
        <div class="flex flex-row-reverse mr-2">
            <div class="dark-light-mode-toggler">
                <span
                    class="w-32 text-deepred cursor-pointer text-2xl"
                    @click="modeUpdate"
                    title="Toggle light/dark mode"
                >
                    <i class="fa fa-adjust"></i>
                </span>
            </div>
        </div>
        <router-view class="p-1"></router-view>
    </div>
</template>
<script>
    export default {
        computed: {
            dark() {
                return this.$store.getters.DARK
            }
        },
        methods: {
            modeUpdate: function () {
                this.$store.dispatch("THEME_UPDATE", !this.dark);
            }
        }
    };
</script>
