<template>
    <div class="ticket">
        <div class="header"></div>
        <div class="content">
            <navbar></navbar>
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
                    <label><input type="radio" class="radio" name="type" value="1" checked v-model="jb"/><span>四级</span></label>
                    <label><input type="radio" class="radio" name="type" value="2" v-model="jb"/><span>六级</span></label>
                </div>
                <div class="btn" @click="submit()">{{submitBtn}}</div>
            </form>
        </div>
        <foot></foot>
        <error ref="error"></error>
    </div>
</template>

<script type="text/ecmascript-6">
    import store from '../common/store'
    import navbar from '../navbar/navbar'
    import error from '../error/error'
    import foot from '../footer/footer'

    export default {
        data() {
            return {
                xm: '',    //姓名
                sfz: '',   //身份证
                jb: 1,      //类型(四六级)
                submitBtn: '查 询',
                ticket: ''
            }
        },
        methods: {
            submit() {
                this.submitBtn = '查 询 中...'
                this.ticket = ''
                axios.post('api/tickets', {
                    xm: this.xm,
                    sfz: this.sfz,
                    jb: this.jb
                }).then(response => {
                    let data = response.data
                    if (data.status === 403 || data.status === 404) {
                        this.$refs.error.show(false,"查询失败，未找到您的准考证！","请正确输入信息！")
                        this.submitBtn = '查 询'
                    } else if (data.status === 200) {
                        this.ticket = data.msg
                        this.submitBtn = '查 询'
                        store.set('ticket', this.ticket)
                        this.$router.push({name: 'detail', params: {ticket: this.ticket}})
//                        this.$router.push({name: 'detail', query: {ticket: this.ticket}})
                    }
                }).catch(error => {
                    console.log(error)
                });
            }
        },
        components: {
            navbar,
            error,
            foot
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    .ticket
        display flex
        flex-direction column
        min-height 100%
        overflow auto
        .header
            width 100%
            height 25rem
            background-image url(banner.jpg)
            background-repeat no-repeat
            background-size 100% 100%
        .content
            width 100%
            flex 1
            -webkit-flex 1
            .getticket
                width 100%
                .input-wrap
                    width 18rem
                    position relative
                    padding 0.5rem 0.6rem 0.5rem 3.4rem
                    margin 1.5rem auto 0.5rem auto
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