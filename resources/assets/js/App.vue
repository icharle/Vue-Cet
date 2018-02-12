<template>
    <div>
        <h1>Hello, {{ msg }}!</h1>
        <router-view></router-view>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                msg: 'Vue'
            }
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">

</style>