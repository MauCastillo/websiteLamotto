var app = new Vue({
    el: '#social',
    components: {
    },
    data: {
        WHATSAPP: '3122513459',
    },
    methods: {
        WhatsAppLink: function () {
            window.open(`https://wa.me/+57${this.WHATSAPP}?text=Me%20interesa%20el%20servicio`);
        },
        TwitterLink: function () {
            window.open(`https://twitter.com/LamottoC`);
        },
        InstagramLink: function () {
            window.open(`https://www.instagram.com/lamotto_oficial/`);
        },
        FacebookLink: function () {
            window.open(`https://www.facebook.com/La-Motto-103916758016269/?modal=admin_todo_tour`);
        },
        YoutubeLink: function () {
            window.open(`https://www.youtube.com/channel/UCrrbnfT_rTCcB4KqI7tkMLQ`);
        },
    },
})