<template>
    <div class="w-40">
        <nav>
            <TopNavItem name="Read" fillcolor="#2152B6" active="true"/>
            <TopNavItem name="Learn" fillcolor="#AF3121"/>
            <TopNavItem name="Discuss" fillcolor="#E87A2E"/>
            <TopNavItem name="Listen" fillcolor="#32691A"/>
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
