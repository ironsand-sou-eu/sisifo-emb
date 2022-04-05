async function apiUpdate(params) {
    params.e?.preventDefault()

    const form = document.querySelector('[update-form]')
    const updateData = new FormData(form)
    // Mudar os textos de selects (relacionamentos belongsTo) para IDs
    form.querySelectorAll('datalist').forEach(element => {
        const boundInput = element.previousElementSibling.previousElementSibling
        const selectedOption = element.options.namedItem(boundInput.value);
        if (selectedOption) {
            const selectedId = selectedOption.getAttribute('data-id');
            updateData.set(boundInput.name, selectedId)
        }
    })

    // Mudar os valores dos checkboxes para booleano
    form.querySelectorAll('input[type="checkbox"]').forEach(element => {
        const status  = element.checked ? 1 : 0
        updateData.set(element.name, status)
    })

    const options = {
        method: 'PUT',
        headers: { "Authorization": `Bearer ${params.jwt}` },
        body: new URLSearchParams(updateData)
    }
    
    let rssUrl = `${params.apiUrl}/${params.id}`
    const flashDiv = document.querySelector("[flash]")
    try {
        const resp = await fetch(rssUrl, options)
        const json = await resp.json()
        
        if (resp.status >= 400) {
            throw {resp, json}
        }

        flashDiv.innerHTML = json.resp + ' Redirecionando...'
        flashDiv.classList.add("success")
        flashDiv.classList.remove("hidden", "error")
        setTimeout(() => {
            window.location.href = params.url
        }, 3000);

    } catch (err) {
        errMsg = `${err.json.resp}.<br>Detalhes: ${JSON.stringify(err.json[0])}`
        flashDiv.innerHTML = errMsg
        flashDiv.classList.add("error")
        flashDiv.classList.remove("hidden", "success")
    }
}