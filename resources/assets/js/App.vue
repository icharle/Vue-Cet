<template>
    <div style="height: 100%; width: 100%">
        <transition name="slide-fade">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </transition>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
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
            }
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    .slide-fade{
        position: absolute;left:0;right: 0;
    }
    .slide-fade-enter-active {
        transition: all 1.5s ease;
    }
    .slide-fade-leave-active {

        transition: all .1s cubic-bezier(2.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
    {
        left:0;right: 0;
        transform: translateX(8rem);
        opacity: 0;
    }
</style>