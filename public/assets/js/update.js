async function apiUpdate(params) {
    params.e?.preventDefault()

    const form = document.querySelector('[update-form]')
    const updateData = new FormData(form)
    // Mudar os textos de belongsTo para IDs
    form.querySelectorAll('datalist').forEach(element => {
        const bindedInput = element.previousElementSibling.previousElementSibling
        const selectedOption = element.options.namedItem(bindedInput.value);
        if (selectedOption) {
            const selectedId = selectedOption.getAttribute('data-id');
            updateData.set(bindedInput.name, selectedId)
        }
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

        flashDiv.innerHTML = json.resp
        flashDiv.classList.add("success")
        flashDiv.classList.remove("hidden", "error")
        // document.querySelector('.entry-name').innerHTML = 

    } catch (err) {
        errMsg = `${err.json.resp}.<br>Detalhes: ${JSON.stringify(err.json[0])}`
        flashDiv.innerHTML = errMsg
        flashDiv.classList.add("error")
        flashDiv.classList.remove("hidden", "success")
    }
}