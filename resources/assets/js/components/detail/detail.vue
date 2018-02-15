<template>
    <div class="detail">
        <div class="header"></div>
        <div class="ticket-box" title="准考证信息">
            <div class="details">
                <label>考生姓名:<span>{{xm}}</span></label>
                <label>身份证号:<span>{{sfz}}</span></label>
                <label>准考证号:<span>{{zkz}}</span></label>
            </div>
        </div>
        <div class="clickScore" v-show="!turnScore" @click="submit()">
            <div class="btn">{{submitBtn}}</div>
        </div>
        <div class="score-box" title="成绩情况" v-show="turnScore" @click="showScore">
            <div class="details">
                <label>考生姓名:<span>{{xm}}</span></label>
                <label>准考证号:<span>{{zkz}}</span></label>
                <label>考生学校:<span>{{xx}}</span></label>
                <div class="icon" :class=" (this.zf >= 425) ? 'pass' : 'loser' "></div>
            </div>
            <div class="score">
                <label>总分<span>{{zf}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner" :style="lezf"></div>
                </div>
            </div>
            <div class="score">
                <label>听力<span>{{tl}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner" :style="letl"></div>
                </div>
            </div>
            <div class="score">
                <label>阅读<span>{{yd}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner" :style="leyd"></div>
                </div>
            </div>
            <div class="score">
                <label>写作<span>{{xz}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner" :style="lexz"></div>
                </div>
            </div>
        </div>
        <error ref="error"></error>
    </div>
</template>

<script type="text/ecmascript-6">
    import store from '../common/store'
    import error from '../error/error'

    export default {
        props: ['ticket'],
        data() {
            return {
                xm: '',     //姓名
                sfz: '',    //身份证
                zkz: '',    //准考证
                xx: ' ',    //考生学校
                zf: ' ',   //总分
                tl: ' ',   //听力35%
                yd: ' ',   //阅读35%
                xz: ' ',   //写作及翻译30%
                submitBtn: '查询成绩',    //按钮
                sScore: '',         //服务器返回值
                turnScore: false,    //查询按钮
                score: '',           //处理过的分数(听力、阅读、写作及翻译)
            }
        },
        mounted: function () {
            this.$nextTick(function () {
                const data = store.get('ticket')
                this.xm = data.xm
                this.sfz = data.sfz
                this.zkz = data.zkz
//                console.log(this.$route.params.ticket)
//                const data = this.$route.query.ticket
//                console.log(data)
            })
        },
        watch: {
            sScore: function () {
                this.dealscore(store.get(sScore))
            }
        },
        computed: {
            lezf() {
                return {
                    width: (this.zf / 710 * 100) + '%'
                }
            },
            letl() {
                return {
                    width: (this.tl / 249 * 100) + '%'
                }
            },
            leyd() {
                return {
                    width: (this.yd / 249 * 100) + '%'
                }
            },
            lexz() {
                return {
                    width: (this.xz / 212 * 100) + '%'
                }
            }
        },
        methods: {
            showScore() {
                this.turnScore = !this.turnScore
            },
            submit() {
                this.submitBtn = '查 询 中...'
                axios.post('api/score', {
                    xm: this.xm,
                    zkz: this.zkz
                }).then(response => {
                    let data = response.data
                    if (data.status === 403 || data.status === 404) {
                        this.submitBtn = '查 询'
                    } else if (data.status === 500) {
                        this.submitBtn = '查 询'
                        this.$refs.error.show("查询服务暂不可用", "请前往官网查询")
//                        window.location.href = 'http://www.chsi.com.cn/cet/'
                    } else if (data.status === 200) {
                        this.submitBtn = '查 询'
                        this.showScore()
                        const res = data.msg
                        this.dealscore(res)
                        store.set('xm', res)
                    }
                }).catch(error => {
                    console.log(error)
                });
            },
            dealscore(res) {
                this.xx = res.school
                let wrScore = res.written
                this.zf = wrScore.score
                this.tl = wrScore.listening
                this.yd = wrScore.reading
                this.xz = wrScore.translation
            }
        },
        components: {
            error
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    @import "../../../sass/mixin.styl"
    .header
        width 100%
        height 12rem
        margin 0 auto
        background-image url(query.jpg)
        background-repeat no-repeat
        background-size 100% 100%

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

    .score-box
        width 80%
        position relative
        top 4.5rem
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
                margin 0 auto 2rem auto
            span
                font-size 1.5rem
                font-weight bold
                color #93999f
                padding-left 1.5rem
            .icon
                position absolute
                top -0.2rem
                right -0.2rem
                width 4.8rem
                height 3.65rem
                background-size 4.8rem 3.65rem
                background-repeat no-repeat
                &.pass
                    bg-image('pass')
                &.loser
                    bg-image('loser')
        .score
            width 100%
            height 3rem
            padding-bottom 1rem
            label
                width 85%
                font-size 1.5rem
                color black
                display block
                margin 0 auto
                font-weight bold
                padding-bottom 0.5rem
            span
                float right
                font-weight bold
                color lightskyblue
            .progress
                width 85%
                background #ddd
                margin 0 auto
                .curRate
                    width 0
                    background lightskyblue
                .round-conner
                    height 1rem
</style>