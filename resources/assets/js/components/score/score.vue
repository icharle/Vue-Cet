<template>
    <div class="score">
        <div class="score-box" title="成绩情况" v-show="turnScore">
            <div class="details">
                <label>考生姓名:<span>{{name}}</span></label>
                <label>准考证号:<span>{{ticket}}</span></label>
                <label>考生学校:<span>{{school}}</span></label>
                <div class="icon" :class=" (this.sumscore >= 425) ? 'pass' : 'loser' "></div>
            </div>
            <div class="score">
                <label>总分<span>{{sumscore}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner" :style="lengthSumscore"></div>
                </div>
            </div>
            <div class="score">
                <label>听力<span>{{listenscore}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner" :style="lengthListenscore"></div>
                </div>
            </div>
            <div class="score">
                <label>阅读<span>{{readscore}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner" :style="lengthReadscore"></div>
                </div>
            </div>
            <div class="score">
                <label>写作<span>{{writescore}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner" :style="lengthWritescore"></div>
                </div>
            </div>
        </div>
        <error ref="error"></error>
    </div>
</template>

<script type="text/ecmascript-6">
    import error from '../error/error'

    export default {
        data() {
            return {
                name: '',           //姓名
                ticket: '',         //准考证号码
                school: '',         //学校
                sumscore: '',       //总分
                listenscore: '',    //听力分数
                readscore: '',      //阅读分数
                writescore: '',      //写作分数
                turnScore: false      //控制是否隐藏
            }
        },
        methods: {
            submit() {
                this.$emit('changebtn', '查 询 中...')
                axios.post('api/score', {
//                    xm: this.xm,
//                    zkz: this.zkz
                    xm: '张嘉阳',
                    zkz: '320590171103912'
                }).then(response => {
                    let data = response.data
                    if (data.status === 403 || data.status === 404) {

                        this.$emit('changebtn', '查询成绩')
                        this.$refs.error.show(false, "查询服务暂不可用", "请前往官网查询")

                    } else if (data.status === 500) {

                        this.$emit('changebtn', '查询成绩')
                        this.$refs.error.show(false, "查询服务暂不可用", "请前往官网查询")
//                        window.location.href = 'http://www.chsi.com.cn/cet/'

                    } else if (data.status === 200) {

                        this.$emit('changebtn', '查询成绩')
                        this.$emit('changescore', false)
                        let res = data.msg
                        this.name = res.name            //姓名
                        this.school = res.school        //学校
                        let wrScore = res.written       //转
                        this.ticket = wrScore.number        //准考证号码
                        this.sumscore = wrScore.score       //总分
                        this.listenscore = wrScore.listening        //听力分数
                        this.readscore = wrScore.reading        //阅读分数
                        this.writescore = wrScore.translation       //写作分数
                        this.turnScore = true
                    }
                }).catch(error => {
                    console.log(error)
                });
            }
        },
        computed: {
            lengthSumscore() {
                return {
                    width: (this.sumscore / 710 * 100) + '%'
                }
            },
            lengthListenscore() {
                return {
                    width: (this.listenscore / 249 * 100) + '%'
                }
            },
            lengthReadscore() {
                return {
                    width: (this.readscore / 249 * 100) + '%'
                }
            },
            lengthWritescore() {
                return {
                    width: (this.writescore / 212 * 100) + '%'
                }
            }
        },
        components: {
            error
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    @import "../../../sass/mixin.styl"
    .score
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