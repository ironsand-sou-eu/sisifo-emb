async function apiCreate(params) {
    params.e?.preventDefault()

    const form = document.querySelector('[create-form]')
    const createData = new FormData(form)
    // Mudar os textos de selects (relacionamentos belongsTo) para IDs
    form.querySelectorAll('datalist').forEach(element => {
        const bindedInput = element.previousElementSibling.previousElementSibling
        const selectedOption = element.options.namedItem(bindedInput.value);
        if (selectedOption) {
            const selectedId = selectedOption.getAttribute('data-id');
            createData.set(bindedInput.name, selectedId)
        }
    })

    // Mudar os valores dos checkboxes para booleano
    form.querySelectorAll('input[type="checkbox"]').forEach(element => {
        const status  = element.checked ? 1 : 0
        createData.set(element.name, status)
    })

    const options = {
        method: 'POST',
        headers: { "Authorization": `Bearer ${params.jwt}` },
        body: new URLSearchParams(createData)
    }
    
    const flashDiv = document.querySelector("[flash]")
    try {
        const resp = await fetch(params.apiUrl, options)
        const json = await resp.json()
        
        if (resp.status >= 400) {
            throw {resp, json}
        }

        flashDiv.innerHTML = json.resp + ' Redirecionando...'
        flashDiv.classList.add("success")
        flashDiv.classList.remove("hidden", "error")
        window.scrollTo({top: 0, behavior: "smooth"})
        setTimeout(() => {
            window.location.href = params.url
        }, 3000);

    } catch (err) {
        errMsg = `${err.json.resp}.<br>Detalhes: ${JSON.stringify(err.json[0])}`
        flashDiv.innerHTML = errMsg
        flashDiv.classList.add("error")
        flashDiv.classList.remove("hidden", "success")
        window.scrollTo({top: 0, behavior: "smooth"})
    }
}