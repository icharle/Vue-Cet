<template>
    <div class="detail">
        <div class="header"></div>
        <div class="content">
            <div class="ticket-box" title="准考证信息">
                <div class="details">
                    <label>考生姓名:<span>{{name}}</span></label>
                    <label>身份证号:<span>{{idcard}}</span></label>
                    <label>准考证号:<span>{{ticket}}</span></label>
                </div>
            </div>
            <div class="clickScore" v-show="turnScore" @click="submit()">
                <div class="btn">{{submitBtn}}</div>
            </div>
            <score ref="score" @changebtn="changebtn" @changescore="changescore"></score>
        </div>
        <foot></foot>
    </div>
</template>

<script type="text/ecmascript-6">
    import store from '../common/store'
    import score from '../score/score'
    import foot from '../footer/footer'

    export default {
//        props: ['ticket'],
        data() {
            return {
                name: '',     //姓名
                idcard: '',    //身份证
                ticket: '',    //准考证
                submitBtn: '查询成绩',    //按钮
                turnScore: true,    //查询按钮
            }
        },
        mounted: function () {
            this.$nextTick(function () {
                const data = store.get('ticket')
                this.name = data.xm
                this.idcard = data.sfz
                this.ticket = data.zkz
//                console.log(this.$route.params.ticket)
//                const data = this.$route.query.ticket
//                console.log(data)
            })
        },
        methods: {
            submit() {
                this.$refs.score.submit(this.name, this.ticket)
            },
            showScore() {
                this.turnScore = !this.turnScore
            },
            changebtn(txt) {
                this.submitBtn = txt
            },
            changescore(txt) {
                this.turnScore = txt
            }

        },
        components: {
            score,
            foot
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    @import "../../../sass/mixin.styl"
    .detail
        display flex
        flex-direction column
        height 100%
        min-height 100%
        .header
            width 100%
            height 12rem
            margin 0 auto
            background-image url(query.jpg)
            background-repeat no-repeat
            background-size 100% 100%
        .content
            width 100%
            flex 1
            -webkit-flex 1
            overflow auto
            .ticket-box
                width 80%
                position relative
                top 2rem
                margin 0 auto
                border 0.2rem dashed #d9dde1
                color #93999f
                font-size 2rem
                border-radius 0.5rem
                &:before
                    content attr(title)
                    position absolute
                    left 50%
                    transform translateX(-50%)
                    -webkit-transform translate(-50%, -50%)
                    padding 0 1rem
                    background-color #fff
                .details
                    font-size 1rem
                    margin 2.5rem auto 0rem auto
                    label
                        width 90%
                        display block
                        color lightskyblue
                        line-height 2.5rem
                        margin 0 auto 2.5rem auto
                    span
                        font-size 1.5rem
                        font-weight bold
                        color #93999f
                        padding-left 1.5rem

            .clickScore
                width 80%
                position relative
                top 4.5rem
                margin 0 auto
                .btn
                    width 75%
                    height 3rem
                    background-color lightskyblue
                    margin 0 auto
                    border-radius 0.5rem
                    color white
                    line-height 3rem
                    font-size 2rem
                    text-align center
</style>