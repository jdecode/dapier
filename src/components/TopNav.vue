<template>
    <div class="w-40">
        <nav>
            <TopNavItem name="Read" fillcolor="#AF3121" active="true"/>
            <TopNavItem name="Learn" fillcolor="#E87A2E"/>
            <TopNavItem name="Discuss" fillcolor="#32691A"/>
            <TopNavItem name="Listen" fillcolor="#2152B6"/>
            <TopNavItem name="Connect" fillcolor="#9400d3"/>
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
