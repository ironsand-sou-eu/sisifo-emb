const button = document.querySelector('#updt_button_wrapper button[type="submit"]')
const newPwd = document.querySelector('input#new-pwd')
const pwdConfirmation = document.querySelector('input#pwd-confirmation')
const confirmationLabel = document.querySelector('input#pwd-confirmation ~ label')
const parentDiv = pwdConfirmation.parentElement

newPwd.addEventListener('input', changesAccordingPwdsMatch)
pwdConfirmation.addEventListener('input', changesAccordingPwdsMatch)

function changesAccordingPwdsMatch(e) {
    if(newPwd.value !== pwdConfirmation.value) {
        confirmationLabel.dataset.title = 'Senhas não conferem'
        confirmationLabel.classList.add('fail')
        parentDiv.classList.add('fail')
        button.setAttribute('disabled', 'disabled')
    } else {
        confirmationLabel.dataset.title = 'Repita a nova senha'
        confirmationLabel.classList.remove('fail')
        parentDiv.classList.remove('fail')
        button.removeAttribute('disabled')
    }
}