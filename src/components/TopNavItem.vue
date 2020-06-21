<template>
    <router-link :to="to" class="group flex items-center leading-5 rounded-md focus:outline-none transition ease-in-out duration-150" aria-current="page">
        <svg width="8" height="40" xmlns="http://www.w3.org/2000/svg">
            <g>
                <rect stroke="#000" width="8" height="40" y="0" x="0" stroke-width="0" :fill="fillcolor"/>
            </g>
        </svg>
        <span class="truncate -pt-1 pl-1">
          {{name}}
        </span>
    </router-link>
</template>
<script>
    export default {
        name: 'TopNavItem',
        props: {
            name: String,
            fillcolor: String,
            active: String,
            to: String
        }
    };
</script>
