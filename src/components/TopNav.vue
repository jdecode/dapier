<template>
    <div class="top-nav w-auto flex flex-col absolute z-10">
        <div class="logo h-10 w-10 mx-2 my-1 mb-5">
            <router-link to="/">
                <img src="/img/logo.png" alt="DAPIER!" />
            </router-link>
        </div>
        <div>
                <span class="float-left mr-5 md:mr-0" @click="showMenu = !showMenu">
                    <i class="fa fa-bars"></i>
                </span>
        </div>
        <nav :class="{ 'hidden sm:hidden md:invisible': !showMenu}">
            <TopNavItem name="Home" fillcolor="#AF3121" active="true" to="home" />
            <TopNavItem name="Integrations" fillcolor="#E87A2E" to="integrations" />
            <TopNavItem name="Docs" fillcolor="#32691A" to="docs" />
            <TopNavItem name="Support" fillcolor="#2152B6" to="support" />
            <TopNavItem name="Login" fillcolor="#9400d3" to="login" />
        </nav>
    </div>
</template>
<script>
    import TopNavItem from "./TopNavItem";
    export default {
        data: function () {
            return {
                showMenu: false
            }
        },
        name: 'TopNav',
        components: {
            TopNavItem
        }
    };
</script>
