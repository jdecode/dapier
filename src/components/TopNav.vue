<template>
    <div class="top-nav w-1/5">
        <div class="logo h-10 w-10 mx-5 my-1 mb-5">
            <router-link to="/">
                <img src="/img/logo.png" alt="DAPIER!" />
            </router-link>
        </div>
        <nav>
            <TopNavItem name="Home" fillcolor="#AF3121" active="true" to="home" />
            <TopNavItem name="Integrations" fillcolor="#E87A2E" to="integrations" />
            <TopNavItem name="Docs" fillcolor="#32691A" to="docs" />
            <TopNavItem name="Support" fillcolor="#2152B6" to="support" />
            <TopNavItem name="Login/Register" fillcolor="#9400d3" to="login-register" />
        </nav>
    </div>
</template>
<script>
    import TopNavItem from "./TopNavItem";
    export default {
        name: 'TopNav',
        components: {
            TopNavItem
        }
    };
</script>
