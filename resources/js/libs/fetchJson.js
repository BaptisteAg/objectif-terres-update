window.fetchJson = async function(url, formData) {
    if(formData instanceof FormData) {
        formData.append('_token', window.csrf_token);
    }

    const response = await fetch(url, {
        method: formData ? 'POST' : 'GET',
        body: formData
    });

    return await response.json()
};