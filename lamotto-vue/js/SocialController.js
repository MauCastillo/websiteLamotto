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
    },
})