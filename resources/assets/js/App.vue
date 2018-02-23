<template>
    <div style="height: 100%">
        <transition :name="transitionName">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </transition>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        data(){
            return {
                transitionName:''
            }
        },
        mounted() {
            const script = document.createElement('script')
            script.src = 'https://s19.cnzz.com/z_stat.php?id=1267073773&web_id=1267073773'     //友盟链接
            script.language = 'JavaScript'
            document.body.appendChild(script)
        },
        watch: {
            '$route'(to, from) {
                if (window._czc) {
                    let location = window.location
                    let contentUrl = location.pathname + location.hash
                    let refererUrl = '/'
                    window._czc.push(['_trackPageview', contentUrl, refererUrl])
                }
                if(to.meta.index > from.meta.index){
                    //设置动画名称
                    this.transitionName = 'slide-left';
                }else{
                    this.transitionName = 'slide-right';
                }
            }
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    .slide-right-enter-active,
    .slide-right-leave-active,
    .slide-left-enter-active,
    .slide-left-leave-active {
        will-change: transform;
        transition: all 200ms;
        position: absolute;
    }
    .slide-right-enter {
        opacity: 0;
        transform: translate3d(-100%, 0, 0);
    }
    .slide-right-leave-active {
        opacity: 0;
        transform: translate3d(100%, 0, 0);
    }
    .slide-left-enter {
        opacity: 0;
        transform: translate3d(100%, 0, 0);
    }
    .slide-left-leave-active {
        opacity: 0;
        transform: translate3d(-100%, 0, 0);
    }
</style>