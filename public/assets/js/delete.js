async function apiDelete(params) {
            
    if (!window.confirm(`Tem certeza de que deseja excluir o registro "${params.name}"?`)) {
        return
    }

    params.ev?.preventDefault()

    const options = {
        method: 'DELETE',
        headers: { "Authorization": `Bearer ${params.jwt}` }
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

        params.table?.ajax.reload()
        
        if (params.redirect) {
            window.location.href = params.redirect
        }
        
    } catch (err) {
        switch (err.resp.status) {
            case 404:
                errMsg = `Não foi encontrado um registro com o ID ${params.id}`
                break;
            default:
                errMsg = `${err.json.resp}.<br>Detalhes: ${err.json.data.errorInfo}`
                if (errMsg.includes('a foreign key constraint fails')) {
                    errMsg = `O registro não pôde ser excluído, pois possui outros registros vinculados.`
                }
                break;
        }

        flashDiv.innerHTML = errMsg
        flashDiv.classList.add("error")
        flashDiv.classList.remove("hidden", "success")
    }
}