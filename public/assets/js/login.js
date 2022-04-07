document.login.onsubmit = async e => {
    e.preventDefault()
    toggleLoginButtonWait()
    const form = e.target
    fillEmailFieldWithEmbasaData(form)
    const loginData = new FormData(form)
    const options = {
        method: form.method,
        body: new URLSearchParams(loginData)
    }

    try {
        const resp = await fetch(form.action, options)
        switch (resp.status) {
            case 422:
                toggleLoginButtonWait()
                throw 'Usuário ou senha incorretos. Tente novamente.'
            case 500:
                toggleLoginButtonWait()
                throw 'Ocorreu um erro no servidor. Tente novamente mais tarde.'
        }
        const json = await resp.json()
        const jwt = json.access_token
        const secondsToExpiration = json.expires_in
        setJwtCookie(jwt, secondsToExpiration)
        window.location.href = "/"

    } catch (e) {
        const errorDiv = document.querySelector("div.errors")
        errorDiv.innerHTML = e
        errorDiv.style.display = 'block'
    }
}

function toggleLoginButtonWait() {
    const btn = document.querySelector('button.btn-primary')
    if (btn.innerHTML.indexOf('Login') >= 0) {
        btn.innerHTML = btn.innerHTML.replace('Login', '')
    } else {
        btn.innerHTML = 'Login' + btn.innerHTML
    }
    btn.classList.toggle('lds-ellipsis')
}

function setJwtCookie(value, secondsToExpire) {
    setCookie('jat', value, secondsToExpire)
}

function setCookie(name, value, secondsToExpire) {
    var expires = "";
    if (secondsToExpire) {
        var date = new Date();
        date.setTime(date.getTime() + (secondsToExpire*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function fillEmailFieldWithEmbasaData(form) {
    const email = form.email.value;
    if (!email.includes('@'))
        form.email.value = `${email}@embasa.ba.gov.br`
}