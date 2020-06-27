<template>
  <div
      class="h-screen"
      :class="{'bg-gray-900 text-gray-500': this.dark, 'bg-gray-200 text-gray-700': !this.dark}">
      <div
          id="homepage"
          class="h-screen"
      >
          <div class="flex flex-col md:flex-row mx-0 md:mx-20 relative">
              <TopNav/>
              <Dashboard/>
          </div>
      </div>
      <Foot/>
  </div>
</template>

<script>
import TopNav from "./components/TopNav";
import Dashboard from "./components/Dashboard";
import Foot from "./components/Foot";

export default {
    name: 'App',
    computed: {
        dark() {
            return this.$store.getters.DARK
        }
    },
    components: {
        TopNav,
        Dashboard,
        Foot
    }
}
</script>
