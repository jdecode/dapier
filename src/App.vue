<template>
  <div id="homepage" class="flex mx-20">
      <TopNav/>
      <Dashboard/>
  </div>
</template>

<script>
import TopNav from "./components/TopNav";
import Dashboard from "./components/Dashboard";
export default {
  name: 'App',
  components: {
    TopNav,
    Dashboard
  }
}
</script>
