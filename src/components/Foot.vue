<template>
    <footer class="flex justify-center items-center -mt-10">
        <!--<span style="color: #9400d3">D</span><span style="color: #2152B6">API</span><span style="color: #32691A">ER</span><span style="color: #E87A2E">&copy;</span><span style="color: #AF3121">2020</span>-->
        <span class="">DAPIER 2020</span>
        <div class="dark-light-mode-toggler pl-10">
                <span
                    class="w-32 cursor-pointer text-2xl"
                    @click="modeUpdate"
                    title="Toggle light/dark mode"
                >
                    <i class="fa fa-adjust"></i>
                </span>
        </div>
    </footer>
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
