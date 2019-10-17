import { LightningElement, track } from 'lwc';
import './loginForm.scss';

export default class LoginForm extends LightningElement {
    @track isLoading;
    @track formMessage;

    loginPressed() {
        this.isLoading = true;
        const usernameInput = this.template.querySelector(
            '.login-form__input_username'
        );
        const passwordInput = this.template.querySelector(
            '.login-form__input_password'
        );
        const username = usernameInput.value;
        const password = passwordInput.value;

        fetch('/admin/login', {
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            method: 'post',
            body: JSON.stringify({
                username: username,
                password: password
            })
        })
            .then(responce => responce.json())
            .then(result => {
                this.isLoading = false;
                if (result.status) {
                    this.dispatchEvent(new CustomEvent('loginsuccess'));
                } else {
                    this.formMessage = result.message;
                }
            })
            .catch(error => {
                console.log(error);
                this.isLoading = false;
                this.formMessage =
                    'Server error, call you system administrator';
            });
    }
}
