<template>
    <a href="#" class="group flex items-center px-3 text-sm leading-5 font-medium text-gray-600 rounded-md focus:outline-none transition ease-in-out duration-150" aria-current="page">
        <svg width="8" height="40" xmlns="http://www.w3.org/2000/svg">
            <g>
                <rect stroke="#000" width="8" height="40" y="0" x="0" stroke-width="0" :fill="fillcolor"/>
            </g>
        </svg>
        <span class="truncate text-sm -pt-1 pl-1" :class="{'font-bold': active}">
          {{name}}
        </span>
    </a>
</template>
<script>
    export default {
        props: {
            name: String,
            fillcolor: String,
            active: String
        }
    };
</script>
