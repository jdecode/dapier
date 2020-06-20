<template>
  <div
      class="h-screen"
      :class="{'bg-gray-900 text-gray-500': this.dark, 'bg-gray-200 text-gray-700': !this.dark}">
      <div
          id="homepage"
          class="h-screen"
      >
          <div class="flex mx-20">
              <TopNav/>
              <Dashboard/>
          </div>
      </div>
      <footer class="flex-col text-center -mt-8">
          <!--<span style="color: #9400d3">D</span><span style="color: #2152B6">API</span><span style="color: #32691A">ER</span><span style="color: #E87A2E">&copy;</span><span style="color: #AF3121">2020</span>-->
          DAPIER &copy; 2020
      </footer>
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
