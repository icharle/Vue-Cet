/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
import wx from 'weixin-js-sdk'

router.afterEach((to, from) => {
    let _url = window.location.origin + to.fullPath
    axios({
        url: 'api/RspSignature',
        method: 'post',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        params: {
            PostUrl: _url
        },
        dataType: 'json',
    }).then(response => {
        let data = response.data
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: data.appId, // 必填，公众号的唯一标识
            timestamp: data.timestamp, // 必填，生成签名的时间戳
            nonceStr: data.nonceStr, // 必填，生成签名的随机串
            signature: data.signature,// 必填，签名
            jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage'] // 必填，需要使用的JS接口列表
        });
        wx.ready(() => {
            wx.onMenuShareTimeline({
                title: '四六级准考证查询', // 分享标题
                link: _url,
                imgUrl: 'https://icharle.com/logo/logo.png', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                }, cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareAppMessage({
                title: '四六级准考证查询', // 分享标题
                desc: '四六级免证查询', // 分享描述
                link: _url,
                imgUrl: 'https://icharle.com/logo/logo.png', // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
        wx.error(function (res) {

        });
    })
        .catch(function (error) {
            console.log(error);
        });
})

new Vue({
    el: '#app',
    router,
    components: {App},
    template: '<App/>'
})

