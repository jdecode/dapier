<template>
    <div class="w-40">
        <nav>
            <TopNavItem name="About" fillcolor="#AF3121" active="true"/>
            <TopNavItem name="Integrations" fillcolor="#E87A2E"/>
            <TopNavItem name="Docs" fillcolor="#32691A"/>
            <TopNavItem name="Support" fillcolor="#2152B6"/>
            <TopNavItem name="Login/Register" fillcolor="#9400d3"/>
        </nav>
    </div>
</template>
<script>
    import TopNavItem from "./TopNavItem";
    export default {
        components: {
            TopNavItem
        }
    };
</script>
