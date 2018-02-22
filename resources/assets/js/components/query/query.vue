<template>
    <div class="query">
        <div class="header"></div>
        <div class="content">
            <span class="title">四六级成绩查询</span>
            <form class="getscore" v-show="turnScore">
                <div class="input-wrap">
                    <span><i class="icon-user"></i></span>
                    <div class="input-inner">
                        <input type="text" v-model="name" placeholder="姓名"/>
                    </div>
                </div>
                <div class="input-wrap">
                    <span><i class="icon-profile"></i></span>
                    <div class="input-inner">
                        <input type="text" v-model="ticket" placeholder="准考证"/>
                    </div>
                </div>
                <div class="btn" @click="submit()">{{submitBtn}}</div>
            </form>
            <score ref="score" @changebtn="changebtn" @changescore="changescore"></score>
        </div>
        <foot></foot>
    </div>
</template>

<script type="text/ecmascript-6">
    import foot from '../footer/footer'
    import score from '../score/score'

    export default {
        data() {
            return {
                name: '',     //姓名
                ticket: '',    //准考证
                submitBtn: '查询成绩',    //按钮
                turnScore: true     //表单框控制是否隐藏
            }
        },
        methods: {
            submit() {
                this.$refs.score.submit(this.name, this.ticket)
            },
            changebtn(txt) {
                this.submitBtn = txt
            },
            changescore(txt) {
                this.turnScore = txt
            }
        },
        components: {
            foot,
            score
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    .query
        display flex
        flex-direction column
        height 100%
        min-height 100%
        .header
            width 100%
            height 12rem
            margin 0 auto
            background-image url(../detail/query.jpg)
            background-repeat no-repeat
            background-size 100% 100%
        .content
            width 100%
            flex 1
            -webkit-flex 1
            overflow auto
            .title
                display inherit
                padding-top 2rem
                text-align center
                font-size 2.3rem
                line-height 2.3rem
            .getscore
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
</style>