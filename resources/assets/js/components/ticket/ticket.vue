<template>
    <div class="ticket">
        <div class="head">
            <img src="/img/banner.jpg">
        </div>
        <div class="content">
            <span class="title">四六级准考证查询</span>
            <form class="getticket">
                <div class="input-wrap">
                    <span><i class="icon-user"></i></span>
                    <div class="input-inner">
                        <input type="text" v-model="xm" placeholder="姓名"/>
                    </div>
                </div>
                <div class="input-wrap">
                    <span><i class="icon-profile"></i></span>
                    <div class="input-inner">
                        <input type="text" v-model="sfz" placeholder="身份证"/>
                    </div>
                </div>
                <div class="radio-wrap">
                    <label><input type="radio" class="radio" name="type" value="1" checked/><span>四级</span></label>
                    <label><input type="radio" class="radio" name="type" value="2" /><span>六级</span></label>
                </div>
                <div class="btn">{{submitBtn}}</div>
            </form>
        </div>
        <div class="footer">
            <p>Copyright © 2018 <a href="https://icharle.com">Icharle</a>. All rights reserved.</p>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                xm: '',
                sfz: '',
                submitBtn: '查 询'
            }
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    .ticket
        display flex
        flex-direction column
        height 100%
        max-height 100%
        .head
            width 100%
            height 25rem
            img
                width 100%
                height 100%
                min-width 100%
                min-height 100%
        .content
            width 100%
            flex 1
            .title
                display inherit
                text-align center
                font-size 2.3rem
                line-height 2.3rem
            .getticket
                width 100%
                .input-wrap
                    width 18rem
                    position relative
                    padding 0.5rem 0.6rem 0.5rem 3.4rem
                    margin 2rem auto 0.5rem auto
                    border 0.08rem solid #ccc
                    border-radius 0.5rem
                    span
                        position absolute
                        top 1.2rem
                        left 1rem
                        font-size 2.2rem
                    input
                        width 100%
                        line-height 3.5rem
                        font-size 1.4rem
                        border-width 0
                .radio-wrap
                    width 20rem
                    margin 2rem auto 1rem auto
                    label
                        input
                            -webkit-appearance: none;
                            -moz-appearance: none;
                            appearance: none;
                            border: 0;
                            outline: 0 !important;
                            vertical-align middle
                        span
                            padding-left 0.4rem
                            font-size 1.3rem
                            vertical-align middle
                        .radio:after {
                            content ""
                            display block
                            width 1.8rem
                            height 1.8rem
                            border-radius 50%
                            text-align center
                            line-height 1.8rem
                            font-size 1.3rem
                            color #09f
                            border 0.2rem solid #ddd
                            background-color #fff
                            box-sizing border-box
                        }
                        .radio:checked:after {
                            content "\2713"
                            border-color #09f
                            transition all 0.3s ease-in-out
                        }
                .btn
                    margin 3rem auto 0rem auto
                    width 19rem
                    height 3rem
                    line-height 3rem
                    text-align center
                    border none
                    font-size 2rem
                    color #ffffff
                    border-radius 0.5rem
                    background-color #636b6f
        .footer
            width 100%
            height 2rem
            line-height 2rem
            text-align center
</style>