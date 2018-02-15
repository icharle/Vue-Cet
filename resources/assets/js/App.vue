<template>
    <div style="height: 100%">
        <keep-alive>
            <router-view></router-view>
        </keep-alive>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        mounted () {
            const script = document.createElement('script')
            script.src = 'https://s19.cnzz.com/z_stat.php?id=1267073773&web_id=1267073773'     //友盟链接
            script.language = 'JavaScript'
            document.body.appendChild(script)
        },
        watch: {
            '$route' () {
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

</style>