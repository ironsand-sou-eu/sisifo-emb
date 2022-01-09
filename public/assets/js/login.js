document.login.onsubmit = async e => {
    e.preventDefault()
    const form = e.target
    const loginData = new FormData(form)
    const options = {
        method: form.method,
        body: new URLSearchParams(loginData)
    }

    try {
        const resp = await fetch(form.action, options)
        if (resp.status >= 401) {
            throw 'Usuário ou senha incorretos.'
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