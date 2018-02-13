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
        <div class="clickScore" v-show="!turnScore" @click="showScore">
            <div class="btn">查询成绩</div>
        </div>
        <div class="score-box" title="成绩情况" v-show="turnScore" @click="showScore">
            <div class="details">
                <label>考生姓名:<span>{{xm}}</span></label>
                <label>准考证号:<span>{{zkz}}</span></label>
            </div>
            <div class="score">
                <label>总分<span>{{zf}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner"></div>
                </div>
            </div>
            <div class="score">
                <label>听力<span>{{tl}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner"></div>
                </div>
            </div>
            <div class="score">
                <label>阅读<span>{{yd}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner"></div>
                </div>
            </div>
            <div class="score">
                <label>写作<span>{{xz}}</span></label>
                <div class="progress round-conner">
                    <div class="curRate round-conner"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        data() {
            return {
                xm: '艾超',                    //姓名
                sfz: '789546123547895136',    //身份证
                zkz: '41186882896',           //准考证
                zf: '470',   //总分
                tl: '175',   //听力35%
                yd: '145',   //阅读35%
                xz: '150',   //写作及翻译30%
                turnScore: false
            }
        },
        methods: {
            showScore(){
                this.turnScore = !this.turnScore
            }
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    .header
        width 100%
        height 12rem
        margin 0 auto
        background url(/img/query.jpg)
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
                    width 60%
                    background lightskyblue
                .round-conner
                    height 1rem
</style>