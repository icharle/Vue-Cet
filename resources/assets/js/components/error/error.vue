<template>
    <div class="error" v-show="errors">
        <div class="icon-error"><i :class="(this.type) ? 'icon-checkmark' : 'icon-cross'"></i></div>
        <div class="err-msg">{{msg1}}<br>{{msg2}}</div>
        <div class="err-btn" @click="show()">确定</div>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                type: false,       //类型
                errors: false,    //错误提示
                msg1: '',            //提示语
                msg2: ''            //提示语
            }
        },
        methods: {
            show(type, msg1, msg2) {
                this.type = type
                this.errors = !this.errors
                this.msg1 = msg1
                this.msg2 = msg2
//                window.location.href = 'http://www.chsi.com.cn/cet/'
            }
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    .error
        position fixed
        top: 35%
        left 15%
        width 70%
        height 18.5rem
        z-index 100
        border-radius 0.5rem
        overflow hidden
        background #636b6f
        .icon-error
            width 4rem
            height 4rem
            border-radius 50%
            border 0.3rem solid red
            font-size 3rem
            color red
            line-height 4rem
            text-align center
            margin 1rem auto 0.5rem auto
        .err-msg
            font-size 1.5rem
            font-weight bold
            line-height 2rem
            color #ffffff
            padding-top 2.5rem
            text-align center
        .err-btn
            width 70%
            height 3rem
            position absolute
            bottom 1rem
            left 15%
            line-height 3rem
            border-radius 0.5rem
            text-align center
            font-size 2rem
            color #ffffff
            background-color red
</style>