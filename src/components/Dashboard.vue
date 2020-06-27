<template>
    <div class="w-9/12 z-10 mx-auto flex-row">
        <div>
            <ul class="flex flex-row-reverse w-full">
                <li>
                    <router-link to="/login" class="text-2xl">
                        <i class="fa fa-user"></i>
                    </router-link>
                </li>
            </ul>
        </div>
        <div>
            <router-view class=""></router-view>
        </div>
    </div>
</template>
<script>
    export default {
    };
</script>
