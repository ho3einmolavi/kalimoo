<template>
    <section>
        <center>
            <div class="col-xs col-sm col col-md col-lg col-xl-12 dashboard-page flex">
                <admin-dashboard ></admin-dashboard>

                <admin-dashboard-res></admin-dashboard-res>

                <router-view :flag="flag" :unreadnotifications="unreadnotifications" :setting_data="setting_data"></router-view>
            </div>
        </center>
    </section>
</template>

<script>
    export default {
        name: "admin-content" ,
        props: ['setting_data' , 'unreadnotifications' , 'flag']
    }
</script>

<style scoped>

</style>