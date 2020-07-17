import Vue from 'vue'

Vue.component('login-form', {
    components: {},
    props: {
        oldValues: {
            type: Object
        },
    },
    data() {
        return {
            email: this.oldValues.email || '',
            hasPassedCheckpoint: !!this.oldValues.email,
            isLoading: false
        }
    },
    methods: {
        onValidate(event) {
            event.preventDefault();

            if (!this.email) {
                alert("Veuillez saisir votre adresse email");
                return;
            }

            if (this.hasPassedCheckpoint) {
                event.target.submit();
                return;
            }

            let formData = new FormData;
            formData.append('_token', window.csrf_token);
            formData.append('email', this.email);

            this.isLoading = true;

            this.hasPassedCheckpoint = true;
            this.isLoading = false;
            // fetch('/connexion/checkpoint', {
            //     method: 'POST',
            //     body: formData,
            //     headers: {
            //         'Accept': 'application/json',
            //         'Content-Type': 'application/json'
            //     },
            // })
            //     .then(response => response.json())
            //     .then(result => {
            //         if (result.error) {
            //             if(result.status === 419) {
            //                 alert("La page a expiré et va être rafraîchie. Merci de réessayer.") && location.reload();
            //             }
            //             else {
            //                 this.loginErrorHandler(result.error)
            //             }
            //         } else if (result.redirect && result.redirect !== '') {
            //             location.href = result.redirect;
            //         } else {
            //             this.hasPassedCheckpoint = true;
            //             this.isLoading = false;
            //         }
            //     })
            //     .catch(error => this.loginErrorHandler(error))
        },
        onEmailChange(event) {
            this.hasPassedCheckpoint = false;
        },
        loginErrorHandler(error) {
            console.log("checkpoint error :", error);
            alert("Une erreur imprévue a eu lieu.");
            this.isLoading = false;
        }

    }
});
