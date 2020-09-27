var app = new Vue({
    el: '#form-register',
    components: {
    },
    data: {
        PATHPHP: './php/functions.php',
        errors: [],
        placa: "",
        email: "",
        name: "",
        lastname: "",
        identification: "",
        phone: "",
    },
    methods: {
        checkForm: function (e) {
            console.log("Ya se realizo la consulta")
            axios.post(this.PATHPHP, {
                function: 'set_record_user',
                parametros: {
                    'placa': this.placa,
                    'email': this.email,
                    'name': this.name,
                    'lastname': this.lastname,
                    'identification': this.identification,
                    'phone': this.phone,
                    'link': `${window.location.href}reportes/user_info.html?user_id`
                }
            }).then(response => {
                console.log("Respose", response)
                Swal.fire({
                    title: '<strong class="parrafo_red">Tu moto a sido registrada con éxito</strong>',
                    icon: 'success',
                    html:
                        'Tu nombre de usuario es la placa de tu moto.' +
                        'Si deseas un servicio o información usa el boton de WhatsApp' +
                        'and other HTML tags',
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText:
                        '<i class="fa fa-thumbs-up"></i>Genial!',
                    confirmButtonAriaLabel: 'Genial!',
                })
            }).catch(error => {
                console.log(error)
                this.errors.push(error)
            }).finally(() => {
                this.placa = ""
                this.email = ""
                this.name = ""
                this.lastname = ""
                this.identification = ""
                this.phone = ""
            })

            e.preventDefault();
        },
        validateEmail: function (mail) {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
                return true
            }
            return false
        },
        centersChange: function () {
            switch (this.selected) {
                case "practical":
                    this.loadingPracticalCenters()
                    break;
                case "theory":
                    this.loadingTheoryCenters()
                    break;
            }

        },
        setRecordUser: function () {
            axios.post(this.PATHPHP, {
                function: 'set_record_user',
                parametros: {
                    'placa': this.placa,
                    'email': this.email,
                    'name': this.name,
                    'lastname': this.lastname,
                    'identification': this.identification,
                    'phone': this.phone,
                    'link': `${window.location.href}/reportes/user_info.html?user_id`
                }
            }).then(response => {
                console.log("Respose", response)
            }).catch(error => {
                console.log(error)
            }).finally(() => {
            })
        }
    },
    mounted() {
        var d = new Date();
        var n = d.getHours();
        console.log("Ya se realizo la consulta", n)
    }
})