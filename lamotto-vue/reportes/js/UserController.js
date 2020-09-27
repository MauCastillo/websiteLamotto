var app = new Vue({
    el: '#app',
    components: {
    },
    data: {
        user: {},
        PATHPHP: '../php/functions.php',
    },
    methods: {
        WhatsAppLink: function () {
            window.open(`https://wa.me/+57${this.WHATSAPP}?text=Me%20interesa%20el%20servicio`);
        },
    },
    mounted() {
        const queryString = window.location.search;
        console.log(queryString);
        const urlParams = new URLSearchParams(queryString);
        const userID = urlParams.get('user_id')
        console.log("URL  ------ ",queryString);


        console.log('>>> ID <<<', userID) // outputs 'yay'
        axios.post(this.PATHPHP, {
            function: 'get_user',
            parametros: { 'ID': userID }
        }).then(response => {
            console.log("Respose", response)
            this.user = response.data[0]
            console.log('User object: ', this.user)
        }).catch(error => {
            console.log(error)
        }).finally(() => {
        })
    }
})

var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
        , base64 = function (s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }
    return function (table, name) {
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = { worksheet: name || 'Worksheet', table: table.innerHTML }
        window.location.href = uri + base64(format(template, ctx))
    }
})()