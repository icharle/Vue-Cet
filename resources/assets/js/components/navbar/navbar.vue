<template>
    <div class="navbar">
        <div class="tab">
            <div class="tab-item">
                <router-link to="/reserve"><i class="icon-circle-left"></i>
                    <p>预约查询</p></router-link>
            </div>
            <div class="tab-item">
                <router-link to="/ticket"><p>准考证查询</p></router-link>
            </div>
            <div class="tab-item">
                <router-link to="/query"><p>成绩查询</p><i class="icon-circle-right"></i></router-link>
            </div>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {}
</script>

<style lang="stylus" rel="stylesheet/stylus">
    .navbar
        .tab
            display flex
            width 100%
            height 2.3rem
            margin-top 2rem
            line-height 2.3rem
            .tab-item
                flex 1
                text-align center
                & > a
                    display block
                    &.active
                        font-size 2rem
                        color: #09f
                    p
                        display inline-block
                        padding 0 0.3rem 0 0.3rem
                    i
                        display inline-block
                        font-size 1.5rem
</style>