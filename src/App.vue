<template>
  <div
      id="homepage"
      class="h-screen"
      :class="{'bg-gray-900 text-gray-500': this.dark, 'bg-gray-200 text-gray-700': !this.dark}">
      <div class="flex mx-20">
          <TopNav/>
          <Dashboard/>
      </div>
  </div>
</template>

<script>
import TopNav from "./components/TopNav";
import Dashboard from "./components/Dashboard";
export default {
    name: 'App',
    computed: {
        dark() {
            return this.$store.getters.DARK
        }
    },
    components: {
        TopNav,
        Dashboard
    }
}
</script>
