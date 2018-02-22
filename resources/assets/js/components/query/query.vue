<template>
    <div class="query">
        <div class="header"></div>
        <div class="content">
            <span class="title">四六级成绩查询</span>
            <form class="getticket" v-show="true">
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
                    <label><input type="radio" class="radio" name="type" value="1" checked v-model="jb"/><span>四级</span></label>
                    <label><input type="radio" class="radio" name="type" value="2" v-model="jb"/><span>六级</span></label>
                </div>
                <div class="btn" @click="submit()">{{submitBtn}}</div>
            </form>
            <div class="score-box" title="成绩情况" @click="showScore" v-show="false">
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
        </div>
        <foot></foot>
    </div>
</template>

<script type="text/ecmascript-6">
    import foot from '../footer/footer'

    export default {
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
        components: {
            foot
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
        .footer
            width 100%
            height 2rem
            line-height 2rem
            text-align center
</style>